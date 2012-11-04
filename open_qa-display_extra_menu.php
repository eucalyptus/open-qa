<?php

$testname = $_POST["testname"];
$uid = $_POST["uid"];
$testunit= $_POST["testunit"];

$description = "[NO DATA]";
$output = "";

if( preg_match("/^(\S+)_No_(\d+)/" , $testunit, $match) ){
	$testunit = $match[1];
};

if( $testunit == "TEST" ){
	$testunit = "auto_pilot";
	$description = display_test_info($testunit);
#	$output = compute_test_duration($testname, $uid, $testunit);
}else if( $testunit == "BUILD" ){
	$description = display_test_info($testunit);
#	$output = compute_build_duration($testname, $uid, $testunit);
}else if( $testunit == "PXEBOOT" ){
	$description = display_test_info($testunit);
#	$output = compute_pxe_duration($testname, $uid, $testunit);
}else{
	$description = display_test_info($testunit);
#	$output = compute_test_duration($testname, $uid, $testunit);
};

###	NO DATE UNTIL BACKEND IS ESTABLISHED
$output = "DURATION: [NO DATA]";

if( strlen($description) > 140 ){
	$description = substr($description, 0, 140);
	$description .= "...";
};

print "<font size=1>";
print "<br>";
print "&nbsp; &nbsp;";
print "Testunit <font color=\"green\">$testunit</font><br>";
print "<font color=\"blue\">";
print "&nbsp; &nbsp; &nbsp; &nbsp;";
print $description;
print "</font>";
print "<br>";
print "</font>";

print "<div style=\"padding:5px;\"><pre>". $output . "</pre></div>";

exit(0);


function display_test_info($testunit){

	$info = `cat ./webcache/test_info/testunit_info.txt | grep $testunit`;
	$iarray = explode("\n", $info);
	if( count($iarray) > 0 ){
		foreach( $iarray as $line ){
			if( preg_match("/$testunit\s+(.+)/", $line, $match) ){
				$info = $match[1];
			};
		};
	};

	return $info;
};


function compute_test_duration($testname, $uid, $testunit){
	$url = "http://10.1.1.210/test_space/" . $testname . "/" . $uid . "/" . $testunit . "/artifacts/";

	$check = 1;
	$check = `wget -O /dev/null -q $url && echo 1 || echo 0`;

	if( $check == 0 ){
		return "[NO DATA]";
	};

	$list = `perl ./compute_test_duration.pl $testname $uid $testunit`;
	return $list;
}; 

function compute_build_duration($testname, $uid, $testunit){
	$url = "http://qa-server/euca-qa/build_log/" . $testname . "/" . $uid . "/";

	$check = 1;
	$check = `wget -O /dev/null -q $url && echo 1 || echo 0`;

	if( $check == 0 ){
		return "[NO DATA]";
	};

	$list = `perl ./compute_build_duration.pl $testname $uid`;
	return $list;
};

function compute_pxe_duration($testname, $uid, $testunit){
	$url = "http://qa-server/euca-qa/pxe_log/" . $testname . "/" . $uid . "/";

	$check = 1;
	$check = `wget -O /dev/null -q $url && echo 1 || echo 0`;

	if( $check == 0 ){
		return "[NO DATA]";
	};

	$list = `perl ./compute_pxe_duration.pl $testname $uid`;
	return $list;
};


function my_sort($a,$b){
	return strnatcmp($a, $b);
};




?>


