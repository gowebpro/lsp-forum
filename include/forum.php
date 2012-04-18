<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: forum.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

/**
 * Строит дерево форумов
 */
if (!function_exists('create_forum_list')) {
	function create_forum_list($aForums=array(),$aList=array(),$sDepthGuide="") {
		if (is_array($aForums) && !empty($aForums)) {
			foreach ($aForums as $oForum) {
				$aList[] = array(
					'id' => $oForum->getId(),
					'title' => $sDepthGuide . $oForum->getTitle()
				);

				if ($aSubForums = $oForum->getChildren()) {
					$aList = create_forum_list($aSubForums, $aList, $sDepthGuide . PluginForum_ModuleForum::DEPTH_GUIDE);
				}
			}
		}
		return $aList;
	}
}

?>