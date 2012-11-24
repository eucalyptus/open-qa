<?php

######################## SUBROUTINE ###################################################################

function get_prev_date($this_date){
	$year = "";
	$month = "";
	$day = "";
	if( preg_match("/(\d+)\-(\d+)-(\d+)/", $this_date, $match) ){
		$year = $match[1];
		$month = $match[2];
		$day = $match[3];
	};
	$prev_date = date("Y-m-d",mktime(0,0,0, $month, $day-1, $year));

	return $prev_date;

};

function get_prev_date_two_days_ago($this_date){
	$year = "";
	$month = "";
	$day = "";
	if( preg_match("/(\d+)\-(\d+)-(\d+)/", $this_date, $match) ){
		$year = $match[1];
		$month = $match[2];
		$day = $match[3];
	};
	$prev_date = date("Y-m-d",mktime(0,0,0, $month, $day-2, $year));

	return $prev_date;

};

function print_page_header_this_date($this_date){

	print "<div class=\"page-header\">";
	print "<h2>";
	print "<small>";
	print "Eucalyptus QA on ";
	print "<font color=\"green\">";
	print $this_date;
	print "</font>";
	print "</small>";
	print "</h2>";
	print "</div>";

	return;
};

function print_hidden_div_block_for_inifiniti_scrolling(){

        print "<div id=\"loadMore\" style=\"display:none;\">";
        print "<center>Loading More Results. Please Wait..</center>";
        print "</div>";

        return;
};

function get_day_diff($test_date){
	
	$year = "";
        $month = "";
        $day = "";
        if( preg_match("/(\d+)\-(\d+)-(\d+)/", $test_date, $match) ){
                $year = $match[1];
                $month = $match[2];
                $day = $match[3];
        };
	
	$mktime1= mktime(0,0,0, $month, $day, $year);
	$mktime2 = mktime(0,0,0, date("m"), date("d"), date("y"));
	$diff = ( ($mktime2 - $mktime1) / 3600 ) / 24;
	return $diff . "d";
};

function get_developer_icon($user){
	$jpg_name = "./image/developer/".$user.".jpg";
        $png_name = "./image/developer/".$user.".png";

	if( file_exists($jpg_name)){
		return $jpg_name;
        }else if( file_exists($png_name)){
                return $png_name;
        };
        return "./image/euca_icon.jpg";
};

function print_test_result_well($test_date, $test_time, $testname, $uid, $sequence, $os, $git_hash, $test_stage, $user, $test_date){

	### FOR RETREIVING EC2 PUBLIC HOSTNAME
	if( $GLOBALS["this_hostname"] == "" ){
		$GLOBALS["this_hostname"] = `wget -q -O - http://169.254.169.254/latest/meta-data/public-hostname`;
	};
	$this_hostname = $GLOBALS["this_hostname"];

#	$test_id = $testname . "_UID-" . $uid;
	$test_id = $test_date;
#	$test_result_url = "http://qa-server.eucalyptus-systems.com/euca-qa/display_test.php?testname=" . $testname . "&uid=" . $uid;	
	$test_result_url = "http://" . $this_hostname . "/open_qa-display_test.php?testname=" . $testname . "&uid=" . $uid;	
	
	print "<div class=\"well well-small\" id=\"testBlock\" title=\"$test_id\" style=\"height: 70%; width: 100%; background-color: #EFFBF5;\">";
#	print "<button class=\"close\">&times;</button>";
	$day_diff = get_day_diff($test_date);
	print "<button class=\"close\"><font size=2>$day_diff</fontt></button>";

	print "<div class=\"container-fluid\">";
	print "<div class=\"row-fluid\">";

	### DIV span2 for Thumbnails
	print "<div class=\"span2\">";

	print "<ul class=\"thumbnails\">";
	print "<li class=\"span12\">";
	print "<a href=\"#\" class=\"thumbnail\">";

	$icon = get_developer_icon($user);
	print "<img class=\"img-rounded\" src=\"" . $icon . "\" alt=\"\">";

	print "</a>";
	print "</li>";
	print "</ul>";

	print "</div>";
	### DIV span2 CLOSED

	### DIV span10 for Test Result
	print "<div class=\"span10\">";

	print "&nbsp;";
	print "&nbsp;";
	print "<b>";
	print $user;
	print "</b>";
	print "&nbsp;";
	print "<font color=\"grey\" size=1>";
	print "@ $test_date $test_time";
	print "</font>";
	print "&nbsp;&nbsp;";
	print "<a href=\"$test_result_url\" class=\"btn btn-mini btn-success\" style=\"margin-bottom: 5px;\"><i class=\"icon-leaf icon-white\"></i> View</a>";
	print "</a>";
	
	if( preg_match("/^UI/", $testname) || preg_match("/^CI/", $testname) || preg_match("/^GA/", $testname) || preg_match("/^qa/", $testname) ){ 
		print "&nbsp;<span class=\"label label-warning\">QA</span>";
	};

	if( preg_match("/pkg/", $testname) ){ 
		print "&nbsp;<span class=\"label label-inverse\">PKG</span>";
	};

	if( preg_match("/vnx/", $testname) || preg_match("/san/", $sequence) || preg_match("/multipath/", $sequence) || preg_match("/multistorage/", $sequence) ){ 
		print "&nbsp;<span class=\"label label-default\">SAN</span>";
	};

	if( preg_match("/rhel/", $testname) ){ 
		print "&nbsp;<span class=\"label label-default\">RHEL</span>";
	};

	if( preg_match("/upgrade/", $testname) ){ 
		print "&nbsp;<span class=\"label label-default\">UPGRADE</span>";
	};

	if( preg_match("/vmware/", $testname) ){ 
		print "&nbsp;<span class=\"label label-default\">VMWARE</span>";
	};

	if( preg_match("/windows/", $sequence) ){ 
		print "&nbsp;<span class=\"label label-default\">WINDOWS</span>";
	};

	if( preg_match("/-ha-/", $testname) ||  preg_match("/-ha-/", $sequence) ){ 
		print "&nbsp;<span class=\"label label-default\">HA</span>";
	};

	print "<br>";

	print "&nbsp;";
	print "<font color=\"black\" size=1>";
	print "TESTNAME ";
	print "</font>";
	print "<font color=\"blue\">";
	print "$testname ";
	print "</font>";

	print "<br>";

	print "&nbsp;";
	print "<font color=\"black\" size=1>";
	print "UID ";
	print "</font>";
	print "<font color=\"navy\">";
	print "$uid";
	print "</font>";

	print "&nbsp;";
	print "<font color=\"black\" size=1>";
	print "GIT HASH ";
	print "</font>";
	print "<font color=\"brown\">";
	print substr($git_hash, 0, 8) . "..";
	print "</font>";

	print "<br>";

	print "&nbsp;";
	print "<font color=\"black\" size=1>";
	print "SEQUENCE ";
	print "</font>";
	print "<font color=\"green\">";
	print "$sequence ";
	print "</font>";
	print "<font color=\"black\" size=1>";
	print "OS ";
	print "</font>";
	print "<font color=\"orange\">";
	print "$os ";
	print "</font>";
	
	print "<br>";

	print "</div>";		### CLOSING class=span10
	print "</div>";		### CLOSING class=row-fluid
	print "</div>";		### CLOSING class=container-fluid

	### DIV BLOCK for Test Result and Progress BAR
	print "<div class=\"container-fluid\" style=\"margin-bottom: 0px;\">";	
	print "<div class=\"row-fluid\">";
	print "<div class=\"span9\" style=\"margin-bottom: 0px;\" >";

	if( $test_stage == "passed" ){
		print "<span class=\"label label-success\">PASSED</span>";
	}else if( $test_stage == "failed" ){
		print "<span class=\"label label-important\">FAILED</span>";
	}else if( $test_stage == "killed" ){
		print "<span class=\"label label-inverse\">KILLED</span>";
	}else if( $test_stage == "running" ){
		$percent = rand(30,90);
		$progress = $percent . "%";				
		$progress_class = "progress-success progress-striped active";

		### FOR MOCK-UP PROGRESS BAR 
		if( $percent % 7 == 0 ){
			$progress_class = "progress-warning progress-striped active";
		}else if( $percent % 10 == 0 ){
			$progress_class = "progress-danger progress-striped active";
		};

		print "<font size=1>";
		print "PROGRESS";
		print "</font>";

		print "<div class=\"progress " . $progress_class . "\" style=\"height: 15px; margin-top: 5px; margin-bottom: 5px; \">";
		print "<div class=\"bar\" style=\"width: " . $progress . "; \"></div>";
		print "</div>";
	};

	print "</div>";			### CLOSING span9

	### TWITTER BUTTON
	print "<div class=\"span3\" style=\"margin-bottom: 0px; text-align: right;\" >";	### OPENING span3
	print "<a href=\"https://twitter.com/intent/tweet?screen_name=eucalyptus\" class=\"twitter-share-button\" data-lang=\"en\" data-count=\"none\" data-url=\"".$test_result_url."\" data-text=\"[Ask ". $user. "]: \" data-related=\"eucalyptus,kyolee,cloud computing\">Tweet</a>";

	print "</div>";			### CLOSING span3

	print "</div>";			### CLOSING class=row-fluid
	print "</div>";			### CLOSING class=container-fluid
	### DIV BLOCK for Progress Bar Closed

	print "</div>";			### CLOSING class=well

	return;
};


?>


