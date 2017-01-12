<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usersadministration extends CI_Controller {

      public function __construct() {
        parent::__construct();


      $this->load->model('admin/Usersadministration_model');
	//	$this->load->library('session');


        
    }

    public function index() {

		
		$dane['site']='usersadministration';
		$dane['js']='usersadministration';
		$dane['usersadministration_active']='active';
		
		$this->load->view('admin/master', $dane);

		
		
		
		}
						

	public function loadUsers(){
		
	
	$results=$this->Usersadministration_model->loadUsers();	
	
	echo json_encode($results);
		
		
	}










	
	
	
	
	
	
	
	
	
	
	
	
	
	




}
