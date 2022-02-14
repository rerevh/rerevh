<?php
/* Smarty version 3.1.33, created on 2022-01-27 02:47:08
  from 'C:\xampp\htdocs\Bank_Jatim\apps\application\views\career\home.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61f1a53c221f43_11631752',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b739aef8e672714810985e9078a203f0929f9b38' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Bank_Jatim\\apps\\application\\views\\career\\home.html',
      1 => 1643226283,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../dfJobModal_window.html' => 1,
    'file:../dfPersonModal_window.html' => 1,
  ),
),false)) {
function content_61f1a53c221f43_11631752 (Smarty_Internal_Template $_smarty_tpl) {
?><!--begin::Page Vendors Styles(used by this page)-->
<link href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<!--end::Page Vendors Styles-->  
<style>
#float {
        position: fixed;
        top: 3em;
        right: 2em;
        z-index: 100;
    }
    
.fixedContainer {
  position: fixed;
  width:100%;

  top: 14%;
 
}    
</style>
<!-- .dataTables_scrollHeadInner{  width:100% !important; } !-->
<!--begin::Card-->

	<div>
		

 					               
        <div id="find_parameter" class="row col-lg-12 mt-0" >	
						<div class="col-lg-1">
						</div>	        						
				  	<div class="col-lg-4 mt-3">

              <div class="col">
                <div class="row">
                	<p>Please select find method</p>
                </div>
                <div class="row">
       							<div class="radio-inline mb-3">        								
       								<label class="radio radio-solid font-weight-bold">
       									<input class="form-control" type="radio" id="find_method" name="find_method" checked value="1"/>
       									<span></span>
       									Job To Person
       								</label>								
       								<label class="radio radio-solid font-weight-bold">
       									<input class="form-control" type="radio" id="find_method" name="find_method" value="2"/>
       									<span></span>
       									Person To Job
       								</label>
       								<label class="radio radio-solid font-weight-bold">
       									<input class="form-control" type="radio" id="find_method" name="find_method" value="3"/>
       									<span></span>
       									Job To Job
       								</label>								
       							</div>    
                </div>
              </div>				  		
  				  			
						</div>																				

						<div class="col-lg-4">	
						<div style="display:block" id="find_job_list">										
				     	<select class="form-control" id="job_id" name="job_id" style="width:100% !important"></select><!-- form-control-select2 !-->
				    	<span class="form-text text-muted mb-2">Please enter job position</span> 	
						</div>
						<div style="display:none" id="find_person_list">
				     	<select class="form-control" id="employee_id" name="employee_id" style="width:100% !important"></select> <!-- form-control-select2 !-->
				    	<span class="form-text text-muted mb-2">Please enter person</span> 	
						</div>							
						</div>	
            <div class="row col-lg-3">           	
                <div class="col-lg-12">
                  <div>
                    <div class="row">
                      <div class="ml-2">
                      	<button type="submit" class="btn btn-primary mr-2 mb-2" id="findJobsubmitButton" name="findJobsubmitButton">Search</button> 
                      </div>
                      <div class="ml-2">
                      	<button type="button" class="btn btn-light-primary mr-2 mb-2" id="clearJobsubmitButton" name="clearJobsubmitButton" style="display:none">Clear Result</button> 
                      </div>
                    </div>	  		
                  </div>
                  <div>
                    <div class="checkbox-list mb-1" id="show_parameter_check" name="show_parameter_check">                      
                    <label class="checkbox">
                        <input class="form-control" type="checkbox" id="show_parameter" name="show_parameter" value="0" checked/>
                        <span></span>
                        <label class="font-weight-bold mt-2">Parameter Details</label>                    
                    </label>	
                   </div>                   	
                  	
                  </div>
                </div>	            	

      			   
      			</div> 											
					  
				</div>	

		 <div id="param_setting" class="row col-lg-12 align-items-center justify-content-center">                  		 	
   			<div class="col-lg-10 align-items-center mb-9 text-white bg-light-green rounded" style="display:block">             
     			<form class="form" id="findjob_dialog"> 
     				  <input class="form-control" type="hidden" id="hide_result" name="hide_result">  
     			  	<input class="form-control" type="hidden" id="method_selected" name="method_selected">  
     				  <input class="form-control" type="hidden" id="comp_type" name="comp_type">      				
   				    <input class="form-control" type="hidden" id="tool_method" name="tool_method">
   				    <input class="form-control" type="hidden" id="find_key" name="find_key">	
              <input class="form-control" type="hidden" id="j2pres" name="j2pres">	 
              <input class="form-control" type="hidden" id="p2jres" name="p2jres">	
              <input class="form-control" type="hidden" id="j2jres" name="j2jres">	        	        	
               <div class="row mt-4 mb-4">
                 <div id="p_left" class="col-lg-12">
                     <div class="row">
                     	  <input class="form-control" id="size_method_selected" name="size_method" type="hidden">
           							<div class="radio-inline ml-6 mt-2 mb-3">        								
           								<label class="radio radio-solid mr-7">
           									Size method:
           								</label>								
           								<label class="radio radio-solid font-weight-bold mr-15">
           									<input class="form-control" type="radio" id="size_method" name="size_method_option" checked value="1"/>
           									<span></span>
           									Esselon
           								</label>
           								<label class="radio radio-solid font-weight-bold">
           									<input class="form-control" type="radio" id="size_method" name="size_method_option" value="2"/>
           									<span></span>
           									Grade
           								</label>								
           							</div>                  	
                     </div>                 	                 	
                     <div id="p_left_up" class="row">

                         <div class="col-lg-4" id="target_to_find" style="display:none;">
                             <div class="checkbox-list mt-0" id="current_grade_on_target_check"
                                  name="current_grade_on_target_check" style="display:block">
                                 <input class="form-control" id="include_on_target" name="include_on_target"
                                        type="hidden">
                                 <label class="checkbox">
                                     <p class="ml-2 mr-3">Target size [+]:</p>
                                     <input class="form-control" disabled id="current_grade_on_target"
                                            name="current_grade_on_target" type="checkbox" value="0"/>
                                     <span class="mb-4"></span>
                                     <p class="mr-3">Include same size </p>
                                 </label>
                             </div>

                             <div class="input-group">
                                 <input class="form-control" id="grade_target" name="grade_target" type="text" style="background-color:#c1c6cb;" value="1"/>
                             </div>
                         </div>


                         <div class="col-lg-4" id="feed_to_find">
                             <div class="checkbox-list mt-0" id="current_grade_on_feed_check"
                                  name="current_grade_on_feed_check" style="display:block">
                                 <input class="form-control" id="include_on_feed" name="include_on_feed" type="hidden">
                                 <label class="checkbox">
                                     <p class="ml-2 mr-3">Feeder size [-]:</p>
                                     <input class="form-control" disabled id="current_grade_on_feed"
                                            name="current_grade_on_feed" type="checkbox" value="0"/>
                                     <span class="mb-4"></span>
                                     <p class="mr-3">Include same size </p>
                                 </label>
                             </div>

                             <div class="input-group">
                                 <input class="form-control" id="grade_feed" name="grade_feed" type="text" style="background-color:#c1c6cb;" value="1"/>
                             </div>
                         </div>
           						
           						<div id="percent_to_find" class="col-lg-4">	
           							<label>Match Percentage:</label>
           							<div style="display:block" id="percent_comp">
             							<div class="input-group mt-2">																			
             								 <input type="text" class="form-control" value="0" id="percent_compability" name="percent_compability"/>		
             							</div>							
           							</div>
           						</div>    
           						<!--
           						<div id="tmt_to_find" class="col-lg-4">	
           							<label>TMT Grade:</label>
           							<div style="display:block" id="percent_comp">
             							<div class="input-group mt-2">																			
             								 <input type="text" class="form-control" value="0" id="tmt_grade" name="tmt_grade"/>		
             							</div>							
           							</div>
           						</div> 
           						!-->               						                    
                     </div>
                     <div id="p_left_down" class="row">
           						<div id="performance_to_find" class="col-lg-6 mt-3">
           							<label>Performance Expectation:</label>
           							<div style="display:block" id="perform_level">
           								<input class="form-control" type="hidden" id="performance_level" name="performance_level">
                           <div class="checkbox-inline mt-2">
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="perform_level_check" name="perform_level_check" value="1"/>
                                   <span></span>Poor
                               </label>
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="perform_level_check" name="perform_level_check" value="2"/>
                                   <span></span>Below
                               </label>
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="perform_level_check" name="perform_level_check" value="3"/>
                                   <span></span>Meet
                               </label>
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="perform_level_check" name="perform_level_check" value="4"/>
                                   <span></span>Exceed 
                               </label>
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="perform_level_check" name="perform_level_check" value="5"/>
                                   <span></span>Outstanding
                               </label>                              
                           </div>						
           							</div>
           						</div>
           						
           						<div id="assessment_to_find" class="col-lg-4 mt-3">
           							<label>Assessment:</label>
           							<div style="display:block" id="assessment_">
           							 <input class="form-control" type="hidden" id="assessment" name="assessment">
                          <div class="checkbox-inline mt-2">
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="assessment_check" name="assessment_check" value="1"/>
                                   <span></span>Low
                               </label>
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="assessment_check" name="assessment_check" value="2"/>
                                   <span></span>Medium
                               </label>
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="assessment_check" name="assessment_check" value="3"/>
                                   <span></span>High
                               </label>                              
                           </div>							
           							</div>
           						</div> 
           						<input class="form-control" type="hidden" id="talentbox" name="talentbox">
           						<!--
           						<div id="talent_box_to_findx" class="col-lg-4 mt-3">	
           							<label>Talent Box:</label>
           							<div style="display:block" id="talent_box">
           								
                           <div class="checkbox-inline mt-2">
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="talent_box_check" name="talent_box_check" value="1"/>
                                   <span></span>1
                               </label>
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="talent_box_check" name="talent_box_check" value="2"/>
                                   <span></span>2
                               </label>
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="talent_box_check" name="talent_box_check" value="3"/>
                                   <span></span>3
                               </label>
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="talent_box_check" name="talent_box_check" value="4"/>
                                   <span></span>4
                               </label>
                               <label class="checkbox checkbox-square mr-5 mb-2">
                                   <input class="form-control" type="checkbox" id="talent_box_check" name="talent_box_check" value="5"/>
                                   <span></span>5
                               </label>                                  
                           </div>						
           							</div>
           						</div>    
           						!-->    						                        	
                     </div>
                 </div>

               </div> 				  
     		  
     			</form>           			    	  					
   			</div>			                     	                     		
		 </div> 	
		   		 			
		 <div id="find_result" class="row col-lg-12 align-items-center justify-content-center">  					              	         
        <div class="container" align="center" style="display:none;" id="start_processs">
        	 <img src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/media/misc/seacrh.gif" /> 
        </div>	
        
  			<div class="p-2 col-lg-10 align-items-center justify-content-center bg-soft-light-green rounded" style="display:none" id="j2p_found_desc">                			  	
            <div class="col mt-5 mb-5"> 
              <table border=0 cellpadding="2" width="100%" class="text-white">
              	<tr valign="top" class="h6 text-white mt-4 font-weight-bold"><td width="45%" colspan=3>Job Attribute</td><td width="10%" rowspan=5>&nbsp;</td><td width="45%" colspan=3>Incumbent</td></tr>
              	<tr valign="top"><td width="10%">Job Title</td><td width="1%" align="center">:</td><td width="34%" id="jp_jobselected_title"></td><td width="10%">Person Name</td><td width="1%" align="center">:</td><td width="34%" id="jp_jobselected_title2"></td></tr>
                <tr valign="top"><td>Job Unit</td><td align="center">:</td><td id="jp_jobselected_location"></td><td>Person NIP</td><td align="center">:</td><td id="jp_jobselected_nip"></td></tr>
                <tr valign="top"><td>Job Grade</td><td align="center">:</td><td id="jp_jobselected_grade"></td><td>Person Grade</td><td align="center">:</td><td id="jp_jobselected_grade2"></td></tr>
                <tr valign="top"><td>Job Family</td><td align="center">:</td><td id="jp_jobselected_sg"></td><td>Job Family</td><td align="center">:</td><td id="jp_jobselected_sg2"></td></tr>
              </table>                			  	
            </div>	                                                                             		                    	                    
        </div>                  

				<div class="container col-lg-12 align-items-center" data-scroll="false" data-height="500" style="display:none" id="j2p_result">
          <div class="text-dark-50 mb-0">
            <div id="j2p_breadcrumb" style="display:none"></div>	
          </div>			                    					 
          <div class="form-group row" id="j2p_content" style="display:block" data-scroll="false" data-height="500">                  					
            <div class="row">
              <div class="col ml-5 mt-3 mr-5">
    						<label class="h4 text-dark text-hover-primary mt-3 mb-2" id="jp_person_match">Found Result :</label>                      						
              </div>
              <div class="col-3 ml-15 mt-3 mr-5" align="right" >
                <div id="j2p_export_button"></div>
              </div>
            </div>  
 						<div class="col-lg-12 mt-0">
            		<div id="jp_data_target">
            	    <table class="table table-striped table-bordered display nowrap table-hover" id="j2p_personfeed_dt" style="width:100% !important;">  
                  </table>  	    
          	    </div>	
  					</div>
          </div>                    					 	                  					 
				</div>	     
				             
			  <div class="p-2 col-lg-10 align-items-center justify-content-center bg-soft-light-green rounded" style="display:none" id="p2j_found_desc"> 
          <div class="col mt-5 mb-5"> 
            <table border=0 cellpadding="2" width="100%" class="text-white">
            	<tr valign="top" class="h6 text-white mt-4 font-weight-bold"><td width="45%" colspan=3>Incumbent</td><td width="10%" rowspan=5>&nbsp;</td><td width="45%" colspan=3>Job Attribute</td></tr>
            	<tr valign="top"><td width="10%">Person Name</td><td width="1%" align="center">:</td><td width="34%" id="pj_jobselected_title2"></td><td width="10%">Job Title</td><td width="1%" align="center">:</td><td width="34%" id="pj_jobselected_title"></td></tr>
              <tr valign="top"><td>Person NIP</td><td align="center">:</td><td id="pj_jobselected_nip"></td><td>Job Unit</td><td align="center">:</td><td id="pj_jobselected_location"></td></tr>
              <tr valign="top"><td>Person Grade</td><td align="center">:</td><td id="pj_jobselected_grade2"></td><td>Job Grade</td><td align="center">:</td><td id="pj_jobselected_grade"></td></tr>
              <tr valign="top"><td>Job Family</td><td align="center">:</td><td id="pj_jobselected_sg2"></td><td>Job Family</td><td align="center">:</td><td id="pj_jobselected_sg"></td></tr>
            </table>                			  	
          </div>	                			  	                 			  	
			  </div>	  
      			                                               		                  	
				<div class="container col-lg-12 align-items-center justify-content-center" data-scroll="false" data-height="500" style="display:none" id="p2j_result">
        	<div class="row"> 
        		  <div class="col-lg-6 text-dark-50 mb-0">
        		    <div id="p2j_breadcrumb" style="display:block">
        		    </div>	                    		  	
        		  </div>	                    		                      			
              <div class="col-lg-2 checkbox-list mt-2" id="show_pj_result1_check" name="show_pj_result1_check">                      
                <label class="checkbox">
                    <input class="form-control" type="checkbox" id="show_pj_result1" name="show_pj_result1" value="0" checked/>
                    <span></span>Show Job Match                                
                </label>	
              </div>                                      			             			
              <div class="col-lg-3 checkbox-list mt-2" id="show_pj_result2_check" name="show_pj_result2_check">                      
                <label class="checkbox">
                    <input class="form-control" type="checkbox" id="show_pj_result2" name="show_pj_result2" value="0"/>
                    <span></span>Show Person Feed Match                                
                </label>	
              </div>                                     			                  		
          </div>                         
				  			                    					 
          <div class="form-group row" id="p2j_content" style="display:block" data-scroll="false" data-height="500">  
            <div class="form-group row">                      	                       
   						  <div class="col-lg-12 mt-0" id="pj_result1" name="pj_result1">
   						  	
                  <div class="row">
                    <div class="col ml-5 mt-3 mr-5">
      						    <label class="h4 text-dark text-hover-primary mt-5 mb-2" id="pj_person_match">Found Result :</label>                      						
                    </div>
                    <div class="col-3 ml-15 mt-3 mr-5" align="right" >
                      <div id="p2j_job_export_button"></div>
                    </div>
                  </div>                 						  	
  				        

              		<div id="pj_data_target" class="mb-5">
              	    <table class="table table-striped table-bordered display nowrap table-hover" id="p2j_jobtarget_dt"  style="width:100% !important;">  
                    </table>  	    
            	    </div>	
    						</div>
    						 
    						<div class="col-lg-6 mt-0" id="pj_result2" name="pj_result2" style="display:none">
   						  	
                  <div class="row">
                    <div class="col ml-5 mt-3 mr-5">
        					  	<label class="h4 text-dark text-hover-primary mt-5 mb-2" id="pj_jobfeed_found">Found Result :</label> 
                    </div>
                    <div class="col-3 ml-15 mt-3 mr-5" align="right" >
                      <div id="p2j_person_export_button"></div>
                    </div>
                  </div>                  							
    							
        					 
              		<div id="pj_data_feeder">
              	    <table class="table table-striped table-bordered display nowrap table-hover" id="p2j_personfeed_dt" style="width:100% !important;">  
                    </table>  	    
            	    </div>	
    						</div>    
            </div>                                              	                     
          </div>                    					 	                  					 
				</div>	
				          				                          
  			<div class="p-2 col-lg-10 align-items-center justify-content-center bg-soft-light-green rounded" style="display:none" id="j2j_found_desc">                			  	
            <div class="col mt-5 mb-5"> 
              <table border=0 cellpadding="2" width="100%" class="text-white">
              	<tr valign="top" class="h6 text-white mt-4 font-weight-bold"><td width="45%" colspan=3>Job Attribute</td></tr>
              	<tr valign="top"><td width="10%">Job Title</td><td width="1%" align="center">:</td><td width="89%" id="jj_jobselected_title"></td></tr>
                <tr valign="top"><td>Job Unit</td><td align="center">:</td><td id="jj_jobselected_location"></td></tr>
                <tr valign="top"><td>Job Grade</td><td align="center">:</td><td id="jj_jobselected_grade"></td></tr>
                <tr valign="top"><td>Job Family</td><td align="center">:</td><td id="jj_jobselected_sg"></td></tr>
              </table>                			  	
            </div>	                                                                             		                    	                    
        </div>                        
                                                   
				<div class="container col-lg-12 align-items-center justify-content-center" data-scroll="false" data-height="500" style="display:none" id="j2j_result">	
        	<div class="row"> 
        		  <div class="col-lg-6 text-dark-50 mb-0">
        		    <div id="j2j_breadcrumb" style="display:block">
        		    </div>	                    		  	
        		  </div>	                    		                     			
              <div class="col-lg-2 checkbox-list mt-2" id="show_jj_result1_check" name="show_jj_result1_check">                      
                <label class="checkbox">
                    <input class="form-control" type="checkbox" id="show_jj_result1" name="show_jj_result1" value="0" checked/>
                    <span></span>Show Job Target                                 
                </label>	
              </div>                                      			                     			
              <div class="col-lg-3 checkbox-list mt-2" id="show_jj_result2_check" name="show_jj_result2_check">                      
                <label class="checkbox">
                    <input class="form-control" type="checkbox" id="show_jj_result2" name="show_jj_result2" value="0"/>
                    <span></span>Show Job Feeder                                
                </label>	
              </div>                                     			                    		
          </div>                         
				  	            				  	                      		                    					 
          <div class="form-group row" id="j2j_content" style="display:block" data-scroll="false" data-height="500">                  					
             <div class="form-group row">
   						  <div class="col-lg-12 mt-0" id="jj_result1" name="jj_result1">
                  <div class="row">
                    <div class="col ml-5 mt-3 mr-5">
      						    <label class="h4 text-dark text-hover-primary mt-5 mb-2" id="jj_jobtarget_found">Found Result :</label>                      						   
                    </div>
                    <div class="col-3 ml-15 mt-3 mr-5" align="right" >
                      <div id="j2j_target_export_button"></div>
                    </div>
                  </div>                                           					  
              		<div id="jj_data_target" class="mb-5">
              	    <table class="table table-striped table-bordered display nowrap table-hover" id="j2j_jobtarget_dt"  style="width:100% !important;">  
                    </table>  	    
            	    </div>	
    						</div>
    						 
    						<div class="col-lg-6 mt-0" id="jj_result2" name="jj_result2" style="display:none"> 
                  <div class="row">
                    <div class="col ml-5 mt-3 mr-5">
        					  	<label class="h4 text-dark text-hover-primary mt-5 mb-2" id="jj_jobfeed_found">Found Result :</label>  
                    </div>
                    <div class="col-3 ml-15 mt-3 mr-5" align="right" >
                      <div id="j2j_feed_export_button"></div>
                    </div>
                  </div>                     					 
              		<div id="jj_data_feeder">
              	    <table class="table table-striped table-bordered display nowrap table-hover" id="j2j_jobfeed_dt" style="width:100% !important;">  
                    </table>  	    
            	    </div>	
    						</div>    
             </div>              						
          </div>                    					 	                  					 
				</div>	     
		        							          
     </div>                
	</div>
  <?php $_smarty_tpl->_subTemplateRender('file:../dfJobModal_window.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  <?php $_smarty_tpl->_subTemplateRender('file:../dfPersonModal_window.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<!--end::Card-->
   
<!--begin::Page Vendors(used by this page)-->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/js/validation.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/custom/datatables/datatables.bundle.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
  var KTAppSettings = { "breakpoints":{ "sm":576,"md":768,"lg":992,"xl":1200,"xxl":1400}};            
<?php echo '</script'; ?>
>

<!--end::Page Vendors-->





<?php }
}
