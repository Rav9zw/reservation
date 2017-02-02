<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usersadministration extends CI_Controller {

      public function __construct() {
        parent::__construct();


      $this->load->model('admin/Usersadministration_model');
	  $this->load->library('session');


        
    }

    public function index() {

	
	
		if($this->session->userdata('logged_in'))
		{
   
		$dane['site']='usersadministration';
		$dane['js']='usersadministration';
		$dane['usersadministration_active']='active';
		$user=$this->session->userdata('logged_in');
		$dane['user']=$user['user'];
		
		$this->load->view('admin/master', $dane);

		}
		else
	   {
		 //If no session, redirect to login page
		 redirect('login', 'refresh');
	   }
		
		
		
		
		
		}
						

	public function loadUsers(){
		
	
	$results=$this->Usersadministration_model->loadUsers();	
	
	echo json_encode($results);
		
		
	}










	
	
	
	
	
	
	
	
	
	
	
	
	
	




}
