<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo "<br/>";
$att=array('class'=>'dark-matter');
//Enter Hours
echo validation_errors();
//foreach ($query->result() as $row) :
echo form_open('projects_controller/enter_hours/'.$id,$att); ?>
<div id="container">
	<center><h1>Enter Hours</h1></center>
	<div id="body">
	<table align="center" style="color:#ffffff;">
		<tr>
		<td><label>*Update project hours:</label></td>
		<td><input type="number" min="0" name="hours" size="5" value="<?php echo $hours?>"></td>
		<td><?php echo form_submit('', 'Save and Close','class=""');?></td>
		</tr>
		<?php echo form_close(); ?>
	</table>
	</div>
</div>
<?php //endforeach; ?>