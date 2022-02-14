<?php
/* Smarty version 3.1.33, created on 2022-01-29 22:31:48
  from 'D:\web\root\FED\bankjatim\apps\application\views\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61f55de494bb31_66184165',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a7d7b14b887bbc252c504220cf5080af700c914a' => 
    array (
      0 => 'D:\\web\\root\\FED\\bankjatim\\apps\\application\\views\\index.html',
      1 => 1642480680,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu.html' => 1,
    'file:footer.html' => 1,
    'file:user_profile.html' => 1,
  ),
),false)) {
function content_61f55de494bb31_66184165 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en" >
    <!--begin::Head-->
    <head>
        <base href="" />
        <meta charset="utf-8" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/media/logos/fed.ico" />
    		<title><?php echo $_smarty_tpl->tpl_vars['app_title']->value;?>
</title>
    		<?php echo '<script'; ?>
 type="text/javascript">
    	        var API_host = "<?php echo $_smarty_tpl->tpl_vars['API_host']->value;?>
";
    	        var host = "<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
";
    	        var app = "<?php echo $_smarty_tpl->tpl_vars['auth']->value['data']['app'];?>
";
    	        var modul = "<?php echo $_smarty_tpl->tpl_vars['modul']->value;?>
";
    	        var token = "<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
";
    	        var user_id = "<?php echo $_smarty_tpl->tpl_vars['auth']->value['data']['user_id'];?>
";
    	        var userGrp = "<?php echo $_smarty_tpl->tpl_vars['auth']->value['data']['usergrp_name'];?>
";
    	        var userGrpID = "<?php echo $_smarty_tpl->tpl_vars['auth']->value['data']['usergrp_id'];?>
";
    	        var userGrpDescr = "<?php echo $_smarty_tpl->tpl_vars['auth']->value['data']['usergrp_desc'];?>
";
    	        var resetPword = "<?php echo $_smarty_tpl->tpl_vars['auth']->value['data']['resetPword'];?>
";
    	        var convProp = {
    					id: '',
    					mode: false,
    					flags: []
    				};
    			var auth = <?php echo json_encode($_smarty_tpl->tpl_vars['auth']->value);?>
;
    	  <?php echo '</script'; ?>
>
	      <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/css/appl.css"/>
	      <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/css/<?php echo $_smarty_tpl->tpl_vars['auth']->value['data']['app'];?>
/<?php echo $_smarty_tpl->tpl_vars['modul']->value;?>
.css"/>

        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!--end::Fonts-->

        <!--begin::Global Theme Styles(used by all pages)-->
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/global/plugins.bundle.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/custom/prismjs/prismjs.bundle.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/css/bankjatim.style.bundle.css"/>
        <!--end::Global Theme Styles-->

        <!--begin::Global Theme Bundle(used by all pages)-->
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/global/plugins.bundle.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/custom/prismjs/prismjs.bundle.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/js/scripts.bundle.js"><?php echo '</script'; ?>
>
     <!--   <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/custom/validation/validate.min.js"><?php echo '</script'; ?>
> !-->
        <!--end::Global Theme Bundle-->
    </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_body"  class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed aside-enabled aside-static page-loading">
        <!--begin::Header Mobile-->
        <div id="kt_header_mobile" class="header-mobile  header-mobile-fixed " >
        	<!--begin::Logo-->
        	<a href="<?php echo $_smarty_tpl->tpl_vars['host']->value;
echo $_smarty_tpl->tpl_vars['auth']->value['data']['app'];?>
/sModule/home">
        		<img alt="Logo" src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/media/logos/hcms_logo.png" class="logo-default max-h-50px"/>
        	</a>
        	<!--end::Logo-->

        	<!--begin::Toolbar-->
        	<div class="d-flex align-items-center">
        		<?php if ($_smarty_tpl->tpl_vars['auth']->value['data']['usergrp_id'] != '2') {?>
        					<button class="btn p-0 burger-icon rounded-0 burger-icon-left" id="kt_aside_tablet_and_mobile_toggle">
        				<span></span>
        			</button>
            <?php }?>
        		<button class="btn btn-hover-text-primary p-0 ml-3" id="kt_header_mobile_topbar_toggle">
        			<span class="svg-icon svg-icon-xl"><!--begin::Svg Icon | path:<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/media/svg/icons/General/User.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"/>
                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
            </g>
        </svg><!--end::Svg Icon--></span>		</button>
        	</div>
        	<!--end::Toolbar-->
        </div>
        <!--end::Header Mobile-->

      	<div class="d-flex flex-column flex-root">
      		<!--begin::Page-->
      		<div class="d-flex flex-row flex-column-fluid page">
      		  <!--begin::Aside-->
            <div class="aside aside-left  d-flex flex-column flex-row-auto" id="kt_aside">
            	<!--begin::Aside Menu-->
            	<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                <!--begin::Menu Container-->
                <?php $_smarty_tpl->_subTemplateRender('file:menu.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                <!--end::Menu Container-->
            	</div>
            	<!--end::Aside Menu-->
            </div>
            <!--end::Aside-->

      			<!--begin::Wrapper-->
      			<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header  header-fixed " >
                	<!--begin::Container-->
                	<div class=" container  d-flex align-items-stretch justify-content-between">
                		<!--begin::Left-->
                		<div class="d-none d-lg-flex align-items-center mr-3">
                			<!--begin::Aside Toggle-->
                			<?php if ($_smarty_tpl->tpl_vars['auth']->value['data']['usergrp_id'] != '2') {?>
                			<button class="btn btn-icon aside-toggle ml-n3 mr-10" id="kt_aside_desktop_toggle">
                				<span class="svg-icon svg-icon-xxl svg-icon-dark-75"><!--begin::Svg Icon | path:<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/media/svg/icons/Text/Align-left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="2" rx="1"/>
                        <rect fill="#000000" opacity="0.3" x="4" y="13" width="16" height="2" rx="1"/>
                        <path d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z" fill="#000000"/>
                    </g>
                </svg><!--end::Svg Icon--></span>			</button><?php }?>
                			<!--end::Aside Toggle-->

                			<!--begin::Logo-->
                			<a href="<?php echo $_smarty_tpl->tpl_vars['host']->value;
echo $_smarty_tpl->tpl_vars['auth']->value['data']['app'];?>
/sModule/home">
                				<img alt="Logo" src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/media/logos/hcms_logo.png" class="logo-sticky max-h-50px"/>
                			</a>
                			<!--end::Logo-->

                		</div>
                		<!--end::Left-->

                		<!--begin::Topbar-->
                		<div class="topbar">

                			<!--begin::User-->
                			<div class="topbar-item mr-4">
                          <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                              <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                              <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><?php echo $_smarty_tpl->tpl_vars['auth']->value['data']['nama'];?>
</span>
                              <span class="symbol symbol-lg-35 symbol-25 symbol-light-primary">
                                  <span class="symbol-label font-size-h5 font-weight-bold"><?php echo substr($_smarty_tpl->tpl_vars['auth']->value['data']['nama'],0,1);?>
</span>
                              </span>
                          </div>
                			</div>
                			<!--end::User-->
                		</div>
                		<!--end::Topbar-->
                	</div>
                	<!--end::Container-->
                </div>
                <!--end::Header-->

        				<!--begin::Content-->
        				<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                	<!--begin::Entry-->
                	<div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container-fluid">
            					<?php if ($_smarty_tpl->tpl_vars['content']->value == '') {?>
            						<?php $_smarty_tpl->_subTemplateRender(($_smarty_tpl->tpl_vars['auth']->value['data']['app']).('/home.html'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
            					<?php } else { ?>
            						<?php $_smarty_tpl->_subTemplateRender((($_smarty_tpl->tpl_vars['auth']->value['data']['app']).('/')).($_smarty_tpl->tpl_vars['content']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
            					<?php }?>
                    </div>
                    <!--end::Container-->
                	</div>
                  <!--end::Entry-->
        				</div>
        				<!--end::Content-->

                <!--begin::Footer-->
                <?php $_smarty_tpl->_subTemplateRender('file:footer.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                <!--end::Footer-->
      			</div>
      			<!--end::Wrapper-->
      		</div>
      		<!--end::Page-->
      	</div>

        <!-- begin::User Panel-->
        <?php $_smarty_tpl->_subTemplateRender('file:user_profile.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <!-- end::User Panel-->

        <!--begin::Scrolltop-->
        <div id="kt_scrolltop" class="scrolltop">
            <span class="svg-icon">
                <!--begin::Svg Icon | path:<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/media/svg/icons/Navigation/Up-2.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                        <path
                            d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                            fill="#000000"
                            fill-rule="nonzero"
                        />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </div>
        <!--end::Scrolltop-->

	      <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/js/appl.js"><?php echo '</script'; ?>
>
	      <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/js/<?php echo $_smarty_tpl->tpl_vars['auth']->value['data']['app'];?>
/<?php echo $_smarty_tpl->tpl_vars['modul']->value;?>
.js"><?php echo '</script'; ?>
>
    </body>
    <!--end::Body-->
</html><?php }
}
