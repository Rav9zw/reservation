<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Config extends CI_Controller {

      public function __construct() {
        parent::__construct();


     $this->load->model('admin/Config_model');

        
    }

    public function index() {

		$dane['site']='config';
		$dane['js']='config';
		$dane['config_active']='active';

		$this->load->view('admin/master', $dane);

		}
						
	public function workingHours(){
		
		
		$date = new DateTime(date('Y-m-d').' 00:00:00');
		$data=array();
		
		
		for($i=0;$i<24;$i++){

	
			
		
		for($j=1;$j<=7;$j++){	
		
		$data['table'][$date->format('H:i')][$j]='<i data-value="2" class="fa_hours fa fa-circle" aria-hidden="true"></i>';
		

		}
		$date->modify('+1 hour');
	
		
		
		
	}
	
	
	$where=array('end'=>'2100-01-01');
	
	$result=$this->Config_model->getWorkingHours($data,$where);
	
	
	echo json_encode($result);



}







public function updateHours(){
	
		$client=$this->input->post('client');
		$day=$this->input->post('day');
		$hour=$this->input->post('hour');
		$value=$this->input->post('value');
	
	
	
	
	$result=$this->Config_model->newConfig($client,$day,$hour,$value);
	
	echo json_encode($result);
	
}






}
