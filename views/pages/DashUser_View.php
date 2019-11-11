<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$AccessDelete = $this->session->userdata('U_ACCESS_DELETE');
$AccessInsert = $this->session->userdata('U_ACCESS_INSERT');
$AccessUpdate = $this->session->userdata('U_ACCESS_UPDATE');
$userTypeSession = $this->session->userdata('U_USER_TYPE');
if($userTypeSession  !=="SUPERADMIN"){    
        redirect('Dashboard'); 
         }    
?>  
<style type="text/css">

</style>
  <!-- Breadcrumbs-->       
    
        <div class="addButton" style="padding: 10px 0 10px 0;">
          <button <?php if($AccessInsert!=='Y'){echo 'disabled'; } ?> id="Add" type="button" class="btn bg-success AddEditButton" data-toggle="modal" data-target="#DashUser_Modal" data-backdrop="static" data-keyboard="false" >
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
                  <th data-class="expand" >NAME</th>
                  <th data-class="expand" >USERNAME</th>
                  <th data-class="expand" >TYPE</th>
                  <th data-class="expand" >GENDER</th>                  
                  <th data-class="expand">EMAIL</th>
                  <th data-class="expand">CONTACT</th>
                  <th data-class="expand">ADDRESS</th>
                  <th data-class="expand">ACTIVE</th>
                  <th data-class="expand">INSERT</th>
                  <th data-class="expand">UPDATE</th>
                  <th data-class="expand">DELETE</th>                
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
          InputContact_flag('U_CONTACT');
          State_List('U_COUNTRY','U_STATE','U_CITY');
          City_List('U_STATE','U_CITY');
          //FOOTER FUNCTION
           //$.fn.dataTable.ext.errMode = 'throw';

          var DataTableObject=[
            { data: 'U_ID' ,className:"all text-center"},
            { data: 'U_NAME' ,className:"all"},
            { data: 'U_USERNAME' ,className:"all"},
            { data: 'U_USER_TYPE' ,className:"all"},
            { data: 'U_GENDER' ,className:"all"},
           // { data: 'U_PASSWORD'},
            { data: 'U_EMAIL'},
            { data: 'U_CONTACT'},
            { data: null , 'searchable': false ,
            render : function (data, type, dataToSet) {
            return data.U_ADDRESS + ", " + data.CT_NAME + "<br>" + data.ST_NAME + ", " + data.CN_NAME +","+ data.U_PINCODE;
            }},
            { data: 'U_ACTIVE'},
            { data: 'U_ACCESS_INSERT'},
            { data: 'U_ACCESS_UPDATE'},
            { data: 'U_ACCESS_DELETE'},
            { data: null, "orderable": false, 'searchable': false, className:"all text-center", 
              render: function( data, type, row) {
                sysid=data['U_ID'];				
                return   '<div class="dropdown" >'
                      +'	<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">'
                      +	'</button>'
                      +	'<div class="dropdown-menu">'
                      +	  '<button <?php if($AccessUpdate!=="Y"){echo "disabled"; } ?> id="Edit" class="dropdown-item AddEditButton" data-id="'+sysid+'" data-toggle="modal" data-target="#DashUser_Modal" href="#" data-backdrop="static" data-keyboard="false">Edit</button>'
                      +	  '<button <?php if($AccessDelete!=="Y"){echo "disabled"; } ?> class="dropdown-item" id="DashUser_Delete" data-id="'+sysid+'"  href="#">Delete</button>'								
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
                  "url": "<?= base_url(); ?>Dashboard/DashUserView_Ajax",
                  "type": "POST"
              },
            
          
          });
          linesSwitchery();          
      });
      // functions
     function linesSwitchery() {
          $('.lcs_check').lc_switch('Y', 'N');
	    		$('.lcs_wrap').delegate('#U_ACTIVE_YN', 'lcs-on', function() {
	    		$('#U_ACTIVE').val('Y');
	    		});
					$('.lcs_wrap').delegate('#U_ACTIVE_YN', 'lcs-off', function() {
            $('#U_ACTIVE').val('N');						
					});
          } 

     
     function GetDashUserData_Ajax(){
         
        $('#SaveButton').text('Update');
         loader();
         var sysId = $('#U_ID').val();   
         $.ajax({
                   type: "POST",
                   url: "<?= site_url('Dashboard/GetDashUserData_Ajax'); ?>",
                   data: {sysId : sysId} ,
                   dataType:'json',
                   success: function(json)
                   {
                     var obj = json['data'][0];
                      $('#U_ID').val(obj.U_ID);
                      $('#U_NAME').val(obj.U_NAME);
                      $('#U_USERNAME').val(obj.U_USERNAME);
                      $('#U_USER_TYPE').val(obj.U_USER_TYPE).trigger('change');
                      $('#U_GENDER').val(obj.U_GENDER).trigger('change');
                      $('#U_PASSWORD').val(obj.U_PASSWORD);
                      $('#U_PASSWORD_CONFIRM').val(obj.U_PASSWORD);
                      $('#U_EMAIL').val(obj.U_EMAIL);
                      $('#U_CONTACT').val(obj.U_CONTACT);
                      $('#U_ADDRESS').val(obj.U_ADDRESS);               
                      $('#U_COUNTRY option[value='+obj.U_COUNTRY+']').attr('selected','selected');
                     // $('#U_COUNTRY').val(obj.U_COUNTRY).trigger('change');

                      $('#U_STATE').html(json.stateOption);                
                      $('#U_STATE option[value='+obj.U_STATE+']').attr('selected','selected');
                     // $('#U_STATE').val(obj.U_STATE).trigger('change');

                      $('#U_CITY').html(json.cityOption);               
                      $('#U_CITY option[value='+obj.U_CITY+']').attr('selected','selected');
                    //  $('#U_CITY').val(obj.U_CITY).trigger('change');
                      
                      $('#U_PINCODE').val(obj.U_PINCODE);                
                      $('#U_ACTIVE').val(obj.U_ACTIVE);
                      $('#U_ACCESS_INSERT').val(obj.U_ACCESS_INSERT).trigger('change');
                      $('#U_ACCESS_DELETE').val(obj.U_ACCESS_DELETE).trigger('change');
                      $('#U_ACCESS_UPDATE').val(obj.U_ACCESS_UPDATE).trigger('change');
                      var $ActiveYn = obj.U_ACTIVE;
                      if($ActiveYn == 'Y'){
                        $('#U_ACTIVE_YN').lcs_on();
                      }else{
                        $('#U_ACTIVE_YN').lcs_off();
                      }
                     //$(".selectpicker").selectpicker('refresh');

                      $('#DashUserAddEdit_Form').valid(); 
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
        $('#U_ID').val('');
         $('#U_USERNAME').prop('readonly', false);
         $('#SaveButton').text('Save');
          var $ActiveYn = $('#U_ACTIVE_YN').val();
                      if($ActiveYn == 'Y'){
                        $('#U_ACTIVE_YN').lcs_on();
                      }else{
                        $('#U_ACTIVE_YN').lcs_off();
                      }

       }
       else{        
       var sysId =  $(this).attr('data-id');
        $('#U_ID').val(sysId);
         $('#U_USERNAME').rules('remove');
         $('#U_USERNAME').prop('readonly', true);
        GetDashUserData_Ajax();

       }
  });  
    $(document).on("click", "#DashUser_Delete", function(e) {
         var sysId = $(this).attr('data-id');
        bootbox.confirm("Are you sure you want to delete?", function(result) {
          if(result){ 
           loader();          
           $.ajax({
             type: "POST",
             url: "<?= site_url('Dashboard/DashUserDelete_Ajax'); ?>",
             data: {sysId : sysId} ,// serializes the form's elements.
             success: function(data)
             {
                 //alert(data); // show response from the php script.
                  $('.AlertMessage').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong> Record successfully deleted</div>') ;
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
       var sysId = $('#U_ID').val();
       var url = "<?php echo site_url('Dashboard/DashUser_UpdateAjax') ?>";
       if(sysId == ''){
       var url = "<?php echo site_url('Dashboard/DashUser_SaveAjax') ?>";
       } 
       loader();
      $.ajax({
             type: "POST",
             url: url,
             data: $(form).serialize(), // serializes the form's elements.
             success: function(data)
             {
               if(sysId ==''){
                 $('#U_ID').val(data)
                 //alert(data); // show response from the php script.
                  $('.AlertMessageModal').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong> Data seccessfully inserted</div>') ;
                 setTimeout(function(){ 
                  $('.AlertMessageModal').html('') ;
                 }, 2000);

               }
               else{
                 $('#U_ID').val(data)
                 //alert(data); // show response from the php script.
                  $('.AlertMessageModal').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong> Data seccessfully Updated</div>') ;
                 setTimeout(function(){ 
                  $('.AlertMessageModal').html('') ;
                 }, 2000);               
               }
               
            
                 GetDashUserData_Ajax(); 
                  unloader();                 
             }
            
           }); 
           $("#datatables").DataTable().draw();
           //$('#datatables').DataTable().ajax.reload();
			}     
		});     
		$(document).ready( function () {      
     
			$( "#DashUserAddEdit_Form" ).validate( {
        onkeyup: function(element) {
            $(element).valid();           
          }, 
        onfocusout: function (element) {
          $(element).valid();
        },  

				rules: {
          U_NAME: "required",				
          U_USERNAME:{                
                required: true,
                remote: 
                  {
                        url: "<?php echo site_url("Dashboard/U_USERNAME_EXISTS"); ?>",
                        type: "post",
                        data: 
                        {
                          U_USERNAME: function(){ return $("#U_USERNAME").val(); }
                        }
                  }                         
            },         
          U_PASSWORD : 
                {
                    required:true,
                    minlength : 5
                },
          U_PASSWORD_CONFIRM : {
              minlength : 5,
              equalTo : "#U_PASSWORD"
          },
          U_USER_TYPE: "required",
					U_GENDER: "required",
					U_EMAIL:  {
                  required: true,
                   email: true

          },         	
          U_CONTACT: {
                  required:true,                 
                  number:true  
               },                
					U_ADDRESS: "required",
					U_COUNTRY: "required", 
					U_STATE: "required",
          U_ACCESS_INSERT: "required",
          U_ACCESS_UPDATE: "required",
					U_ACCESS_DELETE: "required",
					U_PINCODE: {
                  required: true,
                   digits: true

          },
				},
				messages: {
          U_USERNAME: "Please enter your name",
					U_USERNAME: "This username in not available",
					U_PASSWORD: "Please enter your password",
          U_GENDER: "Please enter your gender",
          U_USER_TYPE: "Please enter uers type",
					U_EMAIL: "Please enter your email",
					U_CONTACT: "Please enter your contact",
					U_ADDRESS: "Please enter your address",
					U_COUNTRY: "Please enter your country",
					U_STATE: "Please enter your state",					
					U_PINCODE: "Please enter your pincode",         				
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

function DashUserModalForm_Reset(){

     $("#DashUserAddEdit_Form")[0].reset();
     $('#U_COUNTRY option:selected').removeAttr('selected');     
     $('#U_CITY,#U_STATE').html("<option value=''> Select </option>"); 
     $('#DashUserAddEdit_Form').valid(); 
     var validator = $( "#DashUserAddEdit_Form" ).validate();
     validator.resetForm();
     $("#DashUserAddEdit_Form").find('.is-valid').removeClass("is-valid"); 
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
                <button type="button" onclick="DashUserModalForm_Reset();" class="close" data-dismiss="modal">&times;</button>
              </div>
             <div class="AlertMessageModal"></div> 
              <form mathod="POST" id="DashUserAddEdit_Form">            
              <div class="modal-body">              
                <div class="row">
                  <div class="col-sm-6">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="Name">Name</label>
                          <input type="text" class="form-control form-control-sm" id="U_NAME" placeholder="name" name="U_NAME">
                        </div>
                         <div class="form-group col-md-6">
                          <label for="USERNAME">Login Username</label>
                          <input type="text" class="form-control form-control-sm" id="U_USERNAME" placeholder="Username" name="U_USERNAME">
                        </div>
                         <div class="form-group col-md-6">
                          <label for="password">Password</label>
                          <input type="password" class="form-control form-control-sm" id="U_PASSWORD" placeholder="Password" name="U_PASSWORD">
                        </div> 
                        <div class="form-group col-md-6">
                          <label for="password">Confirm Password</label>
                          <input type="password" class="form-control form-control-sm" id="U_PASSWORD_CONFIRM" placeholder="Password" name="U_PASSWORD_CONFIRM">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="TYPE">TYPE</label>
                          <select class="form-control form-control-sm custom-select" id="U_USER_TYPE" name="U_USER_TYPE">                           
                            <option value="" selected>SELECT</option>
                            <option value="SUPERADMIN">SUPER ADMIN</option>
                            <option value="ADMIN">ADMIN</option>
                            <option value="EMPLOYEE">EMPLOYEE</option>
                          </select>
                        </div>
                       
                        <div class="form-group col-md-6">
                          <label for="gender">Gender</label>
                          <select class="form-control form-control-sm custom-select" id="U_GENDER" name="U_GENDER">                           
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>                            
                          </select> 
                          
                        </div>
                        <div class="form-group col-md-6">
                          <label for="email">Email</label>
                          <input type="email" class="form-control form-control-sm" placeholder="email" id="U_EMAIL" name="U_EMAIL">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="contact">Contact</label>
                          <input type="tel" class="form-control form-control-sm"  placeholder="contact" id="U_CONTACT" name="U_CONTACT">
                        </div> 
                        <div class="form-group col-md-6">
                          <label for="access">Insert</label>
                          <select class="form-control form-control-sm custom-select" id="U_ACCESS_INSERT" name="U_ACCESS_INSERT">                            
                            <option value="Y">Enable</option>
                            <option value="N">Disable</option>                            
                          </select>                           
                        </div>     
                      </div>
                  </div>
                  <div class="col-sm-6">                                      
                        <div class="form-row">
                          <div class="form-group col-md-6">
                          <label for="access">Update</label>
                          <select class="form-control form-control-sm custom-select" id="U_ACCESS_UPDATE" name="U_ACCESS_UPDATE">                            
                            <option value="Y">Enable</option>
                            <option value="N">Disable</option>                            
                          </select>                           
                        </div> 
                        <div class="form-group col-md-6">
                          <label for="access">Delete</label>
                          <select class="form-control form-control-sm custom-select" id="U_ACCESS_DELETE" name="U_ACCESS_DELETE">
                            <option value="Y">Enable</option>
                            <option value="N">Disable</option>                             
                          </select>                           
                        </div> 
                        <div class="form-group col-md-12">
                          <label for="Address">Address</label>
                          <input type="text" class="form-control form-control-sm" id="U_ADDRESS" name="U_ADDRESS" placeholder="1234 Main St">
                        </div>  
                          <div class="form-group col-md-6">
                            <label for="country">Country</label>
                            <select class="form-control form-control-sm custom-select" id="U_COUNTRY" name="U_COUNTRY">
                            <?php                           
                            if(!empty($countries)){
                               $option = "<option value='' Selected>Select</option>";
                               echo $option;
                              foreach ($countries as $value) {
                              echo "<option country-code=".$value['CN_CODE']." value=".$value['CN_ID'].">".$value['CN_NAME']."</option>";
                              }
                            }                            
                             ?>                                                         
                          </select>  
                            
                          </div>
                          <div class="form-group col-md-6">
                            <label for="State">State</label>
                            <select class="form-control form-control-sm custom-select" id="U_STATE" name="U_STATE">                            
                            <option value="">Select</option>                  
                          </select>                             
                          </div>
                          <div class="form-group col-md-6">
                            <label for="city">City</label>
                            <select class="form-control  custom-select form-control-sm" id="U_CITY" name="U_CITY">                            
                            <option value="">Select</option>                   
                          </select>                           
                          </div>
                          <div class="form-group col-md-6">
                            <label for="Pincode">Pincode</label>
                            <input type="text" class="form-control form-control-sm" id="U_PINCODE" name="U_PINCODE">
                          </div>
                        </div>                        
                  </div>
                </div>
              </div>             
              <div class="modal-footer">
              <div class="col-md-6" id="Activedivfooter">             
              <input type="checkbox" value="Y" class="lcs_check form-control form-control-sm" id="U_ACTIVE_YN"/>              
              <label class="checkbox-inline text-left"> Active</label>
              <input type="hidden" name="U_ACTIVE" value="N"  id="U_ACTIVE"/>
              <input type="hidden" name="U_ID" value=""  id="U_ID"/>
              </div>
              <div class="col-md-6 text-right">   
                <button type="button" class="btn bg-secondary btn-sm" data-dismiss="modal" onclick="DashUserModalForm_Reset();">Close</button>
                <button type="submit" class="btn bg-success btn-sm" id="SaveButton">Save</button>
              </div>
              </div>
            </form> 
            </div>
          </div>
        </div>
      </div>
      <!-- modal end for add edit -->
