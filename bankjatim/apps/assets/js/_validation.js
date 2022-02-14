 document.addEventListener('DOMContentLoaded', function(e) {
	const form = document.getElementById('kt_form_crud');
	const fv   = FormValidation.formValidation(form,       			
        			 {
        				fields: {
        					user_id          : { validators: { notEmpty    : { message: 'Required.' },
        						                              stringLength: { min:3,max:100,message: 'Name min 3 character'},
                                                  regexp      : { regexp: /^[A-Za-z\/\s\.\,\']+$/,message: 'Name not contains number or symbol'} }},        					
        					nama          : { validators: { notEmpty    : { message: 'Required.' },
        						                              stringLength: { min:3,max:100,message: 'Name min 3 character'},
                                                  regexp      : { regexp: /^[A-Za-z\/\s\.\,\']+$/,message: 'Name not contains number or symbol'} }},							                              						                             
       					  nama_panggilan: { validators: { notEmpty    : { message: 'Required.' },
        						                              stringLength: { min:3,max:100,message: 'Isian Nama minimal 3 karakter huruf'},
                                                  regexp      : { regexp: /^[A-Za-z\/\s\.\,\']+$/,message: 'Isian Nama tidak boleh mengandung karakter angka dan simbol'} }},		
        					gender        : { validators: { notEmpty    : { message: 'Required.' }}},	
        					gol_darah     : { validators: { notEmpty    : { message: 'Required.' }}},	
        					agama         : { validators: { notEmpty    : { message: 'Required.' }}},		
        					hub_keluarga  : { validators: { notEmpty    : { message: 'Required.' }}},	
        					no_telp       : { validators: { notEmpty    : { message: 'Required.' },
        						                              digits      : { message: 'Isian No Telp berupa karakter angka'}, 
        						                              stringLength: { min:6,max:15,message: 'Isian No Telp minimal 6 karakter angka'}}},			
        					email         : { validators: { notEmpty    : { message: 'Required' },
        						                            	emailAddress: {	message: 'Not valid email address'}}},	
        					email_1         : { validators: { notEmpty    : { message: 'Required' },
        						                            	emailAddress: {	message: 'alamat email tidak valid'}}},	        						                            		
        					act_sts       : { validators: { notEmpty    : { message: 'Required.' }}},	
        					usr_grp_id    : { validators: { notEmpty    : { message: 'Required.' }}},		                            						                              					
        					alamat        : { validators: { notEmpty    : { message: 'Required.' },
        						                              stringLength: { min:10,max:150,message: 'Isian Alamat minimal 10 karakter huruf'}}},	
        					prov_id       : { validators: { notEmpty    : { message: 'Required.' }}},	
        					kabu_id       : { validators: { notEmpty    : { message: 'Required.' }}},	
        					keca_id       : { validators: { notEmpty    : { message: 'Required.' }}},	
        					desa_id       : { validators: { notEmpty    : { message: 'Required.' }}},		                              		
        					stat_penduduk	: { validators: { notEmpty    : { message: 'Required.' }}},	
        					nik         	: { validators: { notEmpty    : { message: 'Required.' }, 
        						                              digits      : { message: 'Isian NIK berupa karakter angka'}, 
        						                              stringLength: { min:16,message: 'Isian NIK berupa 16 digit angka'}}},	
        					no_kk        	: { validators: { notEmpty    : { message: 'Required.' }, 
        						                              digits      : { message: 'Isian No KK berupa karakter angka'}, 
        						                              stringLength: { min:16,message: 'Isian No KK berupa 16 digit angka'}}},	
        					tempat_lahir	: { validators: { notEmpty    : { message: 'Required.' },
        						                              stringLength: { min:3,max:100,message: 'Isian Nama minimal 3 karakter huruf'},
                                                  regexp      : { regexp: /^[A-Za-z\/\s\.\,\']+$/,message: 'Isian Nama tidak boleh mengandung karakter angka dan simbol'} }},							                              						                             							
        					tgl_lahir	    : { validators: { notEmpty    : { message: 'Required.' }}},			
        					nama_ayah	    : { validators: { notEmpty    : { message: 'Required.' },
        						                              stringLength: { min:3,max:100,message: 'Isian Nama minimal 3 karakter huruf'},
                                                  regexp      : { regexp: /^[A-Za-z\/\s\.\,\']+$/,message: 'Isian Nama tidak boleh mengandung karakter angka dan simbol'} }},							                              						                             									
        					nama_ibu      : { validators: { notEmpty    : { message: 'Required.' },
        						                              stringLength: { min:3,max:100,message: 'Isian Nama minimal 3 karakter huruf'},
                                                  regexp      : {regexp: /^[A-Za-z\/\s\.\,\']+$/,message: 'Isian Nama tidak boleh mengandung karakter angka dan simbol'} }},							                              						                             							
        					warga_negara  : { validators: { notEmpty    : { message: 'Required.' }}},		
        					stat_kawin    : { validators: { notEmpty    : { message: 'Required.' }}},	
        					nama_keluarga_darurat : { validators: { notEmpty    : { message: 'Required.' },
        						                              stringLength: { min:3,max:100,message: 'Isian Nama minimal 3 karakter huruf'},
                                                  regexp      : { regexp: /^[A-Za-z\/\s\.\,\']+$/,message: 'Isian Nama tidak boleh mengandung karakter angka dan simbol'} }},	        											
        					telp_keluarga_darurat : { validators: { notEmpty    : { message: 'Required.' },
        						                              digits      : { message: 'Isian No Telp berupa karakter angka'}, 
        						                              stringLength: { min:6,max:15,message: 'Isian No Telp minimal 6 karakter angka'}}},
        					hub_keluarga_darurat : { validators: { notEmpty    : { message: 'Required.' }}},		

                  pword: {
                      validators: {
                          notEmpty: {
                              message: 'The password is required',
                          },
                      },
                  },
                  pword_check: {
                      validators: {
                          notEmpty: {
                              message: 'The confirm Password is required',
                          },                            	
                          identical: {
                              compare: function () {
                                  return form.querySelector('[name="pword"]').value;
                              },
                              message: 'The password and its confirm are not the same',
                          },
                      },
                  },        					                              	                                                  	
        				},

        				plugins: { //Learn more: https://formvalidation.io/guide/plugins
        					trigger: new FormValidation.plugins.Trigger(),
        					// Bootstrap Framework Integration
        					bootstrap: new FormValidation.plugins.Bootstrap(),
        					// Validate fields when clicking the Submit button
        					submitButton: new FormValidation.plugins.SubmitButton(),
                    		// Submit the form when all fields are valid
                    	//	defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        				}
        			 }
        		)
    
   .on('core.element.validated', function(e) {
      // e.element presents the field element
      // e.valid indicates the field is valid or not
      
      // Get the validator options
      const validators = fv.getFields()[e.field].validators;

      // Check if the field has 'notEmpty' validator
      if (validators && validators['notEmpty']
          && validators['notEmpty'].enabled !== false) {
          return;
      }

      // Get the field value
      const value = fv.getElementValue(e.field, e.element);
      if (e.valid && value === '') {
          // Now the field is empty and valid
          // Remove the success color from the container
          const container = FormValidation.utils.closest(e.element, '.has-success');
          FormValidation.utils.classSet(container, {
              'has-success': false
          });

          // Remove 'is-valid' class from the field element
          FormValidation.utils.classSet(e.element, {
              'is-valid': false
          });
      }
    }) 
    
   .on('core.form.invalid', function() {
     showMessage('Ooops...', 'Please check, have an empty require information or not allow.', '', 'btn btn-danger'); 
    });            			
}); 