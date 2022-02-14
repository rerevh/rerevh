<?php
/* Smarty version 3.1.33, created on 2022-01-25 12:16:45
  from 'C:\xampp\htdocs\Bank_Jatim\apps\application\views\career\parameter.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61ef87bd5df411_16828750',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b120a62ac9dc887706e386c8f06fbf1996b9ffcb' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Bank_Jatim\\apps\\application\\views\\career\\parameter.html',
      1 => 1642589805,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61ef87bd5df411_16828750 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="card card-custom">
    <div class="card-header">
        <div id="modul_title" class="card-title">
            <h3 class="card-label"><?php echo $_smarty_tpl->tpl_vars['modul_title']->value;?>

                <div class="text-muted pt-2 font-size-sm"><?php echo $_smarty_tpl->tpl_vars['modul_desc']->value;?>
</div>
            </h3>
        </div>
    </div>
    <div class="card-body">


        <div id="param_setting" class="row col-lg-12 align-items-center justify-content-center">
            <div class="col-lg-10" style="display:block">
                <form class="form" id="parameter_setting">
                    <input class="form-control" id="form_method" name="form_method" type="hidden">
                    <div class="row">
                        <div class="col-lg-4">
                            <div id="target_to_find">
                                <div class="checkbox-list mt-0" id="current_grade_on_target_check"
                                     name="current_grade_on_target_check" style="display:block">
                                    <input class="form-control" id="include_on_target" name="include_on_target"
                                           type="hidden">
                                    <label class="checkbox">
                                        <p class="ml-2 mr-3">Target grade [+]:</p>
                                        <input class="form-control" disabled id="current_grade_on_target"
                                               name="current_grade_on_target" type="checkbox"/>
                                        <span class="mb-4"></span>
                                        <p class="mr-3">Include same grade </p>
                                    </label>
                                </div>

                                <div class="input-group">
                                    <input class="form-control" id="grade_target" name="grade_target" type="text"
                                           value="1"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div id="feed_to_find">
                                <div class="checkbox-list mt-0" id="current_grade_on_feed_check"
                                     name="current_grade_on_feed_check" style="display:block">
                                    <input class="form-control" id="include_on_feed" name="include_on_feed"
                                           type="hidden">
                                    <label class="checkbox">
                                        <p class="ml-2 mr-3">Feeder grade [-]:</p>
                                        <input class="form-control" disabled id="current_grade_on_feed"
                                               name="current_grade_on_feed" type="checkbox" value="0"/>
                                        <span class="mb-4"></span>
                                        <p class="mr-3">Include same grade </p>
                                    </label>
                                </div>

                                <div class="input-group">
                                    <input class="form-control" id="grade_feed" name="grade_feed" type="text"
                                           value="1"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-8">
                        <!--<div class="col-lg-4">
                            <div id="tmt_to_find">
                                <label>TMT Grade:</label>
                                <div id="percent_comp" style="display:block">
                                    <div class="input-group mt-2">
                                        <input class="form-control" id="tmt_grade" name="tmt_grade" type="text"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <div class="col-lg-4">
                            <div id="percent_to_find">
                                <label>Match Percentage:</label>
                                <div id="percent_comp" style="display:block">
                                    <div class="input-group mt-2">
                                        <input class="form-control" id="percent_compability" name="percent_compability"
                                               type="text"
                                               value="0"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-8">
                        <div class="col-lg-4">
                            <div id="performance_to_find">
                                <label>Performance Expectation:</label>
                                <div id="perform_level" style="display:block">
                                    <input class="form-control" id="performance_level" name="performance_level"
                                           type="hidden">
                                    <div class="checkbox-list">
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="perform_level_check"
                                                   name="perform_level_check"
                                                   type="checkbox" value="1"/>
                                            <span></span>Poor
                                        </label>
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="perform_level_check"
                                                   name="perform_level_check"
                                                   type="checkbox" value="2"/>
                                            <span></span>Below
                                        </label>
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="perform_level_check"
                                                   name="perform_level_check"
                                                   type="checkbox" value="3"/>
                                            <span></span>Meet
                                        </label>
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="perform_level_check"
                                                   name="perform_level_check"
                                                   type="checkbox" value="4"/>
                                            <span></span>Exceed
                                        </label>
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="perform_level_check"
                                                   name="perform_level_check"
                                                   type="checkbox" value="5"/>
                                            <span></span>Outstanding
                                        </label>
                                        <!--
                                        <label class="checkbox checkbox-square mr-10 mb-2">
                                            <input class="form-control" type="checkbox" id="perform_level_check" name="perform_level_check" value="4"/>
                                            <span></span>4
                                        </label>
                                        <label class="checkbox checkbox-square mr-10 mb-2">
                                            <input class="form-control" type="checkbox" id="perform_level_check" name="perform_level_check" value="5"/>
                                            <span></span>5
                                        </label>
                                        !-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div id="assessment_to_find">
                                <label>Assessment:</label>
                                <div id="assessment_" style="display:block">
                                    <input class="form-control" id="assessment" name="assessment" type="hidden">
                                    <div class="checkbox-list">
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="assessment_check" name="assessment_check"
                                                   type="checkbox" value="1"/>
                                            <span></span>Low
                                        </label>
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="assessment_check" name="assessment_check"
                                                   type="checkbox" value="2"/>
                                            <span></span>Medium
                                        </label>
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="assessment_check" name="assessment_check"
                                                   type="checkbox" value="3"/>
                                            <span></span>High
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row mt-8">
                        <div class="col-lg-6">
                            <div id="talent_box_to_find">
                                <label>Talent Box:</label>
                                <div id="talent_box" style="display:block">
                                    <input class="form-control" id="talentbox" name="talentbox" type="hidden">
                                    <div class="checkbox-inline mt-2">
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="talent_box_check" name="talent_box_check"
                                                   type="checkbox" value="1"/>
                                            <span></span>1
                                        </label>
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="talent_box_check" name="talent_box_check"
                                                   type="checkbox" value="2"/>
                                            <span></span>2
                                        </label>
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="talent_box_check" name="talent_box_check"
                                                   type="checkbox" value="3"/>
                                            <span></span>3
                                        </label>
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="talent_box_check" name="talent_box_check"
                                                   type="checkbox" value="4"/>
                                            <span></span>4
                                        </label>
                                        <label class="checkbox checkbox-outline checkbox-square mr-10 mb-2">
                                            <input class="form-control" id="talent_box_check" name="talent_box_check"
                                                   type="checkbox" value="5"/>
                                            <span></span>5
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                    <div id="action_button">
                        <div class="row mt-10">
                            <div class="col-lg-12 ml-lg-auto">
                                <button type="submit" class="btn btn-primary font-weight-bold mr-2" id="submitButton"
                                        name="submitButton">Save
                                </button>
                                <button type="reset" class="btn btn-light-primary font-weight-bold mr-2"
                                        id="cancelButton" name="cancelButton">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php }
}
