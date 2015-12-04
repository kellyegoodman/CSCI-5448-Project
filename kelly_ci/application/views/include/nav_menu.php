
<div id="nav">

	<ul style="float:right;list-style-type:none;">
		<?php 
		echo '<li>' . anchor('/Welcome','Home') .'</li>';
		if($this->session->userdata('logged_in')) {
			// add: display the user's name
			echo '<li>' . anchor('/User/projects_show','Your Projects') .'</li>';
			echo '<li>' . anchor('/User/profile_show','View Profile') .'</li>';
			echo '<li>' . anchor('/User/logout','Log Out') .'</li>';
		} else {
			echo '<li>' . anchor('/User/login','Log In') .'</li>';
			echo '<li>' . anchor('/User/register','Create Account') .'</li>';
		}
		?>
	</ul>

</div>