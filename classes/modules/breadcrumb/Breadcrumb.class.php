<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Breadcrumb.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleBreadcrumb extends Module
{
    /**
     * Массив хлебных крошек
     * @var array
     */
    protected $aItems = array();

    public function Init()
    {

    }

    private function CreateItem($sTitle, $sUrl, $bLastNoLink=false) {
        return Engine::GetEntity('PluginForum_Breadcrumb', array(
            'title' => $sTitle,
            'url' => $sUrl,
            'link' => !$bLastNoLink
        ));
    }

    public function Push(Entity $oEntity, $bLastNoLink=false)
    {
        if ($aAncestors = $oEntity->getAncestors()) {
            foreach ($aAncestors as $oParent) {
                array_unshift($this->aItems, $this->CreateItem($oParent->getTitle(), $oParent->getUrlFull()));
            }
        }
        array_push($this->aItems, $this->CreateItem($oEntity->getTitle(), $oEntity->getUrlFull(), $bLastNoLink));
    }

    public function GetCollection()
    {
        return $this->aItems;
    }

    /**
     * Добавляем HTML тайтлы их хлебных крошек
     */
    public function AddHtmlTitles()
    {
        $aItems = $this->GetCollection();
        foreach ($aItems as $oItem) {
            $this->Viewer_AddHtmlTitle($oItem->getTitle());
        }
    }

    public function Shutdown()
    {
        $this->Viewer_Assign('aBreadcrumbs', $this->aItems);
    }
}