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
		$dane['js']='admin';
		$dane['admin_active']='active';

		$this->load->view('admin/master', $dane);

						}
						
	
	public function admin_available_courts(){

	
	//tworznie tablicy do rezerwacji
	
		$client=$this->input->post('client');
		$sub=$this->input->post('sub');
		$date_start=$this->input->post('date_start');
		$deleted=$this->input->post('deleted');
		$date_start=date( "Y-m-d", strtotime( "$date_start $sub day" ) );
		
	
	
		$where=array('client_id'=>$client,
					 'day'=>date('N',strtotime($date_start))
					 );
	
	

		$config=$this->Admin_model->getConfigHours($where);
		
		$min=$config['extremes']['min'];
		$max=$config['extremes']['max'];
		
		$date = new DateTime($date_start.' '.$min.':00:00');
	

	
		for($i=$min;$i<=$max;$i++){
		


			for($j=1;$j<=4;$j++){
			$data['table'][$date->format('H:i')]['kort '.$j]['text']='';
			
			$data['table'][$date->format('H:i')]['kort '.$j]['lvl']=9;
			
		

			
			}
			
	
			if(isset($config['halfs'][$i]))	{
				
			$date->modify('+30 minutes');
			
			for($j=1;$j<=4;$j++){
			$data['table'][$date->format('H:i')]['kort '.$j]['text']='';
			
			$data['table'][$date->format('H:i')]['kort '.$j]['lvl']=9;
			

			}
			
			
			$date->modify('+30 minutes');
			
			}else
			$date->modify('+1 hour');

		}
		
		
		
		
		


		
		
		$where=array(
		
		'h.id_reserv'=>null,
		'k.id_klienta'=>$client,
		'data='=>$date_start,
	
		
	
		);
		if($deleted==1){
		
		unset($where['h.id_reserv']);
		
		$where['h.id_reserv is not']=null;
		
			
		}
		
		//wyciąganie danych o dostępności kortów
		$result=$this->Admin_model->get_available_courts($where);
	
		
		
			//matchowanie talicy z dostępnością


			foreach ($data['table'] as $key=>$row)
			{

			if(array_key_exists($key,$result))
				$data['table'][$key]=array_merge($row,$result[$key]);	
				
			}
			$data['config']=$config;
			
			
		
			echo json_encode($data);




	}
	
	
	
	
	public function Price(){
			
		$client=$this->input->post('client');
		$day=$this->input->post('day');
		$hour=$this->input->post('hour');
			
		
			
			
			$weekDay=date('w',strtotime($day));
			
			$where=array(
		
			'client_id'=>$client,
			'day'=>$weekDay,
			'hour'=>$hour,
			'end'=>'2100-01-01'
			
			);
			
	
		$result=$this->Admin_model->getPrice($where);
			
			
			
		echo json_encode($result);	
			
			
			
			
		}
		
		
		
		public function confirmRealisation(){
			

			$id=$this->input->post('id');
			
				$where=array(
			
					'id'=>$id
				
				);
			
	
		$result=$this->Admin_model->confirmRealisation($where);
			
			
			
		echo json_encode($result);	
			
			
			
			
		}
	
	public function getPlayers(){
		

		$data['players']=$this->Admin_model->getPlayers();

	
		echo json_encode($data);
		
	
	}
		
		
		public function insert_reservation(){
			
		$date_time=date('Y-m-d H:i:s');
		$client=$this->input->post('client');
		$court=$this->input->post('court');
		$player=$this->input->post('player');
		$reservationLength=$this->input->post('reservation_length');
		$comment=$this->input->post('comment');
		$day=$this->input->post('day');
		$hour=$this->input->post('hour');
		

			$insert=array(
			
			'date_time'=>$date_time,
			'id_klienta'=>$client,
			'nr_kortu'=>$court,
			'godzina'=>$hour,
			'data'=>$day,
			'telefon'=>$player,
			'notatka'=>$comment,
			'typ_rezerwacji'=>0
						
			);
			
			$insert = $this->security->xss_clean($insert);
			
			
			$where=array(
			
			
			'id_klienta'=>$client,
			'nr_kortu'=>$court,
			'godzina'=>$hour,
			'data'=>$day,
		
						
			);
			
			
			$weekday=date('N',strtotime($day));
			
			
			$whereHalf=array(
			
			
			'client_id'=>$client,	
			'substr(hour,1,2)'=>substr($hour,0,2),
			'day'=>$weekday,
			'end'=>'2100-01-01',
			'value'=>1
		
						
			);
			

		//wrzucanie nowej rezerwacji
		$result['result']=$this->Admin_model->insert_reservation($insert,$where,$whereHalf,$reservationLength);
			

		
		echo json_encode($result);	
			
			
			
			
		}	
	

	
		public function loadModalDetails()
		{

		$id=$this->input->post('id');
		
		
		$where=array(
			'k.id'=>$id
			);
	
		//wyciąganie danych o rezerwacji
		$data['dane']=$this->Admin_model->getReservationDetails($where);
		
		
		
		echo json_encode($data);	


		}
	
		public function insertNewPlayer()
		{
			
		$registered=date('Y-m-d');
		$phone=$this->input->post('phone');
		$surname=$this->input->post('surname');
		$name=$this->input->post('name');
		$email=$this->input->post('email');
		
		
		
			$insert=array(
			
			'phone'=>$phone,
			'surname'=>$surname,
			'name'=>$name,
			'email'=>$email,
			'registered'=>$registered
						
			);
			
			$insert = $this->security->xss_clean($insert);
	
			
			$where=array(
			
			
			'phone'=>$phone
		
						
			);
			

		//wrzucanie nowej rezerwacji
		$result['result']=$this->Admin_model->insertNewPlayer($insert,$where);
			

		
		echo json_encode($result);	
			
			
			
			
		}	
	
	
	public function deleteReservation()
		{
			
		
		$id=$this->input->post('id');
		$penalty=$this->input->post('penalty');
		$reason=$this->input->post('reason');
		$reservation_comment=$this->input->post('reservation_comment');
		$reservation_user=$this->input->post('reservation_user');
		
		
		
			$insert=array(
			
			'id_reserv'=>$id,
			'penalty'=>$penalty,
			'reason'=>$reason,
			'reservation_comment'=>$reservation_comment,
			'reservation_user'=>$reservation_user,
			'delete_date'=>date('Y-m-d H:i:s')
		
			
						
			);
			
		$insert = $this->security->xss_clean($insert);

		
		$result['result']=$this->Admin_model->deleteReservation($insert);
			

		
		echo json_encode($result);	
			
			
			
			
		}	
	
	
	
		public function updateReservation()
		{
			
		
		$id=$this->input->post('id');
		
		
		
			$insert=array(
			
			'id_reserv'=>$id
			
						
			);
	

	
		$result['result']=$this->Admin_model->deleteReservation($insert);
			

		
		echo json_encode($result);	
			
		$player=$this->input->post('player');
			
			
		
		
		
		}




}
