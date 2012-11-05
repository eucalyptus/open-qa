#!/usr/bin/perl

use strict;

if( @ARGV < 1 ){
	print "NEED INPUT DATE: <MM-DD>\n";
        exit(1);
};

my $today = shift @ARGV;

my $internal_open_qa = "http://qa-server.eucalyptus-systems.com/euca-qa/open_qa.php";
print "wget -qO- $internal_open_qa > /dev/null\n";
system("wget -qO- $internal_open_qa > /dev/null 2> /dev/null");

my $inputlist = "/tmp/temp/webcache/this_date_test_list_2012-".$today.".lst";;

if( !(-e $inputlist) ){
	print "CANNOT LOCATE FILE: $inputlist !!\n";
	exit(1);
};

my $tempbuf = `cat $inputlist`;
my @array1 = split("\n", $tempbuf);

foreach my $line (@array1){
	if( $line =~ /^(\S+)\s+(\d+)/ ){
		my $testname = $1;
		my $uid = $2;
		print "\n";
		print "$testname $uid\n";
		my $cache = "body_".$testname."_UID_".$uid.".cache";
		### TRY TO GENERATE CACHE
		if( !(-e "/tmp/temp/webcache/$cache")){
			my $url = "http://qa-server.eucalyptus-systems.com/euca-qa/cache_test.php?testname=". $testname . "\\\&uid=" . $uid;
			print "wget -qO- $url > /dev/null\n";
			system("wget -qO- $url > /dev/null 2> /dev/null");
			sleep(1);
		};
		print "\n";
	#	if( !(-e "/tmp/temp/webcache/$cache")){
	#		### IF NO CACHE EXISTS, MEANS FAILED BEFORE TEST
	#		system("sed --in-place 's/$testname $uid//' $inputlist");
	#	};
	};
};

exit(0);
1;

