<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: User.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityTopicView extends EntityORM {
	protected $aRelations = array(
		'topic'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityTopic','topic_id')
	);
}

?>