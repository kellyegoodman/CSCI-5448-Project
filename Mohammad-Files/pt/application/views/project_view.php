<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$att=array('class'=>'dark-matter');
if($task==0):
//new project
echo form_open('projects_controller/new_project',$att); ?>
<div id="container">
	<center><h1>Create Project</h1></center>
	<div id="body">
	<table align="center" width="80%" style="color:#ffffff;">
		<tr><td align="right">*Project Name:</td><td ><input type=text" name="name"></td></tr>
		<tr><td align="right">Creation Date:</td><td><input type="date" disabled="true" name="creation_date" value="<?php echo date("m/d/Y");?>"></td></tr>
		<tr><td align="right">*Deadline:</td><td><input id="datepicker1" type="date" name="deadline" value=""></td></tr>
		<tr><td align="right">*Status:</td><td><input type="radio" name="status" value="inactive"> Inactive <input type="radio" checked name="status" value="active"> Active</td></tr>
		<tr><td align="right">*Priority:</td><td><input type="radio" name="priority" value="normal" checked> Normal <input type="radio" name="priority" value="low"> Low <input type="radio" name="priority" value="high"> High </td></tr>
		<tr><td align="right"> Description:</td><td><textarea name="description" ></textarea></td></tr>
		<tr><td align="right"> Note:</td><td><textarea  name="note" value=""></textarea></td></tr>
		<?php form_hidden('operation', 'create');?>
		<tr><td></td><td><?php echo form_submit('', 'Create New Project');?></td></tr>
		<?php echo form_close(); ?>
	</table>
	</div>
</div>
<?php
elseif($task==1):
//modify project
foreach ($query->result() as $row):
echo form_open('projects_controller/edit_project/'.$row->id.'/1',$att); $status="";?>
<div id="container">
	<center><h1>Modify Project Information</h1></center>
	<div id="body">
	<table align="center" width="80%" style="color:#ffffff;">
		<tr><td align="right">*Project Name:</td><td ><input type="text" name="name" value="<?php echo $row->name; ?>"></td></tr>
		<tr><td align="right">Creation Date:</td><td><input type="date" disabled="true" name="creation_date" value="<?php echo date('m/d/Y',strtotime($row->creation_date)) ?>"</td></tr>
		<tr><td align="right">*Deadline:</td><td><input id="datepicker1" type="date" name="deadline"  value="<?php echo date('m/d/Y',strtotime($row->deadline)); ?>"></td></tr>
		<tr><td align="right">*Status:</td><td>
			<?php if($row->status=="inactive"){$status="checked";}else{$status="";}?>
			<input type="radio" name="status" value="inactive" <?php echo $status;?> > Inactive 
			<?php if($row->status=="active"){$status="checked";}else{$status="";}?>
			<input type="radio" name="status" value="active" <?php echo $status;?> > Active</td></tr>
		<tr><td align="right">Priority:</td><td>
			<?php if($row->priority=="normal"){$status="checked";} else{$status="";}?>
			<input type="radio" name="priority" value="normal" <?php echo $status;?> > Normal 
			<?php if($row->priority=="low"){$status="checked";}else{$status="";}?>
			<input type="radio" name="priority" value="low" <?php echo $status;?> > Low 
			<?php if($row->priority=="high"){$status="checked";}else{$status="";}?>
			<input type="radio" name="priority" value="high" <?php echo $status;?> > High </td></tr>
		<tr><td align="right"> Description:</td><td><textarea name="description" ><?php echo $row->description; ?></textarea></td></tr>
		<tr><td align="right"> Note:</td><td><textarea  name="note"><?php echo $row->note?></textarea></td></tr>
		<?php echo form_hidden('project_id', $row->id);?>
		<?php echo form_hidden('operation', 'update');?>
		<tr><td></td><td><?php echo form_submit('', 'Update Project Information','');?></td></tr>
	<?php endforeach; ?>
	<?php echo form_close(); ?>
	</table>
	</div>
</div>
<?php
elseif($task==2): ?>
<div id="container">
	<?php foreach ($query->result() as $row): ?>
	<center><h1><?php echo $row->name; ?></h1></center>
	<div id="body">
	<table align="center" border="0" cellpadding="3" cellspacing="0">
		<tr><th>Creation Date</th><th>Deadline</th></tr>
		<tr><td><?php echo date('m/d/Y',strtotime($row->creation_date));?></td><td><?php echo date('m/d/Y',strtotime($row->deadline)); ?></td></tr>
		<tr><td colspan="2"><?php echo 'The project is <strong>'.$row->status.'</strong>.'?></td><tr>
		<tr><td colspan="2"><?php echo 'The priority of this project is <strong>'.$row->priority.'</strong>.'?></td><tr>	
		<tr><td colspan="2"><?php echo $row->description;?></td></tr>
		<tr><td colspan="2"><?php echo $row->note?></td></tr>
	<?php endforeach; ?>
	</table>
	</div>
</div>
<?php else:
show_error("Access denied!");
endif;?>