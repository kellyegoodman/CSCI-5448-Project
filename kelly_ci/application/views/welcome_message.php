

<div id="container">
	<br/>
	<!--
	<h1>Welcome to my website!</h1>  
  	-->
  	
	<div id="body">
		<?php
		//echo anchor('Register_user','Create Account') . '<br/><br/>';
		echo '<br/><br/>';
		
		foreach($usernames as $object) {
			echo $object->username . '<br/>';
		}
		echo '<br/><br/>';
		foreach ($names as $object) {
			echo $object->name . '<br/>';
		}
			
		?>
	</div>
</div>