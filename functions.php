<?php
	define('W2P_APPNAME', 'w2p');
	define('W2P_URL', get_bloginfo("template_url"));
	define('W2P_INCLUDE', get_template_directory());
	
	require_once ( W2P_INCLUDE . '/core/W2P/W2P.php');
	$system = \W2P\W2P::getInstance();
	
	foreach (array(
			'debug'					=> false,
			'email_name'			=> 'welington',
			'email_from'			=> 'welington.sampaio@zaez.net',
			'jquery_version'		=> '1.9.1',
			'jquery_online_version'	=> false,
			'used_thumbnails'		=> true,
			'compress_css_js'		=> false,
			'developer_link'		=> 'http://www.zaez.net/',
			'developer_logo'		=> 'http://utilities.zaez.net/dev-white.png'
			) as $key=>$item)
		$system->configuration()->{$key} = $item;
	
	$system->post()->addCustomPost('w2p_teste', 'Teste de custom post', 'Teste de custom posts')->generate();

    $name = (new W2P\Form\Element\Text('name', [
        'label'=>'Your name:'
    ]))->setFilter(new \W2P\Filter\Alpha(true));

    $foto = new W2P\Form\Element\FileWp('foto', [
        'label'=> 'Your foto: ( best dimension : 65x65 px )'
    ]);

	$meta = $system->post()->addCustomMeta('Personal data', 'w2p_teste', false)
                            ->addItem($name)
                            ->addItem($foto)
                            ->addItem( new \W2P\Form\Element\WpEditor('test', [
                                'label' => "Teste de titulo para o label do RichText"
                            ]) );

	$meta->generate();
	
	$admin = $system->admin();
	$module1 = new \W2P\Admin\Module( W2P_APPNAME );
	$module2 = new \W2P\Admin\Module( 'Social midia' );
	$module2->addItem(new \W2P\Form\Element\Text('linkFacebook', array('label'=>'Link for your page of facebook')));
	$module2->addItem(new \W2P\Form\Element\Select('linkTwitter', array('label'=>'Link for your page of Twitter', 'multioptions'=>array('teste1'=>'Teste 1','teste2'=>'Teste 2'))));
	$module2->addItem(new \W2P\Form\Element\FileWp('ImageTwitter', array('label'=>'Image for your page of Twitter', 'postid'=> W2P_Utilities::w2pUploadId('ImageTwitter'))));
	$module2->setIcon('icon-thumbs-up');
	$admin->addModule($module1);
	$admin->addModule($module2);
    $admin->addModule(new \W2P\Admin\Module( 'Teste 1' ));
	$admin->addModule(new \W2P\Admin\Module( 'Teste de nome maior' ));
	$admin->addThemeAdmin();
$arr = array(
    'Page' => 'page.php'
);

\W2P\W2P::getInstance()->route()->add_route('Contact One', null, true)
                                ->save_cache();
