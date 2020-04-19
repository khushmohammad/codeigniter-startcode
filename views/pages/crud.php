<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$AccessDelete = $this->session->userdata('U_ACCESS_DELETE');
$AccessInsert = $this->session->userdata('U_ACCESS_INSERT');
$AccessUpdate = $this->session->userdata('U_ACCESS_UPDATE');
$userTypeSession = $this->session->userdata('U_USER_TYPE');   
?>  
<style type="text/css">

</style>
  <!-- Breadcrumbs-->       
    
        <div class="addButton" style="padding: 10px 0 10px 0;">
          <button <?php if($AccessInsert!=='Y'){echo 'disabled'; } ?> id="Add" type="button" class="btn bg-success AddEditButton" data-toggle="modal" data-target="#crudItemModal" data-backdrop="static" data-keyboard="false" >
          Add
        </button>

        </div> 
        <div  class="AlertMessage">               
        </div>
        <!-- DataTables Example -->
        <div class="card mb-3">            
          <div class="card-header">
            <i class="fas fa-table"></i>
            <?= lang('welcome_message')?></div>
          <div class="card-body">
            <div class="">
            <table class="nowrap table table-striped table-bordered  table-hover" id="datatables" width="100%">
              <thead class="thead-light">
                <tr>
                  <th data-class="expand">ID</th>
                  <th data-class="expand" >Name</th>
                  <th data-class="expand" >Contact</th>
                  <th data-class="expand" >Email</th>       
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
            { data: 'ID' ,className:"all text-center"},
            { data: 'NAME' ,className:"all"},
            { data: 'CONTACT'}, 
            { data: 'EMAIL' ,className:"all"},            
            { data: null, "orderable": false, 'searchable': false, className:"all text-center", 
              render: function( data, type, row) {
                sysid=data['ID'];              
                return   '<div class="dropdown" >'
                      +'	<button type="button" class="btn" data-toggle="dropdown"><i class="fas fa-edit"></i>'
                      +	'</button>'
                      +	'<div class="dropdown-menu">'
                      +	  '<button <?php if($AccessUpdate!=="Y"){echo "disabled"; } ?> id="Edit" class="dropdown-item AddEditButton" data-id="'+sysid+'" data-toggle="modal" data-target="#crudItemModal" href="#" data-backdrop="static" data-keyboard="false">Edit</button>'
                      +	  '<button <?php if($AccessDelete!=="Y"){echo "disabled"; } ?> class="dropdown-item" id="crudItemDelete" data-id="'+sysid+'"  href="#">Delete</button>'								
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
          'scrollCollapse': false,		
          'dataType': 'json',				
          columns: DataTableObject,		
              "ajax": {
                  "url": "<?= base_url(); ?>Dashboard/CrudDetailsView_Ajax",
                  "type": "POST"
              },
            
          
          });
          //linesSwitchery('I_ACTIVE_YN','I_ACTIVE'); 
        //free Zone area
       // datepicker('I_PURCHASEDATE');
       // datepicker('I_EXPIRYDATE');
        // $(".custom-file-input").on("change", function() {
        //   var fileName = $(this).val().split("\\").pop();
        //   $(this).siblings(".custom-file-label").addClass("selected").text(fileName).css('overflow','hidden');
        // });

        //free Zone area           
      });
      // functions
      // function readURL(input) {
      //   if (input.files && input.files[0]) {
      //     var reader = new FileReader();          
      //     reader.onload = function(e) {
      //       $('#I_BILL_PREVIEW').attr('src', e.target.result);
      //     }          
      //     reader.readAsDataURL(input.files[0]);
      //   }
      // }
     function GetCrudItemData_Ajax(){         
        $('#SaveButton').text('Update');
         loader();
         var sysId = $('#ID').val();   
         $.ajax({
                   type: "POST",
                   url: "<?= site_url('Dashboard/GetCrudDetailsEditData_Ajax'); ?>",
                   data: {sysId : sysId} ,
                   dataType:'json',
                   success: function(json)
                   {
                     var obj = json['data'][0];
                      $('#ID').val(obj.ID);
                      $('#NAME').val(obj.NAME);
                      $('#EMAIL').val(obj.EMAIL);
                      $('#CONTACT').val(obj.CONTACT);
                      $('#crudItemAddEdit_Form').valid(); 
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
        $('#ID').val('');      
        $('#SaveButton').text('Add');     
                  
       }
       else{        
       var sysId =  $(this).attr('data-id');
        $('#ID').val(sysId);
        GetCrudItemData_Ajax();

       }
  });  
    $(document).on("click", "#crudItemDelete", function(e) {
         var sysId = $(this).attr('data-id');        
        bootbox.confirm("Are you sure you want to delete?", function(result) {
          if(result){ 
           loader();          
           $.ajax({
             type: "POST",
             url: "<?= site_url('Dashboard/CrudDetailsDelete_Ajax'); ?>",
             data: {sysId : sysId} ,// serializes the form's elements.
             success: function(data)
             {
                 //alert(data); // show response from the php script.
                  $('.AlertMessage').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong> A record successfully deleted</div>') ;
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
       var sysId = $('#ID').val();
       var url = "<?php echo site_url('Dashboard/CrudItemUpdate_Ajax') ?>";
       if(sysId == ''){
       var url = "<?php echo site_url('Dashboard/CrudItemSave_Ajax') ?>";
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
                  $('#ID').val(data)
                 setTimeout(function(){ 
                  $('.AlertMessageModal').html('') ;
                 }, 2000);
            
                 GetCrudItemData_Ajax(); 
                  unloader();
                  $("#datatables").DataTable().draw();                 
             }              
            
           }); 
         //  $("#datatables").DataTable().draw();
           //$('#datatables').DataTable().ajax.reload();
			}     
		});     
		$(document).ready( function () {      
     
			$( "#crudItemAddEdit_Form" ).validate( {
        onkeyup: function(element) {
            $(element).valid();           
          }, 
        onfocusout: function (element) {
          $(element).valid();
        },  

				rules: {
         
          NAME: { required: true, },
					EMAIL: "required",
          CONTACT:{ required: true  },        
                  
				},
				messages: {
          NAME: "Enter name",
          EMAIL: "Enter purchase date",
          CONTACT: "Enter Purchase by"          
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

function crudModalForm_Reset(){
     $("#crudItemAddEdit_Form")[0].reset();
     $('#crudItemAddEdit_Form').valid(); 
     var validator = $( "#crudItemAddEdit_Form" ).validate();
     validator.resetForm();
     $("#crudItemAddEdit_Form").find('.is-valid').removeClass("is-valid"); 
    // $(".selectpicker").selectpicker('refresh');

}
// jQuery

</script>
<!-- modal for add and edit -->
<div class="modal" id="crudItemModal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add Item</h4>
                <button type="button" onclick="crudModalForm_Reset();" class="close" data-dismiss="modal">&times;</button>
              </div>
             <div class="AlertMessageModal"></div> 
              <form mathod="POST" id="crudItemAddEdit_Form">            
              <div class="modal-body">              
                <div class="row">
                  <div class="col-sm-6">
                      <div class="form-row">                       
                        <div class="form-group col-md-6">
                          <label for="Name">Name</label>
                          <input type="text" class="form-control form-control-sm" id="NAME" placeholder="NAME" name="NAME">
                        </div> 
                         <div class="form-group col-md-6">
                          <label for="">Email</label>
                          <input type="text" class="form-control form-control-sm" id="EMAIL" placeholder="EMAIL" name="EMAIL">
                        </div> 
                                            
                      </div>
                  </div>
                  <div class="col-sm-6"> 
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="">Contact</label>
                          <input type="text" class="form-control form-control-sm" id="CONTACT" placeholder="CONTACT" name="CONTACT">
                        </div> 
                      </div>                        
                  </div>
                </div>
              </div>             
              <div class="modal-footer">
              <div class="col-md-6" id="Activedivfooter">             
              <!-- <input type="checkbox" value="Y" class="lcs_check form-control form-control-sm" id="I_ACTIVE_YN"/> -->    
            <!--   <label class="checkbox-inline text-left"> Active</label> -->
             <!--  <input type="hidden" name="I_ACTIVE" value="N"  id="I_ACTIVE"/> -->
              <input type="hidden" name="ID" value=""  id="ID"/>            
              </div>
              <div class="col-md-6 text-right">   
                <button type="button" class="btn bg-secondary btn-sm" data-dismiss="modal" onclick="crudModalForm_Reset();">Close</button>
                <button type="submit" class="btn bg-success btn-sm" id="SaveButton">Save</button>
              </div>
              </div>
            </form> 
            </div>
          </div>
        </div>
      </div>
      <!-- modal end for add edit -->
	  
	  <script>
$(document).ready(function(){
  $("#test").keyup(function(){
  
  var month = $("#month").val();
  
  var day  = $("#day").val();
  
  var par = $("#test").val();
  
  var perdaysalary = parseFloat(month) / parseFloat(day);
  
  
  var salary = parseFloat(perdaysalary)* parseFloat(par);
    //alert(Math.ceil(salary)+'     new '+ parseFloat(salary) );
    $('#salary').val(Math.ceil(salary));
    
  });
});
</script>
</head>
<body>

<p>persent: <input type="text" id="test" value="25"></p>
<p>month: <input type="text" id="month" value="5000"></p>
<p>day: <input type="text" id="day" value="30"></p>
<p>Salary: <input type="text" id="salary" value=""></p>
<button>Show Value</button>
