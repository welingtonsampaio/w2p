<?php
function maintenance()
{
	if ( isset( $_GET[ 'preview' ] ) )
		return true;
	
	if ( $_SERVER['HTTP_REFERER'] == get_bloginfo('url') . '/wp-login.php?preview' )
		return true;
	
	if ( is_user_logged_in() )
		return true;
	
	if ( W2P::getInstance()->configuration()->modeMaintenance == false )
		return true;
	
	include_once( W2P::getInstance()->modules()->get_module_include_path('maintenance') . '/index.php');
	exit();
}
