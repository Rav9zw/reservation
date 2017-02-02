<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
    
$this->reserve = $this->load->database('default', TRUE); 
	    
	
    
    }






public function get_available_courts($where){
	
	
		$this->reserve->select("count(*)zarezerwowanych,
		k.nr_kortu,k.id,k.id_parent,k.data, k.id_klienta ,
		concat(TIME_FORMAT(k.godzina,'%H'),':00')godzina,c.ilosc_kortow");
		
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
			
		
			$polishWeek = array( 'Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota' );
			$polishWeekShort = array( 'Ndz', 'Pn', 'Wt', 'Śr', 'Czw', 'Pt', 'So' );
			
            foreach ($arraycalc as $key=>$row) {
             

				foreach($row as $k=>$r){
					
				$week=$polishWeek[date('w',strtotime($k))];
			 	$weekShort=$polishWeekShort[date('w',strtotime($k))];
					
						if( count($r['zarezerwowane'])==$r['ilosc_kortow'] ){
						$array[$key][$k]['text']=$weekShort.', '.$key.'</br>Zarezerwowane';
						$array[$key][$k]['lvl']=0;
						$array[$key][$k]['week']=$week;
					
						}elseif( $r['ilosc_kortow']-count($r['zarezerwowane'])==1 ){
						$array[$key][$k]['text']=$weekShort.', '.$key.'</br>Ostatni kort';
						$array[$key][$k]['lvl']=1;
						$array[$key][$k]['week']=$week;
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


public function get_available_courts_details($where,$wherePrice){
	
	
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
			
			
			$array['courts'][$i]=$i;
			
				
			}
	
	

	
	$array['courts']=array_diff($array['courts'],$zajete);
	
	
	
		$this->reserve->select("value");
		
        $this->reserve->from("a_config_price");

		$this->reserve->where($wherePrice);

		
  
        $result = $this->reserve->get();
		$array['price']='Cena: 30 zł';
	
	
	foreach($result->result() as $row)
	{
		
		$array['price']='Cena: '.$row->value.' zł';
		
	}
	
	
	
	
	
	
	
	
	
	return $array;
}



public function getConfigHours($where){
	
	
	$this->reserve->select("substring(hour,1,2)hour");
		
	$this->reserve->from("a_config_hour c");
	
	$this->reserve->where($where);
	
	$this->reserve->group_by('substring(hour,1,2)');
	
	$this->reserve->having('count(*)=7');
	
	$result=$this->reserve->get();
	
	$array=array();
	
	//echo $this->reserve->last_query();
	
	
	foreach($result->result() as $row)
	{
		
		$array['work'][intval($row->hour)]=$row->hour;
	
	}
	
	
	$array['extremes']['min']=0;	

	
	
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
	



	$this->reserve->select("hour,day");
		
	$this->reserve->from("a_config_hour");
	
	$this->reserve->where($where);
	
	$result=$this->reserve->get();
	
$polishWeekShort = array( 1=>'Pn',2=> 'Wt',3=> 'Śr',4=> 'Czw', 5=>'Pt', 6=>'So',7=>'Ndz' );
	
	foreach($result->result() as $row)
	{
		
		$array['work'][$row->hour][$polishWeekShort[$row->day]]=true;
	
	}


	
	return $array;
	
	
	
	
}


private function checkForReservation($where){
	
	
	
	
		$this->reserve->select("k.id");
		
        $this->reserve->from("a_korty k");

		$this->reserve->join("a_reserv_history h","k.id=h.id_reserv","left");
		
		$this->reserve->where($where);
		
		$this->reserve->where('h.id_reserv is null');
	
		$result = $this->reserve->get();
		
		return $result->num_rows();
		
	
}

private function checkForHalfs($where){
	
	
		
	
		$this->reserve->select("k.id");
		
        $this->reserve->from("a_config_hour k");
		
		$this->reserve->where($where);

		$result = $this->reserve->get();
		
		//echo $this->reserve->last_query();
		
		return $result->num_rows();
		
	
}


public function insert_reservation($insert,$where,$whereHalf){
	

	
		$isFree=self::checkForReservation($where);
		
		$isHalf=self::checkForHalfs($whereHalf);
	
	
	
		$array=array();
	
	
		if($isFree>0){
			
		$array['message']='<strong>Kort zajęty!</strong> Niestety ktoś Cie uprzedził, prosimy wybrać inną godzine/termin';
		$array['status']='danger';

		
		return $array;
	}
	
		$hour=new DateTime(date('Y-m-d').' '.$insert['godzina']);
		$hour->modify('+30 minutes');
		$where['godzina']=$hour->format('H:i:s');
		
		$isFreeHalf=self::checkForReservation($where);
		
		
		if($isFreeHalf>0){
			
		$array['message']='<strong>Kort zajęty!</strong> Kort dostępny tylko pierwsze 30min, możliwość rezerwacji tylko telefonicznej';
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
	
		$isHalf=self::checkForHalfs($whereHalf);
	
		if($isHalf>0){	
		
		$insert['id_parent']=$this->reserve->insert_id();
				
		$insert['godzina']=$hour->format('H:i:s');
		$insert['notatka']='<i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>';
		
		
		$this->reserve->insert('a_korty', $insert);

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



public function insertCode($insert){
	

		$this->reserve->insert('verification_code', $insert);


		//echo $this->reserve->affected_rows();
		//  echo $this->reserve->last_query();

	 if($this->reserve->affected_rows() == 1){
		 
	
		 $array['status']='success';

	 } else{
		 
		 $array['message']='<strong>Błąd!</strong> Coś poszło nie tak, prosze odświeżyc strone i spróbować ponownie';
		 $array['status']='danger';
		 
		 
	 }
	
		return $array;
			
	
}



public function checkVerificationCode($where){
	

		$array=array();
	
		$this->reserve->select("email");
		
        $this->reserve->from("verification_code");

		$this->reserve->where($where);
	
		$result = $this->reserve->get();
		
		if($result->num_rows()==0){
			
		$array['message']='<strong>Uwaga!</strong> Błedny kod aktywacyjny';
		$array['status']='danger';

		
		return $array;
	}
	
	$array['status']='success';
	
	return 	$array;
			
	
}






}