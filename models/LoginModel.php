<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {
	public function Login($data){  
		$query=$this->db->get_where('dash_users',array('U_USERNAME'=>$data['U_USERNAME'],'U_PASSWORD'=>$data['U_PASSWORD'],'U_ACTIVE' => 'Y'));
//        if($query->num_rows() > 0)  
//           {  
//                return true;  
//           }  
//           else  
//           {  
//                return false;       
//           }  
		 if($query->num_rows() == 1) {
            return $query->row();
			} 			 
	}    
	
	 //common function
   function SettingMenu(){
        $sqlQry = "SELECT *	FROM menudetail	WHERE M_LOCATION = 'Setting' AND M_ACTIVE = 'Y' ORDER BY M_SNO ASC";
		return $this->db->query($sqlQry)->result_array();
   }
    function DashboardMenu(){                    
        $sqlQry = "SELECT *	FROM menudetail WHERE M_LOCATION != 'Setting' AND M_ACTIVE = 'Y' ORDER BY M_SNO ASC" ;
		return $this->db->query($sqlQry)->result_array();
   }
        
	function date(){
		date_default_timezone_set('Asia/Dubai');
		return  date('Y/m/d H:i:s');
	}

     function country_list(){

     	$query =  $this->db->get('countries')->result_array();
     	return $query;
     }   

     function Get_StateList($country_id){
     	$query = $this->db->get_where('states', array('COUNTRY_ID' => $country_id));
		return $query;

     }
     function Get_CityList($State_Id){
     	$query = $this->db->get_where('cities', array('STATE_ID' => $State_Id));
		return $query;

     }
      public function isU_USERNAME_EXISTS($USERNAME) {
      	$sysId = $this->input->post('sysId');
      	$sqlQry = "SELECT *	FROM dash_users WHERE U_USERNAME = '".$USERNAME."' AND NOT U_ID  = '".$sysId."'" ;
		$query = $this->db->query($sqlQry)->num_rows();		                  
           if( $query > 0 ){
               return TRUE;                 
           } else { 
               return FALSE;                
           }

		   }	
    //common function end

     public function GetDashUserData($sysId){

     	$sql = 'SELECT * FROM dash_users WHERE U_ID = "'.$sysId.'"';
		return  $this->db->query($sql)->result_array();
     }

	public function DashUser_SaveAjax($userId){
		$U_NAME = $this->input->post('U_NAME'); 
		$U_USERNAME = $this->input->post('U_USERNAME'); 
		$U_USER_TYPE = $this->input->post('U_USER_TYPE'); 
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
			'U_NAME' => $U_NAME, 
			'U_USERNAME' => $U_USERNAME, 
			'U_USER_TYPE' => $U_USER_TYPE, 
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
			'V_USER_ID' => $userId
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
		function DashUser_UpdateAjax($userId){
		$id = $this->input->post('U_ID');	
		$U_NAME = $this->input->post('U_NAME'); 
		$U_USERNAME = $this->input->post('U_USERNAME');
		$U_USER_TYPE = $this->input->post('U_USER_TYPE');
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
		$V_UP_TIME = $this->date();
		$data = array(
			'U_NAME' => $U_NAME, 
			'U_USERNAME' => $U_USERNAME,
			'U_USER_TYPE' => $U_USER_TYPE,
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
			'V_USER_ID' => $userId,
			'V_UP_TIME' => $V_UP_TIME,
		);
		$update = $this->db->update('dash_users', $data, array('U_ID' => $id));		
			if($update){
				echo json_encode($id);
			} 
			else{
				echo json_encode('error');
			}
		}
	//PetDetails  

	public function PetDetailsSave_Ajax($userId){
		$P_IMAGE = '';
  		$config['upload_path']          = './upload/PetImage';
        $config['allowed_types']        = 'gif|jpg|png';
        $this->load->library('upload', $config);
        if($this->input->post('P_IMAGE')!==''){
         $this->upload->do_upload('P_IMAGE');
        }    
       if ($this->upload->data('file_name')!=='') {
         	$P_IMAGE = $this->upload->data('file_name');
         } 
		$P_NAME = $this->input->post('P_NAME'); 
		$P_CODE_ID = $this->input->post('P_CODE_ID'); 
		$P_GENDER = $this->input->post('P_GENDER'); 
		$P_DOB = $this->input->post('P_DOB'); 
		$P_SECTION_AREA  = $this->input->post('P_SECTION_AREA'); 
		$P_STATUS = $this->input->post('P_STATUS'); 		 
		$P_CONDITION_TYPE = $this->input->post('P_CONDITION_TYPE'); 
		$P_WEIGHT = $this->input->post('P_WEIGHT');
		$P_ACTIVE = $this->input->post('P_ACTIVE');
		$data = array(
			'P_NAME' => $P_NAME, 
			'P_CODE_ID' => $P_CODE_ID, 
			'P_GENDER' => $P_GENDER, 
			'P_DOB' => $P_DOB, 
			'P_SECTION_AREA' => $P_SECTION_AREA, 
			'P_STATUS' => $P_STATUS, 
			'P_IMAGE' => $P_IMAGE, 
			'P_CONDITION_TYPE' => $P_CONDITION_TYPE, 
			'P_WEIGHT' => $P_WEIGHT, 
			'P_ACTIVE' => $P_ACTIVE,
			'V_USER_ID' => $userId
		);
		$insert =  $this->db->insert('v_pets',$data); 
		$insertId = $this->db->insert_id();
			if($insert){
				echo json_encode($insertId);
			} 
			else{
				echo json_encode('error');
			}
		}

		function PetDetailsUpdate_Ajax($userId){
		$id = $this->input->post('P_ID');	
		$config['upload_path']          = './upload/PetImage';
        $config['allowed_types']        = 'gif|jpg|png';
        $this->load->library('upload', $config);		

        if($this->input->post('P_IMAGE')!==''){
         $this->upload->do_upload('P_IMAGE');
        }        
       if ($this->upload->data('file_name')!=='') {
         	$P_IMAGE = $this->upload->data('file_name');
         	$P_IMAGE_OLD =  $this->input->post('P_IMAGE_OLD');
         	if(!empty($P_IMAGE_OLD)){
         		$path = './upload/PetImage/'.$P_IMAGE_OLD;
				unlink($path);	
         	}
         	
         } 
         else{
         	$P_IMAGE =  $this->input->post('P_IMAGE_OLD');

         }
		$P_NAME = $this->input->post('P_NAME'); 
		$P_CODE_ID = $this->input->post('P_CODE_ID'); 
		$P_GENDER = $this->input->post('P_GENDER');		
		$P_DOB = $this->input->post('P_DOB'); 
		$P_SECTION_AREA  = $this->input->post('P_SECTION_AREA'); 
		$P_STATUS = $this->input->post('P_STATUS'); 		 
		$P_CONDITION_TYPE = $this->input->post('P_CONDITION_TYPE'); 
		$P_WEIGHT = $this->input->post('P_WEIGHT');
		$P_ACTIVE = $this->input->post('P_ACTIVE');	 
		$V_UP_TIME = $this->date();
		$data = array(
			'P_NAME' => $P_NAME, 
			'P_CODE_ID' => $P_CODE_ID, 
			'P_GENDER' => $P_GENDER, 
			'P_DOB' => $P_DOB, 
			'P_SECTION_AREA' => $P_SECTION_AREA, 
			'P_STATUS' => $P_STATUS, 
			'P_IMAGE' => $P_IMAGE, 
			'P_CONDITION_TYPE' => $P_CONDITION_TYPE, 
			'P_WEIGHT' => $P_WEIGHT, 
			'P_ACTIVE' => $P_ACTIVE,
			'V_USER_ID' => $userId ,			
			'V_UP_TIME' => $V_UP_TIME,
		);
		$update = $this->db->update('v_pets', $data, array('P_ID' => $id));		
			if($update){
				echo json_encode($id);
			} 
			else{
				echo json_encode('error');
			}
		}
	public function GetPetDetailsEditData($sysId){

     	$sql = 'SELECT * FROM v_pets WHERE P_ID = "'.$sysId.'"';
		return  $this->db->query($sql)->result_array();
     }
	//PetDetails end	
    //menu Details
    public function menuDetailsSave($userId){       
		$M_SNO = $this->input->post('M_SNO'); 
		$M_NAME = $this->input->post('M_NAME'); 
		$M_LINK = $this->input->post('M_LINK'); 
		$M_ICON = $this->input->post('M_ICON'); 
		$M_LOCATION  = $this->input->post('M_LOCATION'); 
		$M_ACTIVE = $this->input->post('M_ACTIVE'); 
		$data = array(
			'M_SNO' => $M_SNO, 
			'M_NAME' => $M_NAME, 
			'M_LINK' => $M_LINK, 
			'M_ICON' => $M_ICON,			
            'M_LOCATION' => $M_LOCATION,
			'M_ACTIVE' => $M_ACTIVE,
			'V_USER_ID' => $userId
		);
		$insert =  $this->db->insert('menudetail',$data); 
		$insertId = $this->db->insert_id();
			if($insert){
				echo json_encode($insertId);
			} 
			else{
				echo json_encode('error');
			}
		}

		function menuDetailsUpdate($userId){
		$id = $this->input->post('M_ID');	
		$M_SNO = $this->input->post('M_SNO'); 
		$M_NAME = $this->input->post('M_NAME'); 
		$M_LINK = $this->input->post('M_LINK'); 
		$M_ICON = $this->input->post('M_ICON'); 
		$M_LOCATION  = $this->input->post('M_LOCATION'); 
		$M_ACTIVE = $this->input->post('M_ACTIVE'); 
		$data = array(
			'M_SNO' => $M_SNO, 
			'M_NAME' => $M_NAME, 
			'M_LINK' => $M_LINK, 
			'M_ICON' => $M_ICON,			
            'M_LOCATION' => $M_LOCATION,
			'M_ACTIVE' => $M_ACTIVE,
			'V_USER_ID' => $userId
		);
		$update = $this->db->update('menudetail', $data, array('M_ID' => $id));		
			if($update){
				echo json_encode($id);
			} 
			else{
				echo json_encode('error');
			}
		}
	public function GetmenuDetailsEditData($sysId){

     	$sql = 'SELECT * FROM menudetail WHERE M_ID = "'.$sysId.'"';
		return  $this->db->query($sql)->result_array();
     }
    //menu Details
     //stock
     //PetDetails 

	public function StockItemSave($userId){
		$I_BILL = '';
  		$config['upload_path']          = './upload/BillImage';
        $config['allowed_types']        = 'gif|jpg|png';
        $this->load->library('upload', $config);
        if($this->input->post('I_BILL')!==''){
         $this->upload->do_upload('I_BILL');
        }

       if ($this->upload->data('file_name')!=='') {
         	$I_BILL = $this->upload->data('file_name');
         } 
		$I_NAME = $this->input->post('I_NAME'); 
		$I_PURCHASEDATE = $this->input->post('I_PURCHASEDATE'); 
		$I_PURCHASEBY = $this->input->post('I_PURCHASEBY'); 
		$I_AMOUNT = $this->input->post('I_AMOUNT'); 		
		$I_EXPIRYDATE = $this->input->post('I_EXPIRYDATE');
		$I_ACTIVE = $this->input->post('I_ACTIVE');
		$data = array(
			'I_NAME' => $I_NAME, 
			'I_PURCHASEDATE' => $I_PURCHASEDATE, 
			'I_PURCHASEBY' => $I_PURCHASEBY, 
			'I_AMOUNT' => $I_AMOUNT, 		
			'I_EXPIRYDATE' => $I_EXPIRYDATE, 
			'I_BILL' => $I_BILL,			
			'I_ACTIVE' => $I_ACTIVE,
			'V_USER_ID' => $userId
		);
		$insert =  $this->db->insert('allitem',$data); 
		$insertId = $this->db->insert_id();
			if($insert){
				echo json_encode($insertId);
			} 
			else{
				echo json_encode('error');
			}
		}

		function StockItemUpdate($userId){
		$id = $this->input->post('I_ID');	
		$config['upload_path']          = './upload/BillImage';
        $config['allowed_types']        = 'gif|jpg|png';
        $this->load->library('upload', $config);		

        if($this->input->post('I_BILL')!==''){
         $this->upload->do_upload('I_BILL');
        }        
       if ($this->upload->data('file_name')!=='') {
         	$I_BILL = $this->upload->data('file_name');
         	$I_BILL_OLD =  $this->input->post('I_BILL_OLD');
         	if(!empty($I_BILL_OLD)){
         		$path = './upload/BillImage/'.$I_BILL_OLD;
				unlink($path);	
         	}
         	
         } 
         else{
         	$I_BILL =  $this->input->post('I_BILL_OLD');

         }
        $I_NAME = $this->input->post('I_NAME'); 
		$I_PURCHASEDATE = $this->input->post('I_PURCHASEDATE'); 
		$I_PURCHASEBY = $this->input->post('I_PURCHASEBY'); 
		$I_AMOUNT = $this->input->post('I_AMOUNT'); 		
		$I_EXPIRYDATE = $this->input->post('I_EXPIRYDATE');
		$I_ACTIVE = $this->input->post('I_ACTIVE');
		$V_UP_TIME = $this->date();
		$data = array(
			'I_NAME' => $I_NAME, 
			'I_PURCHASEDATE' => $I_PURCHASEDATE, 
			'I_PURCHASEBY' => $I_PURCHASEBY, 
			'I_AMOUNT' => $I_AMOUNT, 		
			'I_EXPIRYDATE' => $I_EXPIRYDATE, 
			'I_BILL' => $I_BILL,			
			'I_ACTIVE' => $I_ACTIVE,
			'V_USER_ID' => $userId,
			'V_UP_TIME' => $V_UP_TIME,
		);		
		$update = $this->db->update('allitem', $data, array('I_ID' => $id));		
			if($update){
				echo json_encode($id);
			} 
			else{
				echo json_encode('error');
			}
		}
	public function GetStockDetailsEditData($sysId){

     	$sql = 'SELECT * FROM allitem WHERE I_ID = "'.$sysId.'"';
		return  $this->db->query($sql)->result_array();
     }


     //stock

     //crud start
     public function GetCrudDetailsEditData($sysId){
     	$sql = 'SELECT * FROM crud WHERE ID = "'.$sysId.'"';
		return  $this->db->query($sql)->result_array();
     }

	 public function CrudItemSave($userId){		
		//$ID = $this->input->post('ID');
        $NAME = $this->input->post('NAME'); 
		$EMAIL = $this->input->post('EMAIL'); 
		$CONTACT = $this->input->post('CONTACT');
		$data = array(
			'NAME' => $NAME, 
			'EMAIL' => $EMAIL, 
			'CONTACT' => $CONTACT
		);
		$insert =  $this->db->insert('crud',$data); 
		$insertId = $this->db->insert_id();
			if($insert){
				echo json_encode($insertId);
			} 
			else{
				echo json_encode('error');
			}
		}
     function CrudItemUpdate($userId){
		$ID = $this->input->post('ID');
        $NAME = $this->input->post('NAME'); 
		$EMAIL = $this->input->post('EMAIL'); 
		$CONTACT = $this->input->post('CONTACT'); 		
		$data = array(
			'NAME' => $NAME, 
			'EMAIL' => $EMAIL, 
			'CONTACT' => $CONTACT
		);		
		$update = $this->db->update('crud', $data, array('ID' => $ID));		
			if($update){
				echo json_encode($ID);
			} 
			else{
				echo json_encode('error');
			}
		}

		
	
}

