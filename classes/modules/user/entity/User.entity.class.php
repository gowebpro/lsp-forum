<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet version: 1.X
* @File Name: User.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleUser_EntityUser extends EntityORM
{
    protected $aRelations = array(
        'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id')
    );
}