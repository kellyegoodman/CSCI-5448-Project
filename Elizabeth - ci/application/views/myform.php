<html>
<head>
<title>My Form</title>
</head>
<body>

<?php echo validation_errors(); ?>

<?php echo form_open('form'); ?>

Email Address: <input type="text" name="email" value=""><br>
Name: <input type="text" name="name" value=""><br>
Owner: <input type="text" name="owner" value=""><br>
Number of Users: <input type="number" name="num_users" value=""><br>
Deadline: <input type="date" name="deadline" value=""><br>
Status: <input type="radio" name="status" value="hasn'tstarted"> Hasn't Started
<input type="radio" name="status" value="inprogress"> In Progress
<input type="radio" name="status" value="complete"> Complete <br>
<!-- Status: <input type="text" name="Status" value=""><br> -->
Hours: <input type="number" name="hours" value=""><br>
Priority: <input type="radio" name="priority" value="normal"> Normal
<input type="radio" name="priority" value="low"> Low
<input type="radio" name="priority" value="high"> High <br>
<!-- <input type="text" name="Priority" value=""><br> -->
Creation Time: <input type="text" name="time" value=""><br>
Note: <input type="text" name="note" value=""><br>

<div><input type="submit" value="Submit" /></div>


</body>
</html>