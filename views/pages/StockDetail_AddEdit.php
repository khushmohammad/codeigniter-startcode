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

</style>
  <!-- Breadcrumbs-->       
    
        <div class="addButton" style="padding: 10px 0 10px 0;">
          <button <?php if($AccessInsert!=='Y'){echo 'disabled'; } ?> id="Add" type="button" class="btn bg-success AddEditButton" data-toggle="modal" data-target="#StockItemModal" data-backdrop="static" data-keyboard="false" >
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
                  <th data-class="expand" >Name</th>
                  <th data-class="expand" >Purchase Date</th>
                  <th data-class="expand" >Purchase By</th>
                  <th data-class="expand" >Amount</th>
                  <th data-class="expand" >Bill</th>                  
                  <th data-class="expand">Expriy Date</th>
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
          var DataTableObject=[
            { data: 'I_ID' ,className:"all text-center"},
            { data: 'I_NAME' ,className:"all"},
            { data: 'I_PURCHASEDATE'}, 
            { data: 'I_PURCHASEBY' ,className:"all"},
            { data: 'I_AMOUNT' ,className:"all"},
            { data:  function (data, type, dataToSet) {
            var bill =    data.I_BILL;          
             if( bill != ''){               
                 return '<img src="<?php echo site_url('/upload/BillImage/');?>'+bill+'" height="auto" width="50px">';
                }else{                 
                  return '<img src="<?php echo site_url('/assets/img/noimage.png');?>" height="auto" width="50px">';
                } 
              }, 'searchable': false       
            },           
            { data: 'I_EXPIRYDATE'},
            { data: 'I_ACTIVE'},
            { data: null, "orderable": false, 'searchable': false, className:"all text-center", 
              render: function( data, type, row) {
                sysid=data['I_ID'];
                img=data['I_BILL'];
                return   '<div class="dropdown" >'
                      +'	<button type="button" class="btn" data-toggle="dropdown"><i class="fas fa-edit"></i>'
                      +	'</button>'
                      +	'<div class="dropdown-menu">'
                      +	  '<button <?php if($AccessUpdate!=="Y"){echo "disabled"; } ?> id="Edit" class="dropdown-item AddEditButton" data-id="'+sysid+'" data-toggle="modal" data-target="#StockItemModal" href="#" data-backdrop="static" data-keyboard="false">Edit</button>'
                      +	  '<button <?php if($AccessDelete!=="Y"){echo "disabled"; } ?> class="dropdown-item" id="StockItemDelete" data-id="'+sysid+'" data-img="'+img+'"  href="#">Delete</button>'								
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
                  "url": "<?= base_url(); ?>Dashboard/StockDetailsView_Ajax",
                  "type": "POST"
              },
            
          
          });
          linesSwitchery('I_ACTIVE_YN','I_ACTIVE'); 
        //free Zone area
        datepicker('I_PURCHASEDATE');
        datepicker('I_EXPIRYDATE');
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").text(fileName).css('overflow','hidden');
        });

        //free Zone area           
      });
      // functions
      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();          
          reader.onload = function(e) {
            $('#I_BILL_PREVIEW').attr('src', e.target.result);
          }          
          reader.readAsDataURL(input.files[0]);
        }
      }
     function GetStockItemData_Ajax(){         
        $('#SaveButton').text('Update');
         loader();
         var sysId = $('#I_ID').val();   
         $.ajax({
                   type: "POST",
                   url: "<?= site_url('Dashboard/GetStockDetailsEditData_Ajax'); ?>",
                   data: {sysId : sysId} ,
                   dataType:'json',
                   success: function(json)
                   {
                     var obj = json['data'][0];
                      $('#I_ID').val(obj.I_ID);
                      $('#I_NAME').val(obj.I_NAME);
                      $('#I_PURCHASEDATE').val(obj.I_PURCHASEDATE);
                      $('#I_BILL_OLD').val(obj.I_BILL);
                    
                      if(obj.I_BILL ==''){
                        $('#I_BILL_PREVIEW').attr('src','<?php echo site_url('/assets/img/noimage.png');?>');
                      }else{
                        $('#I_BILL_PREVIEW').attr('src','<?php echo site_url('/upload/BillImage/');?>'+obj.I_BILL+'');
                      }
                      
                      $('#I_PURCHASEBY').val(obj.I_PURCHASEBY);
                      $('#I_AMOUNT').val(obj.I_AMOUNT);
                      $('#I_EXPIRYDATE').val(obj.I_EXPIRYDATE);                      
                      var $ActiveYn = obj.I_ACTIVE;
                      if($ActiveYn == 'Y'){
                        $('#I_ACTIVE_YN').lcs_on();
                      }else{
                        $('#I_ACTIVE_YN').lcs_off();
                      }
                     //$(".selectpicker").selectpicker('refresh');

                      $('#StockItemAddEdit_Form').valid(); 
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
        $('#I_ID').val('');       
         $('#SaveButton').text('Save');
          var $ActiveYn = $('#I_ACTIVE_YN').val();
                      if($ActiveYn == 'Y'){
                        $('#I_ACTIVE_YN').lcs_on();
                      }else{
                        $('#I_ACTIVE_YN').lcs_off();
                      }
            $('#I_BILL_PREVIEW').attr('src','<?php echo site_url('assets/img/noimage.png');?>');          
       }
       else{        
       var sysId =  $(this).attr('data-id');
        $('#I_ID').val(sysId);
        GetStockItemData_Ajax();

       }
  });  
    $(document).on("click", "#StockItemDelete", function(e) {
         var sysId = $(this).attr('data-id');
         var img = $(this).attr('data-img');
        bootbox.confirm("Are you sure you want to delete?", function(result) {
          if(result){ 
           loader();          
           $.ajax({
             type: "POST",
             url: "<?= site_url('Dashboard/StockDetailsDelete_Ajax'); ?>",
             data: {sysId : sysId ,img : img} ,// serializes the form's elements.
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
       var sysId = $('#I_ID').val();
       var url = "<?php echo site_url('Dashboard/StockItemUpdate_Ajax') ?>";
       if(sysId == ''){
       var url = "<?php echo site_url('Dashboard/StockItemSave_Ajax') ?>";
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
                  $('#I_ID').val(data)
                 setTimeout(function(){ 
                  $('.AlertMessageModal').html('') ;
                 }, 2000);
            
                 GetStockItemData_Ajax(); 
                  unloader();
                  $("#datatables").DataTable().draw();                 
             }              
            
           }); 
         //  $("#datatables").DataTable().draw();
           //$('#datatables').DataTable().ajax.reload();
			}     
		});     
		$(document).ready( function () {      
     
			$( "#StockItemAddEdit_Form" ).validate( {
        onkeyup: function(element) {
            $(element).valid();           
          }, 
        onfocusout: function (element) {
          $(element).valid();
        },  

				rules: {
          I_NAME: "required",
          I_PURCHASEDATE: { required: true, },
					I_PURCHASEBY: "required",
          I_AMOUNT:{ required: true  },
         
          I_EXPIRYDATE: "required",        
				},
				messages: {
          I_NAME: "Enter name",
          I_PURCHASEDATE: "Enter purchase date",
          I_PURCHASEBY: "Enter Purchase by",
          I_AMOUNT: "Enter price",
          
          I_EXPIRYDATE: "Item Expiry Date",
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

function StockModalForm_Reset(){
     $("#StockItemAddEdit_Form")[0].reset();
     $('#StockItemAddEdit_Form').valid(); 
     var validator = $( "#StockItemAddEdit_Form" ).validate();
     validator.resetForm();
     $("#StockItemAddEdit_Form").find('.is-valid').removeClass("is-valid"); 
    // $(".selectpicker").selectpicker('refresh');

}
// jQuery

</script>
<!-- modal for add and edit -->
<div class="modal" id="StockItemModal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add Item</h4>
                <button type="button" onclick="StockModalForm_Reset();" class="close" data-dismiss="modal">&times;</button>
              </div>
             <div class="AlertMessageModal"></div> 
              <form mathod="POST" id="StockItemAddEdit_Form">            
              <div class="modal-body">              
                <div class="row">
                  <div class="col-sm-6">
                      <div class="form-row">                       
                        <div class="form-group col-md-6">
                          <label for="Name">Name</label>
                          <input type="text" class="form-control form-control-sm" id="I_NAME" placeholder="Name" name="I_NAME">
                        </div>  
                         <div class="form-group col-md-6">
                          <label for="Name">Purchse by</label>
                          <input type="text" class="form-control form-control-sm" id="I_PURCHASEBY" placeholder="purchase by" name="I_PURCHASEBY">
                        </div>
                         <div class="form-group col-md-6">
                          <label for="">Bill</label>
                            <div class="form-control form-control-sm custom-file">
                              <input type="file" class="custom-file-input" id="I_BILL" name="I_BILL" onchange="readURL(this);">
                              <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                         <div class="form-group col-md-6">
                          <label for="">Bill Preview</label>
                          <img src="" id="I_BILL_PREVIEW" height="auto" width="100%" >
                        </div>                      
                      </div>
                  </div>
                  <div class="col-sm-6"> 
                      <div class="form-row">
                     
                      <div class="form-group col-md-6">
                          <label for="">Purchase Date</label>
                          <input type="text" class="form-control form-control-sm" id="I_PURCHASEDATE" placeholder="purchase date" name="I_PURCHASEDATE" aria-labelledby="I_PURCHASEDATE-label">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="">Expiry Date</label>
                          <input type="text" class="form-control form-control-sm" id="I_EXPIRYDATE" placeholder="Expiry date" name="I_EXPIRYDATE" aria-labelledby="I_EXPIRYDATE-label">
                        </div>
                        <div class="form-group col-md-6">
                         <label for="">Amount</label>
                         <input type="text" class="form-control form-control-sm" id="I_AMOUNT" placeholder="Amount" name="I_AMOUNT">
                        </div>
                      </div>                        
                  </div>
                </div>
              </div>             
              <div class="modal-footer">
              <div class="col-md-6" id="Activedivfooter">             
              <input type="checkbox" value="Y" class="lcs_check form-control form-control-sm" id="I_ACTIVE_YN"/>    
              <label class="checkbox-inline text-left"> Active</label>
              <input type="hidden" name="I_ACTIVE" value="N"  id="I_ACTIVE"/>
              <input type="hidden" name="I_ID" value=""  id="I_ID"/>
              <input type="hidden" name="I_BILL_OLD" value=""  id="I_BILL_OLD"/>
              </div>
              <div class="col-md-6 text-right">   
                <button type="button" class="btn bg-secondary btn-sm" data-dismiss="modal" onclick="StockModalForm_Reset();">Close</button>
                <button type="submit" class="btn bg-success btn-sm" id="SaveButton">Save</button>
              </div>
              </div>
            </form> 
            </div>
          </div>
        </div>
      </div>
      <!-- modal end for add edit -->
