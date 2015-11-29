<html>
<?php
if (isset($this->session->userdata['logged_in'])) {
}
?>
<head>
	<title>Enter Hours</title>
</head>
<body>
	<div id="main">
		<div id="enter_hours">
			<h2>Enter Hours</h2>
			<hr/>
			<?php
			echo "<div class='error_msg'>";
			echo validation_errors();
			echo "</div>";
			echo form_open('http://localhost/5448-CI/index.php/project_controller/enter_hours');

			echo form_label('Enter hours worked: ');
			echo"<br/>";
			echo form_input('hours');
			echo "<div class='error_msg'>";
			if (isset($message_display)) {
				echo $message_display;
			}
			echo "</div>";
			echo"<br/>";
			echo form_label('Description/Notes: ');
			echo"<br/>";
			echo form_input('project_notes');
			echo"<br/>";
			echo"<br/>";
			echo form_submit('submit', 'Save and close');
			echo form_close();
			?>
			<a href="<?php echo base_url() ?>/index.php/project_controller/index ">Go back</a>
		</div>
	</div>
</body>
</html>