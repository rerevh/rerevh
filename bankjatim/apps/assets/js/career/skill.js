var tblSkill,tblSubskill,tblSkillmap;
var cSS = 0;
var tabName = 'Skill';
var matrix_type = 0;
var stsSkill = stsSubskill = stsSkillmap = 0;

$('#kt_form_crud .form-control, #compabilityModal .form-control').on('change', function (e) {
	if (e.currentTarget.name == 'comp_index') {
		$('#comp_value').val(e.currentTarget.id.split("_")[2])		
	};
  changeAction(e.currentTarget.type, e.currentTarget.id, e.currentTarget.value)
});

$("#dt_add_data").on("click", function() {
    //alert(tabName);
    switch (tabName) {
        case 'Skill':
            $('#form_skill').show();
            $('#form_subskill').hide();
            $('#form_skillmap').hide();
            break;
        case 'Subskill':
            $('#form_skill').hide();
            $('#form_subskill').show();
            $('#form_skillmap').hide();
            break;
        case 'Skillmap':
            $('#form_skill').hide();
            $('#form_subskill').hide();
            $('#form_skillmap').show();
            fillReference('select-one','skill','',$('#skill_id_select'),'','',false);
            fillReference('select-one','subskill','',$('#subskill_id_select'),'','',false);
            break;
    }
    $("#data_crud").show();
    $('#modul_title').html('<h3 class="card-label">Input Data</h3>');
    setVisibility(['deleteButton', 'data_filter', 'data_list', 'tool_button'], 'obj', false);
});	

$("#dt_filter_data").on("click", function() {
  $("#data_filter").show(); 
});	

$("#dt_print_data").on("click", function() {
    switch (tabName) {
        case 'Skill':
            tblSkill.button( '.buttons-print' ).trigger();    
            break;
        case 'Subskill':
            tblSubskill.button( '.buttons-print' ).trigger();      
            break;
        case 'Skillmap':
            tblSkillmap.button( '.buttons-print' ).trigger();       
            break;
    }	    
});

$('body').on('click', '.remove_row', function(){
    $(this).closest('.row').fadeOut();
    count--;

});

$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
   $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
});

$('#matrix_parameter .form-control').on('change', function(e){
	matrix_type = this.value;
	//alert(matrix_type);

});

function stringDivider(str, width, spaceReplacer) {
  if (str.length>width) {
    var p=width
    for (;p>0 && str[p]!=' ';p--) {
    }
    if (p>0) {
      var left = str.substring(0, p);
      var right = str.substring(p+1);
      return left + spaceReplacer + stringDivider(right, width, spaceReplacer);
    }
  }
  return str;
}

function getMatrixIdx(json,str){
 var as=$(json).filter(function (i,n){return n.matrix_id===str});
	    return as[0].compatibility_index;
};

function viewDetil(id) {
    $('#modul_title').html('<h3 class="card-label">Job Family</h3>');

    $.getJSON(API_host + app + '/skillmap?token=' + token + '&id=' + id, function (resp) {
        if (resp.message == 'success' && resp.length > 0) {
            var jsonData = JSON.parse(JSON.stringify(resp.data[0]));

            $('#v_jf').html(jsonData['skill_name']);
            let sjf = jsonData['subskill_name'];
            sjf = sjf.split(' | ');
            let vsjf = '';
            sjf.forEach(function (value) {
                vsjf += '<li>- '+ value +'</li>';
            });
            $('#v_sjf').html(vsjf);
        }
    });
    $("#form_view").show();
    setVisibility(['submitButton', 'deleteButton', 'cancelButton', 'tool_button', 'data_filter', 'data_list'], 'obj', false);
    //setVisibility(['action_button'],'div',false);
}

function editDetil(id,pointer) {
    $('#modul_title').html('<h3 class="card-label">Modify Data</h3>');
    $.getJSON(API_host + app + '/skillmap?token=' + token + '&id=' + id, function (resp) {
        if (resp.message == 'success' && resp.length > 0) {
            var jsonData = JSON.parse(JSON.stringify(resp.data[0]));


            $('#v_jf').html(jsonData['skill_name']);
            $('#v_sjf').html('<li>- '+ jsonData['subskill_name'] +'</li>');
        }
    });
    switch (pointer) {
        case 1:
            $("#form_skill").show();
            $.getJSON(API_host + app + '/skill?token=' + token + '&id=' + id, function (resp){
                var completeData = Object.assign({}, {form_method: 'PUT'}, resp.data[0]);
                renderDataForm('kt_form_crud', completeData);
            });
            break;
        case 2:
            $("#form_subskill").show();
            $.getJSON(API_host + app + '/subskill?token=' + token + '&id=' + id, function (resp){
                var completeData = Object.assign({}, {form_method: 'PUT'}, resp.data[0]);
                renderDataForm('kt_form_crud', completeData);
            });
            break;
        case 3:
            $("#form_skillmap").show();
            $.getJSON(API_host + app + '/skillmap?token=' + token + '&id=' + id, function (resp){
                var completeData = Object.assign({}, {form_method: 'PUT'}, resp.data[0]);
                var jsonData = JSON.parse(JSON.stringify(completeData));
                $('#form_method').val(jsonData['form_method']).trigger('change');
                let sjf = jsonData['subskill_id'];
                sjf = sjf.split(' | ');
                for (i=0;i<sjf.length;i++){
                    if (i==0){
                        fillReference('select-one','skill','',$('#skill_id_select'),'',jsonData['skill_id'],false);
                        fillReference('select-one','subskill','',$('#subskill_id_select'),'',sjf[i],false);
                    }else {
                        $('#addSkillBtn').click();
                        fillReference('select-one','subskill','',$('#subskill_id_select_' + i),'',sjf[i],false);

                    }
                }
                $('#skillmap_id').val(jsonData['skillmap_id']).trigger('change');
            });
            break;
    }

    /*$.getJSON(API_host + app + '/skill?token=' + token + '&id=' + id, function (resp) {
        if (resp.message == 'success' && resp.length > 0) {
            var completeData = Object.assign({}, {form_method: 'PUT'}, resp.data[0]);
            renderDataForm('kt_form_crud', completeData);
        }
        ;
    });*/
    $("#data_crud").show();
    setVisibility(['deleteButton', 'backButton', 'tool_button', 'data_filter', 'data_list'], 'obj', false);
}

function deleteDetil(id) {
    Swal.fire({
        title: "Delete Job Family Data ?",
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
                url: API_host + app + '/'+ tabName +'?token=' + token + '&id=' + id,
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
                            sumbmitSuccess('Data has been deleted.', host + app + '/sModule/skill');
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


function renderPick(tab) {
     //alert(tab);
    setVisibility(['tool_button'], 'div', true);   
    switch (tab) {
        case 'Skill':
            if (stsSkill === 0){
                renderGrid();
                stsSkill = 1;
            }
            tabName = 'Skill';
            break;
        case 'Subskill':
            if (stsSubskill === 0){
                renderGrid2();
                stsSubskill = 1;
            }
            tabName = 'Subskill';
            break;
        case 'Skillmap':
            if (stsSkillmap === 0){
                renderGrid3();
                stsSkillmap = 1;
            }
            tabName = 'Skillmap';
            break;            
        default :
            setVisibility(['data_filter','tool_button'], 'div', false);    

    }
}


function renderGrid() {
    tblSkill = $('#kt_datatable_skill').DataTable({
        dom: "<'row'<'col-sm-2'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        autoWidth: true,
		    fixedHeader: true,	
        responsive: !0,
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        destroy: !0,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        bLengthChange: !0,
        buttons: [
         { extend: 'print', orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [ 0, 1] }},
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
            {data: "skill_code", title: "JF Code", width: "10%"},
            {data: "skill_name", title: "Job Family Name", width: "88%"},
            {data: null, title: "Action", width: "1%"},
        ],
        columnDefs: [
            {
                targets: 3,
                title: "Action",
                orderable: !1,
                render: function (a, e, t, n) {
                    //	alert(t['id']);
                    actbutton = '<div class="dropdown dropdown-inline">';
                    actbutton += '  <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"><i class="flaticon-more"></i></a>';
                    actbutton += '    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">';
                    actbutton += '       <ul class="nav nav-hoverable flex-column">';
                    //actbutton += '          <li class="nav-item"><a class="nav-link" href="#view_data" onclick="viewDetil(\'' + t['skill_id'] + '\');"><i class="nav-icon la la-clipboard-list"></i><span class="nav-text">View Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="editDetil(\'' + t['skill_id'] + '\',1);"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="deleteDetil(\'' + t['skill_id'] + '\',1);"><i class="nav-icon la la-trash"></i><span class="nav-text">Delete Record</span></a></li>';
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
            url: API_host + app + '/skill?token=' + token,
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
            tblSkill.column(i).search(val ? val : '', false, false);
        });
        tblSkill.table().draw();
    });

    $('#kt_reset').on('click', function (e) {
        e.preventDefault();
        $('.datatable-input').each(function () {
            $(this).val('');
            tblSkill.column($(this).data('col-index')).search('', false, false);
        });
        tblSkill.table().draw();
        $("#data_filter").hide();
    });
}

function renderGrid2() {
    tblSubskill = $('#kt_datatable_subskill').DataTable({
        dom: "<'row'<'col-sm-2'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
		    autoWidth: true,
		    fixedHeader: true,	        
        responsive: !0,
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        destroy: !0,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        bLengthChange: !0,
        buttons: [
         { extend: 'print', orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [ 0, 1] }},
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
            {data: "subskill_code", title: "SJF Code", width: "10%"},
            {data: "subskill_name", title: "Sub Job Family Name", width: "89%"},
            {data: null, title: "Action", width: "1%"},
        ],
        columnDefs: [
            {
                targets: 3,
                title: "Action",
                orderable: !1,
                render: function (a, e, t, n) {
                    //	alert(t['id']);
                    actbutton = '<div class="dropdown dropdown-inline">';
                    actbutton += '  <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"><i class="flaticon-more"></i></a>';
                    actbutton += '    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">';
                    actbutton += '       <ul class="nav nav-hoverable flex-column">';
                    //actbutton += '          <li class="nav-item"><a class="nav-link" href="#view_data" onclick="viewDetil(\'' + t['subskill_id'] + '\');"><i class="nav-icon la la-clipboard-list"></i><span class="nav-text">View Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="editDetil(\'' + t['subskill_id'] + '\',2);"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="deleteDetil(\'' + t['subskill_id'] + '\',2);"><i class="nav-icon la la-trash"></i><span class="nav-text">Delete Record</span></a></li>';
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
            url: API_host + app + '/subskill?token=' + token,
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
            tblSubskill.column(i).search(val ? val : '', false, false);
        });
        tblSubskill.table().draw();
    });

    $('#kt_reset').on('click', function (e) {
        e.preventDefault();
        $('.datatable-input').each(function () {
            $(this).val('');
            tblSubskill.column($(this).data('col-index')).search('', false, false);
        });
        tblSubskill.table().draw();
        $("#data_filter").hide();
    });
}

function renderGrid3() {
    tblSkillmap = $('#kt_datatable_skillmap').DataTable({
        dom: "<'row'<'col-sm-2'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
		    autoWidth: true,
		    fixedHeader: true,	        
        responsive: !0,
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        destroy: !0,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        bLengthChange: !0,
        buttons: [
         { extend: 'print', orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [ 0, 1 ,2] }},
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
            {data: "skill_name", title: "Job Family", width: "49%"},
            {data: "subskill_name", title: "Sub Job Family", width: "49%"},
            {data: null, title: "Action", width: "1%"},
        ],
        columnDefs: [
            {
                targets: 3,
                title: "Action",
                orderable: !1,
                render: function (a, e, t, n) {
                    //	alert(t['id']);
                    actbutton = '<div class="dropdown dropdown-inline">';
                    actbutton += '  <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"><i class="flaticon-more"></i></a>';
                    actbutton += '    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">';
                    actbutton += '       <ul class="nav nav-hoverable flex-column">';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#view_data" onclick="viewDetil(\'' + t['skillmap_id'] + '\');"><i class="nav-icon la la-clipboard-list"></i><span class="nav-text">View Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="editDetil(\'' + t['skillmap_id'] + '\',3);"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>';
                    //actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="deleteDetil(\'' + t['skillmap_id'] + '\');"><i class="nav-icon la la-trash"></i><span class="nav-text">Delete Record</span></a></li>';
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
            url: API_host + app + '/skillmap?token=' + token,
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
            tblSkillmap.column(i).search(val ? val : '', false, false);
        });
        tblSkillmap.table().draw();
    });

    $('#kt_reset').on('click', function (e) {
        e.preventDefault();
        $('.datatable-input').each(function () {
            $(this).val('');
            tblSkillmap.column($(this).data('col-index')).search('', false, false);
        });
        tblSkillmap.table().draw();
        $("#data_filter").hide();
    });
}

function removeData(id){
    delete  dataForm[id];
}

function repeaterOnchange(id) {
    changeAction('select-one', id, $('#'+id+'').val());
}

$("#submitButton").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Save Skill Data ?",
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
                url: API_host + app + '/'+ tabName +'?token=' + token,
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
                            sumbmitSuccess('Data has been added/modify.', host + app + '/sModule/skill');
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
        title: "Delete Job Family Data ?",
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
                url: API_host + app + '/skill?token=' + token,
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
                            sumbmitSuccess('Data has been deleted.', host + app + '/sModule/skill');
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
        cancelButtonClass: "btn btn-light-warning",cancelButtonColor: "#d6d6d7",cancelButtonText: "No",
        confirmButtonClass: "btn btn-warning",confirmButtonText: "Yes",  
        closeOnConfirm: false,
        allowOutsideClick: false
    }).then(function (result) {
        if (result.value) {
            window.location.href = host + app + '/sModule/skill'
        }
    });
});

$("#backButton").click(function (e) {
    e.preventDefault();

    window.location.href = host + app + '/sModule/skill';
});

var KTFormRepeater = function() {

    // Private functions
    var demo1 = function() {
        $('#kt_repeater_1').repeater({
            initEmpty: false,

            /*repeaters:[{
                selector: '.repeater_inner',
                show: function () {
                    cSS++;
                    ss = document.querySelectorAll('.subskill_name');
                    addBtn = document.querySelectorAll('.addButton_subskill');
                    rmBtn = document.querySelectorAll('.removeButton_subskill');
                    rmBtnId = document.querySelectorAll('.subskill_name_rmbtn');

                    $(this).slideDown();
                    addBtn[addBtn.length-1].style.display = 'none';
                    rmBtn[rmBtn.length-1].style.display = 'block';
                    ss[ss.length-1].id = 'subskill_name_'+cSS;
                    ss[ss.length-1].setAttribute('name','subskill_name_'+cSS);
                    ss[ss.length-1].setAttribute('onchange','repeaterOnchange(\''+ss[ss.length-1].id+'\')');
                    rmBtnId[rmBtnId.length-1].setAttribute('onClick','removeData(\''+ss[ss.length-1].id+'\')');
                    suggest_subskill(ss[ss.length-1].id);
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            }],*/

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                cSS++;
                ss = document.querySelectorAll('.subskill_id_select');
                addBtn = document.querySelectorAll('.addButton_subskill');
                rmBtn = document.querySelectorAll('.removeButton_subskill');
                rmBtnId = document.querySelectorAll('.subskill_id_rmbtn');

                $(this).slideDown();
                addBtn[addBtn.length-1].style.display = 'none';
                rmBtn[rmBtn.length-1].style.display = 'block';
                ss[ss.length-1].id = 'subskill_id_select_'+cSS;
                ss[ss.length-1].setAttribute('name','subskill_id_select_'+cSS);
                ss[ss.length-1].setAttribute('onchange','repeaterOnchange(\''+ss[ss.length-1].id+'\')');
                rmBtnId[rmBtnId.length-1].setAttribute('onClick','removeData(\''+ss[ss.length-1].id+'\')');
                fillReference('select-one','subskill','',$('#'+ ss[ss.length-1].id +''),'','',false);
                /*$('#'+ ss[ss.length-1].id +'').select2({
                    placeholder: 'Select One'
                }).trigger('change');*/
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    };

    return {
        // public functions
        init: function() {
            demo1();
        }
    };
}();


  $("#compability_form").submit(function() {
    toMatrix = JSON.parse("[" + $('.jobfamily_list').val() + "]");
   // alert(matrix_type);
		$.getJSON(API_host+app+'/compatibilitymap?token='+token+'&q='+$('.jobfamily_list').val()+'&mt='+matrix_type, function(resp) {
       if(resp.message == 'success'){
       	 vRow='<table border=1 cellspacing=5 cellpadding=1>' ;
       	 vRow +='<thead><tr><th scope="col" colspan="2"></th>' ;
         lastjs = '';
	       i = 0;
         $.each(resp.data, function(k, v){
         	
         	if (lastjs != v.skill_name) {
         		i++;
         		bgcolor = ((i%2) == 0) ? '#fab99f':'#ff5053';
          }	
         	
         	vRow +='<th class="rotated-text" scope="col" style="background-color :'+bgcolor+'"><div><span>'+stringDivider(v.subskill_name, 30, "<br/>\n")+'</span></div></th>';
          lastjs = v.skill_name;
	       });
	       vRow +='</tr></thead><tbody>';
	       
         lastjs = '';
	       i = 0;
         $.each(resp.data, function(k, v){
         	vRow +='<tr>';
         	if (lastjs != v.skill_name) {
         	i++;
         	//bgcolor = ((i%2) == 0) ? '#fe7844':'#fc383c';
         	bgcolor2 = ((i%2) == 0) ? '#fab99f':'#ff5053';
         	bgcolor = '#ffffff';
         		vRow +='<th class="rotated-text2" scope="row" rowspan="'+v.skill_node+'" style="background-color :'+bgcolor+'">'+stringDivider(v.skill_name, 30, "<br/>\n")+'</th>';
         	}

         	vRow +='<th class="rotated-text2" style="width:220px;  padding: 0 !important; background-color :'+bgcolor2+'">'+stringDivider(v.subskill_name, 30, "<br/>\n")+'</th>';
          $.each(resp.data, function(x, z){
          	compatibility_matrix_val = v.subskill_id+'_'+z.subskill_id;
          	color = (v.subskill_name==z.subskill_name) ? '#895d28': ((v.skill_name==z.skill_name) ? bgcolor2 : '#ffffff');
          	val   = getMatrixIdx(resp['matrix'],compatibility_matrix_val);
            vRow +='<td style="height:40px" bgcolor="'+color+'" style="text-align:center;">&nbsp;<input readonly type="text" id="'+v.subskill_id+'_'+z.subskill_id+'" name="'+v.subskill_id+'_'+z.subskill_id+'" size="1" value="'+val+'" ondblclick="load_matrix(\''+v.subskill_id+'_'+z.subskill_id+'#'+v.subskill_name+'_'+z.subskill_name+'\')" style="border-width:0px; border:none; text-align:center; background-color : '+color+'">&nbsp;</td>'
		      });
          lastjs = v.skill_name;
	       });
	       vRow+='</tr></tbody></table>' ;

         $('#matrixdata_list').html(vRow);
       };
    });
    return false;
  });

  
function load_matrix(val) {
	  getVal=val.split("#")
    $('#comp_id').val(getVal[0]);
    $('#jf_from').html(getVal[1].split("_")[0]);
    $('#jf_to').html(getVal[1].split("_")[1]);
    $('#compabilityModal .form-control').prop('checked', false);
    $('#comp_index_'+$('#'+getVal[0]).val()).prop('checked',true);
    $("#compabilityModal").modal();
}

$("#comp_save").on("click", function() {
	dataForm['matrix_type'] = matrix_type;
	dataForm['key'] = $('#comp_id').val();
	dataForm['compatibility_index'] = $('#comp_value').val();
  $('#'+$('#comp_id').val()).val($('#comp_value').val());  
  
            $.ajax({
                url: API_host + app + '/compmatrix?token=' + token,
                type: 'PUT',
                data: dataForm,
                beforeSend: function () {
                   //blockPage('on');
                },
                error: function () {
                   // blockPage('off');
                    showMessage('Update Data Fail', 'Connection problem to database/query access: ' + error, 'error', 'btn btn-danger');
                },
                success: function (resp) {
                    //blockPage('off');
                    if (resp.error == false) {
                        if ((resp.status == 200) && (resp.message == 'success')) {
                            showMessage('Data has been updated', resp.message, 'success', 'btn btnsuccess');
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
  
  
  $('#compabilityModal').modal('hide');       
});	

$(document).ready(function () {
    setVal('form_method', 'POST');
    KTFormRepeater.init();
    renderPick('Skill');

		$.getJSON(API_host+app+'/skill?t=1&token='+token, function(resp) {
			if(resp.error == false) {
         if(resp.message == 'success'){
           $.each(resp.data, function(k, v){
              jobfamily_list.append('<option value="'+v.skill_id+'">'+v.skill_name+'</option>');
		       });
           jobfamily_list.bootstrapDualListbox('refresh');
         } else {
         	 timeoutError();
         };
			} else {
			  timeoutError();
			}
    });    
});

