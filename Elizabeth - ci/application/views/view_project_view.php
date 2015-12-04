<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>View Project</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
		text-align: center;
	}

	#left {
	    float:left;
	    width:100px;
	}

	#center {
	    display: inline-block;
	    margin:0 auto;
	    width:100px;
	}

	#right {
	    float:right;
	    width:100px;
	}
	
	</style>
</head>
<body>

<div id="container">
	<center><h1>View Project</h1></center>

	<div id="body">
		<h3 style="float: center;">Project Description</h3>
		<div id="left"><h4>Owner</h4></div>
		<div id="right"><h4>Status</h4></div>
		<div id="center"><h4>Deadline</h4></div>
		
		<center>This is where the table goes</center>
		<?php
			$tabledata = array(
				array('Example Notes', '5', 'Dec. 1, 2015')
				);
			$this->table->set_heading('Logged Notes', 'Hours', 'Date');
			echo $this->table->generate($tabledata);
		?>

		<!-- This will redirect to the Add Hours Page -->
		<form>
		    <input type="submit" formaction="" value="Add/Edit Hours"/>
		</form>
		<br>
		<br>

		<center>This is where the table goes</center>
		<?php
			$tabledata = array(
				array('Elizabeth Lor (lored@colorado.edu)', '5', 'High')
				);
			$this->table->set_heading('Contributors', 'Hours', 'Priority');
			echo $this->table->generate($tabledata);
		?>
		<form>
			<!-- This will redirect to the Add Users Page -->
		    <input type="submit" formaction="" value="Add Contributors"/>
		    <!-- This will redirect to the Remove Users Page -->
		    <input type="submit" formaction="" value="Remove Contributors"/>
		</form>
	</div>
</div>
</body>
</html>










