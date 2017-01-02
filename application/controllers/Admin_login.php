<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user extends CI_Controller {

      public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
		$this->load->library('session');


        
    }

    public function index() {

 if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $dane['username'] = $session_data['username'];
   
 

		$dane['dane']='';

		$dane['site'] = 'user';
		$this->load->view('master', $dane);


  }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }









						}

function change_password(){

$password_old = array(

  'username'     => $this->input->post('username_logged'),
  'password' => MD5($this->input->post('password_old'))

   );


$password_new = array(

  'username'    => $this->input->post('username_logged'),
  'password' => MD5($this->input->post('password_new'))

   );







$dane=$this->user_model->change_password($password_old ,$password_new);


echo json_encode($dane);

}

		

				

						
    




}
