<?php
global $post;

// Use for stylesheet
echo '<div class="w2p-metas w2p-admin">';

// Use nonce for verification
echo '<input type="hidden" name="custom-post" id="custom-post" value="'.md5($this->name).'" />';
print_r($dados);
echo '<fieldset>';
foreach ( $this->_itens as $item )
{
    /** @var $item \W2P\Form\Element */
    $item->setValue( \W2P\Post\Metas::get_meta_by_post( $post->ID, $this->meta_name_for($item) ) );
?>
        <div class="item">
            <?php echo $item ?>
        </div>
<?php
}
echo '</fieldset>';

// Close for used stylesheet
echo '</div>';

?>