<?php

############################# OPEN_QA DISPLAY HELPER FUNCTIONS ##################################################


### THIS IS A STRIPPED-OFF VERSION OF DISPLAY HELPER FUNCTIONS USED BY THE INTERNAL QA SYSTEM AT EUCALYPTUS
### INSTEAD OF USING DATABASE, THE FUNCTIONS BELOW WILL ONLY ACCESS CACHE FILES
### THUS, ALL $my_db VARIABLES BELOW CONTAINS NULL 


function get_next_date($this_date){
	$year = "";
	$month = "";
	$day = "";
	if( preg_match("/(\d+)\-(\d+)-(\d+)/", $this_date, $match) ){
		$year = $match[1];
		$month = $match[2];
		$day = $match[3];
	};
	$next_date = date("Y-m-d",mktime(0,0,0, $month, $day+1, $year));

	return $next_date;

};


function get_tests_since_given_date($my_db, $this_date){

	$today = date("y-m-d", time());
	$today_ts = "20" . $today;

	$year1 = "";
	$month1 = "";
        $day1 = "";
        if( preg_match("/(\d+)\-(\d+)-(\d+)/", $this_date, $match) ){
                $year1 = $match[1];
                $month1 = $match[2];
                $day1 = $match[3];
        };

	$year2 = "";
	$month2 = "";
        $day2 = "";
        if( preg_match("/(\d+)\-(\d+)-(\d+)/", $today_ts, $match2) ){
                $year2 = $match2[1];
                $month2 = $match2[2];
                $day2 = $match2[3];
        };

	$date = mktime(0,0,0,$month1,$day1,$year1); //Gets Unix timestamp START DATE
	$date1 = mktime(0,0,0,$month2,$day2,$year2); //Gets Unix timestamp END DATE
	$difference = $date1-$date; //Calcuates Difference
	$daysago = floor($difference /60/60/24); //Calculates Days Old

#	echo "Total Days Between: ".$daysago . "<br>";

	$dates = array();

	$i = 0;
	while ($i <= $daysago +1) {
		if($i != 0){
			$date = $date + 86400;
		}else{
			$date = $date - 86400;
	    	};
		$today = date('Y-m-d',$date);
#	    	echo "$i) Day: $today <br>";
		array_push($dates,$today);
	    	$i++;
	};  

	$buffer = "";

	while( $i > 0 ){
		$buffer .= get_tests_given_date($my_db, $dates[--$i]);
	};

	return $buffer;
};


function get_tests_given_date($my_db, $this_date){

	$running_tests = array();
	$running_uid = array();

	$cache_dir = "./webcache";
	$this_date_test_list = $cache_dir . "/this_date_test_list_" . $this_date . ".lst";

	$temp_buf = `cat $this_date_test_list`;
	$temp_buff = rtrim($temp_buf);
	$temp_list = explode("\n", $temp_buf);

	foreach( $temp_list as $today_line){
		if( preg_match("/^(\S+)\s+(\d+)/", $today_line, $this_match) ){
			array_push($running_tests, $this_match[1]);
			array_push($running_uid, $this_match[2]);				
		};
	};

	$buffer = "";

	$count = 0;

	foreach ( $running_tests as $this_test ){
		$this_uid = $running_uid[$count];;
		$buffer .= get_test_in_open_qa_view_given_testname_and_uid($my_db, $this_test, $this_uid) . "\n";
		$count++;
	};
	
	return $buffer;
};



function get_test_in_open_qa_view_given_testname_and_uid($my_db, $this_test, $this_uid){

	$buffer = "";

	$cache_dir = "./webcache";
	$cache_filename = "open_qa_" . $this_test . "_UID_" . $this_uid . ".cache";
	$this_cache = $cache_dir . "/"  . $cache_filename;

	$buffer = `cat $this_cache`;

	return $buffer;
};




?> 

