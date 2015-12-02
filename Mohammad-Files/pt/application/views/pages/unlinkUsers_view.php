<?php
//just for table format
//if large text then use textArea
//if empty text then display -----
function wrapText($text) 
{
	if(strlen($text)==0)
	{
		echo '--------';
	}
    elseif(strlen($text)>20)
    {
        echo '<textarea readonly>'.$text.'</textarea>';
    }
    else {
        echo $text;
    }
}
function checkmessage($msg)
{
    if(isset($msg) && !empty($msg))
    {
        $type=  substr($msg,0,1);
        $msg = substr($msg,1);
        printmsg($msg,$type);
    }
}
function printmsg($text,$type)
{
	if($type==0)
		echo '<div class="msg_warning">'.$text.'</div><br/>';
	elseif($type==2)
		echo '<div class="msg_info">'.$text.'</div><br/>';
	elseif($type==3)
		echo '<div class="title">'.$text.'</div><br/>';
}

//display error messages first
checkmessage($msg);
//if there are items or the user made search
if ($query->num_rows() > 0) : ?>

<!-- Data table -->
<table id="list" class="datagrid" width="70%" border='1' cellspacing='0' >
         <!-- show Labels and sorting -->     
		 <tr><th colspan='5' style="font-size:30; text-align: center;padding:10px"><?php echo "Project ".$title." Users";?></th></tr>
		 <tr>
             <th><?php echo '#';?></th>
             <th><?php echo 'Name';?></th>
             <th><?php echo 'Username';?></th>
             <th><?php echo 'Email';?></th>
			 <th>Tools</th>
         </tr>
         
         <!-- row info -->
		 <?php $counter=0;?>
         <?php foreach ($query->result() as $row) : ?>
		 <?php $class=($counter%2==0)?"alt":""; ?>
         <tr class=<?php echo $class;?> >
             <td><?php echo $counter+1; echo form_hidden('id', $row->id);?></td>
             <td><?php wrapText($row->name) ?></td>
             <td><?php wrapText($row->username) ?></td>
             <td><?php wrapText($row->email) ?></td>
             <td class="tools">
			 <!-- tool box -->
			 <span><?php echo anchor('users_controller/confirmUnlink/'.$this->session->userdata('project').'/'.$row->id, 'Remove','class="delete_button"') ; ?></span>
			 </td>
         </tr>
		 
		 <?php $counter=$counter+1;?>
         <?php endforeach;?>
     </table>
	 <p><?php echo ""; ?></p>
    <?php else: printmsg('No assigned users for this project.', 'info');?>
    <?php endif ; ?>
