<html>
<?php
if (isset($this->session->userdata['logged_in'])) {
	$username = ($this->session->userdata['logged_in']['username']);
	$email = ($this->session->userdata['logged_in']['email']);
} else {
	header("location: login");
}
?>
<head>
	<title>Current Projects</title>
</head>
<body>
	<div id="project">
		<a href="<?php echo base_url() ?>index.php/project_controller/enter_hours_show">Enter hours</a>
		<br/>
		<b id="logout"><a href="logout">Logout</a></b>
	</div>
	<br/>
</body>
</html>