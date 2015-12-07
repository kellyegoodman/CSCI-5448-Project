<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Projects_controller extends CI_Controller
{
	
    public function __construct() 
	{
        parent::__construct();
        $this->initilize();
        $this->getNextListIndex();
        $this->isSigned();
    }
	
	
	private function isSigned()
	{
		if($this->native_session->userdata('user_id')!==NULL AND !empty($this->native_session->userdata('user_id')))
		{
			return TRUE;
		}
		else
		{
			redirect("login_controller/index");
		}
		
	}
	
	//only first time
        private function initilize()
	{
		if($this->native_session->userdata('project_page')===NULL)
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
                        $this->load->library("Authentication");//still no working
			$this->native_session->set_userdata('project_page', '0');
			$this->native_session->set_userdata('project_page_size', Projects_model::LIMIT);
			$this->native_session->set_userdata('project_order_by', 'id');
			$this->native_session->set_userdata('project_asc', 'DESC');
		}
	}
	
	//get column and search value from the form
	// then provide results in new page 0
	public function search()
	{
		//NO SQL Injection
		$search=$this->input->post('search',TRUE);
		$col=$this->input->post('search_column');
		$this->native_session->set_userdata('search_column', $col);
		$this->native_session->set_userdata('search', $search);
		$this->page(0);
	}
	
	//remove search info native_session then reload
	public function reset()
	{
		$this->native_session->unset_userdata('search_column');
		$this->native_session->unset_userdata('search');
		$this->index();
	}
	
	//save the order column in native_session and reload
    public function sort($col,$order='ASC') {

        $this->native_session->set_userdata('project_asc', $order);
        //no SQL injection
        if($col === 'id' || $col== 'name' || $col== 'owner_id' || $col== 'status' || $col== 'priority' || $col== 'deadline' || $col== 'creation_date')
        {
            $this->native_session->set_userdata('project_order_by', $col);
        }
        $this->index();
    }
	
	//determine the next start index
    private function getNextListIndex()
    {
		//start index=page_size * current_page then store it 
        $start=$this->native_session->userdata('project_page_size')*$this->native_session->userdata('project_page');
        $this->native_session->set_userdata('project_start', $start);
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
        if($this->native_session->userdata('project_page')+1< $this->native_session->userdata('project_pages'))
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
        if($this->native_session->userdata('project_page')>0)
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
        $last=$this->native_session->userdata('project_pages')-1;
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
    	$this->isSigned();
        //do the query
        $data['query']=$this->Projects_model->get_projects();
        //store projects, #pages
        $projects=$this->getNumberOfProjects();
        $this->native_session->set_userdata('projects', $projects);
        if($this->native_session->userdata('project_page_size')==0)
        {
                $this->native_session->set_userdata('project_page_size', Projects_model::LIMIT);
        }
        $pages=ceil($projects/$this->native_session->userdata('project_page_size'));
        $this->native_session->set_userdata('project_pages', $pages);
        
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
		//update native_session
		$this->native_session->set_userdata('project_page_size', $page);
		//go to the begging
		$this->page(0);
	}
	
	//update the page and list_index then reload
    private function page($page)
    {
            $this->native_session->set_userdata('project_page', $page);            
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
			$this->load->view('pages/create_project_view');
		}
	}
	//view project or start creating or updating the project
	public function edit_project($id,$task=0)
	{
		$this->isSigned();
		$operation=$this->input->post('operation');
		//start updation
		if($operation=="update")
		{
			
			if ($this->form_validation->run('updateProject') == FALSE OR strtotime($this->input->post('deadline',TRUE))==FALSE)
			{
				$data['query']=$this->Projects_model->getProjectDetails($id);
				$data['task']=1;
				$this->load->view('header');
				$this->load->view('pages/project_view',$data);
			}
			else
			{
				$data = array(
				'name' => $this->input->post('name'),
				'deadline' => date('Y-m-d',strtotime($this->input->post('deadline'))),
				'status' => $this->input->post('status'),
				'priority' => $this->input->post('priority'),
				'note' => $this->input->post('note'),
				'description' => $this->input->post('description'),
				);
				$result = $this->Projects_model->update_entry($id,$data);
				//Check if successfully inserted into db
				if ($result == FALSE)
				{
					//if you want to print a message
				}
				$this->index();
			}
			
		}
		//start creation
		elseif($operation=="create")
		{
			if ($this->form_validation->run('createProject') == FALSE OR strtotime($this->input->post('deadline',TRUE))==FALSE)
			{
				$this->load->view('header');
				$this->load->view('pages/create_project_view');
			}
			else{
				$data = array(
				'name' => $this->input->post('name',TRUE),
				'owner_id' => $this->native_session->userdata('user_id'),
				'deadline' => date('Y-m-d',strtotime($this->input->post('deadline',TRUE))),
				'creation_date' => date('Y-m-d'),
				'status' => $this->input->post('status'),
				'priority' => $this->input->post('priority'),
				'note' => $this->input->post('note',TRUE),
				'description' => $this->input->post('description',TRUE),
				);
				$result = $this->Projects_model->create_project_insert($data);
				//Check if successfully inserted into db
				if ($result == TRUE)
				{
					$this->index();
				}
				else
				{
					show_error('Failed to insert to database!');
				}
			}
			
		}
		//display appropriate form
		else
		{
				$data['query']=$this->Projects_model->getProjectDetails($id);
				$data['task']=$task;
				$this->load->view('header');
				$this->load->view('pages/project_view',$data);
		}
	}
	
	//Enter hours in current project for current user
	public function enter_hours($id) 
	{
		$query['project_id'] = $id;
		$query['user_id'] = $this->native_session->userdata('user_id');
		//Check validation for user input in enter hours form
		//Required - form cannot be empty
		//Trim - strip whitespace from beginning/end of string
		//Numeric - Has to be a number
		$this->form_validation->set_rules('hours', 'Hours', 'trim|numeric|required');
		if ($this->form_validation->run() == FALSE)
		{
			$query['hours']=$this->Projects_model->getHours($query)->hours;
			$query['id']=$id;
			$this->load->view('header');
			$this->load->view('pages/enter_hours_form',$query);
		}
		else 
		{
			$data = array(
				'user_account_id' => $this->native_session->userdata('user_id'),
				'hours' => $this->input->post('hours',TRUE),
				);
			$result = $this->Projects_model->hours_insert($id, $data);
			//Check if succesfully inserted into db still not working
			if ($result == TRUE) 
			{
				echo 'Hours entered!';
				$this->index();
			}
			
			else 
			{
				$this->index();
			}
		}
	}
}
