<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: User.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleUser extends ModuleORM
{
    /**
     * @var PluginForum_ModuleUser_EntityUser
     */
    protected $oUserCurrent = null;

    public function Init()
    {
        parent::Init();
        if ($oUserCurrent = $this->User_GetUserCurrent()) {
            $this->oUserCurrent = $this->GetUserById($oUserCurrent->getId());
        }
    }

    /**
     * Возвращает объект текущего пользователя форума
     * @return PluginForum_ModuleUser_EntityUser
     */
    public function GetUserCurrent()
    {
        return $this->oUserCurrent;
    }

    /**
     * Возвращает массив пользователей форума по массиву ID пользователей
     * @param $aIds
     * @return mixed
     */
    public function GetUsersByArrayId($aIds)
    {
        return $this->GetUserItemsByArrayUserId($aIds);
    }

}