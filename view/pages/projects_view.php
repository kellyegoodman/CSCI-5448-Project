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

//if there are items or the user made search
if ($query->num_rows() > 0 || $this->session->search!==NULL) : ?>
<!-- Search and Pagination Table -->
<table  class="datagrid" >
    <tr class="down">
        <td><ul class="pagination">
                <li><?php echo anchor('projects_controller/firstPage/', '&lt;&lt;','title="First page"');?></li>
                <li><?php echo anchor('projects_controller/previousPage/', '&lt;','title="Previous page"');?></li>				
                <li><?php echo anchor('', 'Page '.($_SESSION['project_page']+1).' of '.$_SESSION['project_pages'].'','class="active" title="Current page"');?></li>
                <li><?php echo anchor('projects_controller/nextPage/', '&gt;','title="Next page"');?></li>
                <li><?php echo anchor('projects_controller/lastPage/', '&gt;&gt;','title="Last page"');?></li>
        </ul></td><td>&nbsp;&nbsp;</td>
		
		<!-- Display total -->
		<td>
			<?php echo 'Total '.($this->session->userdata('projects')).' projects.';?>
		</td>
		<!-- space -->
        <td>&nbsp;&nbsp;</td>
		<!-- search options-->
		<td class="down">
            <?php echo form_open('projects_controller/search/') ; ?>
            <select name="search_column">
                <option value="name">Name</option>
                <option value="note">Note</option>
                <option value="description">Description</option>
            </select>
            <?php 
			echo form_input('search') ;
            echo form_submit('projects_controller/search/', 'Search') ;
			//add this button so the user can cancel the search
			if($this->session->search!==NULL):
				echo anchor('projects_controller/reset/', '[X]','title="cancel search" class="_menu"');
			endif;
            echo form_close() ; ?>
		</td>
		<!-- space -->
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>
			<?php
			//# of items per page options
			echo form_open('projects_controller/setPerPage/') ;
			echo '<input type="text" name="projects" type="number" value="'.$_SESSION['project_page_size'].'" maxlength="6" size="6">';
			echo form_submit('', 'per page') ;
            echo form_close(); ?>
		</td>
    </tr>
</table>
<br/>

<!-- Data table -->
<table id="list" class="datagrid" width="100%" align="center" border='1' cellspacing='0' >
         <!-- show Labels and sorting -->     
		 <tr>
             <th><?php echo '#';?></th>
             <th><?php echo anchor('projects_controller/sort/name/ASC', '&uarr;')
			 .'Name'.anchor('projects_controller/sort/name/DESC', '&darr;');?></th>
             <th><?php echo anchor('projects_controller/sort/priority/ASC', '&uarr;').'Priority'.anchor('projects_controller/sort/priority/DESC', '&darr;');?></th>
             <th><?php echo anchor('projects_controller/sort/creation_date/ASC', '&uarr;').'Creation Date'.anchor('projects_controller/sort/creation_date/DESC', '&darr;');?></th>
             <th><?php echo anchor('projects_controller/sort/deadline/ASC', '&uarr;').'Deadline'.anchor('projects_controller/sort/deadline/DESC', '&darr;');?></th>
             <th><?php echo 'Status';?></th>
             <th>Description</th>
             <th>Note</th>
			 <th>Tools</th>
         </tr>
         
         <!-- row info -->
		 <?php $counter=0;?>
         <?php foreach ($query->result() as $row) : ?>
		 <?php $class=($counter%2==0)?"alt":""; ?>
         <tr class=<?php echo $class;?> >
             <td><?php echo $counter+1; echo form_hidden('id', $row->id);?></td>
             <td><?php wrapText($row->name) ?></td>
             
             <td><?php wrapText($row->priority) ?></td>
             <td><?php wrapText($row->creation_date) ?></td>
             <td><?php wrapText($row->deadline) ?></td>
             <td><?php 
				//display remain days with percentages for active projects
				if($row->status=="active"):
					$date3=date_create($row->creation_date);
					$date2=date_create("now");
					$date1=date_create($row->deadline);
					$allDays=date_diff($date3,$date1)->format('%R%a');
					$remainDays=date_diff($date2,$date1)->format('%R%a');
					if($remainDays<0):
						$allDays='0%';
					else:
						$allDays=(($remainDays/(float)$allDays)*100).'%';
					endif;
					echo '<div id="progress" class="graph"><div id="bar" style="width:'.$allDays.'">'.wrapText($remainDays.' days').'</div></div>';
					
				else:
					wrapText($row->status);
				endif;
				?>
			 </td>
             <td><?php wrapText($row->description) ?></td>
             <td><?php wrapText($row->note) ?></td>
             <td class="tools">
			 <!-- tool box -->
			 <span><?php echo anchor('projects_controller/enter_hours/'.$row->id, 'Enter Hours','class="hours_button"') ; ?></span>
			 <?php 
			 if($row->owner_id==$this->session->user_id):?>
			 <span><?php echo anchor('projects_controller/view_project/'.$row->id, '<span>V</span>','class="view_button"') ; ?></span>
             <span><?php echo anchor('projects_controller/edit_project/'.$row->id, '<span>E</span>','class="edit_button"') ; ?></span>
			 <span><?php echo anchor('projects_controller/viewUnlinkedUsers/'.$row->id, '+Add Users','class="_button"') ; ?></span>
			 <span><?php echo anchor('projects_controller/viewLinkedusers/'.$row->id, '-Remove Users','class="_button"') ; ?></span>
			 <span><?php echo anchor('projects_controller/delete_project/'.$row->id, '<span>-D</span>','class="delete_button"') ; ?></span>
			 <?php endif;?>
			 </td>
         </tr>
		 <?php $counter=$counter+1;?>
         <?php endforeach;?>
     </table>
    <?php endif ; ?>

       