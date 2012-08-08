<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * 
 *  
 *  
 */
function smarty_block_febuild( $params, $content, &$smarty, &$repeat ) {
	if ( !$repeat && !empty($content) ) { 
		
		require_once(COMMON_LIBRARY_PATH . 'lib.febuild.php');
		$feb = new FEBuild( $params["template"] );

		return (
			$feb->debug()
				? $feb->showStaticResources( $content )
				: $feb->showMiniStaticResources( $content )
		);
	}
} ?>