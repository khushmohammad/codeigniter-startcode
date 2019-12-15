<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
            parent::__construct();                  
            $this->load->model('LoginModel'); 
            $this->load->model('DashbaordModal');
            $this->logged_in();            
            $this->userId = $this->session->userdata('U_USERNAME');
			$userId = $this->session->userdata('U_USERNAME'); 
            //$this->Menu['menudata'] = $this->LoginModel->MenuData();         
          }
        // check log in  function  
        private function logged_in()
        {
            if( ! $this->session->userdata('U_USERNAME')){
                redirect('Welcome');			
            }
        }
        //comman function
        function Get_StateList_Ajax(){
        	$Country_Id = $this->input->post('id',TRUE);
			$data = $this->LoginModel->Get_StateList($Country_Id)->result();
			echo json_encode($data);
        }
        function Get_CityList_Ajax(){
        	$State_Id = $this->input->post('id',TRUE);
			$data = $this->LoginModel->Get_CityList($State_Id)->result();
			echo json_encode($data);
        }

        function getSelectedState($selectedCountryCode){
	    $sql="SELECT * FROM states WHERE COUNTRY_ID='".$selectedCountryCode."' ORDER BY ST_NAME ASC";
	    $stateArray = $this->db->query($sql)->result_array();
	    $optionHtml = '';
	    $optionHtml .= '<option value="">Select State</option>';
	    if(!empty($stateArray)){
			foreach($stateArray as $row) {
				$optionHtml .= '<option value="'.$row['ST_ID'].'">'.$row['ST_NAME'].'</option>';
			}
        }
		return $optionHtml;
		}
		function getSelectedCity($selectedStateCode){
		    $sql="SELECT * FROM cities WHERE STATE_ID='".$selectedStateCode."' ORDER BY CT_NAME ASC";
		    $cityArray = $this->db->query($sql)->result_array();
		    $optionHtml = '';
		    $optionHtml .= '<option value="">Select city</option>';
		    if(!empty($cityArray)){
				foreach($cityArray as $row) {
					$optionHtml .= '<option value="'.$row['CT_ID'].'">'.$row['CT_NAME'].'</option>';
				}
	        }
			return $optionHtml;
		}
		function U_USERNAME_EXISTS(){
		       $count= $this->LoginModel->isU_USERNAME_EXISTS($this->input->post('U_USERNAME'));
		           if ( $count == TRUE ) {
		               echo json_encode(FALSE);
		           } else {
		               echo json_encode(TRUE);
		           }
		   }
			
        //common function
   
	public function index()
	{
		$this->load->view('header'); 
		$data['totalPet'] = $this->DashbaordModal->totalPet();		       
		$data['totalMale'] = $this->DashbaordModal->totalMale();		       
		$data['totalFemale'] = $this->DashbaordModal->totalFemale();		       
		$data['totalSold'] = $this->DashbaordModal->totalSold();		       
        $this->load->view('pages/Dashboard_View',$data);        
		$this->load->view('footer');
	}

	//User Details
	public function AdminUser()
	{
		$this->load->view('header');	
		$data['countries']	= $this->LoginModel->country_list();		
        $this->load->view('pages/DashUser_View',$data);                
		$this->load->view('footer');
	}
	
	 	
	function DashUserView_Ajax()	
	{		
		header('Content-Type: application/json');
		$this->datatables->select('U_ID,U_NAME,U_USERNAME,U_GENDER,U_USER_TYPE,U_EMAIL,U_CONTACT,U_ADDRESS,U_PINCODE,U_ACTIVE,U_ACCESS_UPDATE, U_ACCESS_INSERT ,U_ACCESS_DELETE,ST_NAME,CN_NAME,CT_NAME');
		$this->datatables->from('dashuser_view');		
		echo $this->datatables->generate();	   
	}

	function DashUser_SaveAjax(){
		header('Content-Type: application/json');
		$this->LoginModel->DashUser_SaveAjax($this->userId);
	}
	function DashUserDelete_Ajax(){
	$sysId =	$this->input->post('sysId');	
	$delete = $this->db->delete('dash_users',"U_ID = '".$sysId."'");
	 if($delete){
	 	echo json_encode('delete seccessfully');
	 }
	}

	function GetDashUserData_Ajax(){
		$sysId = 	$this->input->post('sysId');		
		$result['data'] = $this->LoginModel->GetDashUserData($sysId);
		$result['stateOption'] = $this->getSelectedState($result['data'][0]['U_COUNTRY']);
		$result['cityOption'] = $this->getSelectedCity($result['data'][0]['U_STATE']);
		echo json_encode($result);
	}
	
	function DashUser_UpdateAjax(){
		header('Content-Type: application/json');
		$this->LoginModel->DashUser_UpdateAjax($this->userId);
	}
	//user Details end

	//ProductDetails
	public function PetDetails()
		{
			$this->load->view('header');			
	        $this->load->view('pages/PetDetails_AddEdit');                
			$this->load->view('footer');
		}

	function PetDetailsView_Ajax()	
	{		
		header('Content-Type: application/json');
		$this->datatables->select('P_ID,P_NAME,P_CODE_ID,P_GENDER,P_DOB,P_SECTION_AREA,P_STATUS,P_IMAGE,P_CONDITION_TYPE,P_WEIGHT,P_ACTIVE');
		$this->datatables->from('v_pets');		
		echo $this->datatables->generate();	   
	}	

	function PetDetailsSave_Ajax(){
		header('Content-Type: application/json');
		$this->LoginModel->PetDetailsSave_Ajax($this->userId);
	}
	function PetDetailsDelete_Ajax(){
	$sysId =	$this->input->post('sysId');	
	$img =	$this->input->post('img');	
	$delete = $this->db->delete('v_pets',"P_ID = '".$sysId."'");		
	  if(!empty($img)){		
		$path = './upload/PetImage/'.$img;
		unlink($path);
		}
	 if($delete){

	 	echo json_encode('delete seccessfully');
	 }
	}

	function GetPetDetailsEditData_Ajax(){
		$sysId = 	$this->input->post('sysId');		
		$result['data'] = $this->LoginModel->GetPetDetailsEditData($sysId);		
		echo json_encode($result);
	}
	function PetDetailsUpdate_Ajax(){
		header('Content-Type: application/json');
		$this->LoginModel->PetDetailsUpdate_Ajax($this->userId);
	}
	//ProductDetails end
	//StockDetails
	public function StockDetails()
		{
			$this->load->view('header');				
	        $this->load->view('pages/StockDetail_AddEdit');                
			$this->load->view('footer');
		}

	function StockDetailsView_Ajax()	
	{		
		header('Content-Type: application/json');
		$this->datatables->select('I_ID ,I_NAME,I_PURCHASEDATE ,I_PURCHASEBY ,	I_AMOUNT,I_BILL,	I_EXPIRYDATE ,V_LANG_CODE ,V_USER_ID ,V_UP_TIME,	V_CR_TIME,I_ACTIVE');
		$this->datatables->from('allitem');		
		echo $this->datatables->generate();	   
	}	

	function StockItemSave_Ajax(){
		header('Content-Type: application/json');
		$this->LoginModel->StockItemSave($this->userId);
	}
	function StockDetailsDelete_Ajax(){
	$sysId =	$this->input->post('sysId');	
	$img =	$this->input->post('img');	
	$delete = $this->db->delete('allitem',"I_ID = '".$sysId."'");		
	  if(!empty($img)){		
		$path = './upload/BillImage/'.$img;
		unlink($path);
		}
	 if($delete){
	 	echo json_encode('delete seccessfully');
	 }
	}

	function GetStockDetailsEditData_Ajax(){
		$sysId = 	$this->input->post('sysId');		
		$result['data'] = $this->LoginModel->GetStockDetailsEditData($sysId);		
		echo json_encode($result);
	}
	function StockItemUpdate_Ajax(){
		header('Content-Type: application/json');
		$this->LoginModel->StockItemUpdate($this->userId);
	}
	//StockDetails end
	
	//MenuDetails
	public function MenuDetails()
		{
			$this->load->view('header');					
	        $this->load->view('pages/MenuDetails_AddEdit');                
			$this->load->view('footer');
		}
	function menuDetailsView_Ajax()	
	{		
		header('Content-Type: application/json');
		$this->datatables->select('M_ID ,M_SNO ,M_NAME ,M_LINK ,M_ICON ,M_LOCATION ,M_ACTIVE ,	V_LANG_CODE ,V_USER_ID ,V_CR_TIME ,V_UP_TIME');
		$this->datatables->from('menudetail');		
		echo $this->datatables->generate();	   
	}	

	function menuDetailsSave_Ajax(){
		header('Content-Type: application/json');
		$this->LoginModel->menuDetailsSave($this->userId);
	}
	function MenuDetailsDelete_Ajax(){
	$sysId =	$this->input->post('sysId');	
	$delete = $this->db->delete('menudetail',"M_ID = '".$sysId."'");		  
	 if($delete){
	 	echo json_encode('delete seccessfully');
	 }
	}

	function GetmenuDetailEditData_Ajax(){
		$sysId = 	$this->input->post('sysId');		
		$result['data'] = $this->LoginModel->GetmenuDetailsEditData($sysId);		
		echo json_encode($result);
	}
	function menuDetailsUpdate_Ajax(){
		header('Content-Type: application/json');
		$this->LoginModel->menuDetailsUpdate($this->userId);
	}
		
	//MenuDetails end
	
}
