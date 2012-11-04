#!/usr/bin/perl

use strict;

my $cache_dir = "/tmp/temp/webcache";
my $storage_dir = "./cache_storage_for_open_qa";
my $filter = "_NONE";

my @testname_array;
my @uid_array;

my $line;

### 	CHECK FOR FILTER INPUT
if( @ARGV > 1 ){
	$filter = shift @ARGV;
	print "\n";
	print "FILTER IS SET TO: $filter\n";
	print "\n";
};

print "\n";

###	CREATE DIRECTORIES FOR CACHE TRANSFER
print("rm -rf $storage_dir\n");
system("rm -rf $storage_dir");

print("mkdir -p $storage_dir/graphs\n");
system("mkdir -p $storage_dir/graphs");

print("mkdir -p $storage_dir/test_info/procedures\n");
system("mkdir -p $storage_dir/test_info/procedures");

print("mkdir -p $storage_dir/config_file_storage/inactive\n");
system("mkdir -p $storage_dir/config_file_storage/inactive");

print("mkdir -p $storage_dir/test_share/mod_2b_tested_dir\n");
system("mkdir -p $storage_dir/test_share/mod_2b_tested_dir");

print "\n";

###	READ THE LIST OF TESTS THAT RAN ON A SPECIFIC DATE
my $scan1 = `ls $cache_dir | grep this_date | sort`;
my @file_list1 = split("\n", $scan1);

print "\n";

###	GATHER THE LIST OF TESTNAMES AND UIDS
for(my $i=0; $i<7 && $i<@file_list1; $i++){
	my $file = $cache_dir . "/" . $file_list1[@file_list1-$i-1];		###	REVERSE ORDER, GET LATEST 7 DAYS ONLY
	open(LIST, "< $file") or die $!;
	while( $line = <LIST>){
		chomp($line);
		###		SCAN FOR TESTNAME AND UID
		if( $line =~ /^(\S+)\s+(\d+)/ ){
			my $testname = $1;
			my $uid = $2;
			###		FILTER TESTNAME IF NECESSARY
			if( $filter eq "_NONE" || !($testname =~ /^$filter/) ){
				push(@testname_array, $testname);
				push(@uid_array, $uid);
			}; 
		};
	};
	close(LIST);
	
	###	COPY THE LIST FILE OVER TO THE STORAGE DIR
	copy_the_file_over_to_storage($file, $storage_dir);
};

print "\n";

###	COPY THE CONTENT FILE OVER TO THE STORAGE DIR
for(my $i=0; $i<@testname_array; $i++){
	my $testname = $testname_array[$i];
	my $uid = $uid_array[$i];
	my $cache_filename = "$cache_dir/open_qa_" . $testname . "_UID_" . $uid . ".cache";
	my $table_body_filename = "$cache_dir/body_" . $testname . "_UID_" . $uid . ".cache";
	my $graph_filename = "/home/www/euca-qa/test-history-graphs/graphs/graph_test_history_" . $testname . ".png";
	my $test_config_filname = "/home/qa-server/control_module/config_file_storage/inactive/" . $testname . ".conf";;
	
	copy_the_file_over_to_storage($cache_filename, $storage_dir);
	copy_the_file_over_to_storage($table_body_filename, $storage_dir);
	copy_the_file_over_to_storage($graph_filename, $storage_dir . "/graphs");
	copy_the_file_over_to_storage($test_config_filname, $storage_dir . "/config_file_storage/inactive/.");
};


###	COPY THE TEST INFORMATION FILES OVER TO THE STORAGE DIR
my $test_info_file = "/home/www/euca-qa/helper/display_testunit_info_helper/testunit_info.txt";
copy_the_file_over_to_storage($test_info_file, $storage_dir . "/test_info/.");
print "\n";

my $procedure_files = "/home/www/euca-qa/helper/display_testunit_info_helper/procedures/*";
copy_the_file_over_to_storage($procedure_files, $storage_dir . "/test_info/procedures/.");
print "\n";

###	COPY MOD_2B_TESTED_DIR FROM MAIN TESTER
my $command = "scp -r -o BatchMode=yes -o ServerAliveInterval=3 -o ServerAliveCountMax=10 -o StrictHostKeyChecking=no test-server\@litmus:~/test_share/mod_2b_tested_dir/. $storage_dir/test_share/mod_2b_tested_dir/.";
system($command);

print "\n";
print "rm -f " . $storage_dir . ".tar.gz\n"; 
system("rm -f " . $storage_dir . ".tar.gz"); 

print "tar -zcf " . $storage_dir . ".tar.gz " . $storage_dir . "\n";
system("tar -zcf " . $storage_dir . ".tar.gz " . $storage_dir);

print "\n";
print "DONE\n";
print "\n";

print "\n";
print "================== NEXT STEPS ========================\n";
print "\n";

print "\n";
print "1. COPY YOUR PUB KEY TO THE AWS INSTANCE's ~/.ssh/authorized_keys\n";
print "\n";
print "cat ~/.ssh/id_rsa.pub\n";
print "\n";
system("cat ~/.ssh/id_rsa.pub");
print "\n";

print "\n";
print "2. COPY THE TARBALL OVER TO THE AWE INSTANCE\n";
print "\n";
print "scp $storage_dir.tar.gz ec2-user\@ec2-##-###-##-###.us-####-#.compute.amazonaws.com::~/.\n";
print "\n";

print "\n";
print "3. UNTAR IT\n";
print "sudo tar -zxvf $storage_dir.tar.gz\n";
print "\n";

print "4. TRANSFER THE FILES TO /var/www/html/webcache/.\n";
print "\n";
print "sudo cp -r $storage_dir/* /var/www/html/webcache/.\n";
print "\n";


exit(0);

############################# SUBROUTINE #################################

sub copy_the_file_over_to_storage{
	my $filename = shift @_;
	my $target = shift @_;
        print("cp -f $filename $target/.\n");
        system("cp -f $filename $target/.");
	return;
};

1;

