<style>
<!--
html{
  background-color: #fafafa;
}
-->
</style>
<div class="w2p-admin">
	<div id="alerts"></div><!-- Final #alerts -->
	<div class="sidebar">
		<div class="logo"></div><!-- Final .logo -->
		<div class="menu btn-toolbar btn-group-vertical btn-group" data-toggle="buttons-radio">
			<?php 
				$admin = \W2P\W2P::getInstance()->admin();
				foreach ( $admin->getAllModules() as $module )
				{
                    /** @var $module \W2P\Admin\Module */
			?>
				<button class="btn" style="text-align:left" data-target="<?php echo md5($module->getName())?>">
					<i class="<?php echo $module->getIcon(); ?>"></i>
					&nbsp;&nbsp;&nbsp;<?php echo $module->getName() ;?>
				</button>
			<?php 
				}
			?>
		</div><!-- Final .menu -->
	</div><!-- Final .sidebar -->
	
	<div class="content">
		<?php 
// 			echo W2P::getInstance()->configuration();
			$key = 0;
			$admin = \W2P\W2P::getInstance()->admin();
			foreach ( $admin->getAllModules() as $module )
			{
                /** @var $module \W2P\Admin\Module */
		?>
		<div class="form" id="<?php echo md5($module->getName())?>" style="<?php echo ( $key == 0 ? 'display: block' : 'display:none' )?>;">
			<form>
				<input type="hidden" name="w2p_theme_gravar" value="<?php echo md5($module->getName())?>" />
				<h3><i class="<?php echo $module->getIcon(); ?>"></i><?php echo __('You are editing:', 'W2P')?> <?php echo $module->getName() ?></h3>
				<?php 
					foreach ( $module->getItens() as $item )
					{
                        /** @var $item \W2P\Form\Element */
						try{
                            if ( \W2P\W2P::getInstance()->configuration()->{$item->getName()} )
                                $item->setValue(\W2P\W2P::getInstance()->configuration()->{$item->getName()});
                        }catch ( \W2p\Admin\Exception $e ){
                            echo ($e->getMessage());
                        }catch ( \W2p\Exception $e ){
                            echo ($e->getMessage());
                        }
						echo '<div class="clearfix">'.$item.'</div>';
				?>
					<hr />
				<?php 
				
					}
				?>
				<div class="gravar"><button class="button" type="button">gravar dados</button></div>
			</form>
		</div>
		<?php 
			$key++;
			}
		?>
	</div><!-- Final .content -->
	<div class="clear"></div><!-- Final .clear -->

</div><!-- Final .w2p-admin -->
