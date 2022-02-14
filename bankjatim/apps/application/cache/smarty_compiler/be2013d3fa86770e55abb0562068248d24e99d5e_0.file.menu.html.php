<?php
/* Smarty version 3.1.33, created on 2022-01-29 22:31:48
  from 'D:\web\root\FED\bankjatim\apps\application\views\menu.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61f55de4c70984_11744223',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'be2013d3fa86770e55abb0562068248d24e99d5e' => 
    array (
      0 => 'D:\\web\\root\\FED\\bankjatim\\apps\\application\\views\\menu.html',
      1 => 1641832406,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61f55de4c70984_11744223 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
	<ul class="menu-nav">
	<?php $_smarty_tpl->_assignInScope('catg', '-----------');?>
	<?php $_smarty_tpl->_assignInScope('par', '-----------');?> 
	<?php $_smarty_tpl->_assignInScope('parOpen', 0);?>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['auth']->value['data']['menu'], 'i', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['i']->value) {
?>  
		<?php if ($_smarty_tpl->tpl_vars['catg']->value != $_smarty_tpl->tpl_vars['i']->value['catg']) {?>
			<?php $_smarty_tpl->_assignInScope('catg', $_smarty_tpl->tpl_vars['i']->value['catg']);?> 
			<?php if ($_smarty_tpl->tpl_vars['k']->value > 0) {?>
			
			<?php if ($_smarty_tpl->tpl_vars['parOpen']->value == 1) {?> 
				</ul></div></li>	
				<?php $_smarty_tpl->_assignInScope('parOpen', 0);?>
			<?php }?>			
            <li class="menu-section">
                <h4 class="menu-text"><?php echo $_smarty_tpl->tpl_vars['i']->value['catg'];?>
</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>					
			<?php } else { ?>
           
            <li class="menu-section">
                <h4 class="menu-text"><?php echo $_smarty_tpl->tpl_vars['i']->value['catg'];?>
</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>			
            			
			<?php }?>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['par']->value != $_smarty_tpl->tpl_vars['i']->value['parent']) {?>
			<?php $_smarty_tpl->_assignInScope('par', $_smarty_tpl->tpl_vars['i']->value['parent']);?>
			<?php if ($_smarty_tpl->tpl_vars['parOpen']->value == 1) {?> 
				</ul></div></li>	
				<?php $_smarty_tpl->_assignInScope('parOpen', 0);?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['par']->value == null) {?>
            <li class="menu-item" aria-haspopup="true">
                <a href="<?php echo $_smarty_tpl->tpl_vars['host']->value;
echo $_smarty_tpl->tpl_vars['auth']->value['data']['app'];?>
/sModule/<?php echo $_smarty_tpl->tpl_vars['i']->value['target'];?>
" class="menu-link">
                    <span class="svg-icon menu-icon"><i class="<?php echo $_smarty_tpl->tpl_vars['i']->value['mn_icon'];?>
" style="color:red"></i></span>  
                    <span class="menu-text"><?php echo $_smarty_tpl->tpl_vars['i']->value['mn_name'];?>
</span>
                </a>
            </li>				
			<?php } else { ?>
				<?php $_smarty_tpl->_assignInScope('parOpen', 1);?>
				<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">	
              <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon"><i class="<?php echo $_smarty_tpl->tpl_vars['i']->value['icon_parent'];?>
" style="color:red"></i></span>
                    <span class="menu-text"><?php echo $_smarty_tpl->tpl_vars['i']->value['parent'];?>
</span><i class="menu-arrow" style="color:red"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                           <span class="menu-link"><span class="menu-text"><?php echo $_smarty_tpl->tpl_vars['i']->value['parent'];?>
</span></span>
                        </li>                    	
                        <li class="menu-item" aria-haspopup="true">
                            <a id="menu-<?php echo $_smarty_tpl->tpl_vars['i']->value['target'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;
echo $_smarty_tpl->tpl_vars['auth']->value['data']['app'];?>
/sModule/<?php echo $_smarty_tpl->tpl_vars['i']->value['target'];?>
" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text"><?php echo $_smarty_tpl->tpl_vars['i']->value['mn_name'];?>
</span>
                            </a>
                        </li> 									
			<?php }?>
		<?php } else { ?>
			<?php if ($_smarty_tpl->tpl_vars['par']->value == null) {?>
                 <!--       <li class="menu-item" aria-haspopup="true">
                            <a id="menu-<?php echo $_smarty_tpl->tpl_vars['i']->value['target'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;
echo $_smarty_tpl->tpl_vars['auth']->value['data']['app'];?>
/sModule/<?php echo $_smarty_tpl->tpl_vars['i']->value['target'];?>
" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text"><?php echo $_smarty_tpl->tpl_vars['i']->value['mn_name'];?>
</span>
                            </a>
                        </li> 	!-->
            <li class="menu-item" aria-haspopup="true">
                <a id="menu-<?php echo $_smarty_tpl->tpl_vars['i']->value['target'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;
echo $_smarty_tpl->tpl_vars['auth']->value['data']['app'];?>
/sModule/<?php echo $_smarty_tpl->tpl_vars['i']->value['target'];?>
" class="menu-link">
                    <span class="svg-icon menu-icon"><i class="<?php echo $_smarty_tpl->tpl_vars['i']->value['mn_icon'];?>
" style="color:red"></i></span>  
                    <span class="menu-text"><?php echo $_smarty_tpl->tpl_vars['i']->value['mn_name'];?>
</span>
                </a>
            </li>	                        
			<?php } else { ?>
                        <li class="menu-item" aria-haspopup="true">
                            <a id="menu-<?php echo $_smarty_tpl->tpl_vars['i']->value['target'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;
echo $_smarty_tpl->tpl_vars['auth']->value['data']['app'];?>
/sModule/<?php echo $_smarty_tpl->tpl_vars['i']->value['target'];?>
" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text"><?php echo $_smarty_tpl->tpl_vars['i']->value['mn_name'];?>
</span>
                            </a>
                        </li> 				
			<?php }?>
		<?php }?>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	</ul></div>

<?php }
}
