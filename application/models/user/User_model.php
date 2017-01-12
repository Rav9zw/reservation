<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
    
$this->reserve = $this->load->database('default', TRUE); 
	    
	
    
    }






public function get_available_courts($where){
	
	
		$this->reserve->select("count(*)zarezerwowanych,k.data, k.id_klienta ,TIME_FORMAT(k.godzina,'%H:%i')godzina,c.ilosc_kortow");
		
        $this->reserve->from("a_korty k");

		$this->reserve->join("a_config c","c.id_klienta=k.id_klienta");
		
		$this->reserve->join("a_reserv_history h","k.id=h.id_reserv","left");
		
		
		$this->reserve->where($where);
		
		$this->reserve->group_by("data, id_klienta ,TIME_FORMAT(k.godzina,'%H:%i')");
  
        $result = $this->reserve->get();

        
   // echo $this->reserve->last_query();

        $array = array();
      
      
       
            foreach ($result->result() as $row) {
                
			if( $row->zarezerwowanych>=$row->ilosc_kortow ){
			$array[$row->godzina][$row->data]['text']='Zarezerwowane';
			$array[$row->godzina][$row->data]['lvl']=0;
		
			}elseif( $row->ilosc_kortow-$row->zarezerwowanych==1 ){
			$array[$row->godzina][$row->data]['text']='Rezerwuj<br>ostatni kort';
			$array[$row->godzina][$row->data]['lvl']=1;
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

        
		$ilosc=self::getCourtCount($where['k.id_klienta']);
		
 // echo $this->reserve->last_query();

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