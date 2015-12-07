
	<?php
	if (isset($logout_message)) {
		echo "<div class='message'>";
		echo $logout_message;
		echo "</div>";
	}
	?>
	<?php
	if (isset($message_display)) 
	{
		echo "<div class='msg_info'>";
		echo $message_display;
		echo "</div><br/>";
	}
	?>
	
	<div id="main">
		<div id="login">
		
			<?php $att=array('class'=>'dark-matter');?>
			<?php echo form_open('login_controller/login',$att); ?>
			<?php
			echo "<div class='msg_warning'>";
			if (isset($error_message)) {
				echo $error_message;
			}
			echo validation_errors();
			echo "</div>";
			echo "<br/>";
			?>
			<label>Username:</label>
			<input type="text" name="username" id="name" placeholder="username"/><br /><br />
			<label>Password:</label>
			<input type="password" name="password" id="password" placeholder="**********"/><br/><br />
			<input type="submit" value=" Login " name="submit"/><br /><br />
			<a href="<?php echo base_url() ?>login_controller/createUserAccount">Register New Account</a>
			<?php echo form_close(); ?>
		</div>
	</div>
</body>
</html>