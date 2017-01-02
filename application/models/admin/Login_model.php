<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_model extends CI_Model {

    public function __construct() {
        
	$this->reserve = $this->load->database('default', TRUE); 
 
     
    }




 function login($username, $password)
 {
   $this -> reserve -> select('user, password');
   $this -> reserve -> from('a_admin');
   $this -> reserve -> where('user', $username);
   $this -> reserve -> where('password', MD5($password));
   $this -> reserve -> limit(1);
 
   $query = $this -> reserve -> get();
   
  //echo $this->reserve->last_query(); 
  
   if($query -> num_rows() == 1)
   {
		$dane=array(
		'id'=>0,
		'login'=>$username,
		'data'=>date('Y-m-d H:i:s')
	);
	

     return $query->result();
   }
   else
   {
     return false;
   }
 }


	
	public function change_password($password_old ,$password_new){
		
		
	    $dane =array();	
		
		$this->lokal->select("*");
        $this->lokal->from("app.users");
		$this->lokal->where($password_old);

		$result = $this->lokal->get();
		
	
	//echo $this->lokal->last_query(); 
	
	
	
		if($result->num_rows()>0)
		{

		$this->lokal->where($password_old);
		$this->lokal->update('app.users',$password_new); 


		$dane['message']='<div class="row">
			  <div class="col s12 m5">
				<div class="card-panel green">
				  <span class="white-text"><strong>Success!</strong> Hasło zmienione.
				  </span>
				</div>
			  </div>
			</div>';

		}
		else{

	
	$dane['message']='<div class="row">
      <div class="col s12 m5">
        <div class="card-panel red darken-2">
          <span class="white-text">  <strong>Uwaga!</strong> Aktualne hasło jest niepoprawne.
          </span>
        </div>
      </div>
    </div>';
	
	
		}






  return ($dane);


		
		
		
	}






}