<?php
global $post;

$dados =  get_post_meta($post->ID, WORDWEBPRESS_APP_NAME . '_metas_' . $this->name);
$dados = unserialize( base64_decode( $dados[0] ) );

// Use for stylesheet
echo '<div class="w2p-metas">';

// Use nonce for verification
echo '<input type="hidden" name="custom-post" id="custom-post" value="'.md5($this->name).'" />';

foreach ( $this->_itens as $item )
{
	$value = '';
	if( !empty( $dados[ $item['name'] ] ) )
	{
		$value = $dados[ $item['name'] ];
	}elseif ( !empty( $item['defaultValue'] ) ) {
		$value = $item['defaultValue'];
	}
?>
	<p>
		<label for="<?php echo $item['name']?>"><?php echo $item['label'] ?></label><br />
		<?php 
			if ( $item['type'] == 'radio' )
			{
		?>
			<input id="<?php echo $item['name']?>" name="<?php echo $item['name']?>" type="hidden" value="<?php echo $value ?>" /><div class="buttomRadio" name="<?php echo $item['name']?>"></div>
		<?php 
			}elseif ( $item['type'] == 'text' ){
		?>
			<input class="" id="<?php echo $item['name']?>" name="<?php echo $item['name']?>" type="text" value="<?php echo $value ?>" />
		<?php 
			}elseif ( $item['type'] == 'textarea' ){
		?>
			<textarea name="<?php echo $item['name']?>" id="<?php echo $item['name']?>"><?php echo $value ?></textarea>
		<?php 
			}elseif ( $item['type'] == 'image' ){
		?>
			<p><input type="text" name="<?php echo $item['name']?>" id="<?php echo $item['name']?>" value="<?php echo $value ?>" />
			&nbsp;&nbsp;&nbsp;
			<input type="button" class="button upload-img-w2p" name="<?php echo $post->ID ?>" id="<?php echo md5($item['name']) ?>" refid="<?php echo $item['name']?>" value="<?php echo __('Browser image')?>" /></p>
		<?php 
			}
		?>
	</p>
<?php
}

// Close for used stylesheet
echo '</div>';

?>