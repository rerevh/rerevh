var dataForm, elements;
var uploadLibDefSts = false; 

function renderForm(app,form_name,const_) {
	//alert(app+'-'+form_name+'-'+const_)
  $.ajax({
    dataType: "json",
    url: API_host+'pub/fillReference?token='+token+'&form_name='+form_name,
    beforeSend: function () {   
      blockPageSet('Mempersiapkan form input');      	
    },
    success: function (resp) {   	
      $.each(resp.data, function(k, v){
        filter  = v.filter; 
        value   = v.value; 
        disable = false; 
   	   
        fillReference(v.form_object, v.table, filter, $('#'+v.target), v.colset, value, disable);
       
      });
      blockPage('off'); 

      
    	$('.datepicker').datepicker({
        toggleActive: !0,
        format: "dd-mm-yyyy",
        autoclose: !0,
      	todayHighlight: !0
      })   
    }
  });	 	
} 

function renderDataForm(form_id,data,fileObjIds,act,stat){  	
	var jsonData = JSON.parse(JSON.stringify(data));
	//alert(JSON.stringify(data));

  var elements = document.forms[form_id].elements
  for( var i = 0, l = elements.length; i < l; i++ ) {
  //	alert(elements[i].id+'-->'+elements[i].type+'-->'+jsonData[elements[i].id]);
    dataField    = (jsonData[elements[i].id] != null) ? jsonData[elements[i].id] : '';
    element_id   = elements[i].id;   
    element_type = elements[i].type; 
    switch(true) {
      case (element_type == 'select-one'):             
          switch(true) {
            case (element_id == 'actsts'):  	  
                fillReference(element_type, 'code_'+element_id, '', $('#'+element_id), null, dataField, false); 
              break;  
            default:
              fillReference(element_type, element_id, '', $('#'+element_id), null, dataField, false);                 
          }            
        break;  
      case (element_type == 'hidden'):  	             
         	$('#'+element_id).val(dataField);	 
         	$('#'+element_id).trigger('change');        
        break;           
      case ((element_type == 'text') || (element_type == 'email')):  
       	      
          $('#'+element_id).val(dataField); 
         	$('#'+element_id).trigger('change');        
        break;                    
    }  
      
  }  
}	

function changeAction(type,element_id,val){
  //alert('re-check '+element_id+'->'+val);
 	if(type == 'select-one'){
 		//alert('re-check '+element_id+'->'+val);
 		selected_val         = $('#'+element_id+' option:selected').val();
 		dataForm[element_id] = (selected_val != '') ? selected_val : '0';
 		if ((dataForm[element_id] != '') || (dataForm[element_id] != undefined) || (dataForm[element_id] != null)) {
 			// alert(element_id+'->'+dataForm[element_id]);
      
      $('.form-control-select2').select2({
        language: {
          noResults: function (params) {
            return "No Data";
          }
        }
      });	   		
 	  };
 	} else if(type == 'text' || type == 'hidden' || type == 'textarea' || type == 'email' || type == 'date' || type == 'number' || type == 'password'){
 		//alert(element_id+' - '+dataForm[id]);
    dataForm[element_id] = $('#'+element_id).val();
 	};
 	//alert(id+' what ->'+dataForm[id]);	
}	
      
function fillReference(compType, refType, filter, jQueryObj, colSet, selID, disabled){  

	var uri = '';
	var uri = API_host+"pub/reference?token="+token+"&ref="+refType;
	sorted = '&sorted=';
	//filter = (filter != '') ? filter : '';
  uri += sorted; 
	$.getJSON(uri, function(resp) {
      //if(resp.message == 'success'){ 
        switch(true) {
          case (compType =='select-one'):
         // alert(compType+' - '+refType+' - '+filter+' - '+jQueryObj+' - '+colSet+' - '+selID+' - '+disabled);
            var opt = '<option value=""></option>';
        		$.getJSON(uri, function(resp) {
               if(resp.message == 'success'){
                 $.each(resp.data, function(k, v){
          				if(selID == v.id)
          					opt += "<option value="+v.id+" selected='selected'>"+v.text+"</option>";
          				else opt += "<option value="+v.id+">"+v.text+"</option>";
  				       });
        				 jQueryObj.html(opt);
        				 if (disabled == true) {
        				 	jQueryObj.prop("disabled", true );
        				 }      
        				 jQueryObj.trigger('change');  	
        				 //alert(refType);
                 $(jQueryObj).select2({
                    placeholder: 'Select One'
                 });        				 	 	          				 
               };
            });
            break;    
          case ((compType == 'radio') || (compType == 'checkbox')) :  
            if (compType == 'checkbox') {
              var res = selID.split("|");
              selID ='';
              for (i = 0; i < res.length; i++) {                     	   	
              	if (res[i] != '') {
              		selID += "'"+res[i]+"'|" 
              	}                   	 
              }             	
            }        
 	            	  	          
            vRow ='<div class="checkbox-inline mb-2"><table border=0 ><tr><td>';    	 
            $.each(JSON.parse(JSON.stringify(resp.data)), function(k, v){ 	

                if (compType == 'checkbox') {
                	checkedBox = ( selID != '') ? ((selID.indexOf(v.id) != '-1') ? 'checked' : '' ) : '';
              	  valueBox   = ( selID != '') ? ((selID.indexOf(v.id) != '-1') ? v.id : '' ) : '';            	          	
                } else {
                	checkedBox = ( selID != '') ? ((selID == v.id) ? 'checked' : '' ) : '';
              	  valueBox   = v.id;             	
                }
        				if (disabled == true) {
        				 	objdisabled = 'disabled';
        				} else {
        					objdisabled = '';
        				}                
              	var x = k%colSet;	
              	col_  = colSet-1;	
              	vRow +='<input type="hidden" id="cb_'+refType+'_'+v.id+'" name="cb_'+refType+'_'+v.id+'" value="'+valueBox+'">';
                //vRow +='<div class="radio-inline">';
                vRow +='<label for="checkbox">';            
                vRow +='<input type="'+compType+'" id="'+refType+'_'+v.id+'" name="'+refType+'_" value="'+v.id+'" '+checkedBox+' '+ objdisabled +' data-fouc  onclick="javascript:checkboxClick(\''+compType+'\',\''+refType+'\',\''+v.id+'\',\''+Object.keys(JSON.parse(JSON.stringify(resp.data))).length+'\')" >';  //required
                vRow += '&nbsp;'+v.text+'&nbsp;&nbsp;</label>';
                //vRow +='</div>'; 
                if ( x != col_ ) { vRow +='</td><td>';} else { vRow +='</td></tr><tr><td>';}
		        });
		        vRow +='</td></tr></table></div>';
		       // alert(vRow);
            jQueryObj.html(vRow);
        		jQueryObj.trigger('change');  	
            //$(jQueryObj).checkbox-inline();            
            //$('#'+refType).trigger('change');	
            break;                                                                                                                                           	
        }                    
      //} else {
      //	showMessage('Error', 'Terdapat gangguan pada layanan API '+refType, 'error', 'btn btn-danger'); 
      //};
  });
};

function eventIdentify(formNama){
  var elements = document.forms[formNama].elements
  for( var i = 0, l = elements.length; i < l; i++ ) {
  	alert(elements[i].id+'-->'+elements[i].type);
  }	  
};

//--- messages begin -- //

function requireError() {
  swal({
    title: "Data Save Failed", 
    text: "Have an information that has been filled is not allowed or empty.",
    type: "error",	        
    confirmButtonText: 'Ok',confirmButtonClass: 'btn btn-danger',         
    allowOutsideClick: false  
  }) ;  
}

function queryError() {
   swal({
     title: "Data Save Failed",
     text: "have a connection problem to database access/query.",
     type: "error",	        
     confirmButtonText: 'Ok',confirmButtonClass: 'btn btn-danger',         
     allowOutsideClick: false  
   }); 
}

function failError(caption, msg) {
   swal.fire({
     title: caption,
     text: msg,
     icon: "error",	        
     confirmButtonText: 'Ok',confirmButtonClass: 'btn btn-danger',         
     allowOutsideClick: false  
   });      
}

function showMessage(caption, msg, mtype, mbtn) {
	Swal.fire({
		title: caption,
		text: msg,
		icon: mtype,
		//buttonsStyling: false,
		confirmButtonText: "Ok",
		customClass: {
			confirmButton: mbtn
		},allowOutsideClick: false		
	});
}

function sumbmitSuccess(msg,redirectUrl) {
   swal.fire({
     title: "Success",
     text: msg,
     icon: "success",	        
     confirmButtonText: 'Ok',confirmButtonClass: 'btn btn-success',         
     allowOutsideClick: false  
   }).then(function() {
   	 window.location.href = redirectUrl;
   });     
}	
 
function sumbmitCancel(msg) {
  	Swal.fire({
  		title: "Cancel",
  		text: msg,
  		icon: "error",
  		//buttonsStyling: false,
  		confirmButtonText: "Ooook",
  		customClass: {
  			confirmButton: "btn btn-light-success"
  		},allowOutsideClick: false 
  	});   
}			

function timeoutError() {
   swal.fire({
     title: "Process Disconnected!",
     text: "Please relogin, have another user active or session timeout.",
     icon: "error",	        
     confirmButtonText: 'Ok',confirmButtonClass: 'btn btn-success',         
     allowOutsideClick: false  
   }).then(function() {
   	 window.location.href = host+'signin';
   });     
}	

//--- messages end -- //

function checkboxClick(ctype,obx,dtval,dtlen){
	if (ctype == 'checkbox') {
    	if ($('#'+obx+'_'+dtval).is(':checked')) {
    	    $('#'+'cb_'+obx+'_'+dtval).val(dtval);	
    	} else {
    		 $('#'+'cb_'+obx+'_'+dtval).val('');	
    	}		

    	var checkedbox = '';
    	$('#'+obx+'_list').find('input:checked').each(function (i, ob) { 
         checkedbox +=$(ob).val()+'|';
      });    		

    	dataForm[obx] = checkedbox;
    	$('#'+obx).val(checkedbox);	 
    	$('#'+obx).trigger('change');	  
    	$('#'+obx).focusout();  		
	} else {
    	if ($('#'+obx+'_'+dtval).is(':checked')) {
    	    $('#'+'cb_'+obx+'_'+dtval).val(dtval);	
    	}	   	
    	dataForm[obx] = dtval;  
    	$('#'+obx).val(dtval);	
    	$('#'+obx).trigger('change');	
    	$('#'+obx).focusout();  	
    	    		
	}					 	
}	 

function addToDataForm(dtval,id){	
  dataForm[id] = dtval;  	
}

//--- setting begin -- //

function setFocus(obj){
  $('#'+obj).focus();
};

function clearCaption(obj){	
  $('#'+obj).html('');	 
};

function setVal(obj,val){	
  $('#'+obj).val(val);	 
  $('#'+obj).trigger('change'); 
};

function setVal2(obj,val){	
  for (i = 0; i < obj.length; i++) { 
    $('#'+obj[i]).val(val);
    $('#'+obj[i]).trigger('change'); 
  };  
}

function setVisibility(obj,type,visible){	
  for (i = 0; i < obj.length; i++) { 
    if (visible==true) {
    	$('#'+obj[i]).show(); 
    } else {
    	$('#'+obj[i]).hide(); 
    }  
    if (type=='div') {  
      $('#'+obj[i]).find('input, select').prop('required',visible);  	
    }
  };  
}

function setRequired(obj,type,require){	
  for (i = 0; i < obj.length; i++) {  
    if (type=='div') {  
      $('#'+obj[i]).find('input, select').prop('required',require);  	
    } else {
      $('#'+obj[i]).prop('required',require); 
    }
  };  
}

function setDisabled(obj,type,disable){	
  for (i = 0; i < obj.length; i++) { 
    if (type=='div') {  
      $('#'+obj[i]).find('input, button, select, radio, checkbox').prop("disabled",disable);  	
    } else {
      $('#'+obj[i]).prop("disabled",disable); 
    }  	 
  };  
}

function blockPageSet(msg){
	$.blockUI({ 
      message: '<i class="fa-3x icon-spinner4 spinner"></i><h3>'+msg+'</h3>',
      overlayCSS: {
          backgroundColor: '#1b2024',
          opacity: 0.8,
          zIndex: 1200,
          cursor: 'wait'
      },
      css: {
          border: 0,
          color: '#fff',
          padding: 0,
          zIndex: 1201,
          backgroundColor: 'transparent'
      }
  });
}

function formatNumber(value, formatType) {
	if($.trim(value) == '')	value = 0;
	
	if(isNaN(value)){
        value = value.replace(/[^0-9\.]/g,'');
        if(value.split('.').length>2)
            value = value.replace(/\.+$/,"");
    };
		
    var neg = false;
    if(value < 0) {
        neg = true;
        value = Math.abs(value);
    };
	
	if(formatType == 'currency')
		return (neg ? "-" : '') + parseFloat(value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	else	
		return (neg ? "-" : '') + parseInt(value).toFixed(0).toString();
};

function dateFormatter(date){
	    var y = date.getFullYear();
	    var m = date.getMonth()+1;
	    var d = date.getDate();
	    return (d<10?('0'+d):d)+'/'+(m<10?('0'+m):m)+'/'+y;
	};

function dateParser(s){
    if(!s) return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[2],10);
    var m = parseInt(ss[1],10);
    var d = parseInt(ss[0],10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
        return new Date(y,m-1,d);
    } else return new Date(); 
};

//--- setting end -- //

jQuery.fn.extend({
focus2Me: function () {
    var x = jQuery(this).offset().top - 100;
    jQuery('html,body').animate({scrollTop: x}, 500);
    jQuery(this).focus();
}});

var colors = [];
function randColor(countColors){
   	var chars = '0123456789abcdef';
   	var charLen = chars.length;
   	for(var c=0; c<countColors; c++) {
   		var warna = '#';
    	for(var i=0; i<6; i++) {
	    	warna += chars.charAt(Math.floor(Math.random() * charLen));
	   	};
	   	colors.push(warna);
   };
}

function lettersOnly(){
	var charCode = event.keyCode;
	if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 8)
		return true;
   	else
   		return false;
}

function waktuLokal(){
   var b = Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nop', 'Des');
   var h = Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu');
   var d = new Date();
   hari = d.getDay();
   tgl = d.getDate().toString().padStart(2, "0");
   bln = d.getMonth();
   thn = d.getFullYear();
   jam = d.getHours().toString().padStart(2, "0");
   mnt = d.getMinutes().toString().padStart(2, "0");
   det = d.getSeconds().toString().padStart(2, "0");
   $("#waktu").html(h[hari]+', '+tgl+' '+b[bln]+' '+thn+' - '+jam+':'+mnt+':'+det);

   var greet = "";
   if(d.getHours() < 12) greet = "Selamat pagi";
   else if(d.getHours() >= 12 && d.getHours() <= 17) greet = "Selamat sore";
   else if(d.getHours() > 17 && d.getHours() <= 24) greet = "Selamat malam";
   $('#greeting').html(greet);

   if(convProp.mode){
    //mengambil pesan baru jika ada
      $.ajax({
         url: API_host+'psks/getNewMsg',
         method: 'POST',
         data: convProp,
         headers: {
                'Authorization': token,
                'Accept': 'application/json'
            },
         success: function(resp){
            if(resp.error == false){
               $.each(resp.data, function(i, v){
                  $.each(convProp.flags, function(ii, vv) {
                     if(vv.user_id == v.user_id){
                        resp.data[i].color = colors[vv.colorID];
                     };
                  });
               });

               var html = "";
               $.each(resp.data, function(i, v){
                  if(d != v.tanggal){
                     html += "<li class='media content-divider justify-content-center text-muted mx-0'>"+v.tanggal+"</li>";
                     d = v.tanggal;
                  };

                  if(user_id == v.user_id){
                     html += "<li class='media media-chat-item-reverse'>";
                     html += "   <div class='media-body'>";
                     html += "      <div class='media-chat-item'>"+v.message+"</div>";
                     html += "      <div class='font-size-sm text-muted mt-2'>"+v.jam+" - "+v.nama+"</div></div>";
                     html += "<div class='ml-3'>";
                     html += "      <img src='"+host+"assets/images/person.png' class='rounded-circle' width='40' height='40' alt=''>";
                     html += "      </div></li>"; 
                  } else {
                     html += "<li class='media'>";
                     html += "   <div class='mr-3'>";
                     html += "   <img src='"+host+"assets/images/person.png' class='rounded-circle' width='40' height='40' alt=''>";
                     html += "   </div>";

                     html += "<div class='media-body'>";
                     html += "   <div class='media-chat-item' style='border: 3px solid "+v.color+" !important;'>"+v.message+"</div>";
                     html += "   <div class='font-size-sm text-muted mt-2'>"+v.nama+" - "+v.jam+"</div></div></li>";
                  };

                  convProp.id = v.forum_id;
               });
               
               if(resp.length > 0){
                  $('#percakapan').html($('#percakapan').html()+html);
                  $('#percakapan').stop().animate({scrollTop: $('#percakapan').prop("scrollHeight")}, 0);
               };
            } else {
               if(resp.status == 440) kickOut();
            };
         }
      });
   };
}

var dataForm = new Object();
function addNew(mod){
	window.location.href = host+mod+'/addnew';
}

function cancelForm(mod){
	swal({
        title: 'Apakah anda yakin?',
        text: "Data yang sudah terisi akan dibatalkan!",
        type: 'warning',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya, Batalkan saja!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonText: 'Lanjutkan!',
        cancelButtonClass: 'btn btn-danger'
    }).then(function(result) {
    	if(result.value) {
            window.location.href = host+app+'/showModul/'+mod;
        } else if(result.dismiss === swal.DismissReason.cancel) {
            
        };
    });
}

var dialogType;
function chgPassword(){
	dialogType = "chgPassword";
	$('#msgLabel').html('Mengganti Password');
	$("#msgDialog").modal();
	$("#additionalBtn").html("<button onclick='globalSave();' type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Simpan<i class='icon-paperplane ml-2'></i></button>");

	var html = "<div class='form-group row'>";
		html += "<label class='col-form-label col-lg-4'>Password baru</label>";
		html += "<div class='col-sm-8'>";
		html += "<input type='password' class='form-control' id='pword'>";
		html += "</div>";
		html += "</div>";
		html += "<div class='form-group row'>";
		html += "<label class='col-form-label col-lg-4'>Confirmasi password</label>";
		html += "<div class='col-sm-8'>";
		html += "<input type='password' class='form-control' id='conf_pword'>";
		html += "</div>";
		html += "</div>";
	$('#msgBody').html(html);
}

function globalSave(){
	switch(dialogType){
		case 'chgPassword':
			if($('#pword').val() == $('#conf_pword').val()){
				$.ajax({
				    url: API_host+'signin/chgPwd?token='+token,
				    method: 'PUT',
				    data: {pword: $('#pword').val()},
				    success: function(resp){
				        if(resp.message == 'success'){
							swal({
				                title: 'Password telah diganti!',
				                text: "Silahkan melakukan login kembali!",
				                type: 'info',
				                showCancelButton: false,
				                confirmButtonClass: "btn btn-primary",
				                closeOnConfirm: true
				            },
								function(){
									logout();
								}
							);
						} else {
							swal({
				                title: 'Gagal mengganti password',
			                text: resp.message,
				                type: 'warning',
				                confirmButtonClass: "btn btn-danger",
				            });
						};
				    },
				    error: function(request,msg,error) {
				        swal({
			                title: 'Gagal mengganti password',
			                text: resp.message,
			                type: 'warning',
				            confirmButtonClass: "btn btn-danger",
			            });
				    }
				});
			} else {
				swal({
	                title: 'Konfirmasi password salah',
	                text: 'Silahkan dicoba lagi!',
	                type: 'warning',
		            confirmButtonClass: "btn btn-danger",
	            });
			};
			break;
	};
}

$.strPad = function(i, l, s) {
	var o = i.toString();
	if (!s) { s = '0'; }
	while (o.length < l) {
		o = s + o;
	}
	return o;
};


function logout(){
	$.post(host+"signin/clearLoginData", {}, function(resp){
    	window.location.href = host;
    });
}

var fileUpload = function(jqObj, upUrl, type, id){
    if (!$().fileinput) {
        console.warn('Warning - fileinput.min.js is not loaded.');
        return;
    }

	var modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
        '  <div class="modal-content">\n' +
        '    <div class="modal-header align-items-center">\n' +
        '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
        '      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
        '    </div>\n' +
        '    <div class="modal-body">\n' +
        '      <div class="floating-buttons btn-group"></div>\n' +
        '      <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
        '    </div>\n' +
        '  </div>\n' +
        '</div>\n';

    // Buttons inside zoom modal
    var previewZoomButtonClasses = {
        toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
        fullscreen: 'btn btn-light btn-icon btn-sm',
        borderless: 'btn btn-light btn-icon btn-sm',
        close: 'btn btn-light btn-icon btn-sm'
    };

    // Icons inside zoom modal classes
    var previewZoomButtonIcons = {
        prev: '<i class="icon-arrow-left32"></i>',
        next: '<i class="icon-arrow-right32"></i>',
        toggleheader: '<i class="icon-menu-open"></i>',
        fullscreen: '<i class="icon-screen-full"></i>',
        borderless: '<i class="icon-alignment-unalign"></i>',
        close: '<i class="icon-cross2 font-size-base"></i>'
    };

	jqObj.fileinput({
        browseLabel: 'Browse',
        uploadUrl: upUrl, // server upload action
        uploadAsync: true,
        maxFileCount: 5,
        initialPreview: [],
        browseIcon: '<i class="icon-file-plus mr-2"></i>',
        uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
        removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
        fileActionSettings: {
            removeIcon: '<i class="icon-bin"></i>',
            uploadIcon: '<i class="icon-upload"></i>',
            uploadClass: '',
            zoomIcon: '<i class="icon-zoomin3"></i>',
            zoomClass: '',
            indicatorNew: '<i class="icon-file-plus text-success"></i>',
            indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
            indicatorError: '<i class="icon-cross2 text-danger"></i>',
            indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>',
        },
        layoutTemplates: {
            icon: '<i class="icon-file-check"></i>',
            modal: modalTemplate
        },
        initialCaption: 'No file selected',
        previewZoomButtonClasses: previewZoomButtonClasses,
        previewZoomButtonIcons: previewZoomButtonIcons,
	    uploadExtraData: function() {
	        return {
	            id: id,
	            type: type
	        };
	    }
    });
};

function uploadDoc(compID, dataRecID, docType){
	/*
		compID = ID (string) komponen input type=file (exp. 'dok_akta_notaris', '#sertifikat_diklat' dll)
		dataRecID = field ID data record induknya (exp. 'REG_ID', 'DIKLAT_ID', 'LKS_ID' dll)
		docType = jenis dokumen (exp. 'sertifikat', 'akta_notaris', 'photo_profile' dll)
	*/

	var jqFileComp = $('#'+compID);
	var docUpload = new FormData();
	var file = jqFileComp.get(0).files[0];
	var fragments = file.name.split('.');
	var ext = "."+fragments[fragments.length-1];
	var newFileNm = compID+"-"+dataRecID+ext;
	docUpload.append('file_data', jqFileComp[0].files[0], newFileNm);
	docUpload.append('id', dataRecID);
	docUpload.append('type', docType);

	$.ajax({
		url: API_host+'pub/picture',
		type: 'POST',
		data: docUpload,
		processData: false,
		contentType: false,
		success: function(resp){},
		error: function(request,msg,error){}
	});
};

$('.file-input').on('fileselect', function(event, numFiles, label) {
    $('.file-preview-frame').css('width', '95%');
});

function blockPage(act){
	switch(act){
		case 'on':
			$.blockUI({ 
                message: '<i class="fa-3x icon-spinner4 spinner"></i><h3>Sedang memproses...</h3>',
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    padding: 0,
                    zIndex: 1201,
                    backgroundColor: 'transparent'
                }
            });
			break;

		case 'off':
			$.unblockUI();
			break;
	};
}

if($().DataTable) {
    $.fn.dataTable.ext.errMode = 'none';
};

function kickOut(){
	swal({
        title: 'Sesi login telah habis',
        text: "Silahkan login kembali!",
        type: 'warning',
        buttonsStyling: false,
        confirmButtonText: 'Ok',
        confirmButtonClass: 'btn btn-success'
    }).then(function(result){
    	logout();
	});
}


$(document).ready(function(){
	$('.menu-link').removeClass('active');
	$('.menu-item-submenu').removeClass('menu-item-open');

	if(typeof modul !== 'undefined'){
		$('#menu-'+modul).addClass('active');

		var par = $('#menu-'+modul).closest('.menu-item-submenu');
		par.addClass('menu-item-open');
		var parUl = $('#menu-'+modul).closest('.menu-group-sub');
		parUl.css('display', 'block');

    if(resetPword != '') chgPassword();
	};

	setInterval(waktuLokal, 5000);
});

