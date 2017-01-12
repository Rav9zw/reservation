<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usersadministration_model extends CI_Model {

    public function __construct() {
    
$this->reserve = $this->load->database('default', TRUE); 
	    
	
    
    }

	


	public function loadUsers(){
		
				
	$this->reserve->select("id,concat(surname,' ',name)user,phone,email,registered");
		
    $this->reserve->from("a_players p");
	
    $result=$this->reserve->get();
	
	$users=array();
	$i=0;
	
	foreach($result->result() as $row){
		
	$users[$i]['id']=$row->id;	
	$users[$i]['user']=$row->user;	
	$users[$i]['phone']=$row->phone;	
	$users[$i]['email']=$row->email;	
	$users[$i]['registered']=$row->registered;	
		
	$i++;
		
	}
	
	
	return $users;
		
		
		
		
	}





}