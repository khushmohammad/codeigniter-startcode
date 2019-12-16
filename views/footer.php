<script type="text/javascript"> 


//today date
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd;
    } 
    if (mm < 10) {
      mm = '0' + mm;
    } 
 var today = dd + '/' + mm + '/' + yyyy;  
///
function datepickerDob(id){

 $('#'+id).datepicker({ gainFocusOnConstruction: false, markup: 'bootstrap4', 
  outputFormat: 'dd/MM/yyyy',
  max: today,
  });
}
function datepicker(id){

 $('#'+id).datepicker({ gainFocusOnConstruction: false, markup: 'bootstrap4', 
  outputFormat: 'dd/MM/yyyy' 
  });
}



 function linesSwitchery(activeYn,activeId) {
          $('.lcs_check').lc_switch('Y', 'N');
          $('.lcs_wrap').delegate('#'+activeYn, 'lcs-on', function() {
          $('#'+activeId).val('Y');
          });
          $('.lcs_wrap').delegate('#'+activeYn, 'lcs-off', function() {
            $('#'+activeId).val('N');            
          });
        } 

 function State_List(countryId,stateId,cityId){
     $('#'+countryId).change(function(){
         $('#'+cityId).html('<option value="" selected> select </option>');
         var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('Dashboard/Get_StateList_Ajax');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){                        
                        var html = '';
                        var i;
                        if(!data.length == ''){ 
                           html += '<option value="">Select</option>';
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].ST_ID+'>'+data[i].ST_NAME+'</option>';
                        }
                      }else{
                            html += '<option value="">Select</option>';

                      }
                        $('#'+stateId).html(html);
                      
                    }
                });
                return false;

      });
  }   
function City_List(stateId,cityId){
       $('#'+stateId).change(function(){
         $('#'+cityId).html('<option value="" selected> select </option>');
         var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('Dashboard/Get_CityList_Ajax');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){                        
                        var html = '';
                        var i;
                        if(!data.length == ''){
                           html += '<option value="">Select</option>';
                        for(i=0; i<data.length; i++){

                            html += '<option value='+data[i].CT_ID+'>'+data[i].CT_NAME+'</option>';
                        }
                      }else{
                            html += '<option value="">Select</option>';                       
                      }
                       $('#'+cityId).html(html);
                    }
                });
                return false;
      });
   }
  function InputContact_flag(Input_id){
     var input = document.querySelector("#"+Input_id);
     var iti = intlTelInput(input, {
        initialCountry: "IN",
        utilsScript: "<?php echo site_url('assets/plugins/build/js/utils.js');?>",
      });
   }

</script>
</div>
 <!-- /.container-fluid -->
<!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

</div>
    <!-- /.content-wrapper -->


<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<script src="<?= site_url('assets/js/custom.js');?>"></script>
<script src="<?= site_url('assets/vendor/js/sb-admin.min.js');?>"></script> 

  </body>
</html>
