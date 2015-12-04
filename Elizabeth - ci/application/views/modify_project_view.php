<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Modify Project</title>

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
	
	</style>
</head>
<body>

<?php 
$att=array('class'=>'dark-matter');
echo form_open('modifyproject/new_project/',$att); ?>

<div id="container">
	<center><h1>Modify Project</h1></center>

	<div id="body">
		Project Name: <input type="text" name="name" value="<?php echo $data->name ?>"><br>		
		Deadline: <input type="date" name="deadline" value="<?php echo $data->deadline ?>"><br>
		Status: <input type="radio" name="status" value="active"> Active
		<input type="radio" name="status" value="inactive"> Inactive<br>
		Hours: <input type="number" name="hours" value="0"><br>
		Priority: <input type="radio" name="priority" value="normal"> Normal
		<input type="radio" name="priority" value="low"> Low
		<input type="radio" name="priority" value="high"> High <br>
		Date Created: <input type="date" name="date" value="<?php echo $data->creation_date ?>"><br>
		Description: <input type="text" name="note" value="<?php echo $data->note ?>"><br>
		<?php
		echo form_submit('submit', 'Submit');
		echo form_close();
		?>
	</div>
</div>

</body>
</html>