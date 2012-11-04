<?php 
	
	include './open_qa-lib.php';

	if( isset($_GET['lastIndex']) ){
		$lastIndex = $_GET['lastIndex'];
#		print "Last Test Block Loaded: " . $lastIndex . "<br>";
	}

	######################## SETUP DATABASE CONNECTION ####################################################

#	include './lib/db_display_helpers.php';
	include './open_qa-display_helper.php';

	######################## PREPARE DATA ##################################################################

	### GET TODAY'S DATE
	$today_date = "20" . date("y-m-d", time());
	$prev_date = get_prev_date($lastIndex);
	$this_test_date = $prev_date;

	### GET ALL TEST RECORDS FROM THE DATE
	$buffer = get_tests_given_date($database, $prev_date);

	$test_array = explode("\n", $buffer);

	######################## HTML ###########################################################################

	print_page_header_this_date($this_test_date);

	foreach( $test_array as $this_test ){
		if( preg_match("/^\[(\d+\-\d+\-\d+)\s+(.+)\]\s+TESTNAME\s(\S+)\sUID\s(\d+)\sSEQUENCE\s(\S+)\sOS\s(\S+\s\S+)\sGIT_HASH\s(\S+)\sTEST_STAGE\s(\S+)/" , $this_test, $match) ){

			$matched_test_date = $match[1];
			$matched_test_time = $match[2];
			$matched_testname = $match[3];
			$matched_uid = $match[4];
			$matched_sequence = $match[5];
			$matched_os = $match[6];
			$matched_git_hash = $match[7];
			$matched_test_stage = $match[8];

			$matched_user = "unknown";

			if( preg_match("/^(\w+)\-/", $matched_testname, $match2) ){
				$matched_user = $match2[1];
			};

			###	CREATE NEW LINE FOR NEW DATE
			if( $matched_test_date != $this_test_date ){
				$this_test_date = $matched_test_date;
				print_page_header_this_date($this_test_date);
			};

			print_test_result_well($matched_test_date, $matched_test_time, $matched_testname, $matched_uid, $matched_sequence, $matched_os, $matched_git_hash, $matched_test_stage, $matched_user, $matched_test_date);
	
		};
	};

	print_hidden_div_block_for_inifiniti_scrolling();

	######################## HTML: END ####################################################################

?>

