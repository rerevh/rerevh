var tblEmployee;

$('#kt_form_crud .form-control').on('change', function (e) {
    changeAction(e.currentTarget.type, e.currentTarget.id, e.currentTarget.value)
});

$("#dt_filter_data").on("click", function() {
  $("#data_filter").show(); 
});	

$("#dt_print_data").on("click", function() {
    tblEmployee.button( '.buttons-print' ).trigger();
});




function filterformShow() {
    $("#data_filter").show();
}

function renderView(parent, data) {
    let jsonField;
    var jsonData = JSON.parse(JSON.stringify(data));
    $(parent).find('div').map(function () {
        if (this.id !== ''){
            jsonField = (this.id).replace('v_','');
            $('#'+this.id+'').html(jsonData[''+jsonField+'']);
        }
    });
}

function viewDetil(id) {
    $('#modul_title').html('<h3 class="card-label">Person Information</h3>');
    $.getJSON(API_host + app + '/employee?token=' + token + '&id=' + id, function (resp){
        if (resp.message == 'success' && resp.length > 0){
            renderView('#form_view',resp.data[0]);
            var jsonData = JSON.parse(JSON.stringify(resp.data[0]));
            let current = moment().startOf('day');
            let given = moment(jsonData['tmtgrade'],'DD-MM-YYYY');
            let elapsed = '';
            if (current.diff(given, 'years') > 0){
                elapsed = current.diff(given, 'years') + ' Tahun ' + (current.diff(given, 'months') - (current.diff(given, 'years')*12)) + ' Bulan' ;
            }else {
                elapsed = current.diff(given, 'months') + ' Bulan';
            }
            $('#v_masa_kerja').html(elapsed);
        }
    });
    $("#form_view").show();
    setVisibility(['submitButton', 'deleteButton', 'cancelButton', 'tool_button', 'data_filter', 'data_list'], 'obj', false);
    //setVisibility(['action_button'],'div',false);
}

function apprDetil(id) {
    Swal.fire({
        title: "Make Person As Top Talent ?",
        text: "Please check the information that you want to approve.",
        icon: "warning",
        showCancelButton: true,
        cancelButtonClass: "btn btn-light-info", cancelButtonColor: "#d6d6d7", cancelButtonText: "Cancel",
        confirmButtonClass: "btn btn-warning", confirmButtonText: "Approve",
        closeOnConfirm: false,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: API_host + app + '/approve?token=' + token + '&id=' + id,
                type: 'PUT',
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
                            sumbmitSuccess('Data has been approved.', host + app + '/sModule/person');
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
            showMessage('Cancel', 'Data approve canceled.', 'error', 'btn btn-danger');
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
			  scrollCollapse:  !0,
        responsive: !1,
        searchDelay: 500,
       // processing: !0,
        serverSide: !0,
        destroy: !0,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        bLengthChange: !0,
        buttons: [
         { extend: 'print', orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7] }},
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
            {data: "person_number", title: "NIP", width: "20%"},
            {data: "person_name", title: "Name", width: "40%"},
            {data: "person_grade", title: "Person Grade", width: "5%", className: "text-center",},
            {data: "person_jf", title: "Person Job Family", width: "20%"},
            {data: "job_name", title: "Job", width: "18%"},
            {data: null, title: "Action", width: "1%"},
        ],
        columnDefs: [        
            {
                targets: 6,
                title: "Action",
                orderable: !1,
                render: function (a, e, t, n) {
                    //	alert(t['id']);
                    actbutton = '<div class="dropdown dropdown-inline">';
                    actbutton += '  <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"><i class="flaticon-more"></i></a>';
                    actbutton += '    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">';
                    actbutton += '       <ul class="nav nav-hoverable flex-column">';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#view_data" onclick="viewDetil(\'' + t['person_id'] + '\');"><i class="nav-icon la la-clipboard-list"></i><span class="nav-text">View Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#appr_data" onclick="apprDetil(\'' + t['person_id'] + '\');"><i class="nav-icon la la-edit"></i><span class="nav-text">Approval</span></a></li>';
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

function renderGrid2() {
    tblEmployee = $('#kt_datatable2').DataTable({
        dom: "<'row'<'col-sm-2'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",       
		    autoWidth: true,
		    //fixedHeader: true,
			  //deferRender:  !0,
			  //scrollY: '450px',
			  scrollX: true, 
			  scrollCollapse:  !0,
        responsive: !1,
        searchDelay: 500,
       // processing: !0,
        serverSide: !0,
        destroy: !0,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        bLengthChange: !0,
        buttons: [
         { extend: 'print', orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7] }},
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
            {data: "person_number", title: "NIP", width: "20%"},
            {data: "person_name", title: "Name", width: "40%"},
            {data: "person_grade", title: "Person Grade", width: "5%", className: "text-center",},
            {data: "person_jf", title: "Person Job Family", width: "20%"},
            {data: "job_name", title: "Job", width: "18%"},
            {data: null, title: "Action", width: "1%"},
        ],
        columnDefs: [        
            {
                targets: 6,
                title: "Action",
                orderable: !1,
                render: function (a, e, t, n) {
                    //	alert(t['id']);
                    actbutton = '<div class="dropdown dropdown-inline">';
                    actbutton += '  <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"><i class="flaticon-more"></i></a>';
                    actbutton += '    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">';
                    actbutton += '       <ul class="nav nav-hoverable flex-column">';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#view_data" onclick="viewDetil(\'' + t['person_id'] + '\');"><i class="nav-icon la la-clipboard-list"></i><span class="nav-text">View Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#appr_data" onclick="apprDetil(\'' + t['person_id'] + '\');"><i class="nav-icon la la-edit"></i><span class="nav-text">Approval</span></a></li>';
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

$("#backButton").click(function (e) {
    e.preventDefault();
    window.location.href = host + app + '/sModule/person';
});

$(document).ready(function () {
	  $("#dt_add_data").hide();
    renderGrid();
    renderGrid2();
});

