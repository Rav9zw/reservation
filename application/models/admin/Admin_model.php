<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
    
$this->reserve = $this->load->database('default', TRUE); 
	    
	
    
    }


private function getReservationType($player,$type,$isNew,$latest,$notatka,$cofirmed)
{
	
							$animation='';
							
							if($latest==1)
							 $animation="animated  bounceIn";
							
							if($isNew==1)
							 $animation="animated  infinite pulse";
				
	if($cofirmed==1)
	{
		
	$confirmed='<i class="fa fa-check" aria-hidden="true"></i>'	;
		
	}
	else
		$confirmed=''	;

					
	
	
	//pozniej zrob tu zaciąganie z bazy, na przyszłośc może dla każdego klienta inne
	
	switch($type){
		
		
		case 0: $reservation="<div class='$animation alert_reserv alert alert-success' role='alert'><strong>$confirmed $player</strong></br>
		$notatka<br>
		</div>";
		break;		
		
		case 1: $reservation="<div class='$animation alert_reserv alert alert-info' role='alert'><strong>$confirmed $player</strong></br>
		$notatka
		</div>";
		break;
		
		case 2: $reservation="<div class='alert_reserv alert alert-warning' role='alert'><strong>$confirmed $player</strong></br>
		$notatka
		</div>";
		break;
		
		case 3: $reservation="<div class='alert_reserv alert alert-danger' role='alert'><strong>$confirmed $player</strong></br>
		$notatka
		</div>";
		break;
		
		default:$reservation="<div class='$animation alert_reserv alert alert-primary' role='alert'><strong>$confirmed $player</strong></br>
		$notatka
		</div>";
	}
	return $reservation;
	
	
	
	
}




public function get_available_courts($where){
	
	
		$this->reserve->select("h.id history_id,
								(case when k.id_parent=0 then k.id
								else k.id_parent
								end)id,k.confirmed,
								k.data, k.id_klienta ,TIME_FORMAT(k.godzina,'%H:%i')godzina,c.ilosc_kortow,k.nr_kortu,k.telefon ,
								TO_SECONDS(STR_TO_DATE(concat(k.data,' ',k.godzina),'%Y-%m-%d %T'))dd,
								(TO_SECONDS(h.delete_date)-TO_SECONDS(STR_TO_DATE(concat(k.data,' ',k.godzina),'%Y-%m-%d %T')))dt,
									(
								case 
								when h.id_reserv is not null and (TO_SECONDS(STR_TO_DATE(concat(k.data,' ',k.godzina),'%Y-%m-%d %T'))-TO_SECONDS(h.delete_date))>86400 then 2
								when h.id_reserv is not null and (TO_SECONDS(STR_TO_DATE(concat(k.data,' ',k.godzina),'%Y-%m-%d %T'))-TO_SECONDS(h.delete_date))<86400 then 3
								else k.typ_rezerwacji
								end)typ_rezerwacji,
								(case 
								when (TO_SECONDS(now())-TO_SECONDS(k.date_time))>300 or k.typ_rezerwacji=0 then 0
								else 1
								end)isNew,
								(case when (select max(id) from a_korty n where k.id_klienta=n.id_klienta and k.typ_rezerwacji=0)=k.id 
								and (TO_SECONDS(now())-TO_SECONDS(k.date_time))<5
								then 1
								else 0
								end)latest,
							
								ifnull(concat(p.surname,' ',p.name),k.telefon)player,k.notatka
								
								");
		
        $this->reserve->from("a_korty k");

		$this->reserve->join("a_config c","c.id_klienta=k.id_klienta");
		$this->reserve->join("a_players p","k.telefon=p.id","left");
		$this->reserve->join("a_reserv_history h","k.id=h.id_reserv","left");
		
		$this->reserve->where($where);
  
        $result = $this->reserve->get();

        
		//echo $this->reserve->last_query();

        $array = array();

       
            foreach ($result->result() as $row) {

			$reservation=self::getReservationType($row->player,$row->typ_rezerwacji,$row->isNew,$row->latest,$row->notatka,$row->confirmed);

			$array[$row->godzina]['kort '.$row->nr_kortu]['text']=$reservation;
			$array[$row->godzina]['kort '.$row->nr_kortu]['lvl']=$row->typ_rezerwacji;
		
			$array[$row->godzina]['kort '.$row->nr_kortu]['id']=$row->id;
			
		
		

			}
	

	
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













public function getPlayers(){
	
	
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


public function insert_reservation($insert,$where,$whereHalf,$reservationLength)
{
	
		$isFree=self::checkForReservation($where);
		
		$isHalf=self::checkForHalfs($whereHalf);
	
	
	
	
		if($isFree>0){
			
		$array['message']='<strong>Kort zajęty!</strong> Kort zarezerwowany przez innego użytkownika';
		$array['status']='danger';


		return $array;
		}
	
		$hour=new DateTime(date('Y-m-d').' '.$insert['godzina']);
		$hour->modify('+30 minutes');
		$where['godzina']=$hour->format('H:i:s');
		
		$isFreeHalf=self::checkForReservation($where);
		
		
		if($isFreeHalf>0 && $reservationLength=='60'){
			
		$array['message']='<strong>Kort zajęty!</strong> Kort dostępny tylko pierwsze 30min';
		$array['status']='danger';

		
		return $array;
		}
		
	

		$this->reserve->insert('a_korty', $insert);
		
		if($isHalf>0 && $reservationLength=='60'){	
		
		$insert['id_parent']=$this->reserve->insert_id();
				
		$insert['godzina']=$hour->format('H:i:s');
		$insert['notatka']='<i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>';
		
		
		$this->reserve->insert('a_korty', $insert);

		}
		
		//echo $this->reserve->affected_rows();
		// echo $this->reserve->last_query();

		
	 if($this->reserve->affected_rows()== 1){
		 
		 $array['message']='<strong>Powodzenie!</strong> Kort zarezerwowany pomyślnie.';
		 $array['status']='success';

	 } else{
		 
		 $array['message']='<strong>Błąd!</strong> Coś poszło nie tak, prosze odświeżyc strone i spróbować ponownie';
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



public function getReservationDetails($where){
	


	
	
		$this->reserve->select("k.nr_kortu,k.data,k.godzina,k.notatka,k.telefon,k.confirmed,ifnull(p.value,'30')value");
		
        $this->reserve->from("a_korty k");
		
        $this->reserve->join("a_config_price p","TIME_FORMAT(k.godzina,'%H:%i')=p.hour and date_format(k.data,'%w')=p.day-1","left");
				
		$this->reserve->where($where);
	
		$result = $this->reserve->get();
		
		
		$array=array();
		
		
		foreach($result->result() as $row)
		{
		$array['court']=$row->nr_kortu;	
		$array['date']=$row->data;	
		$array['hour']=$row->godzina;	
		$array['note']=$row->notatka;	
		$array['player']=$row->telefon;	
		$array['confirmed']=$row->confirmed;	
		$array['price']='Cena: '.$row->value.' zł';
			
		;	
			
			
		}
	return $array;

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


private function getHalfs($idParent){
	
	$halfId=false;
	
	$this->reserve->select('id');
	
	$this->reserve->from('a_korty k');
	
	$this->reserve->where("id_parent=$idParent");
	
	$result=$this->reserve->get();
	
	//echo $this->reserve->last_query();
	
	foreach($result->result() as $row)
	{
	
	$halfId=$row->id;
		
	}
	
	return $halfId;
	
	
}


public function deleteReservation($insert){
	

	
	
	
	$this->reserve->insert('a_reserv_history', $insert);

	 if($this->reserve->affected_rows() == 1){
		 
		 $array['message']='<strong>Powodzenie!</strong> Rezerwacja usunięta';
		 $array['status']='success';

	 } else{
		 
		 $array['message']='<strong>Błąd!</strong>Coś poszło nie tak, prosze odświeżyc strone i spróbować ponownie';
		 $array['status']='danger';
		 
		 
	 }
	
	
	$halfId['id_reserv']=self::getHalfs($insert['id_reserv']);
	$halfId['delete_date']=$insert['delete_date'];
	
	

	if($halfId['id_reserv'])
	$this->reserve->insert('a_reserv_history', $halfId);	

	
	
		return $array;
			
	
}


public function getPrice($where){
	
	
	
		$this->reserve->select("value");
		
        $this->reserve->from("a_config_price");

		$this->reserve->where($where);

		
  
        $result = $this->reserve->get();
	

 	$array['price']='Cena: 30 zł';
	
	
	foreach($result->result() as $row)
	{
		
		$array['price']='Cena: '.$row->value.' zł';
		
	}
	
	return $array;
}



public function confirmRealisation($where){
	

	$data=array('confirmed'=>1);
	
		$this->reserve->set($data);
		$this->reserve->where($where);
		$this->reserve->update('a_korty');

 	
		
	//echo $this->reserve->last_query();
	
		$isHalf=self::getHalfs($where['id']);
	
	
	
	
	if($isHalf){

		$where['id']=$isHalf;
		
		$this->reserve->set($data);
		$this->reserve->where($where);
		$this->reserve->update('a_korty');

	
	}
	
		
		return 1;

	
	
	
	
	
}


















}