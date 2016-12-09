<?php

/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet version: 1.0
* @File Name: Rating.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleRating extends PluginForum_Inherit_ModuleRating
{

    /**
     * Расчет рейтинга и силы при гоосовании за пост на форуме
     *
     * @param ModuleUser_EntityUser $oUser Объект пользователя, который голосует
     * @param PluginForum_ModuleForum_EntityPost $oPost Объект поста
     * @param int $iValue
     * @return int
     */
    public function VoteForumPost(ModuleUser_EntityUser $oUser, PluginForum_ModuleForum_EntityPost $oPost, $iValue)
    {
        /**
         * Устанавливаем рейтинг поста
         */
        $iDeltaRating = $iValue;
        $oPost->setRating($oPost->getRating() + $iDeltaRating);
        /**
         * Начисляем силу и рейтинг автору топика, используя логарифмическое распределение
         */
        $iMinSize = 0.1;
        $iMaxSize = 8;
        $iSizeRange = $iMaxSize - $iMinSize;
        $iMinCount = log(0 + 1);
        $iMaxCount = log(500 + 1);
        $iCountRange = $iMaxCount - $iMinCount;
        if ($iCountRange == 0) {
            $iCountRange = 1;
        }
        $skill = $oUser->getSkill();
        if ($skill > 50 and $skill < 200) {
            $skill_new = $skill / 70;
        } elseif ($skill >= 200) {
            $skill_new = $skill / 10;
        } else {
            $skill_new = $skill / 100;
        }
        $iDelta = $iMinSize + (log($skill_new + 1) - $iMinCount) * ($iSizeRange / $iCountRange);
        /**
         * Сохраняем силу и рейтинг
         */
        $oUser = $this->User_GetUserById($oPost->getUserId());
        $iSkillNew = $oUser->getSkill() + $iValue * $iDelta;
        $iSkillNew = ($iSkillNew < 0) ? 0 : $iSkillNew;
        $oUser->setSkill($iSkillNew);
        $oUser->setRating($oUser->getRating() + $iValue * $iDelta / 2.73);
        $this->User_Update($oUser);
        return $iDeltaRating;
    }

}

?>