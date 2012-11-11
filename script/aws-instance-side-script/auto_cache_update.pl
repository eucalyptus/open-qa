#!/usr/bin/perl

use strict;

my $THIS_DIR = "/home/ec2-user/open-qa-frontend-data";

my $log_time = print_time();

print "\n";
print "$log_time\n";
print "== auto_cache_update.pl ==\n";
print "\n";

my $cmd = "cd $THIS_DIR; git pull";
run_cmd($cmd);

$cmd = "cd $THIS_DIR; sudo rm -fr cache_storage_for_open_qa";
run_cmd($cmd);

$cmd = "cd $THIS_DIR; sudo tar -zxvf ./cache_storage_for_open_qa.tar.gz";
run_cmd($cmd);

$cmd = "cd $THIS_DIR; sudo cp -r ./cache_storage_for_open_qa/* /var/www/html/webcache/.";
run_cmd($cmd);

print "\n";
print "$log_time\n";
print "== auto_cache_update.pl : DONE ==\n";
print "\n";


exit(0);

1;

sub print_time{
	my ($sec,$min,$hour,$mday,$mon,$year,$wday, $yday,$isdst)=localtime(time);
	my $this_time = sprintf "[%4d-%02d-%02d %02d:%02d:%02d]", $year+1900,$mon+1,$mday,$hour,$min,$sec;
	return $this_time;
};

sub run_cmd{
	my $cmd = shift @_;
	print "\n";
	print "CMD $cmd\n";
	system($cmd);
	print "\n";
	return;
};

