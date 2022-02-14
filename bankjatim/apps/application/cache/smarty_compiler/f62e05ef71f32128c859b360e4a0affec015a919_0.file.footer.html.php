<?php
/* Smarty version 3.1.33, created on 2022-01-25 12:16:39
  from 'C:\xampp\htdocs\Bank_Jatim\apps\application\views\footer.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61ef87b7d2f232_06881222',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f62e05ef71f32128c859b360e4a0affec015a919' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Bank_Jatim\\apps\\application\\views\\footer.html',
      1 => 1641176651,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61ef87b7d2f232_06881222 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark">
            <span class="text-muted font-weight-bold mr-2">&copy;<?php echo $_smarty_tpl->tpl_vars['dev_year']->value;?>
.</span>
            <a href="<?php echo $_smarty_tpl->tpl_vars['provider_site']->value;?>
" target="_blank" class="text-dark-75 text-hover-primary"><?php echo $_smarty_tpl->tpl_vars['provider']->value;?>
</a>
        </div>
        <!--end::Copyright-->

        <!--begin::Nav-->
        <div class="nav nav-dark">
            <a href="#" target="_blank" class="nav-link pl-0 pr-5">About</a>
            <a href="#" target="_blank" class="nav-link pl-0 pr-5">Team</a>
            <a href="#" target="_blank" class="nav-link pl-0 pr-0">Contact Us</a>
        </div>
        <!--end::Nav-->
    </div>
    <!--end::Container-->
</div>
<?php }
}
