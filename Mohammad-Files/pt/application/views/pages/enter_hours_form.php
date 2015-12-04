<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$att=array('class'=>'dark-matter');
//Enter Hours
echo validation_errors();
//foreach ($query->result() as $row) :
echo form_open('projects_controller/enter_hours/'.$id,$att); ?>
<div id="container">
	<center><h1>Enter Hours</h1></center>
	<div id="body">
	<table align="center" width="80%" style="color:#ffffff;">
		<tr><td align="right">*Update project hours:</td><td><input type="text" name="hours"></td></tr>
		<tr><td></td><td><?php echo form_submit('', 'Save and Close');?></td></tr>
		<?php echo form_close(); ?>
	</table>
	</div>
</div>
<?php //endforeach; ?>
