        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Users</li>
        </ol>
        <div class="addButton" style="padding: 10px 0 10px 0;">
          <button id="Add" type="button" class="btn btn-primary AddEditButton" data-toggle="modal" data-target="#DashUser_Modal" data-backdrop="static" data-keyboard="false" >
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
            <div class="table-responsive">
            <table class="table table-bordered nowrap" id="datatables" width="100%" cellspacing="0" >
              <thead>
                <tr>
                  <th data-class="expand" width="10%">ID</th>
                  <th data-class="expand" >NAME</th>
                  <th data-class="expand" >PASSWORD</th>
                  <th data-class="expand">EMAIL</th>
                  <th data-class="expand">CONTACT</th>
                  <th data-class="expand">ADDRESS</th>
                  <th data-class="expand">ACTIVE</th>
                  <th data-hide="phone,tablet" width="10%">ACTION</th>
                </tr>
              </thead>
              <tbody>			
              </tbody>
            </table>             
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
       
<script type="text/javascript">
          //datatable view data
        $(document).ready(function() {
         
          var DataTableObject=[
            { data: 'U_ID' ,className:"all"},
            { data: 'U_USERNAME' ,className:"all"},
            { data: 'U_PASSWORD'},
            { data: 'U_EMAIL'},
            { data: 'U_CONTACT'},
            { data: null , 'searchable': false ,
            render : function (data, type, dataToSet) {
            return data.U_ADDRESS + ", " + data.U_CITY + "<br>" + data.U_STATE + ", " + data.U_COUNTRY + "<br>"+ data.U_PINCODE;
            }},
            { data: 'U_ACTIVE'},
            { data: null, "orderable": false, 'searchable': false, className:"all", 
              render: function( data, type, row) {
                sysid=data['U_ID'];				
                return   '<div class="dropdown" >'
                      +'	<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">'
                      +	'</button>'
                      +	'<div class="dropdown-menu">'
                      +	  '<a id="Edit" class="dropdown-item AddEditButton" data-id="'+sysid+'" data-toggle="modal" data-target="#DashUser_Modal" href="#" data-backdrop="static" data-keyboard="false">Edit</a>'
                      +	  '<a class="dropdown-item" id="DashUser_Delete" data-id="'+sysid+'"  href="#">Delete</a>'								
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
      //functions
    //script 
    $(document).on('click' , '.AddEditButton' , function(e){ 
      e.preventDefault();
       var buttonid =  $(this).attr('id');
       if(buttonid == 'Add'){
        
        
       }
       else{
        

       }

  });      

    //script       
  //validation
  $.validator.setDefaults( {
			submitHandler: function (form) {
       // debug: true
       var url = "<?php echo site_url('Dashboard/DashUser_SaveAjax') ?>";

      $.ajax({
             type: "POST",
             url: url,
             data: $(form).serialize(), // serializes the form's elements.
             success: function(data)
             {
                $('#U_ID').val(data)
                 //alert(data); // show response from the php script.
                  $('.AlertMessageModal').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong> This alert box could indicate a successful or positive action.</div>') ;
                 setTimeout(function(){ 
                  $('.AlertMessageModal').html('') ;
                 }, 2000);
            
                 
             }
           });  
       $('#datatables').DataTable().ajax.reload();
			}
		} );

		$( document ).ready( function () {
			$( "#DashUserAddEdit_Form" ).validate( {
				rules: {
					U_USERNAME: "required",
					U_PASSWORD: "required",
					U_COUNTRY: {
						required: true,
						minlength: 2
					},			
				
				},
				messages: {
					U_USERNAME: "Please enter your username",
					U_PASSWORD: "Please enter your password",
          U_COUNTRY: {
						required: "Please enter a username"
						
					},					
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `invalid-feedback` class to the error element
					error.addClass( "invalid-feedback" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.next( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
				}
			} );

		} );



  //validation
  $(document).ready(function(){ 
    

    //$("#DashUserAddEdit_Form").submit(function(e) {

      //e.preventDefault(); // avoid to execute the actual submit of the form.

    //  var form = $(this);
      

    //}); 
    
  });
      $(document).on("click", "#DashUser_Delete", function(e) {
         var sysId = $(this).attr('data-id');
        bootbox.confirm("Are you sure you want to delete?", function(result) {

          if(result){
           
           $.ajax({
             type: "POST",
             url: "<?= site_url('Dashboard/DashUserDelete_Ajax'); ?>",
             data: {sysId : sysId} ,// serializes the form's elements.
             success: function(data)
             {
                 //alert(data); // show response from the php script.
                  $('.AlertMessage').html('<div  class="AlertMessage alert alert-success"><strong>Success!</strong> This alert box could indicate a successful or positive action.</div>') ;
                 setTimeout(function(){ 
                  $('.AlertMessage').html('') ;
                 }, 2000);
             },
             error: function (jqXHR, exception) {
              console.log(jqXHR);
                // Your error handling logic here..
              }  
           });
           $('#datatables').DataTable().ajax.reload();
            }

        }); 

    });
 
</script>

<!-- modal for add and edit -->
<div class="modal" id="DashUser_Modal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
             <div class="AlertMessageModal"></div> 
              <form mathod="POST" id="DashUserAddEdit_Form">            
              <div class="modal-body">              
                <div class="row">
                  <div class="col-sm-6">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="Name">Name</label>
                          <input type="text" class="form-control form-control-sm" id="U_USERNAME" placeholder="Username" name="U_USERNAME">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="password">Password</label>
                          <input type="text" class="form-control form-control-sm" id="U_PASSWORD" placeholder="Password" name="U_PASSWORD">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="gender">Gender</label>
                          <select class="form-control form-control-sm selectpicker border border-secondary" id="U_GENDER" data-live-search="true" name="U_GENDER">
                            <option>Male</option>
                            <option>Female</option>                            
                          </select> 
                          
                        </div>
                        <div class="form-group col-md-6">
                          <label for="email">Email</label>
                          <input type="email" class="form-control form-control-sm" placeholder="email" id="U_EMAIL" name="U_EMAIL">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="contact">Contact</label>
                          <input type="text" class="form-control form-control-sm"  placeholder="contact" id="U_CONTACT" name="U_CONTACT">
                        </div>                             
                      </div>
                      
                  </div>
                  <div class="col-sm-6"> 
                       <div class="form-group">
                          <label for="Address">Address</label>
                          <input type="text" class="form-control form-control-sm" id="U_ADDRESS" name="U_ADDRESS" placeholder="1234 Main St">
                        </div>                                         
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="country">Country</label>
                            <input type="text" class="form-control form-control-sm" id="U_COUNTRY" name="U_COUNTRY">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="State">State</label>
                            <input type="text" class="form-control form-control-sm" id="U_STATE" name="U_STATE">  
                          </div>
                          <div class="form-group col-md-6">
                            <label for="city">City</label>
                            <input type="text" class="form-control form-control-sm" id="U_CITY " name="U_CITY">
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
              <div class="col-md-6 ">             
              <input type="checkbox" value="Y" class="lcs_check" autocomplete="off" id="U_ACTIVE_YN"/>
              <input type="hidden" name="U_ACTIVE" value="Y"  id="U_ACTIVE"/>                            
              <label class="checkbox-inline text-left"> Active</label>
              </div>
              <div class="col-md-6 text-right">   
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
              </div>
            </form> 
            </div>
          </div>
        </div>
      </div>
      <!-- modal end for add edit -->
 