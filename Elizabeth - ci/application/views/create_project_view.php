<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Create Project</title>

</head>
<body>

<?php 
$att=array('class'=>'dark-matter');
echo form_open('createproject/new_project/',$att); ?>

<div id="container">
	<center><h1>Create Project</h1></center>
	<div id="body">
		Project Name: <input type="text" name="name" value=""><br>		
		Deadline: <input type="date" name="deadline" value="<?php echo date('m-d-Y'); ?>"><br>
		Status: <input type="radio" name="status" value="inactive"> Inactive
		<input type="radio" name="status" value="active"> Active<br>
		Hours: <input type="number" name="hours" value="0"><br>
		Priority: <input type="radio" name="priority" value="normal"> Normal
		<input type="radio" name="priority" value="low"> Low
		<input type="radio" name="priority" value="high"> High <br>
		Date Created: <input type="date" name="date" value="<?php echo date('m-d-Y'); ?>"><br>
		Description: <input type="text" name="note" value=""><br>
		<?php
		echo form_submit('submit', 'Submit');
		echo form_close();
		?>
	</div>
</div>
</body>
</html>