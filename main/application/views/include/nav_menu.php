<div class="title">
		<?php 
		echo anchor('/Welcome','Home','class="_menu"');
		
		if($this->session->userdata('user_id')) {
			// add: display the user's name
			echo anchor('projects_controller/new_project/', 'New Project','class="_menu"');
			echo anchor('projects_controller/index/', 'My Projects','class="_menu"') ;
			echo anchor('/Register_controller/profile_show','View Profile','class="_menu"');
			echo anchor('/Login_controller/logout','Log Out','class="_menu"');
			
			$sess = $this->session->userdata('user_id');
			echo ' Welcome ' . $sess['username'];
		} else {
			echo anchor('/Login_controller/login_show','Log In','class="_menu"');
			echo anchor('/Register_controller/register_show','Create Account','class="_menu"');
		}
		?>
		 
</div>
