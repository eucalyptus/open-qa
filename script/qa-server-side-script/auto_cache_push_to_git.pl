#!/usr/bin/perl

use strict;

my $THIS_DIR = "/root/open_qa_transfer";

my $log_time = print_time();
my $this_date = print_yesterday();

if( @ARGV > 0 ){
	$this_date = shift @ARGV;
};

print "\n";
print "$log_time\n";
print "== auto_cache_push_to_git.pl $this_date ==\n";
print "\n";

my $cmd = "cd $THIS_DIR; ./generate_cache_for_today.pl $this_date";
run_cmd($cmd);

$cmd = "cd $THIS_DIR; ./open_qa_data_create_a_tarball.pl $this_date";
run_cmd($cmd);

$cmd = "cd $THIS_DIR; ./clear_cache_for_today.pl $this_date";
run_cmd($cmd);

$log_time = print_time();
print "\n";
print "$log_time\n";
print "== auto_cache_push_to_git.pl $this_date : DONE ==\n";
print "\n";

exit(0);

1;

sub print_time{
	my ($sec,$min,$hour,$mday,$mon,$year,$wday, $yday,$isdst)=localtime(time);
	my $this_time = sprintf "[%4d-%02d-%02d %02d:%02d:%02d]", $year+1900,$mon+1,$mday,$hour,$min,$sec;
	return $this_time;
};



sub print_yesterday{
	my ($sec,$min,$hour,$mday,$mon,$year,$wday, $yday,$isdst)=localtime(time);
	my $yesterday = sprintf "%02d-%02d", $mon+1,$mday-1;
	return $yesterday;
};

sub run_cmd{
	my $cmd = shift @_;
	print "\n";
	print "CMD $cmd\n";
	system($cmd);
	print "\n";
	return;
};

1;

