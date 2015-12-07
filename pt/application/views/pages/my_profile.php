<br/>
<?php echo form_open('users_controller/profile_update',
array('class'=>'dark-matter'));
foreach ($query->result() as $row):?>
	<div id="container">
	<center><h1>My Profile</h1></center>
	<div id="body">
			<?php
			echo "<div class='msg_warning'>";
			echo validation_errors();
			echo "</div>";
			echo"<br/>";
			
			echo form_fieldset('Editable');
			echo form_label('First and last name: ');
			echo form_input(array('name'=>'name','value'=>$row->name));
			echo"<br/>";
			
			
			echo form_label('Email Address: ');
			echo form_input(array('name'=>'email','value'=>$row->email,'type'=>'email'));
			echo form_fieldset_close();
			echo"<br/>";
			
			echo form_fieldset('');
			echo form_label('Username: '.$row->username);
			echo form_label('Creation date: '.$row->creation_date);
			echo form_label('Last login: '.$row->last_login);
			echo form_label('Status: '.$row->status);
			echo form_fieldset_close();
			echo"<br/>";
			
			echo form_submit('submit', 'Update my Profile');
			
			?><?php endforeach; ?>
			<?php echo form_close();?>
		</div>
	</div>
