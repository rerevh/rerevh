var changed;

$('#parameter_setting .form-control').on('change', function (e) {
    changed = 1;
    switch(true) {
        case (e.currentTarget.id == 'grade_target'):
            if (this.value != '0') {
                setDisabled(['current_grade_on_target'],'obj',false);
            } else {
                setVal('include_on_target','0');
                $('#current_grade_on_target').prop('checked', false);
                setDisabled(['current_grade_on_target'],'obj',true);
            }
            break;
        case (e.currentTarget.id == 'grade_feed'):
            if (this.value != '0') {
                setDisabled(['current_grade_on_feed'],'obj',false);
            } else {
                setVal('include_on_feed','0');
                $('#current_grade_on_feed').prop('checked', false);
                setDisabled(['current_grade_on_feed'],'obj',true);
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
    }
    changeAction(e.currentTarget.type, e.currentTarget.id, e.currentTarget.value);
    changed == 1 ? $('#action_button').show() : $('#action_button').hide();
});

function renderParameter() {
    blockPageSet('Processing ...');
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
                $('#'+key).prop('checked',val);
            }else if(key.includes('performance_level') || key.includes('assessment') || val.includes('-') || val.includes('|')){
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
                setVal(key,val);
            }
        })
    }).then(function () {
        blockPage('off');
        $('#action_button').hide();
        changed = 0;
    });
}

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

    min: 1,
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

$("#submitButton").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Save Parameter Setting ?",
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
                url: API_host + app + '/parameter?token=' + token,
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
                            sumbmitSuccess('Data has been added/modify.', host + app + '/sModule/parameter');
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
            window.location.href = host + app + '/sModule/parameter'
        }
    });
});

$(document).ready(function() {
    renderParameter();
    setVal('form_method','PUT');
});