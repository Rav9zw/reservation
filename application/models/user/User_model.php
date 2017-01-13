<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
    
$this->reserve = $this->load->database('default', TRUE); 
	    
	
    
    }






public function get_available_courts($where){
	
	
		$this->reserve->select("count(*)zarezerwowanych,k.nr_kortu,k.id,k.id_parent,k.data, k.id_klienta ,concat(TIME_FORMAT(k.godzina,'%H'),':00')godzina,c.ilosc_kortow");
		
        $this->reserve->from("a_korty k");

		$this->reserve->join("a_config c","c.id_klienta=k.id_klienta");
			
		$this->reserve->join("a_reserv_history h","k.id=h.id_reserv","left");
		
		$this->reserve->where($where);
		
		$this->reserve->group_by("k.nr_kortu,k.id,k.id_parent,data, id_klienta ,TIME_FORMAT(k.godzina,'%H')");
  
        $result = $this->reserve->get();

        
		// echo $this->reserve->last_query();

        $arraycalc = array();
        $array = array();
      
      
			foreach ($result->result() as $row) {
	  
			$arraycalc[$row->godzina][$row->data]['zarezerwowane'][$row->nr_kortu]=1;
			$arraycalc[$row->godzina][$row->data]['ilosc_kortow']=$row->ilosc_kortow;
			
			}
			
		
			
       
            foreach ($arraycalc as $key=>$row) {
             

				foreach($row as $k=>$r){
				
			 
						if( count($r['zarezerwowane'])==$r['ilosc_kortow'] ){
						$array[$key][$k]['text']='Zarezerwowane';
						$array[$key][$k]['lvl']=0;
					
						}elseif( $r['ilosc_kortow']-count($r['zarezerwowane'])==1 ){
						$array[$key][$k]['text']='Rezerwuj<br>ostatni kort';
						$array[$key][$k]['lvl']=1;
						}
			
			
				}
			
			}
			
			
			
	
	return $array;
}


private function getCourtCount($client){
	
	
		$where=array('id_klienta'=>$client);
	
		$this->reserve->select("c.ilosc_kortow");
		
        $this->reserve->from("a_config c");
	
		$this->reserve->where($where);
	
		$result = $this->reserve->get();
	 
	 $count='';
	 
	 foreach($result->result() as $row){
		 
		 $count=$row->ilosc_kortow;
		 
	 }
	 
	 
	 return $count;
	 
}


public function get_available_courts_details($where){
	
	
		$this->reserve->select("k.nr_kortu");
		
        $this->reserve->from("a_korty k");

		$this->reserve->join("a_reserv_history h","k.id=h.id_reserv","left");

		$this->reserve->where($where);

		
  
        $result = $this->reserve->get();

        //echo $this->reserve->last_query();
		 
		$ilosc=self::getCourtCount($where['k.id_klienta']);
		


			$array = array();
			
			$zajete = array();
      
		
			
			
       
            foreach ($result->result() as $row) {
                
			$zajete[$row->nr_kortu]=$row->nr_kortu;
		 
			
	
			}
	
			for($i=1;$i<=$ilosc;$i++){
			
			
			$array[$i]=$i;
			
				
			}
	
	

	
	$array=array_diff($array,$zajete);
	
	
	
	
	return $array;
}



public function getConfigHours($where){
	
	
	$this->reserve->select("substring(hour,1,2)hour,value");
		
	$this->reserve->from("a_config_hour c");
	
	$this->reserve->where($where);
	
	$result=$this->reserve->get();
	
	$array=array();
	
	
	

	
	foreach($result->result() as $row)
	{
		
		if($row->value==0)
		$array['work'][intval($row->hour)]=$row->value;
	
		if($row->value==1)
		$array['halfs'][intval($row->hour)]=$row->value;
		
		
	}
	
			$array['extremes']['min']=0;	
			$min=true;
			
			for($i=0;$i<=23;$i++){
			
				if(isset($array['work'][$i]) && $min==true ){
				 $array['extremes']['min']=$i+1;	
				$min=true;
				}else
				 $min=false;	
			
			
			}
			$array['extremes']['max']=23;	
			$max=true;
			
			for($i=23;$i>=0;$i--){
			
				if(isset($array['work'][$i]) && $max==true ){
				 $array['extremes']['max']=$i-1;	
				$max=true;
				}else
				 $max=false;	
			
			
			}
	
	
	return $array;
	
	
	
	
}


public function insert_reservation($insert,$where){
	

	
	
	
	
	
		$array=array();
	
		$this->reserve->select("k.id");
		
        $this->reserve->from("a_korty k");
		
		$this->reserve->join("a_reserv_history h","k.id=h.id_reserv","left");

		$this->reserve->where($where);
	
		$result = $this->reserve->get();
		
		if($result->num_rows()>0){
			
		$array['message']='<strong>Kort zajęty!</strong> Niestety ktoś Cie uprzedził, prosimy wybrać inną godzine/termin';
		$array['status']='danger';

		
		return $array;
	}
	
		$this->reserve->insert('a_korty', $insert);


    //echo $this->reserve->affected_rows();
    //  echo $this->reserve->last_query();

	 if($this->reserve->affected_rows() == 1){
		 
		 $array['message']='<strong>Powodzenie!</strong> Kort zarezerwowany pomyślnie.';
		 $array['status']='success';

	 } else{
		 
		 $array['message']='<strong>Błąd!</strong> Coś poszło nie tak, prosze odświeżyc strone i spróbować ponownie';
		 $array['status']='danger';
		 
		 
	 }
	
		return $array;
			
	
}



public function phone_verification($where){
	


		$array=array();
	
		$this->reserve->select("id");
		
        $this->reserve->from("a_players");

		$this->reserve->where($where);
	
		$result = $this->reserve->get();
		
		$array=array();
		foreach($result->result() as $row){
		
	 	$array[]=	$row->id;
		
		
		}
		
		
	if(count($array)>0)
		return $array;
	else
		return 'brak';

}


public function insertNewPlayer($insert,$where){
	

	
	
	
	
	
		$array=array();
	
		$this->reserve->select("phone");
		
        $this->reserve->from("a_players");

		$this->reserve->where($where);
	
		$result = $this->reserve->get();
		
		if($result->num_rows()>0){
			
		$array['message']='<strong>Uwaga!</strong> Podany numer telefonu jest już w bazie';
		$array['status']='danger';

		
		return $array;
	}
	
		$this->reserve->insert('a_players', $insert);


    //echo $this->reserve->affected_rows();
    //  echo $this->reserve->last_query();

	 if($this->reserve->affected_rows() == 1){
		 
		 $array['message']='<strong>Powodzenie!</strong> Użytkownik dodany pomyślnie.';
		 $array['status']='success';

	 } else{
		 
		 $array['message']='<strong>Błąd!</strong> Coś poszło nie tak, prosze odświeżyc strone i spróbować ponownie';
		 $array['status']='danger';
		 
		 
	 }
	
		return $array;
			
	
}














}