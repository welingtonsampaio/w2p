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
				$admin = W2P::getInstance()->admin();
				foreach ( $admin->getAllModules() as $module )
				{
					$module instanceof W2P_Admin_Module;
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
			$admin = W2P::getInstance()->admin();
			foreach ( $admin->getAllModules() as $module )
			{
				$module instanceof W2P_Admin_Module;
		?>
		<div class="form" id="<?php echo md5($module->getName())?>" style="<?php echo ( $key == 0 ? 'display: block' : 'display:none' )?>;">
			<form>
				<input type="hidden" name="w2p_theme_gravar" value="<?php echo md5($module->getName())?>" />
				<h3><i class="<?php echo $module->getIcon(); ?>"></i><?php echo __('You are editing:', 'W2P')?> <?php echo $module->getName() ?></h2>
				<?php 
					foreach ( $module->getItens() as $item )
					{
						$item instanceof W2P_Form_Element;
						try{
						if ( W2P::getInstance()->configuration()->{$item->getName()} )
							$item->setValue(W2P::getInstance()->configuration()->{$item->getName()});
						}catch ( W2P_Exception $e ){
							
						}
						echo '<p>'.$item.'</p>';
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
