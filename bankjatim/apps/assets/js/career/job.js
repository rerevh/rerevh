var tblJob;
var cSS = 0;
var cCO = 0;

$('#kt_form_crud .form-control').on('change', function (e) {
    changeAction(e.currentTarget.type, e.currentTarget.id, e.currentTarget.value)
});

$("#dt_add_data").on("click", function () {
    renderFill();
    $("#data_crud").show();
    $("#data_filter").hide();
    $("#data_list").hide();
    $("#tool_button").hide();
    $('#modul_title').html('<h3 class="card-label">Input Job</h3>');
    setVisibility(['backButton', 'deleteButton'], 'obj', false);
});

$("#dt_filter_data").on("click", function () {
    fillReference('select-one', 'skill', '', $('#find_job_family'), '', '', false);
    $("#data_filter").show();
});

$("#dt_print_data").on("click", function () {
    tblJob.button('.buttons-print').trigger();
});

function getSkill(divId, corespondId) {
    changeAction('select-one', divId, $('#'+divId).val())
    let id = $('#' + divId + '').val();
    if (id != '') {
        $.getJSON(API_host + app + '/skilldata?token=' + token + '&id=' + id, function (resp) {
            if (resp.message == 'success' && resp.length > 0) {
                var jsonData = JSON.parse(JSON.stringify(resp.data[0]));

                $('#' + corespondId + '').val(jsonData['skill_name']);
            }
        });
        // repeaterOnchange(divId);
    }
}

function renderFill() {
    /*fillReference('select-one','code_klasifikasi','',$('#klasifikasi'),'','',false);
    fillReference('select-one','code_type','',$('#type'),'','',false);
    fillReference('select-one','code_orgrisk','',$('#orgrisk'),'','',false);*/
    fillReference('select-one', 'jobgrade', '', $('#job_grade'), '', '', false);
    fillReference('select-one', 'subskill', '', $('#job_sjf'), '', '', false);
}

function addformShow() {
    renderFill();
    $("#data_crud").show();
    $("#data_filter").hide();
    $("#data_list").hide();
    $("#tool_button").hide();
    $('#modul_title').html('<h3 class="card-label">Input Job</h3>');
    setVisibility(['backButton', 'deleteButton'], 'obj', false);
}

function filterformShow() {
    $("#data_filter").show();
}

function renderView(parent, data) {
    var jsonData = JSON.parse(JSON.stringify(data));
    $(parent).find('div').map(function () {
        if (this.id !== '') {
            jsonField = (this.id).replace('v_', '');
            $('#' + this.id + '').html(jsonData['' + jsonField + '']);
        }
    });
}

function viewDetil(id) {
    $('#modul_title').html('<h3 class="card-label">Job Information</h3>');

    $.getJSON(API_host + app + '/job?token=' + token + '&id=' + id, function (resp) {
        if (resp.message == 'success' && resp.length > 0) {
            renderView('#form_view', resp.data[0]);
        }
    });

    $("#form_view").show();
    setVisibility(['submitButton', 'deleteButton', 'cancelButton', 'tool_button', 'data_filter', 'data_list'], 'obj', false);
    //setVisibility(['action_button'],'div',false);
}

function editDetil(id) {
    $('#modul_title').html('<h3 class="card-label">Modify Data<div class="text-muted pt-2 font-size-sm">Job Data Modify</div></h3>');

    $.getJSON(API_host + app + '/job?token=' + token + '&id=' + id, function (resp) {
        let sjfInput = '';
        if (resp.message == 'success' && resp.length > 0) {
            var completeData = Object.assign({}, {form_method: 'PUT'}, resp.data[0]);
            var jsonData = JSON.parse(JSON.stringify(completeData));

            $('#form_method').val(jsonData['form_method']).trigger('change');
            changeAction('text', 'form_method', 'PUT');
            $('#job_id').val(jsonData['job_id']).trigger('change');
            $('#job_name').val(jsonData['job_name']).trigger('change');
            $('#job_grade').val(jsonData['job_grade']).trigger('change');
            fillReference('select-one', 'jobgrade', '', $('#job_grade'), '', jsonData['c_job_grade'], false);
            let sjf = jsonData['c_job_sjf'].split(',');
            $('#job_sjf_input').empty();
            for (let i = 0; i < sjf.length; i++) {
                sjfInput += '' +
                    '<div class="col-lg-6">\n' +
                    '    <div class="form-group">\n' +
                    '        <label class="col-form-label text-left col-lg-12">Job Family</label>\n' +
                    '        <div class="col-lg-12">\n' +
                    '            <input class="form-control" disabled id="job_jf_' + i + '"\n' +
                    '                   name="job_jf_' + i + '" placeholder="Add Job Family" type="text"/>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>\n' +
                    '<div class="col-lg-6">\n' +
                    '    <div class="form-group">\n' +
                    '        <label class="col-form-label text-left col-lg-12">Sub Job Family</label>\n' +
                    '        <div class="col-lg-12">\n' +
                    '            <select class="form-control" id="job_sjf_' + i + '" name="job_sjf_' + i + '"\n' +
                    '                    onchange="getSkill(\'job_sjf_' + i + '\', \'job_jf_' + i + '\')">\n' +
                    '            </select>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>'
            }
            $('#job_sjf_input').append(sjfInput);
            for (let i = 0; i < sjf.length; i++) {
                fillReference('select-one', 'subskill', '', $('#job_sjf_' + i), '', sjf[i].trim(), false);
            }
        }
    });

    $("#data_crud").show();
    setVisibility(['deleteButton', 'backButton', 'tool_button', 'data_filter', 'data_list'], 'obj', false);
}

function deleteDetil(id) {
    Swal.fire({
        title: "Delete Employee Data ?",
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
                url: API_host + app + '/job?token=' + token + '&id=' + id,
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
                            sumbmitSuccess('Data has been deleted.', host + app + '/sModule/job');
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
    tblJob = $('#kt_datatable').DataTable({
        dom: "<'row'<'col-sm-2'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        responsive: !0,
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        destroy: !0,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        bLengthChange: !0,
        buttons: [
            {extend: 'print', orientation: 'landscape', pageSize: 'LEGAL', exportOptions: {columns: [0, 1, 2, 3, 4]}},
        ],
        columns: [
            {
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
            {data: "job_name", title: "Job Name", width: "39%"},
            {data: "job_grade", title: "Job Grade", width: "10%", className: "text-center"},
            {data: "job_jf", title: "Job Family", width: "35%"},
            /*{data: "orgrisk", title: "Organizational Risk", width: "15%"},*/
        ],
        columnDefs: [
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
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#view_data" onclick="viewDetil(\'' + t['job_id'] + '\');"><i class="nav-icon la la-clipboard-list"></i><span class="nav-text">View Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="editDetil(\'' + t['job_id'] + '\');"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="deleteDetil(\'' + t['job_id'] + '\');"><i class="nav-icon la la-trash"></i><span class="nav-text">Delete Details</span></a></li>';
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
            url: API_host + app + '/job?token=' + token,
            beforeSend: function () {
                blockPageSet('Processing ...');
            },
            dataSrc: function (json) {
                blockPage('off');
                if (json.error == false) {
                    if ((json.status == 200) && (json.message == 'success')) {
                        return json.data;
                    }
                } else {
                    if ((json.status == 200) && ((json.message == 'Token expired!') || (json.message == 'Token is not accepted!'))) {
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
                    orisk: $('#find_org_risk').val(),
                    jfam: $('#find_job_family').val(),
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
            tblJob.column(i).search(val ? val : '', false, false);
        });
        tblJob.table().draw();
    });

    $('#kt_reset').on('click', function (e) {
        e.preventDefault();
        $('.datatable-input').each(function () {
            $(this).val('');
            tblJob.column($(this).data('col-index')).search('', false, false);
        });
        tblJob.table().draw();
        $("#data_filter").hide();
    });
}

$("#submitButton").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Save Job Data ?",
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
                url: API_host + app + '/job?token=' + token,
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
                            sumbmitSuccess('Data has been added/modify.', host + app + '/sModule/job');
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
        title: "Delete Employee Data ?",
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
                url: API_host + app + '/job?token=' + token,
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
                            sumbmitSuccess('Data has been deleted.', host + app + '/sModule/job');
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
            window.location.href = host + app + '/sModule/job'
        }
    });
});

$("#backButton").click(function (e) {
    e.preventDefault();
    window.location.href = host + app + '/sModule/job';
});

$(document).ready(function () {
    setVal('form_method', 'POST');
    renderGrid();
});

