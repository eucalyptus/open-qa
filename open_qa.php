<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Open QA</title>

<!-- TWITTER BOOTSTRAP CSS -->

<link href="css/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 

<!-- OPEN_QA CSS -->

<link href="css/open_qa.css" rel="stylesheet" type="text/css"> 

<!-- JQUERY 1.8.2 JS -->

<script type="text/javascript" src="js/jQuery/jquery-1.8.2.min.js"></script>

<!-- TWITTER BOOTSTRAP JS -->

<script type="text/javascript" src="css/bootstrap/js/bootstrap.js"></script> 

<!-- OPEN_QA JS -->

<script type="text/javascript" src="js/open_qa.js"></script> 

</head>

<body>

<!-- MESSAGE BOARD -->

<div class="show screen page" id="myscreen" style="position:fixed; top:100px;" >
	Welcome to Open QA<br>
</div>
<div class="hide screen page" id="myabout" style="position:fixed; top:100px;" >
	<font color="grey"><b>Open QA</b></font> is a <font color="orange">Collaborative</font> Space for <font color="brown">Active</font> Development of <font color="green">Eucalyptus</font>.<br>
	<br>
	<a href="#" class="btn btn-mini btn-success" style="margin-bottom: 5px;"><i class="icon-leaf icon-white"></i> View</a>&nbsp: Click to View Test Result Page<br>
	<br>
	<span class="label label-success">PASSED</span>&nbsp: All Testunit Passed<br>
	<span class="label label-important">FAILED</span>&nbsp: One or More Testunit Failed<br>
	<span class="label label-inverse">KILLED</span>&nbsp: Test Stopped<br>
	<br>
	<span class="label label-warning">QA</span>&nbsp: QA Acceptance Test<br>
 	<span class="label label-inverse">PKG</span>&nbsp: Package-Build Test<br>
	<br>
	<span class="label label-default">SAN</span>&nbsp: SAN Device Test<br>
	<span class="label label-default">RHEL</span>&nbsp: RHEL Distro Test<br>
	<span class="label label-default">UPGRADE</span>&nbsp: System Upgrade Test<br>
	<span class="label label-default">VMWARE</span>&nbsp: Vmware ESX Test<br>
	<span class="label label-default">WINDOWS</span>&nbsp: Windows Image Test<br>
	<span class="label label-default">HA</span>&nbsp: High Availability Test<br>
	
</div>
<div class="hide screen page" id="mycontact" style="position:fixed; top:100px;" >
	Contact Eucalyptus Developers at <b>irc.freenode.net</b><br>
	<br>
	#eucalyptus<br>
	#eucalyptus-devel<br>
	#eucalyptus-qa<br>
</div>

<!-- TREE GRAPHIC -->

<div id="tree" class=".bottom-layer" >
	<img src="./image/eucalyptus_tree_istock.jpg">
</div>

<!-- NAV BAR BOTTOM -->

<div class="navbar navbar-fixed-bottom">
   <div class="navbar-inner">
      <ul class="nav pull-right">
	<img src="./image/euca_new_logo.jpg" width=200 style="margin: 0px 20px; margin-top: 8px;">
      </ul>
   </div>
</div>

<!-- NAV BAR TOP -->

<div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <ul class="nav">
                    <a class="brand" href="#">OPEN QA</a>
                    <li class="active top-menu" id="home"><a href="#">Home</a></li>
                    <li class="top-menu" id="about"><a href="#about">About</a></li>
                    <li class="top-menu" id="contact"><a href="#contact">Contact</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">More<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="http://www.eucalyptus.com/">Euca @Home</a></li>
                            <li><a href="https://engage.eucalyptus.com/">Euca @Engage</a></li>
                            <li><a href="https://github.com/eucalyptus">Euca @GitHub</a></li>
                            <li class="divider"></li>
                            <li><a href="https://github.com/eucalyptus/open-qa">Open-QA @GitHub</a></li>
                            <li><a href="https://github.com/eucalyptus/eutester">Eutester @GitHub</a></li>
                        </ul>
                    </li>
                </ul>
		<ul class="nav pull-right">
		    <form class="navbar-search">
               		<input type="text" class="search-query" placeholder="Search">
            	    </form>
		</ul>
            </div>
        </div>
    </div>
</div>

<!-- PHP CODE -->

<?php
	######################## HTML BODY ####################################################################

	print_main_body_frame();

	require_once './open_qa-loadRecent.php';

	print_close_main_body_frame();

	######################## HTML BODY: END ###############################################################
?>



</body>

</html>

<?php

############################################### SUBROUTINES ###################################################

function print_main_body_frame(){

	print "<div class=\"container .pull-right .top-layer\">";
	print "<div class=\"row-fluid\">";
	print "<div class=\"span6\" id=\"empty_field\">";
	print "</div>";
	print "<div class=\"span6\" id=\"reservoir\">";

	return;
};

function print_close_main_body_frame(){

	print "</div>";		### CLOSING span6
	print "</div>";		### CLOSING row-fluid
	print "</div>";		### CLOSING container-fluid
	
	return;
};

?>


