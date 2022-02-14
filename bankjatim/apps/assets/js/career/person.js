var tblEmployee;
var cSS = 0;
var cCO = 0;

$('#kt_form_crud .form-control').on('change', function (e) {
    changeAction(e.currentTarget.type, e.currentTarget.id, e.currentTarget.value)
});

$("#dt_add_data").on("click", function () {
    renderFill();
    $("#data_crud").show();
    $('#modul_title').html('<h3 class="card-label">Input Person</h3>');
    setVisibility(['deleteButton', 'backButton', 'data_filter', 'data_list', 'tool_button'], 'obj', false);
});

$("#dt_filter_data").on("click", function () {
    $("#data_filter").show();
});

$("#dt_print_data").on("click", function () {
    tblEmployee.button('.buttons-print').trigger();
});

function renderFill() {
    fillReference('radio', 'code_gender', '', $('#gender'), 2, '', false);
    fillReference('select-one', 'code_agama', '', $('#agama'), '', '', false);
    fillReference('select-one', 'code_confirm', '', $('#mp'), '', '', false);
    fillReference('select-one', 'code_confirm', '', $('#top_talent'), '', '', false);
    fillReference('select-one', 'code_penggolongan', '', $('#penggolongan'), '', '', false);
    fillReference('select-one', 'code_pendidikan', '', $('#pendidikan'), '', '', false);
    fillReference('select-one', 'code_talentbox', '', $('#talentbox'), '', '', false);
    fillReference('select-one','code_plevel','',$('#performance_level'),'','',false);
    fillReference('select-one', 'code_assessment', '', $('#assessment'), '', '', false);
    fillReference('select-one', 'code_caspirasi', '', $('#aspirasi'), '', '', false);
    fillReference('select-one', 'code_flexibility', '', $('#flexibility'), '', '', false);
    fillReference('select-one', 'code_retention', '', $('#retention'), '', '', false);
    fillReference('select-one', 'job', '', $('#job_id'), '', '', false);
    fillReference('select-one', 'persongrade', '', $('#person_grade'), '', '', false);
    fillReference('select-one', 'subskill', '', $('#person_sjf'), '', '', false);
}

function addformShow() {
    renderFill();
    $("#data_crud").show();
    $('#modul_title').html('<h3 class="card-label">Input Person</h3>');
    setVisibility(['deleteButton', 'backButton', 'data_filter', 'data_list', 'tool_button'], 'obj', false);
}

function filterformShow() {
    $("#data_filter").show();
}

function renderView(parent, data) {
    let jsonField;
    var jsonData = JSON.parse(JSON.stringify(data));
    $(parent).find('div').map(function () {
        if (this.id !== '') {
            jsonField = (this.id).replace('v_', '');
            $('#' + this.id + '').html(jsonData['' + jsonField + '']);
        }
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

function viewDetil(id) {
    $('#modul_title').html('<h3 class="card-label">Person Information</h3>');
    $.getJSON(API_host + app + '/employee?token=' + token + '&id=' + id, function (resp) {
        if (resp.message == 'success' && resp.length > 0) {
            renderView('#form_view', resp.data[0]);
            let mp = resp.data[0]['mp'] == 1 ? 'Yes' : 'No';
            let topTalent = resp.data[0]['top_talent'] == 1 ? 'Yes' : 'No';
            let retTxt = convertPlevel(resp.data[0]['performance_level'], 1);
            let retTxt1 = convertPlevel(resp.data[0]['performance_year1'], 1);
            let retTxt2 = convertPlevel(resp.data[0]['performance_year2'], 1);
            $('#v_performance_level').empty().html(retTxt);
            $('#v_performance_year1').empty().html(retTxt1);
            $('#v_performance_year2').empty().html(retTxt2);
            $('#v_mp').empty().html(mp);
            $('#v_top_talent').empty().html(topTalent);
            if (resp.data[0]['job_id'] != 0){
                $.getJSON(API_host + app + '/job?token=' + token + '&id=' + resp.data[0]['job_id'], function (resp){
                    renderView('#form_view', resp.data[0]);
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
            $('#v_masa_kerja').html(elapsed);
        }
    });
    $("#form_view").show();
    setVisibility(['submitButton', 'deleteButton', 'cancelButton', 'tool_button', 'data_filter', 'data_list'], 'obj', false);
    //setVisibility(['action_button'],'div',false);
}

function editDetil(id) {
    $('#modul_title').html('<h3 class="card-label">Modify Data<div class="text-muted pt-2 font-size-sm">Person Data Modify</div></h3>');
    /*$('#form_crud').find('#typeaheadJob').empty();
    $('#form_crud').find('#repeaterList1').empty();
    $('#form_crud').find('#repeaterList2').empty();*/

    $.getJSON(API_host + app + '/employee?token=' + token + '&id=' + id, function (resp) {
        if (resp.message == 'success' && resp.length > 0) {

            var completeData = Object.assign({}, {form_method: 'PUT'}, resp.data[0]);
            var jsonData = JSON.parse(JSON.stringify(completeData));
            let sjf = jsonData['person_sjf_id'];
            if (sjf != null) {
                sjf = sjf.split(' | ');
                for (i = 0; i < (sjf.length - 1); i++) {
                    $('#addSkillBtn').click();
                }
                for (j = 0; j < sjf.length; j++) {
                    if (j == 0) {
                        fillReference('select-one', 'subskill', '', $('#person_sjf'), '', sjf[j], false);
                    } else {
                        fillReference('select-one', 'subskill', '', $('#person_sjf_' + j + ''), '', sjf[j], false);
                    }
                }
            } else {
                fillReference('select-one', 'subskill', '', $('#person_sjf'), '', sjf, false);
            }

            $('#gender').change(function () {
                dataForm['gender'] = jsonData['c_gender'];
            });

            $('#form_method').val(jsonData['form_method']).trigger('change');
            changeAction('text', 'form_method', 'PUT');
            $('#person_id').val(jsonData['person_id']).trigger('change');
            $('#person_number').val(jsonData['person_number']).trigger('change');
            $('#person_name').val(jsonData['person_name']).trigger('change');
            fillReference('select-one', 'persongrade', '', $('#person_grade'), '', jsonData['person_grade'], false);
            fillReference('select-one', 'code_confirm', '', $('#mp'), '', jsonData['mp'], false);
            fillReference('select-one', 'code_confirm', '', $('#top_talent'), '', jsonData['top_talent'], false);
            fillReference('radio', 'code_gender', '', $('#gender'), 2, jsonData['c_gender'], false);
            fillReference('select-one', 'code_agama', '', $('#agama'), '', jsonData['c_agama'], false);
            fillReference('select-one', 'code_penggolongan', '', $('#penggolongan'), '', jsonData['c_penggolongan'], false);
            fillReference('select-one', 'code_pendidikan', '', $('#pendidikan'), '', jsonData['c_pendidikan'], false);
            fillReference('select-one', 'code_talentbox', '', $('#talentbox'), '', jsonData['talentbox'], false);
            let cAssessment = jsonData['c_assessment'];
            switch (cAssessment) {
                case '1':
                    cAssessment = 1;
                    break;
                case '2':
                    cAssessment = 1;
                    break;
                case '3':
                    cAssessment = 3;
                    break;
                case '4':
                    cAssessment = 4;
                    break;
                case '5':
                    cAssessment = 4;
                    break;
                default:
                    cAssessment = jsonData['c_assessment'];
            }
            fillReference('select-one', 'code_assessment', '', $('#assessment'), '', cAssessment, false);
            fillReference('select-one', 'code_caspirasi', '', $('#aspirasi'), '', jsonData['c_aspirasi'], false);
            fillReference('select-one', 'code_flexibility', '', $('#flexibility'), '', jsonData['c_flexibility'], false);
            fillReference('select-one', 'code_retention', '', $('#retention'), '', jsonData['c_retention'], false);
            fillReference('select-one', 'job', '', $('#job_id'), '', jsonData['job_id'], false);
            $('#tgl_lahir').val(moment(jsonData['tgl_lahir'], 'DD-MM-YYYY').format('YYYY-MM-DD')).trigger('change');
            $('#tgl_masuk').val(moment(jsonData['tgl_masuk'], 'DD-MM-YYYY').format('YYYY-MM-DD')).trigger('change');
            $('#email').val(jsonData['email']).trigger('change');
            $('#performance_year1').val(jsonData['performance_year1']).trigger('change');
            $('#performance_year2').val(jsonData['performance_year2']).trigger('change');
            $('#notes').val(jsonData['notes']).trigger('change');
            // fillReference('select-one','code_plevel','',$('#performance_level'),'',convertPlevel(jsonData['performance_level']),false);
            // $('#performance_level').val(convertPlevel(jsonData['performance_level'])).trigger('change');
            // $('#job_jf').val(jsonData['job_jf']).trigger('change');
            // $('#job_sjf').val(jsonData['job_sjf']).trigger('change');
            // $('#job_grade').val(jsonData['job_grade']).trigger('change');
            $('#tmtgrade').val(moment(jsonData['tmtgrade'], 'DD-MM-YYYY').format('YYYY-MM-DD')).trigger('change');
            $('#pos1').val(jsonData['pos1']).trigger('change');
            $('#pos2').val(jsonData['pos2']).trigger('change');
            $('#pos3').val(jsonData['pos3']).trigger('change');
            $('#loc1').val(jsonData['loc1']).trigger('change');
            $('#loc2').val(jsonData['loc2']).trigger('change');
            $('#loc3').val(jsonData['loc3']).trigger('change');

            //console.log(dataForm);


            /*$('#v_agama').html(jsonData['agama']);
            $('#v_aspirasi').html(jsonData['aspirasi']);
            $('#v_assessment').html(jsonData['assessment']);
            $('#v_email').html(jsonData['email']);
            $('#v_flexibility').html(jsonData['flexibility']);
            $('#v_gender').html(jsonData['gender']);
            $('#v_jg').html(jsonData['jg']);
            $('#v_job_name').html(jsonData['job_name']);
            $('#v_loc1').html(jsonData['loc1']);
            $('#v_loc2').html(jsonData['loc2']);
            $('#v_loc3').html(jsonData['loc3']);
            $('#v_pendidikan').html(jsonData['pendidikan']);
            $('#v_name').html(jsonData['person_name']);
            $('#v_nik').html(jsonData['person_number']);
            $('#v_pg').html(jsonData['pg']);
            $('#v_pl').html(jsonData['pl']);
            $('#v_pos1').html(jsonData['pos1']);
            $('#v_pos2').html(jsonData['pos2']);
            $('#v_pos3').html(jsonData['pos3']);
            $('#v_retention').html(jsonData['retention']);
            $('#v_pjf').html(jsonData['subskill_name']);
            $('#v_jjf').html(jsonData['subskill_name']);
            $('#v_talentbox').html(jsonData['talentbox']);
            $('#v_tgl_masuk').html(moment(jsonData['tgl_masuk']).format('DD-MM-YYYY'));
            $('#v_tgl_lahir').html(moment(jsonData['tgl_lahir']).format('DD-MM-YYYY'));
            $('#v_tmtgrade').html(moment(jsonData['tmtgrade']).format('DD-MM-YYYY'));
            $('#v_penggolongan').html(jsonData['penggolongan_jabatan']);


            var given = moment(jsonData['tmtgrade'], 'YYYY-MM-DD');
            var current = moment().startOf('day');
            var elapsed = '';
            if (current.diff(given, 'years') > 0){
                elapsed = current.diff(given, 'years') + ' Tahun ' + (current.diff(given, 'months') - (current.diff(given, 'years')*12)) + ' Bulan';
            }else {
                elapsed = current.diff(given, 'months') + ' Bulan';
            }
            $('#v_masa_kerja').html(elapsed);*/
        }
    });
    /*$.getJSON(API_host + app + '/employee?token=' + token + '&id=' + id, function (resp) {
        if (resp.message == 'success' && resp.length > 0) {
            var completeData = Object.assign({}, {form_method: 'PUT'}, resp.data[0]);
            // console.log('kacang1');
            // renderDataForm('kt_form_crud', completeData);
            var jsonData = JSON.parse(JSON.stringify(completeData));
            // console.log(jsonData);
            //alert(JSON.stringify(data));

            var elements = document.forms['kt_form_crud'].elements;
            // console.log(elements[15]);
            for( var i = 0, l = elements.length; i < l; i++ ) {
                //alert(elements[i].id+'-->'+elements[i].type+'-->'+jsonData[elements[i].id]);
                dataField    = (jsonData[elements[i].id] != null) ? jsonData[elements[i].id] : '';
                element_id   = elements[i].id;
                element_type = elements[i].type;
                switch(true) {
                    case (element_type === 'select-one'):
                        fillReference(element_type, 'job', '', $('#job_id'), '', dataField, false);
                        break;
                    case (element_type === 'hidden'):
                        if (element_id != '') {
                            $('#' + element_id).val(dataField);
                            $('#' + element_id).trigger('change');
                        }
                        break;
                    case ((element_type === 'text') || (element_type === 'email')):
                        if (element_id != ''){
                            $('#'+element_id).val(dataField);
                            $('#'+element_id).trigger('change');
                        }
                        break;
                }

            }
            // console.log('kacang2');
            // console.log(jsonData['job_name_view']);
            $('input#job_name').val(jsonData['job_name_view']);
        }
        ;
    });
    $.getJSON(API_host + app + '/personskillmap?token=' + token + '&id=' + id, function (resp) {
        if (resp.message == 'success' && resp.length > 0) {
            var ss = '';
            var countss = 0;
            var jsonData = JSON.parse(JSON.stringify(resp.data));
            // console.log(jsonData);
            for( var i = 0, l = jsonData.length; i < l; i++ ){
                if (i == 0){
                    // console.log('kacang');
                    /!*ss +=   '<div data-repeater-item class="form-group row mb-2">' +
                                '<div class="col-lg-10">' +
                                    '<div class="typeahead">' +
                                        '<input class="form-control subskill_name" id="subskill_name" name="subskill_name" placeholder="Employee Subskill" type="text" onchange="checkDuplicate(\'subskill_name\')" value="'+jsonData[i]['subskill_name']+'" />' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-lg-2 removeButton_subskill" style="display: none">' +
                                    '<a class="btn font-weight-bold btn-danger btn-icon subskill_name_rmbtn" data-repeater-delete="">' +
                                        '<i class="la la-remove"></i>' +
                                    '</a>' +
                                '</div>' +
                                '<div class="col-lg-2 addButton_subskill">' +
                                    '<a id="" class="btn font-weight-bold btn-primary btn-icon" data-repeater-create="">' +
                                        '<i class="la la-plus"></i>' +
                                    '</a>' +
                                '</div>' +
                            '</div>';*!/
                    $('#subskill_name').val(jsonData[i]['subskill_name']);
                }else{
                    ss +=   '<div data-repeater-item class="form-group row mb-2">' +
                                '<div class="col-lg-10">' +
                                    '<div class="typeahead">' +
                                        '<input class="form-control subskill_name" id="subskill_name_'+i+'" name="subskill_name_'+i+'" placeholder="Employee Subskill" type="text" onchange="checkDuplicate(\'subskill_name_'+i+'\')" value="'+jsonData[i]['subskill_name']+'" />' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-lg-2 removeButton_subskill">' +
                                    '<a class="btn font-weight-bold btn-danger btn-icon subskill_name_rmbtn" onclick="removeData(\'subskill_name_'+i+'\')" data-repeater-delete="">' +
                                        '<i class="la la-remove"></i>' +
                                    '</a>' +
                                '</div>' +
                                '<div class="col-lg-2 addButton_subskill" style="display: none">' +
                                    '<a id="" class="btn font-weight-bold btn-primary btn-icon" data-repeater-create="">' +
                                        '<i class="la la-plus"></i>' +
                                    '</a>' +
                                '</div>' +
                            '</div>';
                    countss++;
                }
            }
            cSS = countss;
            $('#repeaterList1').append(ss);

            for (x=0;x<countss;x++){
                if (x===0){
                    suggest_subskill('subskill_name');
                }else{
                    suggest_subskill('subskill_name_'+x);
                }
            }
        }
    });
    $.getJSON(API_host+ app +'/personcompetency?token='+ token +'&id='+id, function(resp) {
        if (resp.message == 'success' && resp.length > 0) {
            // console.log(resp.data[0]);
            var co = '';
            var countco = 0;
            var jsonData = JSON.parse(JSON.stringify(resp.data));
            // console.log(jsonData);
            for( var i = 0, l = jsonData.length; i < l; i++ ){
                if (i == 0){
                    $('#competency_name').val(jsonData[i]['competency_name']);
                    $('#level_id').val(jsonData[i]['level_id']);
                }else{
                    co +=   '<div data-repeater-item="" class="form-group row" style="">\n' +
                                '<div class="col-lg-5">' +
                                    '<div class="typeahead">' +
                                        '<input class="form-control competency_name" id="competency_name_'+i+'" name="competency_name_'+i+'" placeholder="Employee Competency" type="text" onchange="checkDuplicate(\'competency_name_'+i+'\')" value="'+jsonData[i]['competency_name']+'" />' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-lg-5">' +
                                    '<div class="input-group">' +
                                        '<input id="level_id_1" name="level_id_'+i+'" class="form-control level_id" placeholder="Level" type="text" onchange="repeaterOnchange(\'level_id_'+i+'\')" value="'+jsonData[i]['level_id']+'">' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-lg-2 removeButton_competency" style="display: block;">' +
                                    '<a class="btn font-weight-bold btn-danger btn-icon competency_name_rmbtn" data-repeater-delete="" onclick="removeData(\'competency_name_'+i+'\')">' +
                                        '<i class="la la-remove"></i>' +
                                    '</a>' +
                                '</div>' +
                                '<div class="col-lg-2 addButton_competency" style="display: none;">' +
                                    '<a class="btn font-weight-bold btn-primary btn-icon" data-repeater-create="">' +
                                        '<i class="la la-plus"></i>' +
                                    '</a>' +
                                '</div>' +
                            '</div>';
                    countco++;
                }
            }
            cCO = countco;
            $('#repeaterList2').append(co);

            for (x=0;x<countco;x++){
                if (x===0){
                    suggest_competency('competency_name');
                }else{
                    suggest_competency('competency_name_'+x);
                }
            }
        }
    });*/
    $("#data_crud").show();
    setVisibility(['deleteButton', 'backButton', 'tool_button', 'data_filter', 'data_list'], 'obj', false);
}

function deleteDetil(id) {
    Swal.fire({
        title: "Delete Person Data ?",
        text: "Please check the information that you want to delete.",
        icon: "warning",
        showCancelButton: true,
        cancelButtonClass: "btn btn-light-info", cancelButtonColor: "#d6d6d7", cancelButtonText: "Cancel",
        confirmButtonClass: "btn btn-danger", confirmButtonText: "Delete",
        closeOnConfirm: false,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: API_host + app + '/employee?token=' + token + '&id=' + id,
                type: 'DELETE',
                data: dataForm,
                beforeSend: function () {
                    blockPage('on');
                },
                error: function () {
                    blockPage('off');
                    showMessage('Delete Data Fail', 'Connection problem to database/query access: ' + error, 'error', 'btn btn-danger');
                },
                success: function (resp) {
                    blockPage('off');
                    if (resp.error == false) {
                        if ((resp.status == 200) && (resp.message == 'success')) {
                            sumbmitSuccess('Data has been deleted.', host + app + '/sModule/person');
                        } else {
                            showMessage('Warning', resp.message, 'warning', 'btn btn-warning');
                        }
                    } else {
                        if ((resp.status == 200) && (resp.message == 'Token expired!')) {
                            timeoutError();
                        } else {
                            showMessage('Error', resp.message, 'error', 'btn btn-danger');
                        }
                        ;
                    }
                    ;
                }
            });
        } else {
            showMessage('Cancel', 'Data save canceled.', 'error', 'btn btn-danger');
        }
    });
}

function renderGrid() {
    tblEmployee = $('#kt_datatable').DataTable({
        dom: "<'row'<'col-sm-2'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        autoWidth: true,
        //fixedHeader: true,
        //deferRender:  !0,
        //scrollY: '450px',
        scrollX: true,
        scrollCollapse: !0,
        responsive: !1,
        searchDelay: 500,
        // processing: !0,
        serverSide: !0,
        destroy: !0,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        bLengthChange: !0,
        buttons: [
            {
                extend: 'print',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
            },
        ],
        columns: [{
            title: "No.",
            orderable: !1,
            data: null,
            defaultContent: '',
            width: "1%",
            className: "text-right",
            render: function (data, type, full, meta) {
                return meta.settings._iDisplayStart + meta.row + 1;
            }
        },
            {data: null, title: "Action", width: "1%"},
            {data: "person_number", title: "NIP", width: "8%"},
            {data: "person_name", title: "Name", width: "25%"},
            {data: "person_grade", title: "Person Grade", width: "5%", className: "text-center",},
            {data: "person_jf", title: "Person Job Family", width: "15%"},
            {data: "job_name", title: "Job", width: "15%"},
            {data: "mp", title: "Under Supervision", width: "15%"},
            {data: "c_assessment", title: "Assessment", width: "15%"},
        ],
        columnDefs: [
            {
                targets: 7,
                render: function (a, e, t, n) {
                    var s = {
                        0: {'title': 'No', 'state': 'success'},
                        1: {'title': 'Yes', 'state': 'danger'},
                    };
                    return void 0 === s[a] ? a : '<span class="font-weight-bold text-' + s[a].state + '">' + s[a].title + '</span>';
                },
            },
            {
                targets: 8,
                render: function (a, e, t, n) {
                    var s = {
                        1: {'title': 'Low', 'state': 'default'},
                        2: {'title': 'Low', 'state': 'default'},
                        3: {'title': 'Medium', 'state': 'warning'},
                        4: {'title': 'High', 'state': 'danger'},
                        5: {'title': 'High', 'state': 'danger'},
                    };
                    return void 0 === s[a] ? a : '<span class="font-weight-bold text-' + s[a].state + '">' + s[a].title + '</span>';
                },
            },
            {
                targets: 1,
                title: "Action",
                orderable: !1,
                render: function (a, e, t, n) {
                    //	alert(t['id']);
                    actbutton = '<div class="dropdown dropdown-inline">';
                    actbutton += '  <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"><i class="flaticon-more"></i></a>';
                    actbutton += '    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">';
                    actbutton += '       <ul class="nav nav-hoverable flex-column">';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#view_data" onclick="viewDetil(\'' + t['person_id'] + '\');"><i class="nav-icon la la-clipboard-list"></i><span class="nav-text">View Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="editDetil(\'' + t['person_id'] + '\');"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="deleteDetil(\'' + t['person_id'] + '\');"><i class="nav-icon la la-trash"></i><span class="nav-text">Delete Record</span></a></li>';
                    //actbutton += '          <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-leaf"></i><span class="nav-text">Update Status</span></a></li>';
                    actbutton += '       </ul>';
                    actbutton += '     </div>';
                    actbutton += '</div>';
                    return actbutton;
                },
            },
        ],
        ajax: {
            dataType: 'JSON',
            type: "GET",
            url: API_host + app + '/employee?token=' + token,
            beforeSend: function () {
                blockPageSet('Processing ...');
            },
            dataSrc: function (json) {
                blockPage('off');
                if (json.error == false) {
                    if ((json.status == 200) && (json.message == 'success')) {
                        return json.data;
                    }
                    ;
                } else {
                    if ((json.status == 200) && (json.message == 'Token expired!')) {
                        timeoutError();
                    }
                }
            },
            cache: true,
            data: function (d) {
                var hal = 1;
                if (d.start > 0) {
                    hal = (d.length / d.start) + 1;
                }
                ;
                var param = {
                    p: (d.start / d.length) + 1,
                    l: d.length,
                    f: $('#find_data').val(),
                    x: $('#find_mp').val(),
                    r: $('#find_assesment').val(),
                    ordType: d.order[0].dir,
                    ordBy: d.columns[d.order[0].column].data,
                    token: token
                };
                return param;
            }
        },
    });

    $('#kt_search').on('click', function (e) {
        e.preventDefault();

        var params = {};
        $('.datatable-input').each(function () {
            var i = $(this).data('col-index');
            if (params[i]) {
                params[i] += '|' + $(this).val();
            } else {
                params[i] = $(this).val();
            }
        });
        $.each(params, function (i, val) {
            // apply search params to datatable
            tblEmployee.column(i).search(val ? val : '', false, false);
        });
        tblEmployee.table().draw();
    });

    $('#kt_reset').on('click', function (e) {
        e.preventDefault();
        $('.datatable-input').each(function () {
            $(this).val('');
            tblEmployee.column($(this).data('col-index')).search('', false, false);
        });
        tblEmployee.table().draw();
        $("#data_filter").hide();
    });
}

function checkDuplicate(id) {
    var arr = [];
    field = document.querySelectorAll('.' + id);
    for (i = 0; i < field.length; i++) {
        if (field[i].value === '') {
            continue;
        }
        arr.push(field[i].value);
    }
    var uniqueArr = Array.from(new Set(arr));
    if (arr.length !== uniqueArr.length) {
        // console.log('kacang')
        swal.fire({
            title: 'Duplicate Value!',
            icon: 'warning'
        }).then(function () {
            const duplicate = arr.filter((item, index) => index !== arr.indexOf(item));
            var duplicateIndex = arr.lastIndexOf("" + duplicate + "");
            field[duplicateIndex].value = '';
        });
    }
}

function inputArr(id) {
    x = document.querySelectorAll('.' + id);
    for (i = 0; i < x.length; i++) {
        dataForm[id + '_' + i] = x[i].value;
    }
}

function removeData(id) {
    if (id.match(/competency_name_\d/)) {
        var num = id.split('_');
        delete dataForm[id];
        delete dataForm['level_id_' + num[2]];
    } else {
        delete dataForm[id];
    }
}

function repeaterOnchange(id) {
    checkDuplicate(id);
    changeAction('select-one', id, $('#' + id).val());
}

$('#job_id').change(function () {
    if ($('#job_id').val() != '') {
        let idJob = $('#job_id').val();
        $.getJSON(API_host + app + '/job?token=' + token + '&id=' + idJob, function (resp) {
            if (resp.message == 'success' && resp.length > 0) {
                var jsonData = JSON.parse(JSON.stringify(resp.data[0]));

                $('#job_jf').val(jsonData['job_jf']);
                $('#job_sjf').val(jsonData['job_sjf']);
                $('#job_grade').val(jsonData['job_grade']);
            }
        });
    }
});

$("#submitButton").click(function (e) {
    e.preventDefault();
    /*inputArr('subskill_name');
    inputArr('competency_name');
    inputArr('level_id');*/

    Swal.fire({
        title: "Save Person Data ?",
        text: "Please check the information that has been filled in is correct.",
        icon: "info",
        showCancelButton: true,
        cancelButtonClass: "btn btn-light-info", cancelButtonColor: "#d6d6d7", cancelButtonText: "Cancel",
        confirmButtonClass: "btn btn-info", confirmButtonText: "Save",
        closeOnConfirm: false,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: API_host + app + '/employee?token=' + token,
                type: JSON.parse(JSON.stringify(dataForm))['form_method'],
                data: dataForm,
                beforeSend: function () {
                    blockPage('on');
                },
                error: function () {
                    blockPage('off');
                    showMessage('Save Data Fail', 'Connection problem to database/query access: ' + error, 'error', 'btn btn-danger');
                },
                success: function (resp) {
                    blockPage('off');
                    if (resp.error == false) {
                        if ((resp.status == 200) && (resp.message == 'success')) {
                            sumbmitSuccess('Data has been added/modify.', host + app + '/sModule/person');
                        } else {
                            showMessage('Warning', resp.message, 'warning', 'btn btn-warning');
                        }
                    } else {
                        if ((resp.status == 200) && (resp.message == 'Token expired!')) {
                            timeoutError();
                        } else {
                            showMessage('Error', resp.message, 'error', 'btn btn-danger');
                        }
                        ;
                    }
                    ;
                }
            });
        } else {
            showMessage('Cancel', 'Data save canceled.', 'error', 'btn btn-danger');
        }
    });
});

$("#deleteButton").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Delete Person Data ?",
        text: "Please check the information that you want to delete.",
        icon: "warning",
        showCancelButton: true,
        cancelButtonClass: "btn btn-light-info", cancelButtonColor: "#d6d6d7", cancelButtonText: "Cancel",
        confirmButtonClass: "btn btn-danger", confirmButtonText: "Delete",
        closeOnConfirm: false,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: API_host + app + '/employee?token=' + token,
                type: 'DELETE',
                data: dataForm,
                beforeSend: function () {
                    blockPage('on');
                },
                error: function () {
                    blockPage('off');
                    showMessage('Delete Data Fail', 'Connection problem to database/query access: ' + error, 'error', 'btn btn-danger');
                },
                success: function (resp) {
                    blockPage('off');
                    if (resp.error == false) {
                        if ((resp.status == 200) && (resp.message == 'success')) {
                            sumbmitSuccess('Data has been deleted.', host + app + '/sModule/employee');
                        } else {
                            showMessage('Warning', resp.message, 'warning', 'btn btn-warning');
                        }
                    } else {
                        if ((resp.status == 200) && (resp.message == 'Token expired!')) {
                            timeoutError();
                        } else {
                            showMessage('Error', resp.message, 'error', 'btn btn-danger');
                        }
                        ;
                    }
                    ;
                }
            });
        } else {
            showMessage('Cancel', 'Data save canceled.', 'error', 'btn btn-danger');
        }
    });
});

$("#cancelButton").click(function (e) {
    e.preventDefault();

    Swal.fire({
        title: "Cancel ?",
        text: "Cancel add/modify data process.",
        icon: "question",
        showCancelButton: true,
        cancelButtonClass: "btn btn-light-warning", cancelButtonColor: "#d6d6d7", cancelButtonText: "No",
        confirmButtonClass: "btn btn-warning", confirmButtonText: "Yes",
        closeOnConfirm: false,
        allowOutsideClick: false
    }).then(function (result) {
        if (result.value) {
            window.location.href = host + app + '/sModule/person'
        }
    });
});

$("#backButton").click(function (e) {
    e.preventDefault();
    window.location.href = host + app + '/sModule/person';
});

function getSkill(divId, corespondId) {
    let id = $('#' + divId + '').val();
    if (id != '') {
        $.getJSON(API_host + app + '/skilldata?token=' + token + '&id=' + id, function (resp) {
            if (resp.message == 'success' && resp.length > 0) {
                var jsonData = JSON.parse(JSON.stringify(resp.data[0]));

                $('#' + corespondId + '').val(jsonData['skill_name']);
            }
        });
        repeaterOnchange(divId);
    }
}


// Class definition
var KTFormRepeater = function () {

    // Private functions
    var demo1 = function () {
        $('#kt_repeater_1').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                cSS++;
                jf = document.querySelectorAll('.person_jf');
                sjf = document.querySelectorAll('.person_sjf');
                // ss = document.querySelectorAll('.subskill_name');
                addBtn = document.querySelectorAll('.addButton_subskill');
                rmBtn = document.querySelectorAll('.removeButton_subskill');
                rmBtnId = document.querySelectorAll('.subskill_name_rmbtn');

                $(this).slideDown();
                addBtn[addBtn.length - 1].style.display = 'none';
                rmBtn[rmBtn.length - 1].style.display = 'block';
                jf[jf.length - 1].id = 'person_jf_' + cSS;
                jf[jf.length - 1].setAttribute('name', 'person_jf_' + cSS);
                jf[jf.length - 1].setAttribute('onchange', 'repeaterOnchange(\'' + jf[jf.length - 1].id + '\')');
                sjf[sjf.length - 1].id = 'person_sjf_' + cSS;
                sjf[sjf.length - 1].setAttribute('name', 'person_sjf_' + cSS);
                // sjf[sjf.length-1].setAttribute('onchange','repeaterOnchange(\''+sjf[sjf.length-1].id+'\')');
                sjf[sjf.length - 1].setAttribute('onchange', 'getSkill(\'' + sjf[sjf.length - 1].id + '\', \'' + jf[jf.length - 1].id + '\')');
                rmBtnId[rmBtnId.length - 1].setAttribute('onClick', 'removeData(\'' + sjf[sjf.length - 1].id + '\')');
                // suggest_subskill(ss[ss.length-1].id);
                fillReference('select-one', 'subskill', '', $('#' + sjf[sjf.length - 1].id + ''), '', '', false);
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
        /*$('#kt_repeater_3').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                cCO++;
                co = document.querySelectorAll('.competency_name');
                lv = document.querySelectorAll('.level_id');
                addBtn = document.querySelectorAll('.addButton_competency');
                rmBtn = document.querySelectorAll('.removeButton_competency');
                rmBtnId = document.querySelectorAll('.competency_name_rmbtn');

                $(this).slideDown();
                addBtn[addBtn.length-1].style.display = 'none';
                rmBtn[rmBtn.length-1].style.display = 'block';
                co[co.length-1].id = 'competency_name_'+cCO;
                co[co.length-1].setAttribute('name','competency_name_'+cCO);
                lv[lv.length-1].id = 'level_id_'+cCO;
                lv[lv.length-1].setAttribute('name','level_id_'+cCO);
                co[co.length-1].setAttribute('onchange','repeaterOnchange(\''+co[co.length-1].id+'\')');
                lv[lv.length-1].setAttribute('onchange','repeaterOnchange(\''+lv[lv.length-1].id+'\')');
                rmBtnId[rmBtnId.length-1].setAttribute('onClick','removeData(\''+co[co.length-1].id+'\')');
                suggest_competency(co[co.length-1].id);
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });*/
    };

    return {
        // public functions
        init: function () {
            demo1();
        }
    };
}();

var suggest_job = function () {
    $.getJSON(API_host + app + '/suggestValue?token=' + token + '&ref=job', function (resp) {
        var suggest_job = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('job_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: resp.data,
        });

        $('#job_name').typeahead(
            {
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'list_job_name',
                display: 'job_name',
                source: suggest_job,
                templates: {
                    empty: [
                        '<div class="empty-message" style="padding: 1rem; text-align: center">',
                        'There\'s no matching job, this data will be added as a new job',
                        '</div>'
                    ].join('\n'),
                    suggestion: Handlebars.compile('<div><strong>{{job_name}}</strong></div>')
                }
            }
        );


    });
};

var suggest_subskill = function (id = 'subskill_name') {
    $.getJSON(API_host + app + '/suggestValue?token=' + token + '&ref=subskill', function (resp) {
        var suggest_subskill = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('subskill_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: resp.data,
        });

        $('#' + id).typeahead(
            {
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'list_subskill_name',
                display: 'subskill_name',
                source: suggest_subskill,
                templates: {
                    empty: [
                        '<div class="empty-message" style="padding: 1rem; text-align: center">',
                        'There\'s no matching subskill, this data will be added as a new subskill',
                        '</div>'
                    ].join('\n'),
                    suggestion: Handlebars.compile('<div><strong>{{subskill_name}}</strong></div>')
                }
            });


    });
};

var suggest_competency = function (id = 'competency_name') {
    $.getJSON(API_host + app + '/suggestValue?token=' + token + '&ref=competency', function (resp) {
        var suggest_competency = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('competency_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: resp.data,
        });

        $('#' + id).typeahead(
            {
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'list_competency_name',
                display: 'competency_name',
                source: suggest_competency,
                templates: {
                    empty: [
                        '<div class="empty-message" style="padding: 1rem; text-align: center">',
                        'There\'s no matching competency, this data will be added as a new competency',
                        '</div>'
                    ].join('\n'),
                    suggestion: Handlebars.compile('<div><strong>{{competency_name}}</strong></div>')
                }
            });


    });
};

/*var KTTypeahead = function(){
    var suggest_job = function() {
        $.getJSON(API_host+app+'/suggestValue?token='+token+'&ref=job', function(resp) {
            var suggest_job = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('job_name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: resp.data,
            });

            $('#job_name').typeahead(
                {
                    hint: true,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'list_job_name',
                    display: 'job_name',
                    source: suggest_job,
                    templates: {
                        empty: [
                            '<div class="empty-message" style="padding: 1rem; text-align: center">',
                            'There\'s no matching job, this data will be added as a new job',
                            '</div>'
                        ].join('\n'),
                        suggestion: Handlebars.compile('<div><strong>{{job_name}}</strong></div>')
                    }
                });


        });
    };

    var suggest_subskill = function(id) {
        $.getJSON(API_host+app+'/suggestValue?token='+token+'&ref=subskill', function(resp) {
            var suggest_subskill = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('subskill_name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: resp.data,
            });

            $('.subskill_name').typeahead(
                {
                    hint: true,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'list_subskill_name',
                    display: 'subskill_name',
                    source: suggest_subskill,
                    templates: {
                        empty: [
                            '<div class="empty-message" style="padding: 1rem; text-align: center">',
                            'There\'s no matching subskill, this data will be added as a new subskill',
                            '</div>'
                        ].join('\n'),
                        suggestion: Handlebars.compile('<div><strong>{{subskill_name}}</strong></div>')
                    }
                });


        });
    };
    var suggest_competency = function(id) {
        $.getJSON(API_host+app+'/suggestValue?token='+token+'&ref=competency', function(resp) {
            var suggest_competency = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('competency_name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: resp.data,
            });

            $('.competency_name').typeahead(
                {
                    hint: true,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'list_competency_name',
                    display: 'competency_name',
                    source: suggest_competency,
                    templates: {
                        empty: [
                            '<div class="empty-message" style="padding: 1rem; text-align: center">',
                            'There\'s no matching competency, this data will be added as a new competency',
                            '</div>'
                        ].join('\n'),
                        suggestion: Handlebars.compile('<div><strong>{{competency_name}}</strong></div>')
                    }
                });


        });
    }

    return {
        // public functions
        init: function(idx,idy) {
            suggest_job();
            suggest_subskill(idx);
            suggest_competency(idy);
        }
    };
}();*/

$(document).ready(function () {
    setVal('form_method', 'POST');
    // renderFill();
    KTFormRepeater.init();
    /*suggest_job();
    suggest_subskill();
    suggest_competency();*/
    renderGrid();
});

