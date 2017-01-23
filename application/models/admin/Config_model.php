<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Config_model extends CI_Model {

    public function __construct() {
    
		$this->reserve = $this->load->database('default', TRUE); 
	    
	
    
    }



private function getIcons($variable,$type=null){
		
		
		switch($variable) {
						
							case '0':{
							$icon='<i data-value="0" class="fa_hours fa fa-times" aria-hidden="true"></i>';
							if($type=='class')	
							$icon='fa-times';								
							}
							break;	
							case '1':{
							$icon='<i data-value="1" class="fa_hours fa fa-adjust" aria-hidden="true"></i>';
							if($type=='class')	
							$icon='fa-adjust';	
								
							}
							break;
							case '2':{
							$icon='<i data-value="2" class="fa_hours fa fa-circle" aria-hidden="true"></i>';
							if($type=='class')	
							$icon='fa-circle';	
								
							}
							break;	
					}
		return $icon;
	
	
}	
	
	
public function getWorkingHours($data,$where){
	
	
	$default=array();
	
	$this->reserve->select('value,hour,day');
	$this->reserve->from('a_config_hour');
	$this->reserve->where($where);
	
	$result=$this->reserve->get();
	
	foreach($result->result() as $row){
		
		$default[$row->hour][$row->day]=$row->value;
		
		
		
	}
	

	
foreach ($data['table'] as $key=>$row){



if(array_key_exists($key,$default)){
	
	
	

	foreach($row as $k=>$r){


			if(array_key_exists($k,$default[$key])){
			
				
			$avail=self::getIcons($default[$key][$k]);
				
	
				
				$data['table'][$key][$k]=$avail;



			
				
					}
			
				
				}	

				

				}

				
			}
	
	
	return $data;
	
	
}





public function getPriceList($data,$where){
	
	
	$default=array();
	
	$this->reserve->select('value,hour,day');
	$this->reserve->from('a_config_price');
	$this->reserve->where($where);
	
	$result=$this->reserve->get();
	
	foreach($result->result() as $row){
		
		$default[$row->hour][$row->day]=$row->value;
		
		
		
	}
	

	
foreach ($data['table'] as $key=>$row){



if(array_key_exists($key,$default)){
	
	
	

	foreach($row as $k=>$r){


			if(array_key_exists($k,$default[$key])){
	
			$data['table'][$key][$k]='<div class="price">'.$default[$key][$k].'</div>';

					}
			
				
				}	

				

				}

				
			}
	
	
	return $data;
	
	
}




private function checkConfig(){
	
	
	
	
}

private function insertConfig($insert,$base){
	
	
$this->reserve->insert($base, $insert);


 if($this->reserve->affected_rows() == 1){
		 
		 $array['message']='<strong>Powodzenie!</strong> Zapisano.';
		 $array['status']='success';

	 } else{
		 
		 $array['message']='<strong>Błąd!</strong> Coś poszło nie tak, prosze odświeżyc strone i spróbować ponownie';
		 $array['status']='danger';
		 
		 
	 }
	
		return $array;


	
}

private function updateConfig($where,$update,$base){
	

	
$this->reserve->set( $update);
$this->reserve->where($where);
$this->reserve->update($base); 


 if($this->reserve->affected_rows() == 1){
		 
		 $array['message']='<strong>Powodzenie!</strong> Zapisano.';
		 $array['status']='success';

		}else{
		 
		 $array['message']='<strong>Błąd!</strong> Coś poszło nie tak, prosze odświeżyc strone i spróbować ponownie';
		 $array['status']='danger';
		 
		 
		}
		//echo $this->reserve->last_query();
		return $array;

	
}



public function newConfig($client,$day,$hour,$value,$base){
	
		$where=array('client_id'=>$client,
					 'hour'=>$hour,
					 'day'=>$day,
					 'end'=>'2100-01-01');
	
		$update=array('value'=>$value);
		
		$insert=array('client_id'=>$client,
					 'hour'=>$hour,
					 'day'=>$day,
					 'value'=>$value,
					 'start'=>date('Y-m-d'),
					 'end'=>'2100-01-01');
		
		
		
		$array=array();
	
		$this->reserve->select("start");
		
        $this->reserve->from($base);

		$this->reserve->where($where);
	
		$result = $this->reserve->get();
		
		$isRecord=true;
		
		//echo $this->reserve->last_query();
		
		foreach($result->result() as $row){
		
			
			if($row->start==date('Y-m-d')){

			self::updateConfig($where,$update,$base);
			$isRecord=false;	
			}else{
		
			
			$date = new DateTime();
			$date->modify('-1 day');
			$yesterday=$date->format('Y-m-d');

			$update['end']=$yesterday;
			$array['update']=self::updateConfig($where,$update,$base);

			}


			}
	
		if($isRecord)
		$array['insert']=self::insertConfig($insert,$base);	


	
	
		if($base=='a_config_hour'){
		$array['value']=$value;
		$array['icons']=self::getIcons($value,'class');
		}
		else
		$array['value']=$value;	
		
		return $array;
	
	
	
	
	
	
}





}