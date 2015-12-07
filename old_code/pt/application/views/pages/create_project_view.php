<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$att=array('class'=>'dark-matter');
//new project
echo '<br/>';
echo form_open('projects_controller/edit_project/0',$att);?>
<div id="container">
	<center><h1>Create Project</h1></center>
	<div id="body">
        <?php
        echo "<div class='msg_warning'>";
                    echo validation_errors();
                    echo "</div>";
                    echo"<br/>";
        ?>
	<table align="center" width="80%" style="color:#ffffff;">
		<tr><td align="right">*Project Name:</td><td ><input type=text" name="name"></td></tr>
		<tr><td align="right">*Deadline:</td><td><input id="datepicker1" type="date" name="deadline" value=""></td></tr>
		<tr><td align="right">*Status:</td><td><input type="radio" name="status" value="inactive"> Inactive <input type="radio" checked name="status" value="active"> Active</td></tr>
		<tr><td align="right">*Priority:</td><td><input type="radio" name="priority" value="normal" checked> Normal <input type="radio" name="priority" value="low"> Low <input type="radio" name="priority" value="high"> High </td></tr>
		<tr><td align="right"> Description:</td><td><textarea name="description" ></textarea></td></tr>
		<tr><td align="right"> Note:</td><td><textarea  name="note" value=""></textarea></td></tr>
		<?php echo form_hidden('operation', 'create');?>
		<tr><td></td><td><?php echo form_submit('', 'Create New Project');?></td></tr>
		<?php echo form_close(); ?>
	</table>
	</div>
</div>