<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {
	public function login($data){  
		$query=$this->db->get_where('dash_users',array('U_USERNAME'=>$data['U_USERNAME'],'U_PASSWORD'=>$data['U_PASSWORD'],'U_ACTIVE' => 'Y'));
		 if($query->num_rows() == 1) {
            return $query->row();
			}  
	}

	public function DashUser_SaveAjax(){ 

		$U_USERNAME = $this->input->post('U_USERNAME'); 
		$U_PASSWORD = $this->input->post('U_PASSWORD'); 
		$U_GENDER  = $this->input->post('U_GENDER'); 
		$U_EMAIL = $this->input->post('U_EMAIL'); 
		$U_CONTACT = $this->input->post('U_CONTACT'); 
		$U_ADDRESS = $this->input->post('U_ADDRESS'); 
		$U_COUNTRY = $this->input->post('U_COUNTRY'); 
		$U_STATE = $this->input->post('U_STATE'); 
		$U_CITY = $this->input->post('U_CITY'); 
		$U_PINCODE = $this->input->post('U_PINCODE'); 
		$U_ACTIVE = $this->input->post('U_ACTIVE'); 
		$U_ACCESS_UPDATE = $this->input->post('U_ACCESS_UPDATE'); 
		$U_ACCESS_INSERT = $this->input->post('U_ACCESS_INSERT'); 
		$U_ACCESS_DELETE = $this->input->post('U_ACCESS_DELETE'); 
		 
		
		$data = array(
			'U_USERNAME' => $U_USERNAME, 
			'U_PASSWORD' => $U_PASSWORD, 
			'U_GENDER' => $U_GENDER, 
			'U_EMAIL' => $U_EMAIL, 
			'U_CONTACT' => $U_CONTACT, 
			'U_ADDRESS' => $U_ADDRESS, 
			'U_COUNTRY' => $U_COUNTRY, 
			'U_STATE' => $U_STATE, 
			'U_CITY' => $U_CITY, 
			'U_PINCODE' => $U_PINCODE, 
			'U_ACTIVE' => $U_ACTIVE, 
			'U_ACCESS_UPDATE' => $U_ACCESS_UPDATE, 
			'U_ACCESS_INSERT' => $U_ACCESS_INSERT, 
			'U_ACCESS_DELETE' => $U_ACCESS_DELETE, 

		);

		$insert =  $this->db->insert('dash_users',$data); 
		$insertId = $this->db->insert_id();
		if($insert){
			echo json_encode($insertId);
		} 
		else{
			echo json_encode('seccess');

		 
		}
		}
		function DashUser_UpdateAjax(){
		$id = $this->input->post('U_ID');	
		$U_USERNAME = $this->input->post('U_USERNAME'); 
		$U_PASSWORD = $this->input->post('U_PASSWORD'); 
		$U_GENDER  = $this->input->post('U_GENDER'); 
		$U_EMAIL = $this->input->post('U_EMAIL'); 
		$U_CONTACT = $this->input->post('U_CONTACT'); 
		$U_ADDRESS = $this->input->post('U_ADDRESS'); 
		$U_COUNTRY = $this->input->post('U_COUNTRY'); 
		$U_STATE = $this->input->post('U_STATE'); 
		$U_CITY = $this->input->post('U_CITY'); 
		$U_PINCODE = $this->input->post('U_PINCODE'); 
		$U_ACTIVE = $this->input->post('U_ACTIVE'); 
		$U_ACCESS_UPDATE = $this->input->post('U_ACCESS_UPDATE'); 
		$U_ACCESS_INSERT = $this->input->post('U_ACCESS_INSERT'); 
		$U_ACCESS_DELETE = $this->input->post('U_ACCESS_DELETE'); 	 
		
		$data = array(
			'U_USERNAME' => $U_USERNAME, 
			'U_PASSWORD' => $U_PASSWORD, 
			'U_GENDER' => $U_GENDER, 
			'U_EMAIL' => $U_EMAIL, 
			'U_CONTACT' => $U_CONTACT, 
			'U_ADDRESS' => $U_ADDRESS, 
			'U_COUNTRY' => $U_COUNTRY, 
			'U_STATE' => $U_STATE, 
			'U_CITY' => $U_CITY, 
			'U_PINCODE' => $U_PINCODE, 
			'U_ACTIVE' => $U_ACTIVE,
			'U_ACCESS_UPDATE' => $U_ACCESS_UPDATE, 
			'U_ACCESS_INSERT' => $U_ACCESS_INSERT, 
			'U_ACCESS_DELETE' => $U_ACCESS_DELETE, 

		);

		$update = $this->db->update('dash_users', $data, array('U_ID' => $id)); 
		
		if($update){
			echo json_encode($id);
		} 
		else{
			echo json_encode('error');
		}

		}
	
	
}

