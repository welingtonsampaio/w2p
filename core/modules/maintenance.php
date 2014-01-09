<?php
function maintenance()
{

    if ( \W2P\W2P::getInstance()->configuration()->modeMaintenance == 0 )
        return true;

	if ( isset( $_GET[ 'preview' ] ) )
		return true;
	
	if ( $_SERVER['HTTP_REFERER'] == get_bloginfo('url') . '/wp-login.php?preview' )
		return true;
	
	if ( is_user_logged_in() )
		return true;
	
	include_once( \W2P\W2P::getInstance()->modules()->get_include_path('maintenance') . '/index.php');
	exit();
}
