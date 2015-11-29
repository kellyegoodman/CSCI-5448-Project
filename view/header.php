<html>
        <head>
                <title>Time Project Management</title>
                <?php $this->load->helper('url');?>
                <?php echo link_tag('css/theme.css',"stylesheet",'text/css');?>
        </head>
        <body >
				<h1>Project Time Management System</h1>
                
				<div class="title">
									
									<a href='' class="_menu">New Project</a>
									<?php echo anchor('projects_controller/index/', 'My Projects','class="_menu"') ; ?>
									<a href='' class="_menu">Sign Out</a>
									&nbsp;&nbsp;&nbsp;Welcome <?php echo $this->session->user_name;?>. &nbsp;&nbsp;&nbsp;
									Last access was on <?php echo $this->session->user_last;?>.&nbsp;&nbsp;&nbsp;
									&nbsp;
									</div>                
                <br/><br/><br/>