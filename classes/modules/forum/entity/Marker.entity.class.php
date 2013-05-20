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
	protected $aRelations = array(
		'forum'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityForum','forum_id')
	);

	public function checkRead() {
		if ((string)$this->getReadArray() == '*') {
			return true;
		}
		$oForum = $this->getForum();
		return $oForum ? $this->getReadItem() == $oForum->getCountPost() : false;
	}

	public function checkTopic($oTopic) {
		if ($aData = $this->getReadArray()) {
			if ((string)$aData == '*') {
				return true;
			}
			if (isset($aData[$oTopic->getId()])) {
				$aTopicData = $aData[$oTopic->getId()];
				if ($aTopicData['i'] == $oTopic->getCountPost()) {
					return true;
				}
			}
		}
		return false;
	}

	public function getLastMarkPost($oTopic) {
		if ($aData = $this->getReadArray()) {
			if (is_array($aData) && isset($aData[$oTopic->getId()])) {
				$aTopicData = $aData[$oTopic->getId()];
				if (isset($aTopicData['p'])) {
					return $aTopicData['p'];
				}
			}
			return $oTopic->getLastPostId();
		}
		return null;
	}
}

?>