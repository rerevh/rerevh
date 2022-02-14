var tblGrade;

$('#kt_form_crud .form-control').on('change', function (e) {
    changeAction(e.currentTarget.type, e.currentTarget.id, e.currentTarget.value)
});

$("#dt_add_data").on("click", function () {
    $("#data_crud").show();
    $("#data_filter").hide();
    $("#data_list").hide();
    $("#tool_button").hide();
    $('#modul_title').html('<h3 class="card-label">Grade Title Input<div class="text-muted pt-2 font-size-sm">Add Grade Title</div></h3>');
    setVisibility(['backButton', 'deleteButton'], 'obj', false);
});

$("#dt_filter_data").on("click", function () {
    $("#data_filter").show();
});

$("#dt_print_data").on("click", function () {
    tblGrade.button('.buttons-print').trigger();
});

function addformShow() {
    $("#data_crud").show();
    $("#data_filter").hide();
    $("#data_list").hide();
    $("#tool_button").hide();
    $('#modul_title').html('<h3 class="card-label">grade Title Input<div class="text-muted pt-2 font-size-sm">Add grade Title</div></h3>');
    setVisibility(['backButton', 'deleteButton'], 'obj', false);
};

function filterformShow() {
    $("#data_filter").show();
};

function viewDetil(id) {
    $('#modul_title').html('<h3 class="card-label">Grade Data<div class="text-muted pt-2 font-size-sm">Detil grade data information</div></h3>');

    $.getJSON(API_host + app + '/grade?token=' + token + '&id=' + id, function (resp) {
        if (resp.message == 'success' && resp.length > 0) {
            var jsonData = JSON.parse(JSON.stringify(resp.data[0]));

            $('#v_jobgroup').html(jsonData['jobgroup']);
            $('#v_jobgrade').html(jsonData['jobgrade']);
            $('#v_grade').html(jsonData['grade']);
            $('#v_grade_name').html(jsonData['grade_name']);

        }
    });

    $("#form_view").show();
    setVisibility(['submitButton', 'deleteButton', 'cancelButton', 'tool_button', 'data_filter', 'data_list'], 'obj', false);

    //setVisibility(['action_button'],'div',false);
}

function editDetil(id) {
    $('#modul_title').html('<h3 class="card-label">Modify Data<div class="text-muted pt-2 font-size-sm">grade Data Modify</div></h3>');

    $.getJSON(API_host + app + '/grade?token=' + token + '&id=' + id, function (resp) {
        if (resp.message == 'success' && resp.length > 0) {
            resp.data[0]['jobgroup'] = resp.data[0]['c_jobgroup'];
            var completeData = Object.assign({}, {form_method: 'PUT'}, resp.data[0]);
            renderDataForm('kt_form_crud', completeData);
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
        cancelButtonClass: "btn btn-light-danger", cancelButtonColor: "#d6d6d7", cancelButtonText: "Cancel",
        confirmButtonClass: "btn btn-danger", confirmButtonText: "Delete",
        closeOnConfirm: false,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: API_host + app + '/grade?token=' + token + '&id=' + id,
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
                            sumbmitSuccess('Data has been deleted.', host + app + '/sModule/grade');
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
    tblGrade = $('#kt_datatable').DataTable({
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
            {extend: 'print', exportOptions: {columns: [0, 1, 2, 3]}},
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
            {data: "jobgroup", title: "Job Group", width: "42%"},
            {data: "jobgrade", title: "Job Grade", width: "8%"},
            {data: "grade", title: "Personal Grade", className: "text-center", width: "8%"},
            {data: "grade_name", title: "Corporate Title", width: "42%"},
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
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#view_data" onclick="viewDetil(\'' + t['grade_id'] + '\');"><i class="nav-icon la la-clipboard-list"></i><span class="nav-text">View Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#edit_data" onclick="editDetil(\'' + t['grade_id'] + '\');"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>';
                    actbutton += '          <li class="nav-item"><a class="nav-link" href="#delete_data" onclick="deleteDetil(\'' + t['grade_id'] + '\');"><i class="nav-icon la la-close"></i><span class="nav-text">Delete Details</span></a></li>';
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
            url: API_host + app + '/grade?token=' + token,
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
            tblGrade.column(i).search(val ? val : '', false, false);
        });
        tblGrade.table().draw();
    });

    $('#kt_reset').on('click', function (e) {
        e.preventDefault();
        $('.datatable-input').each(function () {
            $(this).val('');
            tblGrade.column($(this).data('col-index')).search('', false, false);
        });
        tblGrade.table().draw();
        $("#data_filter").hide();
    });
}

$("#submitButton").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Save grade Data ?",
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
                url: API_host + app + '/grade?token=' + token,
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
                            sumbmitSuccess('Data has been added/modify.', host + app + '/sModule/grade');
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

$("#backButton").click(function (e) {
    e.preventDefault();
    window.location.href = host + app + '/sModule/grade'
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
            window.location.href = host + app + '/sModule/grade'
        }
    });
});

$("#backButton").click(function (e) {
    e.preventDefault();
    window.location.href = host + app + '/sModule/grade'
});

var KTKBootstrapTouchspin = function () {

    // Private functions
    var demos = function () {
        // minimum setup
        $('.kt_touchspin_1').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',

            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
        });
    }

    return {
        // public functions
        init: function () {
            demos();
        }
    };
}();

$(document).ready(function () {
    setVal('form_method', 'POST');
    KTKBootstrapTouchspin.init();
    renderGrid();
    fillReference('select-one', 'jobgroup', '', $('#jobgroup'), '', '', false)
});

