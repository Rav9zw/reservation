<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

      public function __construct() {
        parent::__construct();


     $this->load->model('admin/Admin_model');

        
    }

    public function index() {

		$dane['site']='reservation';

		$this->load->view('admin/master', $dane);

						}
						
	
	public function admin_available_courts(){


	//tworznie tablicy do rezerwacji
	
		$client=$this->input->post('client');
		$sub=$this->input->post('sub');
		$date_start=$this->input->post('date_start');
		$date_start=date( "Y-m-d", strtotime( "$date_start $sub day" ) );
		
		$date = new DateTime($date_start.' 07:00:00');
	


		for($i=7;$i<23;$i++){
			
		$date->modify('+1 hour');

		for($j=1;$j<=4;$j++){
		$data['table'][$date->format('H:i')]['kort '.$j]['text']='';
		$data['table'][$date->format('H:i')]['kort '.$j]['lvl']=9;
	

		}
		
	

		}
		$date->modify('-7 hour');


		
		
		$where=array(
		'k.id_klienta'=>$client,
		'data='=>$date_start,
		
		
		
		);
		
		//wyciąganie danych o dostępności kortów
		$result=$this->Admin_model->get_available_courts($where);
		$data['players']=$this->Admin_model->get_players($where);
		
		
			//matchowanie talicy z dostępnością


			foreach ($data['table'] as $key=>$row){

			if(array_key_exists($key,$result))
				$data['table'][$key]=array_merge($row,$result[$key]);

					
			}
			
			
			
		
			echo json_encode($data);




	}

		public function insert_reservation(){
			
		$date_time=date('Y-m-d H:i:s');
		$client=$this->input->post('client');
		$court=$this->input->post('court');
		$player=$this->input->post('player');
		$day=$this->input->post('day');
		$hour=$this->input->post('hour');
		

			$insert=array(
			
			'date_time'=>$date_time,
			'id_klienta'=>$client,
			'nr_kortu'=>$court,
			'godzina'=>$hour,
			'data'=>$day,
			'telefon'=>$player,
			'typ_rezerwacji'=>0
						
			);
			
			$where=array(
			
			
			'id_klienta'=>$client,
			'nr_kortu'=>$court,
			'godzina'=>$hour,
			'data'=>$day,
		
						
			);
			

		//wrzucanie nowej rezerwacji
		$result['result']=$this->Admin_model->insert_reservation($insert,$where);
			

		
		echo json_encode($result);	
			
			
			
			
		}	
	

	
			public function laodModal(){
	
	
	
			}
	
	
	
	
	
	




}
