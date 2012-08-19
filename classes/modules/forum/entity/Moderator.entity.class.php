<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Moderator.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityModerator extends EntityORM {
	protected $aRelations = array(
		'user'=>array('belongs_to','ModuleUser_EntityUser','user_id'),
		'forums'=>array(self::RELATION_TYPE_MANY_TO_MANY,'PluginForum_ModuleForum_EntityForum','forum_id','db.table.forum_moderator_rel','moderator_id')
	);
}

?>