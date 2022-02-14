<section class="panel panel-faster">
	<div>
        <ul class="nav nav-tabs nav-faster" role="tablist">
          	<li role="presentation" id="view2">
          		<a href="<?php echo site_url('plan/activity-budget')?>" >
          			<i class="icon-magnifier-add"></i>
          			Unprocessed
          		</a>
      		</li>
          <li role="presentation" class="active">
          		<a href="<?php echo site_url('plan/activity-budget-processed')?>" >
          			<i class="icon-magnifier-add"></i>
          			Processed
          		</a>
      		</li>       		
          <li role="presentation">
              <a href="<?php echo site_url('plan/activity-budget-submited')?>">
                  <i class="icon-list"></i>
                  Submited
              </a>
          </li>     
          <li role="presentation">        	
              <a href="<?php echo site_url('plan/activity-budget-approved')?>">
                  <i class="icon-list"></i>
                  Approved
              </a>
          </li>  
          <li role="presentation">
              <a href="<?php echo site_url('plan/activity-budget-rejected')?>">
                  <i class="icon-list"></i>
                  Rejected
              </a>
          </li>                       		
        </ul>
        <div class="tab-content">
            <table class="table table-bordered table-striped table-form " id="table-view-activity-process" 
            	data-url='Plan/Input_activity/activity_budget_processed' style='width:100% !important;'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th width='165px'>TOR Number</th>
                        <th>Project</th>
                        <th>Charge Code(s)</th>
                        <th>TOR<br />Description</th>
                        <th>Submited by</th>
                        <th>TOR Approved Date</th>
                        <th>Total Budget Estimated</th>
                        <th>Action</th>
                    </tr>
                </thead>
              <tbody>                
              </tbody>
            </table>
        </div>
    </div>
</section>

<script>
	

	
    document.onreadystatechange = () => {
        if (document.readyState === 'complete') {
            $(document).on('click', '.submit-activity', function (e) {
            	
                e.preventDefault();
                var status = $(this).attr('data-status');
                var direct_fund_code = $(this).attr('data-directfund');
                var tor_number = $(this).attr('tor_number');

                    const form = `
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel" style="font-weight: 600"><i class="fa fa-edit"></i> Submit Proposal to Finance</h4>
                                    </div>
                                    <div class="modal-body text-center">
                        							<img src='https://w7.pngwing.com/pngs/398/1004/png-transparent-newsletter-email-marketing-business-electronic-mailing-list-email-miscellaneous-text-orange.png'
                        								style='width:100px' />
                        							<center><form action="" class="form-horizontal">
                        								<div class="form-group">
                        									<select class="form-control mb-3" name='email' id='email' style='width:80% !important;'>
                        										<option value=''>Select Manajer Email Account</option>
                        										<option value='NHardiyanto@fhi360.org'>Nico Hardiyanto</option>
                        									</select>
                        								</div>
                        							</form></center>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button id="reason-btn" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        `;

                    $('#myModal').html(form).modal('show');
                    
                    $(document).on('click', '#reason-btn', function (e) {
                    	if ($('#email').val() != '') {
  var formData = {
      id: tor_number,
      email: $("#email").val(),
    };                    		
                    		
                        $('#myModal').modal('hide');
                        const reason = $('#reason').val()
                        Swal.fire({
                            title: 'Confirm ?',
                            text: "Are you sure you want to submit the activity budget ?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, submit it!'
                        }).then((result) => {
                            if (result.value === true) {
                                // console.log(status,direct_fund_code,reason)
                             		$.ajax({
                             		   type:'get',
                             		   url:base_url+'Plan/Monthly_activity_new/submit_to_finance',
                             		   data:formData,
                             		   dataType:'json',
                             		   beforeSend:function(){
                             			 // $this.html("<i class='fa fa-spin fa-spinner'></i>");
                             		   },
                             		   success:function(res){
                             			  if(res.success){
                             				// $this.addClass("remove_to_fav badge-error")
                             				// .removeClass('add_to_fav badge-success')
                             				// .html("<i class='fa fa-close font-danger '></i>  Remove")
                             				 notifikasi('Submit to finance sucess...')
                             			  } else {
                             				 notifikasi('Submit to finance fail...',0)
                             			  }
                             		   }
                             		})   
                            }
                        });                    		
                    	} else {
                              swal.fire({
                                  title: 'Oops',
                                  text: "please select email to submit activity budget!",
                                  type: 'warning',
                              });                    		
                    	}
                    })                    

               
            });
            
        }
    }
</script>