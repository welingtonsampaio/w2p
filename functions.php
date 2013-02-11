<?php
	define('W2P_APPNAME', 'teste de app');
	define('W2P_URL', get_bloginfo("template_url"));
	define('W2P_INCLUDE', get_template_directory());
	
	require_once ( W2P_INCLUDE . '/core/W2P.php');
	$system = W2P::getInstance();
	
	foreach (array(
			'debug'					=> false,
			'email_name'			=> 'welington',
			'email_from'			=> 'welington.sampaio@zaez.net',
			'jquery_version'		=> '1.7.1',
			'jquery_online_version'	=> false,
			'used_thumbnails'		=> true,
			'compress_css_js'		=> false,
			'developer_link'		=> 'http://www.zaez.net/',
			'developer_logo'		=> 'http://utilities.zaez.net/dev-white.png'
			) as $key=>$item)
		$system->configuration()->{$key} = $item;
	
	$system->post()->addCustomPost('w2p_teste', 'Teste de custom post', 'Teste de custom posts')->generate();
	$system->post()->addCustomMeta('Personal data', 'w2p_teste')
						->addItem('name', 'text', 'Your name:')
						->addItem('function', 'text', 'Your function:')
						->addItem('salary', 'text', 'Your salary:')
						->addItem('foto', 'image', 'Your foto: ( best dimension : 65x65 px )')
						->addItem('descr', 'textarea', 'Brief description about you: ( Max. 180 caracters )')
						->generate();
	
	$admin = $system->admin();
	$module1 = new W2P_Admin_Module( W2P_APPNAME );
	$module2 = new W2P_Admin_Module( 'Social midia' );
	$module2->addItem(new W2P_Form_Element_Text('linkFacebook', array('label'=>'Link for your page of facebook')));
	$module2->addItem(new W2P_Form_Element_Select('linkTwitter', array('label'=>'Link for your page of Twitter', 'multioptions'=>array('teste1'=>'Teste 1','teste2'=>'Teste 2'))));
	$module2->addItem(new W2P_Form_Element_FileWp('ImageTwitter', array('label'=>'Image for your page of Twitter', 'postid'=> W2P_Utilities::w2pUploadId('ImageTwitter'))));
	$module2->setIcon('icon-thumbs-up');
	$admin->addModule($module1);
	$admin->addModule($module2);
	$admin->addModule(new W2P_Admin_Module( 'Teste 1' ));
	$admin->addModule(new W2P_Admin_Module( 'Teste de nome maior' ));
	$admin->addThemeAdmin();
	
