<html>
<head>
<title>
TESTUNIT INFORMATION
</title>
</head>
<body>

<div style="position:absolute; top: 30; right: 50;" >
<img src="./image/euca_new_logo.jpg" width=150>
</div>

<?php
	$prev_page = $_SERVER['HTTP_REFERER'];
	if( isset($_GET["prev_page"]) ){
	        $prev_page = $_GET["prev_page"];
	};

?>

<table>
<tr>
<td width=150>
<a href="open_qa.php">
<font color="green">
BACK TO MAIN
</font>
</a>
<td>
<a href="<?php print $prev_page; ?>">
<font color="green">
PREVIOUS PAGE
</font>
</a>
</table>
<br>

<?php

echo "TESTUNIT INFORMATION<br>";
echo "<br>";
echo "<hr>\n";
echo "<div style=\"background:#41A317; padding:2px;\"></div><br>\n";

$testunit= $_GET["testunit"];

if( preg_match("/^(\S+)_No_(\d+)/", $testunit, $match) ){
	$testunit = $match[1];
};

$description = "";
$source_repo = "";
$procedure = "[testunit_procedure_comes_here]";

if( $testunit == "TEST" ){
	$testunit = "auto_pilot";
	$description = display_test_info($testunit);

	$source_repo = "[NO DATA]";
}else if( $testunit == "BUILD" ){
	$description = display_build_info($testunit);

	$source_repo = "git+ssh://repo-euca@git.eucalyptus-systems.com/mnt/repos/qa/euca_builder";
}else if( $testunit == "PXEBOOT" ){
	$description = display_pxe_info($testunit);

#	$source_repo = "git+ssh://repo-euca@git.eucalyptus-systems.com/mnt/repos/qa/pxe_module";
	$source_repo = "[NO DATA]";
}else{
	$description = display_test_info($testunit);

	$source_repo = "git+ssh://repo-euca@git.eucalyptus-systems.com/mnt/repos/qa/testunit/$testunit";
	$procedure = display_testunit_procedure($testunit);
};

print "<br>";
print "Testunit ";
print "<font color=\"green\">";
print $testunit;
print "</font>";
print "<br>";
print "<br>";

print "<div style=\"padding:5px;\">";

print "Description:";
print "<br>";

print "<font color=\"blue\">";
print "<div style=\"padding:5px;\"><pre>". $description . "</pre></div>";
print "</font>";

print "Source Repository:";
print "<br>";

print "<font color=\"gold\">";
print "<div style=\"padding:5px;\"><pre>". $source_repo . "</pre></div>";
print "</font>";

#print "Github Link:";
#print "<br>";

print "Procedure:";
print "<br>";

print "<font color=\"grey\">";
print "<div style=\"padding:5px;\"><pre>". $procedure . "</pre></div>";
print "</font>";

print "</div>";

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

function display_build_info($testunit){

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

function display_pxe_info($testunit){

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


function display_testunit_procedure($testunit){

	$list = "[procedure_for_testunit_" . $testunit . "_comes_here]";
	$procedure_file = "./webcache/test_info/procedures/" .$testunit . ".txt"; 
	if( file_exists($procedure_file) ){
		$list = `cat $procedure_file`;
	};

	return $list;
}; 


?>

</body>
</html>

