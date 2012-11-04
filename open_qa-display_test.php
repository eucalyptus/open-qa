
<html>
<head>
<title>Display Test</title>

<style type="text/css">
   
a {
	text-decoration:none;
}

a:link {
        color: blue
}
a:visited {
        color: blue 
}
a:hover {
        color: red;
	text-decoration:underline;
}

#t_unit { color: black }

#extra_menu { width:200px; height:140px; background:#ff9900; opacity:0.8; border:2px solid black; display:block; }
#extra_menu { float: right; position: fixed; bottom:140px; right:10px; }
   
</style>

<script language="Javascript">

function xmlhttpPost(strURL, str1, str2, str3, divbox) {
    var xmlHttpReq = false;
    var self = this;
    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open('POST', strURL, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4) {
            updatepage(divbox, self.xmlHttpReq.responseText);
        }
    }
    self.xmlHttpReq.send(getquerystring(str1, str2, str3));
}

function getquerystring(str1, str2, str3) {
    var testname = str1;
    var uid = str2;
    var testunit = str3;
    qstr = 'testname=' + escape(testname) + '&uid=' + escape(uid) + '&testunit=' + escape(testunit);  // NOTE: no '?' before querystring
    return qstr;
}

function updatepage(divbox, str){
	document.getElementById(divbox).innerHTML = str;
}

function displayTestunitInfo(str1, str2, str3, divbox){
	var newtab = "";
//	newtab = "./open_qa-display_testunit_info.php?testunit=" + str3;
	newtab = "https://github.com/eucalyptus-qa/" + str3;
	window.open(newtab);
};

function extra_menu(str1, str2, str3, divbox){
	xmlhttpPost("./open_qa-display_extra_menu.php", str1, str2, str3, divbox);
};

function displayEmpty(divbox){
	updatepage(divbox, "<br><br><br><center><img src=\"./image/euca_new_logo.jpg\" width=150></center>");
};


</script>


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
				<font color="green">BACK TO MAIN</font>
			</a>
		<td>
			<a href="<?php print $prev_page; ?>">
				<font color="green">PREVIOUS PAGE</font>
			</a>
</table>
<br>

<?php

	$testname = "_NONE";
	if( isset($_GET["testname"]) ){
	        $testname= $_GET["testname"];
	};

	$uid = "_NONE";
	if( isset($_GET["uid"]) ){
	        $uid = $_GET["uid"];
	};
	
	######################## HTML BODY ####################################################################

	echo "<div id=\"extra_menu\" style=\"background:white\">";
	echo "<br><br><br><center><img src=\"./image/euca_new_logo.jpg\" width=150></center>";
        echo "</div>";

	print "<table><tr><td valign=\"top\">";

	echo "Display Test\n";

        print "<td valign=\"top\">";

        $uid_up = $uid+1;

        print "<form method=\"get\" action=\"$PHP_SELF\">";
        print "<input type=\"hidden\" value=\"" . $testname . "\" name=\"testname\" >";
        print "<input type=\"hidden\" value=\"" . $uid_up . "\" name=\"uid\" >";
        print "<input type=\"hidden\" value=\"" . $prev_page . "\" name=\"prev_page\" >";

        print "<input type=\"submit\" value=\"Up\" name=\"Refresh\" style=\"height: 1.6em; width: 5em\">";
        print "</form>";

	print "<td valign=\"top\">";

	$uid_down = $uid-1;

        print "<form method=\"get\" action=\"$PHP_SELF\">";
        print "<input type=\"hidden\" value=\"" . $testname . "\" name=\"testname\" >";
        print "<input type=\"hidden\" value=\"" . $uid_down . "\" name=\"uid\" >";
        print "<input type=\"hidden\" value=\"" . $prev_page . "\" name=\"prev_page\" >";

        print "<input type=\"submit\" value=\"Down\" name=\"Refresh\" style=\"height: 1.6em; width: 5em\">";
        print "</form>";

	print "</tr></table>";

	echo "<hr>\n";
	echo "<div style=\"background:#41A317; padding:2px;\"></div><br>\n";

	print "<table><tr>";
	print "<td valign=\"top\">";
	print "<font color=\"green\">TESTNAME</font>";
	print "</td><td valign=\"top\">";
	print "$testname";
	print "<td valign=\"top\">";
	print "<font color=\"green\">UID</font>";
	print "</td><td valign=\"top\">";
	print "$uid";

	print "</td>";

	print "</tr></table>";

	$buffer = "";

	$buffer = get_buffer_of_result_given_testname_and_uid($database, $testname, $uid);

	$new_buffer = process_test_table($buffer, $testname, $uid);

	print $new_buffer;

	echo "<br>";
	
	echo "<hr>\n";
	echo "<div style=\"background:#41A317; padding:2px;\"></div><br>\n";

?>

</body>
</html>


<?php

function print_test_history_graph($testname, $uid){

	$last_uid_file = $testname . "_last.uid";

	$this_time = date("H:i:s");
	$graph_name = "graph_test_history_" . $testname . ".png";

	print "<div style=\"background:white; padding-top:3px; padding-left:50px;\">";
#	print "<a href=\"/euca-qa/test-history-graphs/graphs/" . $graph_name . "?" .$this_time. "\" link=\"white\" vlink=\"white\">";
#	print "<img src=\"./test-history-graphs/graphs/" . $graph_name . "?". $this_time ."\" width=150><br>";
	print "<a href=\"./webcache/graphs/" . $graph_name . "?" .$this_time. "\" link=\"white\" vlink=\"white\">";
	print "<img src=\"./webcache/graphs/" . $graph_name . "?". $this_time ."\" width=150><br>";
	print "</a>";

	print "<font color=\"green\" style=\"FONT-SIZE:9pt; padding-left:40px;\">";
	print "Test History";
	print "</font>";

	print "</div>";

	return 0;
};

function escape_div($str){
        $pattern = "<div>";
        $replace = "";

        $new = ereg_replace($pattern, $replace, $str);
	return $new;
};

function scan_for_mod_2b_tested_dir($testname, $uid){
	$loc = "/home/www/euca-qa/config_file_storage/inactive/" . $testname . ".conf";

	$temp = `cat $loc | grep MOD_2B_TESTED_DIR`;	

	$share_dir = "";

	if( preg_match("/MOD_2B_TESTED_DIR=(\S+)/", $temp, $results) ){
		$dir = $results[1];
		$share_dir = "http://10.1.1.210/test_space/" . $testname . "/". $uid . "/auto_pilot/share/mod_2b_tested_dir/" . $dir;
	};
	
	return $share_dir;
};


function process_test_table($table, $this_testname, $this_uid){

	$headline = "";
	$body = "";

	if( preg_match("/(<table\s.+)(<table\s.+)/s", $table, $temps) ){	
		$headline = $temps[1];
		$body = $temps[2];
	};

	$headline = escape_div($headline);

	print "<table valign=\"top\"><tr valign=\"top\"><td>";

	print "<pre>";
	print $headline;
	print "</pre>";

	print "</td><td valign=\"top\">";
	print_test_history_graph($this_testname, $this_uid);
	print "</td></tr></table>";

#	print "<br>=================================<br>";

#	print "<pre>";
#	print $body;
#	print "</pre>";

#	print "<br>=================================<br>";

	$testunits = "";
	$results = "";

	if( preg_match("/<tr>(.+)<tr>(.+)/s", $body, $temps2) ){	
		$testunits = $temps2[1];
		$results = $temps2[2];
	};

#	print "<br>=================================<br>";
	
	$temp_array = preg_split("/<th>/", $testunits);
	$temp_array2 = preg_split("/<td/", $results);


	$count = count($temp_array);
	
	$col_count = 0;
	$max_col = 3;
	$curr_num = -1;
	$first_row = 1;

	print "<table><tr><td valign=\"top\">";
	print "<font color=\"green\">";
	print "Results Matrix";
	print "</font>";
	print "</tr></table>";

	print "<table style=\"border-collapse: collapse; table-layout: auto;\" border=\"1\" cellpadding=\"3\" rules=\"all\">";
	print "<tr>";

	for($i=0; $i<$count; $i++){
		$t_unit = $temp_array[$i];
		$t_result = $temp_array2[$i];

		if( preg_match("/(.+)<\/th>/", $t_unit, $strip) ){
			$t_unit = $strip[1];
		};

		if( preg_match("/(<a\s.+<\/a>)/", $t_result, $strip) ){
			$t_result = $strip[1];
		};

		if( preg_match("/.+_No_(\d+)/", $t_unit, $num) ){
			if( $curr_num < $num[1] ){
				$curr_num = $num[1];
				print "</tr>";
				print "<td>";
				$mod_dir = scan_for_mod_2b_tested_dir($this_testname, $this_uid);
				$mod_file = $mod_dir . "/case_" . $curr_num . ".txt"; 
				print "<a href=\"$mod_file\"><font color=\"blue\">Iteration No_".$curr_num . "</font></a><br>";
				print "<tr>";
				$col_count = $max_col;
			}; 
		};

		if( $col_count >= $max_col){
			$col_count = 0;
			print "</tr>";
			print "<tr>";
			if( $first_row == 1 ){
				print "</tr>";
				print "<tr><td><td><td><td><td><td></tr>";
				print "<tr>";
				$max_col = 4;				
			};
			$first_row = 0;
		};

		if( $t_unit != ""){
		#	print "<td>$t_unit";
#			print "<td><a href=\"./display_testunit_info.php?testunit=$t_unit\" id=\"t_unit\" ";

			if( preg_match("/^(\S+)_No_(\d+)$/", $t_unit, $match) ){
				$t_unit = $match[1];
			};

			print "<td><a href=\"$PHP_SELF\" id=\"t_unit\" ";
			print "onclick=\"JavaScript:displayTestunitInfo('$this_testname', '$this_uid', '$t_unit', 'extra_menu');\" ";
			print "onmouseover=\"JavaScript:extra_menu('$this_testname', '$this_uid', '$t_unit', 'extra_menu');\" ";
			print "onmouseout=\"JavaScript:displayEmpty('extra_menu');\">";
			print $t_unit;
			print "</a>";
			print "<td>$t_result";

			###	GET FAIL SCORE	121611
			if( $t_unit != "TEST" && 0){
				if( preg_match("/failed/", $t_result) ){
					$score = get_fail_score($this_testname, $this_uid, $t_unit);
					print "<font size=2>" . $score . "</font>";
				};
			};

			$col_count++;
		};
		
	};

	print "</table>";

	return;
};

function get_buffer_of_result_given_testname_and_uid($my_db, $this_test, $this_uid){

#	$cache_dir = "/tmp/temp/webcache";
	$cache_dir = "./webcache";
	$cache_filename = "body_" . $this_test . "_UID_" . $this_uid . ".cache";
	$this_cache = $cache_dir . "/"  . $cache_filename;
	$buffer = "";

	### GET IT FROM CACHE
	$buffer = `cat $this_cache`;

	return $buffer;
};


function get_fail_score($testname, $uid, $testunit){
	$lines = `sudo -u qa-group perl /home/qa-server/lib/fail_score/get_fail_score.pl $testname $uid $testunit| grep NORMALIZED`;
	$score = "";	

	$temp = explode("\n", $lines);
	foreach ($temp as $key => $value) {
		if( preg_match("/ORDER\)\s+([\.\d]+)/", $value, $match) ){
			$score .= $match[1] . ",";
		};
	};
	$score = chopchop($score);

	if( $score != "" ){
		$score = "(" . $score . ")";
	};	

	return $score;
};


function chopchop($str){
	return substr($str, 0, -1);
};


?>
