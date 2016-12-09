<?php

/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Read.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityReadonly extends EntityORM
{
    protected $aRelations = array(
        'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
        'moder' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginForum_ModuleForum_EntityModerator', 'moder_id'),
        'post' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginForum_ModuleForum_EntityPost', 'post_id')
    );
}

?>