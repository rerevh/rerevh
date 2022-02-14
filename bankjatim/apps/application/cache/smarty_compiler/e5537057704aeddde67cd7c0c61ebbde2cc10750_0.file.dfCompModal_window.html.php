<?php
/* Smarty version 3.1.33, created on 2022-01-26 11:24:30
  from 'C:\xampp\htdocs\Bank_Jatim\apps\application\views\dfCompModal_window.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61f0ccfe886b23_31618462',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e5537057704aeddde67cd7c0c61ebbde2cc10750' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Bank_Jatim\\apps\\application\\views\\dfCompModal_window.html',
      1 => 1642381610,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61f0ccfe886b23_31618462 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal fade" id="compabilityModal" name="compabilityModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Set Compatibility</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	 <input class="form-control" type="hidden" id="comp_id" name="comp_id">	
            	 <input class="form-control" type="hidden" id="comp_value" name="comp_value">	
                    <div class="col-12">
                        <table cellpadding=5 width=100<?php echo '%>';?>
                            <tr valign=top>
                                <td width=30<?php echo '%>';?>From</td>
                                <td width=2<?php echo '%>';?>:</td>
                                <td>
                                    <div id="jf_from"></div>
                                </td>
                            </tr>
                            <tr valign=top>
                                <td>To</td>
                                <td>:</td>
                                <td>
                                    <div id="jf_to"></div>
                                </td>
                            </tr>
                            <tr valign=top>
                                <td>Compatibility</td>
                                <td>:</td>
                                <td>

                            <div class="radio-inline mt-0">
                                <label class="radio radio-outline radio-danger">
                                    <input class="form-control" type="radio" id="comp_index_1" name="comp_index"/>
                                    <span></span>1
                                </label>
                                <label class="radio radio-outline radio-danger">
                                    <input class="form-control" type="radio" id="comp_index_2" name="comp_index"/>
                                    <span></span>2
                                </label>
                                <label class="radio radio-outline radio-danger">
                                    <input class="form-control" type="radio" id="comp_index_3" name="comp_index"/>
                                    <span></span>3
                                </label>
                                <label class="radio radio-outline radio-danger">
                                    <input class="form-control" type="radio" id="comp_index_4" name="comp_index"/>
                                    <span></span>4
                                </label>                                
                            </div>                           	
                                </td>
                            </tr>
                        </table>

                    </div>                                  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                <button type="button" id="comp_save" name="comp_save" class="btn btn-light-success font-weight-bold">Save</button>
            </div>
        </div>
    </div>
</div><?php }
}
