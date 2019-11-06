<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$AccessDelete = $this->session->userdata('U_ACCESS_DELETE');
$AccessInsert = $this->session->userdata('U_ACCESS_INSERT');
$AccessUpdate = $this->session->userdata('U_ACCESS_UPDATE');
$userTypeSession = $this->session->userdata('U_USER_TYPE');
if($userTypeSession  !=="SUPERADMIN" AND $userTypeSession  !=="ADMIN" AND $userTypeSession  !=="EMPLOYEE"){    
           redirect('Dashboard');
         }   
?>  
<style type="text/css">
.iti__selected-flag{
  display: block ruby !important;
}
</style>
  <!-- Breadcrumbs-->       
    
        <div class="addButton" style="padding: 10px 0 10px 0;">
          <button <?php if($AccessInsert!=='Y'){echo 'disabled'; } ?> id="Add" type="button" class="btn back-color AddEditButton" data-toggle="modal" data-target="#DashUser_Modal" data-backdrop="static" data-keyboard="false" >
          Add
        </button>

        </div> 
        <div  class="AlertMessage">               
        </div>
        <!-- DataTables Example -->
        <div class="card mb-3">            
          <div class="card-header">
            <i class="fas fa-table"></i>
            Data Table Example</div>
          <div class="card-body">
            <div class="">
            <table class="nowrap table table-striped table-bordered  table-hover" id="datatables" width="100%">
              <thead class="thead-light">
                <tr>
                  <th data-class="expand">ID</th>
                  <th data-class="expand" >PET CODE</th>
                  <th data-class="expand" >IMAGE</th>
                  <th data-class="expand" >NAME</th>
                  <th data-class="expand" >GENDER</th>
                  <th data-class="expand" >DOB</th>                  
                  <th data-class="expand">LOCATION</th>
                  <th data-class="expand">STATUS</th>
                  <th data-class="expand">CONDITION</th>
                  <th data-class="expand">WEIGHT</th>                  
                  <th data-class="expand">ACTIVE</th>                                 
                  <th data-hide="phone,tablet">ACTION</th>
                </tr>
              </thead>
              <tbody>			
              </tbody>
            </table>             
            </div>
          </div>
         
        </div>
     
<script type="text/javascript">  
    
          //datatable view data
        $(document).ready(function() {
             //FOOTER FUNCTION
          //changeCountryFlag('contactInputMasking','RM_CONTACT_NUMBER_HIDDEN','RM_CONTACT_NUMBER');
      //    InputContact_flag('U_CONTACT');
        //  State_List('U_COUNTRY','U_STATE','U_CITY');
       //   City_List('U_STATE','U_CITY');
          //FOOTER FUNCTION
           //$.fn.dataTable.ext.errMode = 'throw';

          var DataTableObject=[
            { data: 'P_ID' ,className:"all text-center"},
            { data: 'P_CODE_ID' ,className:"all"},
            { data: 'P_IMAGE'}, 
            { data: 'P_NAME' ,className:"all"},
            { data: 'P_GENDER' ,className:"all"},
            { data: 'P_DOB' ,className:"all"},
            { data: 'P_SECTION_AREA'},
            { data: 'P_STATUS'},                   
            { data: 'P_CONDITION_TYPE'},            
            { data: 'P_WEIGHT'},
            { data: 'P_ACTIVE'},           
            { data: null, "orderable": false, 'searchable': false, className:"all text-center", 
              render: function( data, type, row) {
                sysid=data['P_ID'];
                img=data['P_IMAGE'];

                return   '<div class="dropdown" >'
                      +'	<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">'
                      +	'</button>'
                      +	'<div class="dropdown-menu">'
                      +	  '<button <?php if($AccessUpdate!=="Y"){echo "disabled"; } ?> id="Edit" class="dropdown-item AddEditButton" data-id="'+sysid+'" data-toggle="modal" data-target="#DashUser_Modal" href="#" data-backdrop="static" data-keyboard="false">Edit</button>'
                      +	  '<button <?php if($AccessDelete!=="Y"){echo "disabled"; } ?> class="dropdown-item" id="DashUser_Delete" data-id="'+sysid+'" data-img="'+img+'"  href="#">Delete</button>'								
                      +	'</div>'
                      +' </div>';          
              }
            }
            ];
          
          var table = $('#datatables').DataTable( {  
          "processing": true,
          "serverSide": true,
          'responsive': true,		
          'scrollX':true,
          'scrollY':'320px',
          'scrollCollapse': true,		
          'dataType': 'json',				
          columns: DataTableObject,		
              "ajax": {
                  "url": "<?= base_url(); ?>Dashboard/PetDetailsView_Ajax",
                  "type": "POST"
              },
            
          
          });
          linesSwitchery(); 
        //free Zone area
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        //free Zone area           
      });
      // functions
      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function(e) {
            $('#P_IMAGE_PREVIEW').attr('src', e.target.result);
          }
          
          reader.readAsDataURL(input.files[0]);
        }
      }
     function linesSwitchery() {
          $('.lcs_check').lc_switch('Y', 'N');
	    		$('.lcs_wrap').delegate('#P_ACTIVE_YN', 'lcs-on', function() {
	    		$('#P_ACTIVE').val('Y');
	    		});
					$('.lcs_wrap').delegate('#P_ACTIVE_YN', 'lcs-off', function() {
            $('#P_ACTIVE').val('N');						
					});
          } 

     
     function GetDashUserData_Ajax(){
         
        $('#SaveButton').text('Update');
         loader();
         var sysId = $('#P_ID').val();   
         $.ajax({
                   type: "POST",
                   url: "<?= site_url('Dashboard/GetPetDetailsEditData_Ajax'); ?>",
                   data: {sysId : sysId} ,
                   dataType:'json',
                   success: function(json)
                   {
                     var obj = json['data'][0];
                      $('#P_ID').val(obj.P_ID);
                      $('#P_NAME').val(obj.P_NAME);
                      $('#P_CODE_ID').val(obj.P_CODE_ID);
                      $('#P_IMAGE_OLD').val(obj.P_IMAGE);
                      if(obj.P_IMAGE ==''){
                        $('#P_IMAGE_PREVIEW').attr('src','<?php echo site_url('./assets/img/noimage.png');?>');
                      }else{
                        $('#P_IMAGE_PREVIEW').attr('src','<?php echo site_url('./upload/PetImage/');?>'+obj.P_IMAGE+'');
                      }
                      
                      $('#P_GENDER').val(obj.P_GENDER).trigger('change');
                      $('#P_DOB').val(obj.P_DOB);
                      $('#P_SECTION_AREA').val(obj.P_SECTION_AREA).trigger('change');
                      $('#P_STATUS').val(obj.P_STATUS).trigger('change');
                      $('#P_CONDITION_TYPE').val(obj.P_CONDITION_TYPE).trigger('change');
                      $('#P_WEIGHT').val(obj.P_WEIGHT);
                     
                      var $ActiveYn = obj.P_ACTIVE;
                      if($ActiveYn == 'Y'){
                        $('#P_ACTIVE_YN').lcs_on();
                      }else{
                        $('#P_ACTIVE_YN').lcs_off();
                      }
                     //$(".selectpicker").selectpicker('refresh');

                      $('#PetDetailsAddEdit_Form').valid(); 
                   },
                   error: function (jqXHR, exception) {
                    console.log(jqXHR);
                      // Your error handling logic here..
                    }
                 }); 
                   unloader();    

             }

      //functions
    //script 
    $(document).on('click' , '.AddEditButton' , function(e){ 
      e.preventDefault();
       var buttonid =  $(this).attr('id');
       if(buttonid == 'Add'){
        $('#P_ID').val('');
         $('#U_USERNAME').prop('readonly', false);
         $('#SaveButton').text('Save');
          var $ActiveYn = $('#P_ACTIVE_YN').val();
                      if($ActiveYn == 'Y'){
                        $('#P_ACTIVE_YN').lcs_on();
                      }else{
                        $('#P_ACTIVE_YN').lcs_off();
                      }
            $('#P_IMAGE_PREVIEW').attr('src','<?php echo site_url('./assets/img/noimage.png');?>');          
       }
       else{        
       var sysId =  $(this).attr('data-id');
        $('#P_ID').val(sysId);
         $('#U_USERNAME').rules('remove');
         $('#U_USERNAME').prop('readonly', true);
        GetDashUserData_Ajax();

       }
  });  
    $(document).on("click", "#DashUser_Delete", function(e) {
         var sysId = $(this).attr('data-id');
         var img = $(this).attr('data-img');
        bootbox.confirm("Are you sure you want to delete?", function(result) {
          if(result){ 
           loader();          
           $.ajax({
             type: "POST",
             url: "<?= site_url('Dashboard/PetDetailsDelete_Ajax'); ?>",
             data: {sysId : sysId ,img : img} ,// serializes the form's elements.
             success: function(data)
             {
                 //alert(data); // show response from the php script.
                  $('.AlertMessage').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong> This alert box could indicate a successful or positive action.</div>') ;
                 setTimeout(function(){ 
                  $('.AlertMessage').html('') ;
                 }, 2000);
                unloader();  
             },
             error: function (jqXHR, exception) {
              console.log(jqXHR);
                // Your error handling logic here..
              }  

           });
           $("#datatables").DataTable().draw();
           //$('#datatables').DataTable().ajax.reload();
            }
        }); 
    });

    //script       
  //validation
  $.validator.setDefaults( {

			submitHandler: function (form) {
       // debug: true       
       var sysId = $('#P_ID').val();
       var url = "<?php echo site_url('Dashboard/PetDetailsUpdate_Ajax') ?>";
       if(sysId == ''){
       var url = "<?php echo site_url('Dashboard/PetDetailsSave_Ajax') ?>";
       } 
       loader();
      
      $.ajax({
             type: "POST",
             url: url,
             data: new FormData($(form)[0]), 
             processData: false,
             contentType: false,// serializes the form's elements.
             success: function(data)
             {
                $('#P_ID').val(data)
                 //alert(data); // show response from the php script.
                  $('.AlertMessageModal').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong> This alert box could indicate a successful or positive action.</div>') ;
                 setTimeout(function(){ 
                  $('.AlertMessageModal').html('') ;
                 }, 2000);
            
                 GetDashUserData_Ajax(); 
                  unloader();                 
             }
            
           }); 
           $("#datatables").DataTable().draw();
           //$('#datatables').DataTable().ajax.reload();
			}     
		});     
		$(document).ready( function () {      
     
			$( "#PetDetailsAddEdit_Form" ).validate( {
        onkeyup: function(element) {
            $(element).valid();           
          }, 
        onfocusout: function (element) {
          $(element).valid();
        },  

				rules: {
          P_NAME: "required",
          P_CODE_ID: "required",
					P_GENDER: "required",
          P_DOB: "required",
          P_SECTION_AREA: "required",
          P_STATUS: "required",
          P_CONDITION_TYPE: "required",
          P_WEIGHT: "required",
				},
				messages: {
          P_NAME: "Enter name",
          P_CODE_ID: "Enter Unique code",
          P_GENDER: "Enter gender",
          P_DOB: "Enter Date of Birth",
          P_SECTION_AREA: "Select Locaion",
          P_STATUS: "Select status",
          P_CONDITION_TYPE: "Select condition",
          P_WEIGHT: "Enter wieght",
                				
				},
				   errorClass: 'is-invalid',
            validClass: 'is-valid',
            errorPlacement: function(error, element) {
                    var lastError = $(element).data('lastError'),
                        newError = $(error).text();
                        error.addClass("invalid-feedback");
                    $(element).data('lastError', newError);
                    if (newError !== '') {
                      $(element).tooltip({
                        placement: "bottom",
                        trigger: "manual"
                      }).attr('data-original-title', newError).tooltip('show');                     
                    }
                  },
                  success: function(label, element) {
                    $(element).tooltip('hide');
                  }
                });
                $("input").blur(function() {
                  if (!this.value.trim().length)
                    $(this).tooltip("hide");
               });
		});
  //validation

function PetDetailsModalForm_Reset(){

     $("#PetDetailsAddEdit_Form")[0].reset();
     $('#U_COUNTRY option:selected').removeAttr('selected');     
     $('#U_CITY,#U_STATE').html("<option value=''> Select </option>"); 
     $('#PetDetailsAddEdit_Form').valid(); 
     var validator = $( "#PetDetailsAddEdit_Form" ).validate();
     validator.resetForm();
     $("#PetDetailsAddEdit_Form").find('.is-valid').removeClass("is-valid"); 
    // $(".selectpicker").selectpicker('refresh');

}
// jQuery

</script>
<!-- modal for add and edit -->
<div class="modal" id="DashUser_Modal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
                <button type="button" onclick="PetDetailsModalForm_Reset();" class="close" data-dismiss="modal">&times;</button>
              </div>
             <div class="AlertMessageModal"></div> 
              <form mathod="POST" id="PetDetailsAddEdit_Form">            
              <div class="modal-body">              
                <div class="row">
                  <div class="col-sm-6">
                      <div class="form-row">
                       
                        <div class="form-group col-md-6">
                          <label for="Name">Name</label>
                          <input type="text" class="form-control form-control-sm" id="P_NAME" placeholder="name" name="P_NAME">
                        </div>
                       <div class="form-group col-md-6">
                          <label for="code">Pet Code</label>
                          <input type="text" class="form-control form-control-sm" id="P_CODE_ID" placeholder="name" name="P_CODE_ID">
                        </div>
                         <div class="form-group col-md-6">
                          <label for="DOB">Pet DOB</label>
                          <input type="text" class="form-control form-control-sm " id="P_DOB" placeholder="name" name="P_DOB">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="gender">Pet Gender</label>
                          <select class="form-control form-control-sm custom-select" id="P_GENDER" name="P_GENDER">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>                            
                          </select>                          
                        </div>  
                         <div class="form-group col-md-6">
                          <label for="Name">Image</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="P_IMAGE" name="P_IMAGE" onchange="readURL(this);">
                              <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                         <div class="form-group col-md-6">
                          <label for="Image">Image Preview</label>
                          <img src="" id="P_IMAGE_PREVIEW" height="auto" width="100%" >
                        </div>                      
                      </div>
                  </div>
                  <div class="col-sm-6"> 

                        <div class="form-row">
                          <div class="form-group col-md-6">
                          <label for="gender">Location</label>
                          <select class="form-control form-control-sm custom-select" id="P_SECTION_AREA" name="P_SECTION_AREA">
                            <option value="A">A</option>
                            <option value="B">B</option>                            
                          </select>                          
                        </div>
                        <div class="form-group col-md-6">
                          <label for="gender">Pet Status</label>
                          <select class="form-control form-control-sm custom-select" id="P_STATUS" name="P_STATUS">
                            <option value="A">A</option>
                            <option value="B">B</option>                            
                          </select>                          
                        </div>
                         <div class="form-group col-md-6">
                          <label for="Weight">Weight</label>
                          <input type="text" class="form-control form-control-sm" id="P_WEIGHT" placeholder="name" name="P_WEIGHT">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="Condition">Condition</label>
                          <select class="form-control form-control-sm custom-select" id="P_CONDITION_TYPE" name="P_CONDITION_TYPE">
                            <option value="A">A</option>
                            <option value="B">B</option>                            
                          </select>                          
                        </div> 
                        </div>                        
                  </div>
                </div>
              </div>             
              <div class="modal-footer">
              <div class="col-md-6" id="Activedivfooter">             
              <input type="checkbox" value="Y" class="lcs_check form-control form-control-sm" id="P_ACTIVE_YN"/>              
              <label class="checkbox-inline text-left"> Active</label>
              <input type="hidden" name="P_ACTIVE" value="N"  id="P_ACTIVE"/>
              <input type="hidden" name="P_ID" value=""  id="P_ID"/>
              <input type="hidden" name="P_IMAGE_OLD" value=""  id="P_IMAGE_OLD"/>
              </div>
              <div class="col-md-6 text-right">   
                <button type="button" class="btn bg-secondary btn-sm" data-dismiss="modal" onclick="PetDetailsModalForm_Reset();">Close</button>
                <button type="submit" class="btn back-color btn-sm" id="SaveButton">Save</button>
              </div>
              </div>
            </form> 
            </div>
          </div>
        </div>
      </div>
      <!-- modal end for add edit -->
<script type="text/javascript">

</script>