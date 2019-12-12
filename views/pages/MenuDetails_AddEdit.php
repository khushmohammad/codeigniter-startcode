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
          <button <?php if($AccessInsert!=='Y'){echo 'disabled'; } ?> id="Add" type="button" class="btn bg-success AddEditButton" data-toggle="modal" data-target="#menuDetailModal" data-backdrop="static" data-keyboard="false" >
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
                  <th data-class="expand">Id</th>
                  <th data-class="expand">S no</th>
                  <th data-class="expand" >Name</th>
                  <th data-class="expand" >Link</th>
                  <th data-class="expand" >Icon</th>
                  <th data-class="expand" >Menu Location</th>
                  <th data-class="expand" >Active</th>
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

          var DataTableObject=[
            { data: 'M_ID' ,className:"all text-center"},
            { data: 'M_SNO' ,className:"all"},
            { data: 'M_NAME'}, 
            { data: 'M_LINK' ,className:"all"},
            { data: 'M_ICON' ,className:"all"},
            { data: 'M_LOCATION' ,className:"all"},
            { data: 'M_ACTIVE'},                    
            { data: null, "orderable": false, 'searchable': false, className:"all text-center", 
              render: function( data, type, row) {
                sysid=data['M_ID']; 
                return   '<div class="dropdown" >'
                      +'	<button type="button" class="btn" data-toggle="dropdown"><i class="fas fa-edit"></i>'
                      +	'</button>'
                      +	'<div class="dropdown-menu">'
                      +	  '<button <?php if($AccessUpdate!=="Y"){echo "disabled"; } ?> id="Edit" class="dropdown-item AddEditButton" data-id="'+sysid+'" data-toggle="modal" data-target="#menuDetailModal" href="#" data-backdrop="static" data-keyboard="false">Edit</button>'
                      +	  '<button <?php if($AccessDelete!=="Y"){echo "disabled"; } ?> class="dropdown-item" id="DashUser_Delete" data-id="'+sysid+'"   href="#">Delete</button>'								
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
                  "url": "<?= base_url(); ?>Dashboard/menuDetailsView_Ajax",
                  "type": "POST"
              },
          });
          
        //free Zone area
        linesSwitchery();

        //free Zone area           
      });
      // functions     
     function linesSwitchery() {
          $('.lcs_check').lc_switch('Y', 'N');
	    		$('.lcs_wrap').delegate('#M_ACTIVE_YN', 'lcs-on', function() {
	    		$('#M_ACTIVE').val('Y');
	    		});
					$('.lcs_wrap').delegate('#M_ACTIVE_YN', 'lcs-off', function() {
            $('#M_ACTIVE').val('N');						
					});
          } 

     
     function GetmenuDetailData_Ajax(){
         
        $('#SaveButton').text('Update');
         loader();
         var sysId = $('#M_ID').val();   
         $.ajax({
                   type: "POST",
                   url: "<?= site_url('Dashboard/GetmenuDetailEditData_Ajax'); ?>",
                   data: {sysId : sysId} ,
                   dataType:'json',
                   success: function(json)
                   {
                       
                     var obj = json['data'][0];
                      console.log(obj);
                      $('#M_ID').val(obj.M_ID);
                      $('#M_SNO').val(obj.M_SNO);                     
                      $('#M_LINK').val(obj.M_LINK);
                      $('#M_NAME').val(obj.M_NAME);                                         $('#M_LOCATION').val(obj.M_LOCATION);                     $('#M_ICON').val(obj.M_ICON);
                  //    $('#M_LINK').val(obj.P_STATUS).trigger('change');                    
                     
                      var $ActiveYn = obj.M_ACTIVE;
                      if($ActiveYn == 'Y'){
                        $('#M_ACTIVE_YN').lcs_on();
                      }else{
                        $('#M_ACTIVE_YN').lcs_off();
                      }
                     //$(".selectpicker").selectpicker('refresh');

                      $('#menuDetailsAddEdit_Form').valid(); 
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
        $('#M_ID').val('');       
         $('#SaveButton').text('Save');
          var $ActiveYn = $('#M_ACTIVE_YN').val();
                      if($ActiveYn == 'Y'){
                        $('#M_ACTIVE_YN').lcs_on();
                      }else{
                        $('#M_ACTIVE_YN').lcs_off();
                      }
       }
       else{        
       var sysId =  $(this).attr('data-id');
        $('#M_ID').val(sysId);
        GetmenuDetailData_Ajax();

       }
  });  
    $(document).on("click", "#DashUser_Delete", function(e) {
         var sysId = $(this).attr('data-id');
        bootbox.confirm("Are you sure you want to delete?", function(result) {
          if(result){ 
           loader();          
           $.ajax({
             type: "POST",
             url: "<?= site_url('Dashboard/MenuDetailsDelete_Ajax'); ?>",
             data: {sysId : sysId} ,// serializes the form's elements.
             success: function(data)
             {
                 //alert(data); // show response from the php script.
                  $('.AlertMessage').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong>A Record  Seccessfully Deleted.</div>') ;
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
           $('#datatables').DataTable().ajax.reload();
            }
        }); 
    });

    //script       
  //validation
  $.validator.setDefaults( {

submitHandler: function (form) {
       // debug: true       
       var sysId = $('#M_ID').val();
       var url = "<?php echo site_url('Dashboard/menuDetailsUpdate_Ajax') ?>";
       if(sysId == ''){
       var url = "<?php echo site_url('Dashboard/menuDetailsSave_Ajax') ?>";
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
               if(sysId == ''){
                   $('.AlertMessageModal').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong>A Record Seccessfully Inserted.</div>') ;
               }
             else{
                 $('.AlertMessageModal').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong>A Record Seccessfully Updated.</div>') ;
             }
                  $('#M_ID').val(data)
                 setTimeout(function(){ 
                  $('.AlertMessageModal').html('') ;
                 }, 2000);
            
                 GetmenuDetailData_Ajax(); 
                  unloader();                 
             }
            
           }); 
           $("#datatables").DataTable().draw();
           //$('#datatables').DataTable().ajax.reload();
			}     
		});     
		$(document).ready( function () {      
     
			$( "#menuDetailsAddEdit_Form" ).validate( {
        onkeyup: function(element) {
            $(element).valid();           
          }, 
        onfocusout: function (element) {
          $(element).valid();
        }, 
        rules: {
          M_SNO: "required",
          M_NAME: {
            required: true,            
          },
          M_LINK: "required",
          M_ICON:{
            required: true
          },
          M_LOCATION: "required"
				},
        messages: {
          M_SNO: "Enter name",
          M_NAME: "Enter Unique code",
          M_LINK: "Enter gender",
          M_ICON: "Enter Date of Birth",
          M_LOCATION: "Select Locaion",                          				
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

     $("#menuDetailsAddEdit_Form")[0].reset();    
     $('#menuDetailsAddEdit_Form').valid(); 
     var validator = $( "#menuDetailsAddEdit_Form" ).validate();
     validator.resetForm();
     $("#menuDetailsAddEdit_Form").find('.is-valid').removeClass("is-valid");  

}
// jQuery

</script>
<!-- modal for add and edit -->
<div class="modal" id="menuDetailModal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
                <button type="button" onclick="PetDetailsModalForm_Reset();" class="close" data-dismiss="modal">&times;</button>
              </div>
             <div class="AlertMessageModal"></div> 
              <form mathod="POST" id="menuDetailsAddEdit_Form">            
              <div class="modal-body">              
                <div class="row">
                  <div class="col-sm-6">
                      <div class="form-row">                       
                        <div class="form-group col-md-6">
                          <label for="">S no</label>
                          <input type="text" class="form-control form-control-sm" id="M_SNO" placeholder="S No" name="M_SNO">
                        </div>
                       <div class="form-group col-md-6">
                          <label for="">Menu Name</label>
                          <input type="text" class="form-control form-control-sm" id="M_NAME" placeholder="Name" name="M_NAME">
                        </div>
                        <div class="form-group col-md-12">
                          <label for="">Menu Link</label>
                          <input type="text" class="form-control form-control-sm" id="M_LINK" placeholder="Link" name="M_LINK">
                        </div>    
                      </div>
                  </div>
                  <div class="col-sm-6"> 
                        <div class="form-row">
                         <div class="form-group col-md-6">
                          <label for="">Icon</label>
                          <input type="text" class="form-control form-control-sm" id="M_ICON" placeholder="Icon" name="M_ICON">
                        </div> 
                        <div class="form-group col-md-6">
                          <label for="">Menu Location</label>
                          <select class="form-control form-control-sm custom-select" id="M_LOCATION" name="M_LOCATION">
                            <option value="">Select</option>  
                            <option value="Setting">Setting</option>
                            <option value="Dashboard">Dashboard</option>
                          </select>                          
                        </div> 
                        </div>                        
                  </div>
                </div>
              </div>             
              <div class="modal-footer">
              <div class="col-md-6" id="Activedivfooter">             
              <input type="checkbox" value="Y" class="lcs_check form-control form-control-sm" id="M_ACTIVE_YN"/>    
              <label class="checkbox-inline text-left"> Active</label>
              <input type="hidden" name="M_ACTIVE" value="N"  id="M_ACTIVE"/>
              <input type="hidden" name="M_ID" value=""  id="M_ID"/>              
              </div>
              <div class="col-md-6 text-right">   
                <button type="button" class="btn bg-secondary btn-sm" data-dismiss="modal" onclick="PetDetailsModalForm_Reset();">Close</button>
                <button type="submit" class="btn bg-success btn-sm" id="SaveButton">Save</button>
              </div>
              </div>
            </form> 
            </div>
          </div>
        </div>
      </div>
      <!-- modal end for add edit -->
