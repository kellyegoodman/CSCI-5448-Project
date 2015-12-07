
<?php echo form_open('login_controller/createUserAccount',array('class'=>'dark-matter'));?>
	<div id="container">
	<center><h1>Registration Form</h1></center>
	<div id="body">
			<?php
			echo "<div class='msg_warning'>";
			echo validation_errors();
			echo "</div>";
			echo "<br/>";
			
			echo form_label('*Your name: ');
			echo form_input('name');
			echo"<br/>";
			
			echo form_label('*Create Username: ');
			echo form_input('username');
			echo "<div class='error_msg'>";
			if (isset($message_display)) {
				echo $message_display;
			}
			echo "</div>";

			echo form_label('*Email: ');
			$data = array(
				'type' => 'email',
				'name' => 'email_value'
				);
			echo form_input($data);	
			echo"<br/>";
			
			echo form_label('*Password: ');
			echo form_password('password');
			echo"<br/>";
                        echo form_label('*Password Confirmation: ');
			echo form_password('passwordconf');
			echo"<br/>";
			echo"<br/>";
			echo form_submit('submit', 'Register');
			
			?>
			<a href="<?php echo base_url() ?> ">&nbsp;&nbsp;&nbsp;Already have an account? Login</a>
			<?php echo form_close();?>
		</div>
	</div>