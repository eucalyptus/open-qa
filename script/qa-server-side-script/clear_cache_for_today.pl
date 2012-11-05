#!/usr/bin/perl

use strict;

if( @ARGV < 1 ){
	print "NEED INPUT DATE: <MM-DD>\n";
        exit(1);
};

my $today = shift @ARGV;

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
		### CLEAR THE CACHE
		if( -e "/tmp/temp/webcache/$cache" ){
			print "rm -f /tmp/temp/webcache/$cache\n";
			system("rm /tmp/temp/webcache/$cache");
			sleep(1);
		};
		print "\n";
	};
};

exit(0);
1;

