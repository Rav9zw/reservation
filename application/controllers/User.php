<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

      public function __construct() {
        parent::__construct();


      $this->load->model('user/User_model');
	//	$this->load->library('session');


        
    }

    public function index() {

		$dane['dane']='';

		$this->load->view('user/master', $dane);

						}
						
	
	public function available_courts(){


	//tworznie tablicy do rezerwacji
	
		$client=$this->input->post('client');
		$sub=$this->input->post('sub');
		$date_start=$this->input->post('date_start');
		$date_start=date( "Y-m-d", strtotime( "$date_start $sub day" ) );
		$date_end=date( "Y-m-d", strtotime( "$date_start +6 day" ) );
		
	
		$where=array('client_id'=>$client,
					 'value'=>'0',
					 'end'=>'2100-01-01');

		$config=$this->User_model->getConfigHours($where);
		
		$min=$config['extremes']['min'];
		$max=$config['extremes']['max'];
		
		$date = new DateTime($date_start.' '.$min.':00:00');
	
		$polishWeek = array( 1=> 'Poniedziałek',2=> 'Wtorek',3=> 'Środa', 4=> 'Czwartek',5=> 'Piątek',6=> 'Sobota',7=>'Niedziela' );
		$polishWeekShort = array( 1=>'Pn',2=> 'Wt',3=> 'Śr',4=> 'Czw', 5=>'Pt', 6=>'So',7=>'Ndz' );

		for($i=$min;$i<=$max;$i++){
		
		
		for($j=1;$j<=7;$j++){
			
		$week=$polishWeek[$date->format('N')];
		$weekShort=$polishWeekShort[$date->format('N')];
			
		if(isset($config['work'][$date->format('H:i')][$weekShort]) )
		{
		$table[$date->format('H:i')][$date->format('Y-m-d')]['text']=$weekShort.', '.$date->format('H:i').'</br>Zamknięte';
		$table[$date->format('H:i')][$date->format('Y-m-d')]['lvl']=2;
		}
		else
		{
		$table[$date->format('H:i')][$date->format('Y-m-d')]['text']=$weekShort.', '.$date->format('H:i').'</br>Wolne';
		$table[$date->format('H:i')][$date->format('Y-m-d')]['lvl']=9;
		}
		$table[$date->format('H:i')][$date->format('Y-m-d')]['week']=$week;
		
		$date->modify('+1 day');

		}
		$date->modify('-7 day');

		$date->modify('+1 hour');
		
		}
	


		
		
		$where=array(
		'h.id_reserv'=>null,
		'k.id_klienta'=>$client,
		'data>='=>$date_start,
		'data<='=>$date_end
		
		
		);
		
		//wyciąganie danych o dostępności kortów
		$result=$this->User_model->get_available_courts($where);
		
		
			//matchowanie talicy z dostępnością


			foreach ($table as $key=>$row){

			if(array_key_exists($key,$result))
				$table[$key]=array_merge($row,$result[$key]);

					
			}
		
			echo json_encode($table);




	}

		
		
		
		public function fill_modal(){
			
		$client=$this->input->post('client');
		$day=$this->input->post('day');
		$hour=$this->input->post('hour');
			
			$where=array(
			'h.id_reserv'=>null,
			'k.id_klienta'=>$client,
			'k.data'=>$day,
			'substr(k.godzina,1,2)'=>substr($hour,0,2)
			
			);
			
			
			
			
			$weekDay=date('w',strtotime($day));
			
			$wherePrice=array(
		
			'client_id'=>$client,
			'day'=>$weekDay,
			'hour'=>$hour,
			'end'=>'2100-01-01'
			
			);
			
		//wyciąganie dostępnych kortów
		$result=$this->User_model->get_available_courts_details($where,$wherePrice);
			
			
			
		echo json_encode($result);	
			
			
			
			
		}
		
		

		public function insert_reservation(){
			
		$date_time=date('Y-m-d H:i:s');
		$client=$this->input->post('client');
		$court=$this->input->post('court');
		$player=$this->input->post('player');
		$day=$this->input->post('day');
		$hour=$this->input->post('hour');
		
		/*
		if(!preg_match("/^[0-9]{9}$/", $phone)) {
		
		$result['result']['message']='<strong>Telefon!</strong> Niepoprawny numer telefonu.';
		$result['result']['status']='danger';
		echo json_encode($result);	
		return false;
		
		}
	*/

		
			$insert=array(
			
			'date_time'=>$date_time,
			'id_klienta'=>$client,
			'nr_kortu'=>$court,
			'godzina'=>$hour,
			'data'=>$day,
			'telefon'=>$player,
			'typ_rezerwacji'=>1
						
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
		$result['result']=$this->User_model->insert_reservation($insert,$where,$whereHalf);
			
		
		
		
		


		//$token = "s8sms@40b90e0040e93bb6e0591cc1647ac537";


		//$adres = $key;
		/*
		if(	$result['result']['status']=='success'){
		$params = array(
			 'username' => 'rav86pl@hotmail.com',
			 'password' => 'a905cc75707966498cf3a5f0a8fa7fa7',
			 'encoding'  => 'utf-8',
			 'to' => "$phone",
			 //'to' => $_REQUEST['telefon'],
			 //'flash' => '1' ,	 
			 'from' =>'eco',
			 'message' => "Potwierdzenie rezerwacji kortu $court w dniu $day o godzine $hour . "
		);

		//$this->sms_send($params);
		
			
			
		}
		*/
		
		echo json_encode($result);	
			
			
			
			
		}	
//sprawdzanie czy telefon jest w bazie	
public function checkPhone()
{
		$phone=$this->input->post('phone');
	
	
		$where=array(
			
			
			'phone'=>$phone,
		
			);
	
	
		$result=$this->User_model->phone_verification($where);
		
		echo json_encode($result);	
	
}	
	
	
	
	
	
   		public function insertNewPlayer(){
			
			
			
		$registered=date('Y-m-d');
		$phone=$this->input->post('phone');
		$surname=$this->input->post('surname');
		$name=$this->input->post('name');
		$email=$this->input->post('email');
		$code=$this->input->post('code');
		
		
		
		$where=array(
			
			
			'email'=>$email,
			'code'=>$code
		
						
			);
		
		$result['result']=$this->User_model->checkVerificationCode($where);
		
		
		
		if($result['result']['status']=='success'){
			
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
		$result['result']=$this->User_model->insertNewPlayer($insert,$where);
			
			}
		
		echo json_encode($result);	
			
		
			
			
		}	


public function sms_send($params ,$backup = false) 
{

    static $content;
 //$content = null ;
    if($backup == true){
        $url = 'http://api2.smsapi.pl/sms.do';
    }else{
        $url = 'http://api.smsapi.pl/sms.do';
    }

    $c = curl_init();
    curl_setopt( $c, CURLOPT_URL, $url );
    curl_setopt( $c, CURLOPT_POST, true );
    curl_setopt( $c, CURLOPT_POSTFIELDS, $params );
    curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );

    $content = curl_exec( $c );
    $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    if($http_status != 200 && $backup == false){
        $backup = true;
        sms_send($params, $backup);
    }

    curl_close( $c );    
    return $content;
}




   		public function sendVerificationCode(){
			

		$email=$this->input->post('email');
		$code=mt_rand(10000000, 99999999);
		$data=date('Y-m-d H:i:s');
		
			$insert=array(
			
			'email'=>$email,
			'code'=>$code,
			'date'=>$data
						
			);
	
		$insert = $this->security->xss_clean($insert);
			
			
			

		//wrzucanie nowej rezerwacji
		$result['result']=$this->User_model->insertCode($insert);
			

		
		echo json_encode($result);	
			
			
			
			
		}	






	
	
	
	
	
	
	
	
	
	
	
	
	
	




}
