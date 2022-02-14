"use strict";
var tblJob,tblJob2,tblJob3,tblJob4, tblJobFeed,  tblJobTarget, tblPersonJob, tblJobPerson2;
var scroll_ = false;

$('#grade_target, #grade_feed').TouchSpin({
    buttondown_class: 'btn btn-secondary',
    buttonup_class: 'btn btn-secondary',

    min: 1,
    max: 10,
    stepinterval: 10,
    maxboostedstep: 10
});

$('#tmt_grade').TouchSpin({
    buttondown_class: 'btn btn-secondary',
    buttonup_class: 'btn btn-secondary',

    min: 0,
    max: 55,
    stepinterval: 1,
    maxboostedstep: 1
});

$('#percent_compability').TouchSpin({
    buttondown_class: 'btn btn-secondary',
    buttonup_class: 'btn btn-secondary',

    min: 0,
    max: 100,
    step:10,
    stepinterval: 10,
    maxboostedstep: 10,
    forcestepdivisibility: 'none',
    postfix: '%'
});


$('#findjob_dialog .form-control, #find_parameter .form-control, #find_result .form-control').on('change', function(e){
	//alert(e.currentTarget.id+'-'+e.currentTarget.value);
  switch(true) {
    case (e.currentTarget.id == 'size_method'):
      renderParameter(this.value);
      setVal('size_method_selected',this.value);
      if (this.value == '1') {      	   
    	     setDisabled(['current_grade_on_target','current_grade_on_feed'],'obj',true);
           setDisabled(['grade_target','grade_feed'],'obj',true);
           $("#grade_target,#grade_feed").css("background-color","#c1c6cb");
    	  } else {
    	  	setDisabled(['current_grade_on_target','current_grade_on_feed'],'obj',false);
          setDisabled(['grade_target','grade_feed'],'obj',false);
          $("#grade_target,#grade_feed").css("background-color","#ffffff");   	     
    	  }
      break;  	
    case ((e.currentTarget.id == 'job_id') || (e.currentTarget.id == 'employee_id')):
      setVal('find_key',this.value);
      break;
    case (e.currentTarget.id == 'grade_target'):
      if (this.value != '0') {
  	  	//setDisabled(['current_grade_on_target'],'obj',false);
  	  } else {
  	  	setVal('include_on_target','0');
  	  	$('#current_grade_on_target').prop('checked', false);
  	  	setDisabled(['current_grade_on_target'],'obj',true);
  	  }
      break;
    case (e.currentTarget.id == 'grade_feed'):
  	  if (this.value != '0') {
  	  	//setDisabled(['current_grade_on_feed'],'obj',false);
  	  } else {
  	  	setVal('include_on_feed','0');
  	  	$('#current_grade_on_feed').prop('checked', false);
  	  	setDisabled(['current_grade_on_feed'],'obj',true);
  	  }
      break;
    case (e.currentTarget.id == 'find_method'):
      if (this.value == '1') {
      	$("#show_parameter").prop("checked", $('#j2pres').val()!='1');
      	setVal('tool_method','1');
        setVal('method_selected','0');
        setVal('employee_id','');
      	setVisibility(['clearJobsubmitButton'],'obj',$('#j2pres').val()=='1');
      	setVisibility(['j2p_result','j2p_content','j2p_found_desc'],'div',$('#j2pres').val()=='1');
	      setVisibility(['param_setting'],'div',$('#j2pres').val()!='1');
        setVisibility(['find_job_list','tmt_to_find','p_left_down'],'div',true);
        setVisibility(['target_to_find','find_person_list','p2j_result','j2j_result','p2j_found_desc','j2j_found_desc'],'div',false);
      } else if (this.value == '2') {
      	$("#show_parameter").prop("checked", $('#p2jres').val()!='1');
      	setVal('tool_method','2');
      	setVal('method_selected','1');
        setVal('job_id','');
      	setVisibility(['clearJobsubmitButton'],'obj',$('#p2jres').val()=='1');
        setVisibility(['p2j_result','p2j_content','p2j_found_desc'],'div',$('#p2jres').val()=='1');
	      setVisibility(['param_setting'],'div',$('#p2jres').val()!='1');
        setVisibility(['target_to_find','find_person_list','p_left_down'],'div',true);
        setVisibility(['find_job_list','tmt_to_find','j2p_result','j2j_result','j2p_found_desc','j2j_found_desc'],'div',false);
      } else {
      	$("#show_parameter").prop("checked", $('#j2jres').val()!='1');
      	setVal('tool_method','3');
        setVal('method_selected','0');
        setVal('employee_id','');
      	setVisibility(['clearJobsubmitButton'],'obj',$('#j2jres').val() =='1');
      	setVisibility(['j2j_result','j2j_content','j2j_found_desc'],'div',$('#j2jres').val()=='1');
	      setVisibility(['param_setting'],'div',$('#j2jres').val()!='1');
        setVisibility(['target_to_find','find_job_list'],'div',true);
        setVisibility(['find_person_list','tmt_to_find','p_left_down','j2p_result','p2j_result','j2p_found_desc','p2j_found_desc'],'div',false);
      }
      break;
    case (e.currentTarget.id == 'current_grade_on_target'):
      if($('input[name="current_grade_on_target"]').is(':checked'))
      {
        setVal('include_on_target','1');
      } else {
       setVal('include_on_target','0');
      }
      break;
    case (e.currentTarget.id == 'current_grade_on_feed'):
     if($('input[name="current_grade_on_feed"]').is(':checked'))
      {
        setVal('include_on_feed','1');
      } else {
       setVal('include_on_feed','0');
      }
      break;
    case (e.currentTarget.id == 'show_parameter'):
      if($('input[name="show_parameter"]').is(':checked'))
      {
   	   setVisibility(['param_setting'],'div',true);
      } else {
  	   setVisibility(['param_setting'],'div',false);
      }
      break;
    case (e.currentTarget.id == 'perform_level_check'):
      setVal('performance_level','-');
      if($('input[name="perform_level_check"]').is(':checked')){
         var selected_box = [];
         $.each($("input[name='perform_level_check']:checked"), function(){
           selected_box.push($(this).val());
         });
         setVal('performance_level',selected_box.join("|"));
      };
      break;
    case (e.currentTarget.id == 'assessment_check'):
      setVal('assessment','-');
      if($('input[name="assessment_check"]').is(':checked')){
         var selected_box = [];
         $.each($("input[name='assessment_check']:checked"), function(){
           selected_box.push($(this).val());
         });
         setVal('assessment',selected_box.join("|"));
      };
      break;
    case (e.currentTarget.id == 'talent_box_check'):
      setVal('talentbox','-');
      if($('input[name="talent_box_check"]').is(':checked')){
         var selected_box = [];
         $.each($("input[name='talent_box_check']:checked"), function(){
           selected_box.push($(this).val());
         });
         setVal('talentbox',selected_box.join("|"));
      };
      break;

    case (e.currentTarget.id == 'show_pj_result1'):
      KTApp.blockPage({
          overlayColor: '#000000',
          state: 'success',
          message: 'Please Wait...'
      });
      setTimeout(function() {
        KTApp.unblockPage();
        if($('input[name="show_pj_result1"]').is(':checked'))
        {
        	setVal('hide_result','');
     	    setVisibility(['pj_result1'],'div',true);
     	    $("#pj_result2").removeClass("col-lg-12");
        } else {
         if ($("#hide_result").val() == '') {
         	 setVal('hide_result','1');
    	     setVisibility(['pj_result1'],'div',false);
    	     $("#pj_result2").addClass("col-lg-12");
         } else {
         	showMessage('Warning', 'Can not Hide all result', 'warning', 'btn btn-warning');
         	$("#show_pj_result1").prop("checked", true);
         }
        }
        tblPersonJob.columns.adjust();
        tblJobPerson2.columns.adjust();
      }, 400);
      break;
    case (e.currentTarget.id == 'show_pj_result2'):
      KTApp.blockPage({
          overlayColor: '#000000',
          state: 'success',
          message: 'Please Wait...'
      });
      setTimeout(function() {
        KTApp.unblockPage();
        if($('input[name="show_pj_result2"]').is(':checked'))
        {
         setVal('hide_result','');
     	   setVisibility(['pj_result2'],'div',true);
     	   $("#pj_result1").removeClass("col-lg-12").addClass("col-lg-6");
     	  // $("#pj_result1");
        } else {
          if ($("#hide_result").val() == '') {
      	   setVal('hide_result','1');
      	   setVisibility(['pj_result2'],'div',false);
      	   $("#pj_result1").addClass("col-lg-12");
      	  } else {
           	showMessage('Warning', 'Can not Hide all result', 'warning', 'btn btn-warning');
           	$("#show_pj_result2").prop("checked", true);
      	  }
        }
        tblPersonJob.columns.adjust();
        tblJobPerson2.columns.adjust();
      }, 400);
      break;
    case (e.currentTarget.id == 'show_jj_result1'):
      KTApp.blockPage({
          overlayColor: '#000000',
          state: 'success',
          message: 'Please Wait...'
      });
      setTimeout(function() {
        KTApp.unblockPage();
        if($('input[name="show_jj_result1"]').is(':checked'))
        {
        	setVal('hide_result','');
     	    setVisibility(['jj_result1'],'div',true);
     	    $("#jj_result2").removeClass("col-lg-12");
        } else {
         if ($("#hide_result").val() == '') {
         	 setVal('hide_result','1');
    	     setVisibility(['jj_result1'],'div',false);
    	     $("#jj_result2").addClass("col-lg-12");
         } else {
         	showMessage('Warning', 'Can not Hide all result', 'warning', 'btn btn-warning');
         	$("#show_jj_result1").prop("checked", true);
         }
        }
        tblJobFeed.columns.adjust();
        tblJobTarget.columns.adjust();
      }, 400);
      break;
    case (e.currentTarget.id == 'show_jj_result2'):
      KTApp.blockPage({
          overlayColor: '#000000',
          state: 'success',
          message: 'Please Wait...'
      });
      setTimeout(function() {
        KTApp.unblockPage();
        if($('input[name="show_jj_result2"]').is(':checked'))
        {
        	//alert('check');
         setVal('hide_result','');
     	   setVisibility(['jj_result2'],'div',true);
     	   $("#jj_result1").removeClass("col-lg-12").addClass("col-lg-6");
     	   //$("#jj_result1");
        } else {
          if ($("#hide_result").val() == '') {
      	   setVal('hide_result','1');
      	   setVisibility(['jj_result2'],'div',false);
      	   $("#jj_result1").addClass("col-lg-12");
      	  } else {
           	showMessage('Warning', 'Can not Hide all result', 'warning', 'btn btn-warning');
           	$("#show_jj_result2").prop("checked", true);
      	  }
        }
        tblJobFeed.columns.adjust();
        tblJobTarget.columns.adjust();
      }, 400);
      break;
  }

 	changeAction(e.currentTarget.type,e.currentTarget.id,e.currentTarget.value)
});

$("#clearJobsubmitButton").click(function(){
  setVisibility(['clearJobsubmitButton'],'obj',false);
  setVisibility(['param_setting'],'div',true);
  $("#show_parameter").prop("checked", true);

  switch(true) {
    case ($('#tool_method').val()=='1'):
      setVal('j2pres','0');
      setVisibility(['j2p_result','j2p_content','j2p_found_desc'],'div',false);
      break;
    case ($('#tool_method').val()=='2'):
       setVal('p2jres','0');
       setVisibility(['p2j_result','p2j_content','p2j_found_desc'],'div',false);
      break;
    case ($('#tool_method').val()=='3'):
      setVal('j2jres','0');
      setVisibility(['j2j_result','j2j_content','j2j_found_desc'],'div',false);
      break;
  }
});

$("#findJobsubmitButton").click(function(e){
	e.preventDefault();
	var findSubmit = false;
	if ((($('#method_selected').val() == '0') && ($('#job_id').val()=='')) ||
	    (($('#method_selected').val() == '1') && ($('#employee_id').val()==''))) {
		findSubmit = false;
	} else {
    findSubmit = true;
	}

	if (findSubmit) {
      setVisibility(['param_setting',
                     'j2p_result','j2p_content','j2p_found_desc',
                     'p2j_result','p2j_content','p2j_found_desc',
                     'j2j_result','j2j_content','j2j_found_desc'],'div',false);
      $("#show_parameter").prop("checked", false);
      $("#find_result").addClass("col-lg-12");
      setVisibility(['start_processs'],'div',true);
      setVisibility(['clearJobsubmitButton'],'obj',false);
      setTimeout(function(){
        if ($('#method_selected').val() == '0') {
       	  if ($('#tool_method').val() == '1') {
     	      j2p(dataForm);
     	      setVal('j2pres','1');
        	  setVisibility(['j2p_result','j2p_content','j2p_found_desc'],'div',true);
        	  $('#j2p_breadcrumb').html('<a href="#" onClick="javascript:window.scrollTo(0, 1);">Job To Person&nbsp;|&nbsp;'+$("#job_id option:selected").text()+'</a>');
       	  } else {
       	  	j2j(dataForm);
       	  	setVal('j2jres','1');
        	  setVisibility(['j2j_result','j2j_content','j2j_found_desc'],'div',true);
            $('#j2j_breadcrumb').html('<a href="#" onClick="javascript:window.scrollTo(0, 1);">Job To Job&nbsp;|&nbsp;'+$("#job_id option:selected").text()+'</a>');
       	  }
        } else {
        	p2j(dataForm);
        	setVal('p2jres','1');
        	setVisibility(['p2j_result','p2j_content','p2j_found_desc'],'div',true);
        	$('#p2j_breadcrumb').html('<a href="#" onClick="javascript:window.scrollTo(0, 1);">Person To Job&nbsp;|&nbsp;'+$("#employee_id option:selected").text()+'</a>');
        }
      	setVisibility(['start_processs'],'div',false);
      	setVisibility(['clearJobsubmitButton'],'obj',true);
      	}, 5000);
	} else {
	 showMessage('Warning', 'Please select '+ (($('#method_selected').val() == '1') ? 'person' : 'job') + ' to process.', 'warning', 'btn btn-warning');
	}
});

function renderParameter(stype) {
    $.getJSON(API_host + app + '/parameter?token=' + token, function (resp){
        var jsonData = JSON.parse(JSON.stringify(resp.data[0]));
        function checkThis(target,val){
            if (val != '-'){
                let valSplit = val.split('|');
                let id = document.querySelectorAll(target);
                valSplit.forEach(function (currentValue) {
                    id[currentValue-1].checked = true;
                });
            }
        }
        $.each(jsonData, function (key,val) {
            if (key.includes('include_')){
                setVal(key,val);
                key = key.replace('include_','current_grade_');
                val = parseInt(val);
                if (stype == '1') {
                	$('#'+key).prop('checked',true);
                } else {
                	$('#'+key).prop('checked',val);
                }                
            }else if(key.includes('performance_level') || key.includes('assessment') || val.includes('-') || val.includes('-')){
                switch (key) {
                    case 'performance_level':
                        setVal(key,val);
                        checkThis('#perform_level_check',val);
                        break;
                    case 'assessment':
                        setVal(key,val);
                        checkThis('#assessment_check',val);
                        break;
                }
            }else{
              if (stype == '1') {
              	if ((key == 'grade_target') || (key == 'grade_feed')) {
              		val=1;
              		setDisabled([key],'obj',true);
              	}
              }
              setVal(key,val);
            }
        })
    });
}

function renderView(parent, data) {
    let jsonField;
    let select;
    var jsonData = JSON.parse(JSON.stringify(data));
    if (parent == 'person'){
        select = 'vp_';
    }else {
        select = 'vj_';
    }
    var thisdiv = document.querySelectorAll('[id^="'+select+'"]');
    thisdiv.forEach(function (currentValue) {
        jsonField = (currentValue.id).replace(select,'');
        $('#'+currentValue.id+'').html(jsonData[''+jsonField+'']);
    });
}

function convertPlevel(value,isText = 0) {
    var retVal = 0;
    var retTxt = '';
    if (isText == 0){
        switch (true) {
            case value < 1.49:
                retVal = 1;
                break;
            case value >= 1.5 && value <= 2.99:
                retVal = 2;
                break;
            case value >= 3 && value <= 3.5:
                retVal = 3;
                break;
            case value >= 3.51 && value <= 4.25:
                retVal = 4;
                break;
            case value >= 4.26:
                retVal = 5;
                break;
        }
        return retVal;
    } else {
        switch (true) {
            case value < 1.49:
                retTxt = value+' (Poor)';
                break;
            case value >= 1.5 && value <= 2.99:
                retTxt = value+' (Below)';
                break;
            case value >= 3 && value <= 3.5:
                retTxt = value+' (Meet)';
                break;
            case value >= 3.51 && value <= 4.25:
                retTxt = value+' (Exceed)';
                break;
            case value >= 4.26:
                retTxt = value+' (Outstanding)';
                break;
        }
        return retTxt;
    }
}

function viewDetil(id){
    $.getJSON(API_host + app + '/employee?token=' + token + '&id=' + id, function (resp){
        if (resp.message == 'success' && resp.length > 0){
            renderView('person', resp.data[0]);
            let mp = resp.data[0]['mp'] == 1 ? 'Yes' : 'No';
            let topTalent = resp.data[0]['top_talent'] == 1 ? 'Yes' : 'No';
            let retTxt = convertPlevel(resp.data[0]['performance_level'], 1);
            let retTxt1 = convertPlevel(resp.data[0]['performance_year1'], 1);
            let retTxt2 = convertPlevel(resp.data[0]['performance_year2'], 1);
            $('#vp_performance_level').empty().html(retTxt);
            $('#vp_performance_year1').empty().html(retTxt1);
            $('#vp_performance_year2').empty().html(retTxt2);
            $('#vp_mp').empty().html(mp);
            $('#vp_top_talent').empty().html(topTalent);
            if (resp.data[0]['job_id'] != 0){
                $.getJSON(API_host + app + '/job?token=' + token + '&id=' + resp.data[0]['job_id'], function (resp){
                    renderView('person', resp.data[0]);
                });
            }
            var jsonData = JSON.parse(JSON.stringify(resp.data[0]));
            let current = moment().startOf('day');
            let given = moment(jsonData['tmtgrade'], 'DD-MM-YYYY');
            let elapsed = '';
            if (current.diff(given, 'years') > 0) {
                elapsed = current.diff(given, 'years') + ' Tahun ' + (current.diff(given, 'months') - (current.diff(given, 'years') * 12)) + ' Bulan';
            } else {
                elapsed = current.diff(given, 'months') + ' Bulan';
            }
            $('#vp_masa_kerja').html(elapsed);
        }
    });
	$("#modalPersonDetil").modal();
}

function tenure_period (tmtgrade) {
  let current = moment().startOf('day');
  let given = moment(tmtgrade.substr(8, 2)+'-'+tmtgrade.substr(5, 2)+'-'+tmtgrade.substr(0, 4), 'DD-MM-YYYY');
  let elapsed = '';
  if (current.diff(given, 'years') > 0) {
      elapsed = current.diff(given, 'years') + ' Thn ' + (current.diff(given, 'months') - (current.diff(given, 'years') * 12)) + ' Bln';
  } else {
      elapsed = current.diff(given, 'months') + ' Bln';
  }	
  return elapsed;
}


function viewJobDetil(id){
  $.getJSON(API_host+app+'/job?token='+token+'&id='+id, function (resp){
        if (resp.message == 'success' && resp.length > 0){
            renderView('job',resp.data[0]);
        }
  });
	$("#modalJobDetil").modal();
}

function j2p(params){
	// alert(JSON.stringify(params) );
	tblJob = $('#j2p_personfeed_dt').DataTable({
		  autoWidth: true,
		  fixedHeader: true,
			deferRender:  !0,
			scrollY: '60vh',
			scrollX: true,
			scrollCollapse: !1,
			scroller:  !0,
			bFilter:  !1,
      bInfo : !1 ,
      paging:   false,
      serverSide: !0,
      destroy: !0,
      drawCallback: function () {
         $('[data-toggle="tooltip"]').tooltip();
      },
			columns: [{
				title: "No.",
				orderable: !1,
				data: null,
				defaultContent: '',
				width: "2%",
				className: "text-right",
				render: function (data, type, full, meta) {
					return meta.settings._iDisplayStart + meta.row + 1;
				}
			},
			{data: "person_number", title: "Person NIP", width: "3%", className: "text-center"},
			{data: "person_name", title: "Name", width: "18%"},
		  {data: "person_grade", title: "PG", width: "2%", className: "text-center"},
		  {data: "tmt", title: "Tenure Period", width: "3%", className: "text-center", visible: false,  render: function ( data, type, row ) { return tenure_period(row["tmtgrade"])}},
		  {data: "person_job_name", title: "Current Job", width: "15%", render: function ( data, type, row ) { return (data != null) ? data :'Non Establish';}},
			{data: "person_alnum_job_grade", title: "Current JG", width: "2%", className: "text-center", render: function ( data, type, row ) { return (data != null) ? (parseInt(row["person_job_grade"])<(parseInt(data)) ? '<a data-toggle="tooltip" title="Current Job grade is higher than '+row["job_name"]+'" >'+data+'&nbsp<i class="flaticon2-information" style="color:red;"></i></a>&nbsp' : data) :'N/A';}},
		  {data: "compatibility", title: "%Match", width: "2%", className: "text-center", render: function ( data, type, row ) { return data.toString().match(/\d+(\.\d{1,2})?/g)[0] + "%";}},
			//{data: "person_name", title: "Name", width: "20%", render: function(data, type, row, meta){ if(type === 'display'){data = '<a href="#" onclick="viewDetil(\''+data+'\');" style="color: black">' + data + '</a>';}   return data; } },
			{data: "person_skill", title: "Person Skill", width: "10%", visible: false, render: function ( data, type, row ) { return (data != null) ? data.replace("|", "<br>").replace("|", "<br>") : '';}},		 
		  {data: "person_job_skill", title: " Job Family", width: "10%", visible: false, render: function ( data, type, row ) { return (data != null) ? data.replace("|", "<br>").replace("|", "<br>") : '';}},
		  {data: "notes", title: " Notes", width: "10%", visible: false},
		],
    columnDefs: [ 
        {
          targets: 2,
          title: "Name",
          orderable: !0,
          render: function (a, e, t, n) {
              return '<a href="#" onclick="viewDetil(\''+t['person_id']+'\');" style="color: black">' + t['person_name'] + '</a>';
          },
        },
    ],
    ajax: {
        dataType: 'JSON',
        type: "GET",
        url: API_host+app+'/findjob?token='+token,
        beforeSend: function(){
        // blockPageSet('Processing ...');
        },
        dataSrc: function(json) {
        //	blockPage('off');
       //alert(JSON.stringify(json) );
        	if ( json.error == false) {
          	if (( json.status == 200) && ( json.message == 'success')){
          		 $('#jp_person_match').html( (json.match[0]['warning'] == true) ? '<a data-toggle="tooltip" title="'+json.match[0]['message']+'" >Found : '+json.recordsFiltered+' Person(s) Match &nbsp<i class="flaticon2-warning" style="color:red;"></i></a>' : 'Found : '+json.recordsFiltered+' Person(s) Match ');

          		 $('#jp_jobselected_title').html(json.find['job_name']);
          		 $('#jp_jobselected_location').html(json.find['job_loc']);
          		 $('#jp_jobselected_grade').html(json.find['job_grade']);
          		 $('#jp_jobselected_sg').html(((json.find['job_skill'] != null) ? json.find['job_skill'] : '**'));

          		 $('#jp_jobselected_title2').html(json.find['person_name']);
          		 $('#jp_jobselected_nip').html(json.find['person_nip']);
          		 $('#jp_jobselected_grade2').html(json.find['person_grade']);
          		 $('#jp_jobselected_sg2').html(json.find['person_skill']);
          		 return json.data;
          	};
        	} else {
          	if (( json.status == 200) && (( json.message == 'Token expired!') || ( json.message == 'Token is required!') || ( json.message == 'Token is not accepted!'))) {
          		 timeoutError();
          	}
        	}
        },
  			cache: true,
  			data: function(d){
  				var hal = 1;
  				if(d.start > 0){
  					hal = (d.length/d.start)+1;
  				};
  				var param = {
  					p: (d.start/d.length)+1,
  					l: d.length,
  					r:'j2p',
  					q:params,
  					ordType: d.order[0].dir,
  					ordBy: d.columns[d.order[0].column].data,
  					token: token
  				};
  				return param;
  			}
    },
  });

    let j2p_export_button;
    j2p_export_button = new $.fn.dataTable.Buttons(tblJob, { 
     buttons: [
       { extend: 'excel', className: 'btn btn-secondary mr-1 rounded', text: 'Export Result', exportOptions: { columns: ':visible' }},
       { extend: 'colvis', className: 'btn btn-secondary rounded', text: 'Column Setting' },
       
    ]
  }).container().appendTo($('#j2p_export_button'));
};

function p2j(params){
	tblPersonJob = $('#p2j_jobtarget_dt').DataTable({
		  autoWidth: true,
		  fixedHeader: true,
			deferRender:  !0,
			scrollY: '55vh',
			scrollX: true,
			scrollCollapse: !1,
			scroller:  !0,
			bFilter:  !1,
      bInfo : !1 ,
      paging:   false,
      serverSide: !0,
      destroy: !0,
			columns: [{
				title: "No.",
				orderable: !1,
				data: null,
				defaultContent: '',
				width: "2%",
				className: "text-right",
				render: function (data, type, full, meta) {
					return meta.settings._iDisplayStart + meta.row + 1;
				}
			},
      {data: "job_name", title: "Job Name", width: "40%"},
			{data: "job_alnum_grade", title: "Job Grade", width: "10%", className: "text-center"},
			{data: "job_skill", title: "Job Family", width: "45%", render: function ( data, type, row ) { return (data != null) ? data.replace("|", "<br>").replace("|", "<br>") : '';}},
			{data: "compatibility", title: "%Match", width: "5%", className: "text-center", render: function ( data, type, row ) { return data.toString().match(/\d+(\.\d{1,2})?/g)[0] + "%";}},
		],
    columnDefs: [{
      targets: 1,
      title: "Job Name",
      orderable: !0,
      render: function (a, e, t, n) {
          return '<a href="#" onclick="viewJobDetil(\''+t['job_id']+'\');" style="color: black">' + t['job_name'] + '</a>';
      },
      },
    ],
    ajax: {
        dataType: 'JSON',
        type: "GET",
        url: API_host+app+'/findjob?token='+token,
        beforeSend: function(){
        // blockPageSet('Processing ...');
        },
        dataSrc: function(json) {
        //	blockPage('off');
        	if ( json.error == false) {
          	if (( json.status == 200) && ( json.message == 'success')){
          		//alert(JSON.stringify(json) );
           		 $('#pj_jobselected_title').html(((json.find['job_name'] != null) ? json.find['job_name'] : 'Non Establish'));
          		 $('#pj_jobselected_location').html(json.find['job_loc']);
          		 $('#pj_jobselected_grade').html(((json.find['job_grade'] != null) ? json.find['job_grade'] : '**'));
          		 $('#pj_jobselected_sg').html(((json.find['job_skill'] != null) ? json.find['job_skill'] : '**'));

      		     $('#pj_jobselected_title2').html(json.find['person_name']);
      		     $('#pj_jobselected_nip').html(json.find['person_nip']);
          		 $('#pj_jobselected_grade2').html(json.find['person_grade']);
          		 $('#pj_jobselected_sg2').html(((json.find['person_skill'] != null) ? json.find['person_skill'] : '**'));

               $('#pj_person_match').html( (json.match[0]['warning'] == true) ? '<a data-toggle="tooltip" title="'+json.match[0]['message']+'" >Found : '+json.recordsFiltered+' Job(s) Match &nbsp<i class="flaticon2-warning" style="color:red;"></i></a>' : 'Found : '+json.recordsFiltered+' Job(s) Match ');

               if (json.recordsFiltered == 0) {
                 setVisibility(['p2j_found_desc'],'div',true);
               };
          		 return json.data;
          	};
        	} else {
          	if (( json.status == 200) && (( json.message == 'Token expired!') || ( json.message == 'Token is required!') || ( json.message == 'Token is not accepted!'))) {
          		 timeoutError();
          	}
        	}
        },
  			cache: true,
  			data: function(d){
  				var hal = 1;
  				if(d.start > 0){
  					hal = (d.length/d.start)+1;
  				};
  				var param = {
  					p: (d.start/d.length)+1,
  					l: d.length,
  					r:'p2jtarget',
  					q:params,
  					ordType: d.order[0].dir,
  					ordBy: d.columns[d.order[0].column].data,
  					token: token
  				};
  				return param;
  			}
    },
  });

    let p2j_job_export_button;
    p2j_job_export_button = new $.fn.dataTable.Buttons(tblPersonJob, {
     buttons: [
       { extend: 'excel', className: 'btn btn-secondary', text: 'Export Result', exportOptions: { columns: ':visible' }  },
    ]
  }).container().appendTo($('#p2j_job_export_button'));

	tblJobPerson2 = $('#p2j_personfeed_dt').DataTable({
		  autoWidth: true,
		  fixedHeader: true,
			deferRender:  !0,
			scrollY: '55vh',
			scrollX: true,
			scrollCollapse: !1,
			scroller:  !0,
			bFilter:  !1,
      bInfo : !1 ,
      paging:   false,
      serverSide: !0,
      destroy: !0,
      drawCallback: function () {
         $('[data-toggle="tooltip"]').tooltip();
      },
			columns: [{
				title: "No.",
				orderable: !1,
				data: null,
				defaultContent: '',
				width: "2%",
				className: "text-right",
				render: function (data, type, full, meta) {
					return meta.settings._iDisplayStart + meta.row + 1;
				}
			},
      {data: "person_name", title: "Name", width: "13%"},
			{data: "person_job_name", title: "Current Job", width: "12%", render: function ( data, type, row ) { return (data != null) ? data :'Non Establish';}},
			{data: "person_skill", title: " Person Skill", width: "20%", render: function ( data, type, row ) { return (data != null) ? data.replace("|", "<br>").replace("|", "<br>") : '';}},
			{data: "person_grade", title: " Person Grade", width: "10%", className: "text-center"},
			{data: "person_job_skill", title: " Job Family", width: "22%", render: function ( data, type, row ) { return (data != null) ? data.replace("|", "<br>").replace("|", "<br>") : '';}},
      {data: "person_alnum_job_grade", title: "Job Grade", width: "10%", className: "text-center", render: function ( data, type, row ) { return (data != null) ? (parseInt(row["person_job_grade"])<(parseInt(data)) ? '<a class="red-tooltip" data-toggle="tooltip" title="Current Job grade is higher than '+row["job_name"]+'" >'+data+'&nbsp<i class="flaticon2-information" style="color:red;"></i></a>&nbsp' : data) :'0';}},
      {data: "compatibility", title: "%Match", width: "2%", render: function ( data, type, row ) { return data.toString().match(/\d+(\.\d{1,2})?/g)[0] + "%";}},
      {data: "notes", title: " Notes", width: "10%", className: "text-center"},
		],
    columnDefs: [{
      targets: 1,
      title: "Name",
      orderable: !0,
      render: function (a, e, t, n) {
          return '<a href="#" onclick="viewDetil(\''+t['person_id']+'\');" style="color: black">' + t['person_name'] + '</a>';
      },
    },
    ],
    ajax: {
        dataType: 'JSON',
        type: "GET",
        url: API_host+app+'/findjob?token='+token,
        beforeSend: function(){
        // blockPageSet('Processing ...');
        },
        dataSrc: function(json) {
        //	blockPage('off');
        	if ( json.error == false) {
          	if (( json.status == 200) && ( json.message == 'success')){
          		//alert(JSON.stringify(json) );
               $('#pj_jobfeed_found').html( (json.match[0]['warning'] == true) ? '<a data-toggle="tooltip" title="'+json.match[0]['message']+'" >Found : '+json.recordsFiltered+' Feeder Person(s) Match &nbsp<i class="flaticon2-warning" style="color:red;"></i></a>' : 'Found : '+json.recordsFiltered+' Feeder Person(s) Match ');
               if (json.recordsFiltered == 0) {
                 setVisibility(['j2j_found_desc'],'div',true);
               };
          		 return json.data;
          	};
        	} else {
          	if (( json.status == 200) && (( json.message == 'Token expired!') || ( json.message == 'Token is required!') || ( json.message == 'Token is not accepted!'))) {
          		 timeoutError();
          	}
        	}
        },
  			cache: true,
  			data: function(d){
  				var hal = 1;
  				if(d.start > 0){
  					hal = (d.length/d.start)+1;
  				};
  				var param = {
  					p: (d.start/d.length)+1,
  					l: d.length,
  					r:'p2jfeeder',
  					q:params,
  					ordType: d.order[0].dir,
  					ordBy: d.columns[d.order[0].column].data,
  					token: token
  				};
  				return param;
  			}
    },
  });

    let p2j_person_export_button;
    p2j_person_export_button = new $.fn.dataTable.Buttons(tblJobPerson2, {
     buttons: [
       { extend: 'excel', className: 'btn btn-secondary', text: 'Export Result', exportOptions: { columns: ':visible' }  },
    ]
  }).container().appendTo($('#p2j_person_export_button'));
};

function j2j(params){
	tblJobTarget = $('#j2j_jobtarget_dt').DataTable({
		  autoWidth: true,
		  fixedHeader: true,
			deferRender:  !0,
			scrollY: '55vh',
			scrollX: true,
			scrollCollapse: !1,
			scroller:  !0,
			bFilter:  !1,
      bInfo : !1 ,
      paging:   false,
      serverSide: !0,
      destroy: !0,
			columns: [{
				title: "No.",
				orderable: !1,
				data: null,
				defaultContent: '',
				width: "2%",
				className: "text-right",
				render: function (data, type, full, meta) {
					return meta.settings._iDisplayStart + meta.row + 1;
				}
			},
			{data: "target_job_name", title: "Job Name", width: "40%"},
			{data: "target_job_skill", title: "Job Family", width: "48%", render: function ( data, type, row ) { return (data != null) ? data.replace("|", "<br>").replace("|", "<br>") : '';}},
			{data: "target_job_alnum_grade", title: "Grade", width: "10%", className: "text-center"},
			{data: "compatibility", title: "%Match", width: "2%", className: "text-center", render: function ( data, type, row ) { return data.toString().match(/\d+(\.\d{1,2})?/g)[0] + "%";}},
		],
    columnDefs: [{
      targets: 1,
      title: "Job Name",
      orderable: !0,
      render: function (a, e, t, n) {
          return '<a href="#" onclick="viewJobDetil(\''+t['target_job_id']+'\');" style="color: black">' + t['target_job_name'] + '</a>';
      },
    },
    ],
    ajax: {
        dataType: 'JSON',
        type: "GET",
        url: API_host+app+'/findjob?token='+token,
        beforeSend: function(){
        // blockPageSet('Processing ...');
        },
        dataSrc: function(json) {
        //	blockPage('off');
        	if ( json.error == false) {
          	if (( json.status == 200) && ( json.message == 'success')){
          		//alert(JSON.stringify(json) );
         		   $('#jj_jobselected_title').html(json.find['job_name']);
         		   $('#jj_jobselected_location').html(json.find['job_loc']);
          		 $('#jj_jobselected_grade').html(json.find['job_grade']);
          		 $('#jj_jobselected_sg').html(((json.find['job_skill'] != null) ? json.find['job_skill'] : '**'));

                $('#jj_jobtarget_found').html( (json.match[0]['warning'] == true) ? '<a data-toggle="tooltip" title="'+json.match[0]['message']+'" >Found : '+json.recordsFiltered+' Job(s) Target &nbsp<i class="flaticon2-warning" style="color:red;"></i></a>' : 'Found : '+json.recordsFiltered+' Job(s) Target ');
          		 return json.data;
          	};
        	} else {
          	if (( json.status == 200) && (( json.message == 'Token expired!') || ( json.message == 'Token is required!') || ( json.message == 'Token is not accepted!'))) {
          		 timeoutError();
          	}
        	}
        },
  			cache: true,
  			data: function(d){
  				var hal = 1;
  				if(d.start > 0){
  					hal = (d.length/d.start)+1;
  				};
  				var param = {
  					p: (d.start/d.length)+1,
  					l: d.length,
  					r:'j2jtarget',
  					q:params,
  					ordType: d.order[0].dir,
  					ordBy: d.columns[d.order[0].column].data,
  					token: token
  				};
  				return param;
  			}
    },
  });

    let j2j_target_export_button;
    j2j_target_export_button = new $.fn.dataTable.Buttons(tblJobTarget, {
     buttons: [
       { extend: 'excel', className: 'btn btn-secondary', text: 'Export Result', exportOptions: { columns: ':visible' }  },
    ]
  }).container().appendTo($('#j2j_target_export_button'));

	tblJobFeed = $('#j2j_jobfeed_dt').DataTable({
		  autoWidth: true,
		  fixedHeader: true,
			deferRender:  !0,
			scrollY: '55vh',
			scrollX: true,
			scrollCollapse: !1,
			scroller:  !0,
			bFilter:  !1,
      bInfo : !1 ,
      paging:   false,
      serverSide: !0,
      destroy: !0,
			columns: [{
				title: "No.",
				orderable: !1,
				data: null,
				defaultContent: '',
				width: "2%",
				className: "text-right",
				render: function (data, type, full, meta) {
					return meta.settings._iDisplayStart + meta.row + 1;
				}
			},
			{data: "feeder_job_name", title: "Job Name", width: "40%"},
			{data: "feeder_job_skill", title: "Job Family", width: "48%", render: function ( data, type, row ) { return (data != null) ? data.replace("|", "<br>").replace("|", "<br>") : '';}},
			{data: "feeder_job_alnum_grade", title: "Grade", width: "10%", className: "text-center"},
			{data: "compatibility", title: "%Match", width: "2%", className: "text-center", render: function ( data, type, row ) { return data.toString().match(/\d+(\.\d{1,2})?/g)[0] + "%";}},
		],
    columnDefs: [
        {
          targets: 1,
          title: "Job Name",
          orderable: !0,
          render: function (a, e, t, n) {
              return '<a href="#" onclick="viewJobDetil(\''+t['feeder_job_id']+'\');" style="color: black">' + t['feeder_job_name'] + '</a>';
          },
        },
    ],
    ajax: {
        dataType: 'JSON',
        type: "GET",
        url: API_host+app+'/findjob?token='+token,
        beforeSend: function(){
        // blockPageSet('Processing ...');
        },
        dataSrc: function(json) {
        //	blockPage('off');
        	if ( json.error == false) {
          	if (( json.status == 200) && ( json.message == 'success')){
               $('#jj_jobfeed_found').html( (json.match[0]['warning'] == true) ? '<a data-toggle="tooltip" title="'+json.match[0]['message']+'" >Found : '+json.recordsFiltered+' Job(s) Feeder &nbsp<i class="flaticon2-warning" style="color:red;"></i></a>' : 'Found : '+json.recordsFiltered+' Job(s) Feeder ');
          		 return json.data;
          	};
        	} else {
          	if (( json.status == 200) && (( json.message == 'Token expired!') || ( json.message == 'Token is required!') || ( json.message == 'Token is not accepted!'))) {
          		 timeoutError();
          	}
        	}
        },
  			cache: true,
  			data: function(d){
  				var hal = 1;
  				if(d.start > 0){
  					hal = (d.length/d.start)+1;
  				};
  				var param = {
  					p: (d.start/d.length)+1,
  					l: d.length,
  					r:'j2jfeeder',
  					q:params,
  					ordType: d.order[0].dir,
  					ordBy: d.columns[d.order[0].column].data,
  					token: token
  				};
  				return param;
  			}
    },
  });

    let j2j_feed_export_button;
    j2j_feed_export_button = new $.fn.dataTable.Buttons(tblJobFeed, {
     buttons: [
       { extend: 'excel', className: 'btn btn-secondary', text: 'Export Result', exportOptions: { columns: ':visible' }  },
    ]
  }).container().appendTo($('#j2j_feed_export_button'));
};


$(window).scroll(function () {
//	alert(window.innerWidth);
 var scrollPos = $(window).scrollTop().valueOf();
 if (scrollPos != 0 ) {
    if (scrollPos > 3){
      window.scrollTo(0, 20);
    	setVisibility(['find_parameter','j2p_found_desc','p2j_found_desc','j2j_found_desc'],'div',false);
    	setVisibility(['j2p_breadcrumb','p2j_breadcrumb','j2j_breadcrumb'],'div',true);
    } else {
    	  if (scrollPos < 3) {
    	  	window.scrollTo(0, 0);
          switch(true) {
            case ($('#tool_method').val()=='1'):
          	    setVisibility(['j2p_found_desc'],'div',($('#j2pres').val()=='1'));
          	    setVisibility(['p2j_found_desc','j2j_found_desc'],'div',false);
              break;
            case ($('#tool_method').val()=='2'):
          	    setVisibility(['p2j_found_desc'],'div',($('#p2jres').val()=='1'));
          	    setVisibility(['j2p_found_desc','j2j_found_desc'],'div',false);
              break;
            case ($('#tool_method').val()=='3'):
          	    setVisibility(['j2j_found_desc'],'div',($('#j2jres').val()=='1'));
          	    setVisibility(['p2j_found_desc','j2p_found_desc'],'div',false);
              break;
          }
    	    setVisibility(['find_parameter'],'div',true);
    	    setVisibility(['j2p_breadcrumb','p2j_breadcrumb','j2j_breadcrumb'],'div',false);
    	  }
    }
 }

});

$('#j2j_jobtarget_dt, #j2j_jobfeed_dt, #j2p_personfeed_dt, #p2j_jobtarget_dt, #p2j_personfeed_dt').mouseover(function(){
	if (($('.dataTables_scrollBody').get(0).scrollTop>0) || ($('.dataTables_scrollBody').get(0).scrollTop>350)){
  		window.scrollTo(0, 20);
	}
}).mouseout(function(){
//	do nothing
});

$(document).ready(function() {
   renderParameter($('#size_method').val());
   setVal2(['tool_method','hide_result','size_method_selected'],'1');
   setVal2(['comp_type','method_selected'],'0');
   setVal2(['j2pres','p2jres','j2jres'],'0');
   fillReference('select-one', 'grade_job', '', $('#job_id'), '', '', false);
   fillReference('select-one', 'grade_person', '', $('#employee_id'), '', '', false);
});