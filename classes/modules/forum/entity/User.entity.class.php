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

class PluginForum_ModuleForum_EntityUser extends EntityORM {
	protected $aRelations = array(
		'user'=>array(self::RELATION_TYPE_BELONGS_TO,'ModuleUser_EntityUser','user_id')
	);
}

?>