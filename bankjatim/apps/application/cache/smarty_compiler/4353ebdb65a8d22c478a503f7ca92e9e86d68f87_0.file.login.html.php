<?php
/* Smarty version 3.1.33, created on 2022-01-29 22:23:00
  from 'D:\web\root\FED\bankjatim\apps\application\views\login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61f55bd4d58970_25183865',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4353ebdb65a8d22c478a503f7ca92e9e86d68f87' => 
    array (
      0 => 'D:\\web\\root\\FED\\bankjatim\\apps\\application\\views\\login.html',
      1 => 1641825231,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61f55bd4d58970_25183865 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="">
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="assets/third_party/media/logos/fed.ico" />
    <title><?php echo $_smarty_tpl->tpl_vars['app_title']->value;?>
</title>
    <?php echo '<script'; ?>
 type="text/javascript">
        var API_host = "<?php echo $_smarty_tpl->tpl_vars['API_host']->value;?>
";
        var host = "<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
";
    <?php echo '</script'; ?>
>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Page Login Styles-->
    <link rel="stylesheet" type="text/css" href="assets/third_party/css/pages/login/login-6.css" />
    <!--end::Page Login Styles-->
    
    <!--begin::Global Theme Styles-->
    <link rel="stylesheet" type="text/css" href="assets/third_party/plugins/global/plugins.bundle.css" />
    <link rel="stylesheet" type="text/css" href="assets/third_party/plugins/custom/prismjs/prismjs.bundle.css" />
    <link rel="stylesheet" type="text/css" href="assets/third_party/css/bankjatim.style.bundle.css" />
    <!--end::Global Theme Styles-->

    <!--begin::Global Theme Bundle(used by all pages)-->
    <?php echo '<script'; ?>
 src="assets/third_party/plugins/global/plugins.bundle.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/third_party/plugins/custom/prismjs/prismjs.bundle.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/third_party/js/scripts.bundle.js"><?php echo '</script'; ?>
>
    <!--end::Global Theme Bundle-->
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-6 login-signin-on login-signin-on d-flex flex-column-fluid" id="kt_login">
            <div class="d-flex flex-column flex-lg-row flex-row-fluid text-center"
                style="background-image: url(assets/third_party/media/bg/bg-3.jpg);">
                <!--begin:Aside-->
                <div class="d-flex w-100 h-100 flex-center" style="background-image: url(assets/third_party/media/bg/bgbgf.svg); background-size: 100% 100%; background-repeat: no-repeat">
                </div>
                <!--end:Aside-->
              
                
                <!--begin:Content-->
                <div class="d-flex w-100 flex-center p-15 position-relative overflow-hidden">
                    <div class="login-wrapper">
                        <!--begin:Sign In Form-->
                        <div class="login-signin">
                            <div class="text-center mb-10 mb-lg-20">
                                <p>
                                  <a href="#" class="text-center pt-2">
                                      <img src="assets/third_party/media/logos/hcms_front.svg" class="max-h-125px" alt=""/>
                                  </a>                                  
                                </p>
                                <p class="text-muted font-weight-bolder font-size-h6-md">Please sign in to
                                    your account</p>
                            </div>
                            <form class="form text-left" id="kt_login_signin_form">
                                <div class="form-group py-2 m-0">
                                    <input class="form-control h-auto border-0 px-0 placeholder-dark-75" type="text"
                                        placeholder="Username" id="username" name="username" autocomplete="off" />
                                </div>
                                <div class="form-group py-2 border-top m-0">
                                    <input class="form-control h-auto border-0 px-0 placeholder-dark-75" type="Password"
                                        placeholder="Password" id="password" name="password" />
                                </div>
                                <!--
                                <div
                                    class="form-group d-flex flex-wrap justify-content-between align-items-center mt-5">
                                    <div class="checkbox-inline">
                                        <label class="checkbox m-0 text-muted font-weight-bold">
                                            <input type="checkbox" name="remember" />
                                            <span></span>
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="javascript:;" id="kt_login_forgot"
                                        class="text-muted text-hover-primary font-weight-bold">Forget Password ?</a>
                                </div>
                                !-->
                                <div class="text-center mt-15">
                                    <button id="kt_login_signin_submit"
                                        class="btn btn-primary btn-pill shadow-sm py-4 px-9 font-weight-bold">Sign
                                        In</button>
                                </div>
                            </form>
                        </div>
                        <!--end:Sign In Form-->

                        <div class="text-center pt-12">
                            <div class="opacity-70 font-weight-bold">
                               <span class="text-muted font-weight-bold mr-2">&copy;<?php echo $_smarty_tpl->tpl_vars['dev_year']->value;?>
.</span>
                               <a href="<?php echo $_smarty_tpl->tpl_vars['provider_site']->value;?>
" target="_blank" class="text-dark-75 text-hover-primary"><?php echo $_smarty_tpl->tpl_vars['provider']->value;?>
</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:Content-->
            </div>
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->

    <!--begin::Page Scripts(used by this page)-->
    <?php echo '<script'; ?>
 src="assets/js/appl.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/js/login.js"><?php echo '</script'; ?>
>
    <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html><?php }
}