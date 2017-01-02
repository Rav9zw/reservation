<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
    
$this->reserve = $this->load->database('default', TRUE); 
	    
	
    
    }


private function getReservationType($player,$type,$isNew,$latest)
{
	
							$animation='';
							
							if($latest==1)
							 $animation="animated  bounceIn";
							
							if($isNew==1)
							 $animation="animated  infinite pulse";
						
	
	
	//pozniej zrob tu zaciąganie z bazy, na przyszłośc może dla każdego klienta inne
	
	switch($type){
		
		
		case 0: $reservation="<div class='$animation alert_reserv alert alert-success' role='alert'><strong>$player</strong></br>
		Notatka do rezerwacji</a>.
		</div>";
		break;		
		
		case 1: $reservation="<div class='$animation alert_reserv alert alert-info' role='alert'><strong>$player</strong></br>
		Notatka do rezerwacji</a>.
		</div>";
		break;
		
		default:$reservation="<span class='$animation alert_reserv alert alert-primary'>$player</span>";
		

	}
	return $reservation;
	
	
	
	
}




public function get_available_courts($where){
	
	
		$this->reserve->select("k.data, k.id_klienta ,TIME_FORMAT(k.godzina,'%H:%i')godzina,c.ilosc_kortow,k.nr_kortu,k.telefon ,k.typ_rezerwacji,
								(case when (TO_SECONDS(now())-TO_SECONDS(k.date_time))>300 or k.typ_rezerwacji=0 then 0
								else 1
								end)isNew,
								(case when (select max(id) from a_korty n where k.id_klienta=n.id_klienta and k.typ_rezerwacji=0)=k.id 
								and (TO_SECONDS(now())-TO_SECONDS(k.date_time))<5
								then 1
								else 0
								end)latest,
								ifnull(concat(p.surname,' ',p.name),k.telefon)player
								
								");
		
        $this->reserve->from("a_korty k");

		$this->reserve->join("a_config c","c.id_klienta=k.id_klienta");
		$this->reserve->join("a_players p","k.telefon=p.id","left");
		
		$this->reserve->where($where);
  
        $result = $this->reserve->get();

        
		//echo $this->reserve->last_query();

        $array = array();

       
            foreach ($result->result() as $row) {
                
			
			$reservation=self::getReservationType($row->player,$row->typ_rezerwacji,$row->isNew,$row->latest);
			
			
			
			$array[$row->godzina]['kort '.$row->nr_kortu]['text']=$reservation;
		
		
		
		
		
			
			}
	
	return $array;
}



public function get_players($where){
	
	
		$this->reserve->select("id,concat(surname,' ',name)player");
		
        $this->reserve->from("a_players");

        $result = $this->reserve->get();

        
		//echo $this->reserve->last_query();

        $array = array();

       $i=0;
            foreach ($result->result() as $row) {

			$array[$i]['id']=$row->id;
			$array[$i]['player']=$row->player;
	
			$i++;
			}
	
	return $array;
}





public function insert_reservation($insert,$where){
	

	
	
	
	
	
		$array=array();
	
		$this->reserve->select("id");
		
        $this->reserve->from("a_korty");

		$this->reserve->where($where);
	
		$result = $this->reserve->get();
		
		if($result->num_rows()>0){
			
		$array['message']='<strong>Kort zajęty!</strong>Kort zarezerwowany przez innego użytkownika';
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
		 
		 $array['message']='<strong>Błąd!</strong>Coś poszło nie tak, prosze odświeżyc strone i spróbować ponownie';
		 $array['status']='danger';
		 
		 
	 }
	
		return $array;
			
	
}



public function phone_verification($phone){
	


		$array=array();
	
		$this->reserve->select("id");
		
        $this->reserve->from("a_users");

		$this->reserve->where("telefon='$phone'");
	
		$result = $this->reserve->get();
		
		if($result->num_rows()>0){
		return 'ok';
		}else
		return 'brak';
	

}

















}