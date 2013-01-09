<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.X
* @File Name: Markread.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityMarker extends EntityORM {

	public function checkRead() {
		if ($this->getUnreadItem() == 0) {
			return true;
		}
		return false;
	}

	public function checkTopic($oTopic) {
		if ($aData = $this->getReadArray()) {
			if (isset($aData[$oTopic->getId()])) {
				$aTopicData = $aData[$oTopic->getId()];
				if ($aTopicData['i'] >= $oTopic->getCountPost()) {
					return true;
				}
			}
		}
		return false;
	}

}

?>