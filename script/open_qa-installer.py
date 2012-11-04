#!/usr/bin/env python

import time
import sys
import os
from optparse import OptionParser

def run_cmd(command):
	print "CMD: " + command
	print
	os.system(command)
	print	
	time.sleep(1)
	return

def main():

	print
	print "===== OPEN QA INSTALLER ON AWS ======"
	print

	parser = OptionParser()
	parser.add_option("-t", "--instance-type", dest="instance", help="linux distro instance type: ['amazon-linux', 'rhel6']")
	parser.add_option("-e", "--email", dest="email", help="admin email")
	(options, args) = parser.parse_args()

	if options.instance is None:
		print "Need Input 'instance'; Use --help Option"
		exit()
	
	if options.email is None:
		print "Need Input 'email'; Use --help Option"
		exit()

	print "=== ENVIRONMENT ==="
	print
	print "INSTANCE TYPE: " + options.instance
	print "EMAL: " + options.email
	print
	print

	cmd = "sudo yum -y update"
	run_cmd(cmd)

	cmd = "sudo yum -y install httpd"
	run_cmd(cmd)
	
	cmd = "sudo chkconfig httpd on"
	run_cmd(cmd)
	
	cmd = "sudo service httpd start"
	run_cmd(cmd)
	
	cmd = "sudo netstat -tulpn | grep :80"
	run_cmd(cmd)
	
	cmd = "sudo httpd -V"
	run_cmd(cmd)

	cmd = "sudo sed --in-place 's/#HTTPD=/HTTPD=/' /etc/sysconfig/httpd"
	run_cmd(cmd)

	cmd = "sudo sed --in-place 's/ServerAdmin .*/ServerAdmin " + options.email + "/' /etc/httpd/conf/httpd.conf"
	run_cmd(cmd)
	
	cmd = "sudo yum -y install php"
	run_cmd(cmd)

	if options.instance is "rhel6":
		cmd = "sudo yum -y install php-zts"
        	run_cmd(cmd)

	cmd = "sudo ln --symbolic --force /usr/share/zoneinfo/America/Los_Angeles /etc/localtime"
	run_cmd(cmd)

	cmd = "sudo service ntpd restart"
	run_cmd(cmd)

	cmd = "sudo service httpd restart"
	run_cmd(cmd)

	cmd = "sudo cp -r ../../open_qa/. /var/www/html/."
	run_cmd(cmd)

	print
	print "===== OPEN QA INSTALLER ON AWS : DONE ====="
	print


if __name__ == "__main__":
    main()
    exit


