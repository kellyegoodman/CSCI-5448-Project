<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Projects_controller extends CI_Controller
{
	
    public function __construct() 
	{
        parent::__construct();
		
        $this->initilize();
		//temporary delete after logging controller
		$this->isSigned();
        $this->getNextListIndex();
		$this->load->model('Projects_model');
    }
	
	
	//just an example please delete or call 
	//authentication controller after plugging the
	//other files
	private function isSigned()
	{
		$this->session->set_userdata('user_name', 'Mohammad Alasmary');
		$this->session->set_userdata('user_id', '1');
		$this->session->set_userdata('user_last', date('m/d/Y h:i:s a', time()));
		return TRUE;
	}
	
	//only first time
    private function initilize()
	{
		if($this->session->userdata('project_page')===NULL)
		{
			$this->load->model('Projects_model');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->session->set_userdata('project_page', '0');
			$this->session->set_userdata('project_page_size', Projects_model::LIMIT);
			$this->session->set_userdata('project_order_by', 'id');
			$this->session->set_userdata('project_asc', 'DESC');
		}
	}
	
	//get column and search value from the form
	// then provide results in new page 0
	public function search()
	{
		//NO SQL Injection
		$search=$this->input->post('search',TRUE);
		$col=$this->input->post('search_column');
		$this->session->set_userdata('search_column', $col);
		$this->session->set_userdata('search', $search);
		$this->page(0);
	}
	
	//remove search info session then reload
	public function reset()
	{
		$this->session->unset_userdata('search_column');
		$this->session->unset_userdata('search');
		$this->index();
	}
	
	//save the order column in session and reload
    public function sort($col,$order='ASC') {

        $this->session->set_userdata('project_asc', $order);
        //no SQL injection
        if($this->legalColumn($col)==TRUE){
            $this->session->set_userdata('project_order_by', $col);
        }
        $this->index();
    }
    
	//stop the user from providing  any column search
    private function legalColumn($col)
    {
        if($col === 'id' || $col== 'name' || $col== 'owner_id' || $col== 'status' || $col== 'priority' || $col== 'deadline' || $col== 'creation_date')
        {
            return TRUE;
        }
        return False;
    }
	
	//determine the next start index
    private function getNextListIndex()
    {
		//start index=page_size * current_page then store it 
        $start=$this->session->userdata('project_page_size')*$this->session->userdata('project_page');
        $this->session->set_userdata('project_start', $start);
    }
	
	
    public function index()
    {
        redirect('Projects_controller/view_projects');
    }
	
	//pagination
	//load next rows
    public function nextPage()
    {
		//check current page not lastPage then increment and update indexes
        if($this->session->userdata('project_page')+1< $this->session->userdata('project_pages'))
		{
            $_SESSION['project_page']=$_SESSION['project_page']+1;
			$this->getNextListIndex();    
        }
		//list projects
		$this->index();
    }
	
	
	//pagination
	//load previous rows
    public function previousPage()
    {
		//check current page not firstPage then decrement
        if($this->session->userdata('project_page')>0)
		{
            $_SESSION['project_page']=$_SESSION['project_page']-1;
			$this->getNextListIndex();    
        }	
		//list projects
		$this->index();
    }
	
	
	//pagination
	//load rows in last page
    public function lastPage()
    {
        $last=$this->session->userdata('project_pages')-1;
        $this->page($last);
    }
	
	//pagination
    public function firstPage()
    {
        $this->page(0);
    }
	
	//retrieve no. elements before limits
	//for displaying total items in the table only.
	private function getNumberOfProjects()
	{
		return $this->Projects_model->get_projects(TRUE)->num_rows();
	}
	
	//load projects list view
    public function view_projects()
    {    
        //do the query
        $data['query']=$this->Projects_model->get_projects();
        //store projects, #pages
        $projects=$this->getNumberOfProjects();
        $this->session->set_userdata('projects', $projects);
		if($this->session->userdata('project_page_size')==0)
		{
			$this->session->set_userdata('project_page_size', Projects_model::LIMIT);
		}
        $pages=ceil($projects/$this->session->userdata('project_page_size'));
        $this->session->set_userdata('project_pages', $pages);
        
        //render
        $this->load->view('header',$data);
        $this->load->view('pages/projects_view',$data);
        $this->load->view('footer',$data);
    }
	
	//change # items per page
    public function setPerPage()
	{
		//no SQL injections
		$page=$this->input->post('projects',TRUE);
		//errors load the default
		if($page==0||$page==NULL)
		{
			$page=Projects_model::LIMIT;
		}
		//update session
		$this->session->set_userdata('project_page_size', $page);
		//go to the begging
		$this->page(0);
	}
	
	//update the page and list_index then reload
    private function page($page)
    {
            $this->session->set_userdata('project_page', $page);            
            $this->getNextListIndex();
            $this->index();
    }
	
	
	// shows the create project page
	public function new_project() 
	{	
		$this->isSigned();
		//render the page
		if($this->input->post('name')==NULL OR $this->input->post('name')=="")
		{
			$this->load->view('header');
			$this->load->view('create_project_view');
			$this->load->view('footer');
		}
	}
	//view project or start creating or updating the project
	public function edit_project($id,$task=0)
	{
		$this->isSigned();
		$operation=$this->input->post('operation');
		
		if($operation=="update")
		{
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('deadline', 'Deadline', 'trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				go back to the page
			}
			else
			{
				$data = array(
				'name' => $this->input->post('name'),
				'owner_id' => $this->session->user_id,
				'deadline' => date('Y-m-d',strtotime($this->input->post('deadline'))),
				'status' => $this->input->post('status'),
				'priority' => $this->input->post('priority'),
				'note' => $this->input->post('note'),
				'description' => $this->input->post('description'),
				);
				$result = $this->Projects_model->update_entry($id,$data);
				//Check if successfully inserted into db
				if ($result == TRUE)
				{
					$this->index();
				}
				else
				{
					show_error('Failed to update to database!');
				}
			}
			
		}
		elseif($operation=="create")
		{
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('deadline', 'Deadline', 'trim|required');
			$data = array(
				'name' => $this->input->post('name'),
				'owner_id' => $this->session->user_id,
				'deadline' => date('Y-m-d',strtotime($this->input->post('deadline'))),
				'creation_date' => date('Y-m-d'),
				'status' => $this->input->post('status'),
				'priority' => $this->input->post('priority'),
				'note' => $this->input->post('note'),
				'description' => $this->input->post('description'),
				);
			$result = $this->Projects_model->create_project_insert($data);
			//Check if successfully inserted into db
			if ($result == TRUE)
			{
				//get  the newly id and insert
				echo "inserted!";
				$this->index();
			}
			else
			{
				show_error('Failed to insert to database!');
			}
		}
		else
		{
				$data['query']=$this->Projects_model->getProjectDetails($id);
				$data['task']=$task;
				$this->load->view('header');
				$this->load->view('project_view',$data);
				$this->load->view('footer');
		}
	}
}
