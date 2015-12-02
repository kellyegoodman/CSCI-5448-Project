<html>
        <head>
                <title>Time Project Management</title>
				<?php 
				echo meta('description', 'Time Project Management');
				echo meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>
                <?php $this->load->helper('url');?>
				<?php echo link_tag('css/theme.css',"stylesheet",'text/css');?>
				<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.6.2.min.js"></script>
				<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.8.15.custom.min.js"></script>
				<?php echo link_tag('js/jqueryCalendar.css',"stylesheet",'text/css');?>				
			
				<script>jQuery(function() { jQuery( "#datepicker1" ).datepicker();}); </script>

        </head>
        <body >
				<h1>Project Time Management System</h1>
                
				<div class="title">
									<?php echo anchor('projects_controller/new_project/', 'New Project','class="_menu"') ; ?>
									<?php echo anchor('projects_controller/index/', 'My Projects','class="_menu"') ; ?>
									<a href='' class="_menu">Sign Out</a>
									&nbsp;&nbsp;&nbsp;Welcome <?php echo $this->session->user_name;?>. &nbsp;&nbsp;&nbsp;
									Last access was on <?php echo $this->session->user_last;?>.&nbsp;&nbsp;&nbsp;
									&nbsp;
									</div>                
                <br/><br/><br/>