<?php

if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

require_once( 'application/third_party/smarty-3.1.33/libs/Smarty.class.php' );

class Smartyci extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $config =& get_config();

        $this->caching = 0;
        $this->setTemplateDir('application/views' );
        $this->setCompileDir('application/cache/smarty_compiler' );
        $this->setConfigDir('application/third_party/smarty-3.1.33/configs' );
        $this->setCacheDir('application/cache');
    }

    //if specified template is cached then display template and exit, otherwise, do nothing.
    public function useCached( $tpl, $cacheId = null )
    {
        if ( $this->isCached( $tpl, $cacheId ) )
        {
            $this->display( $tpl, $cacheId );
            exit();
        }
    }
}