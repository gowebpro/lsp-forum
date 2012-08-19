<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Forum.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityForum extends EntityORM {
	protected $aRelations = array(
		self::RELATION_TYPE_TREE,
		'user'=>array(self::RELATION_TYPE_BELONGS_TO,'ModuleUser_EntityUser','last_user_id'),
		'topic'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityTopic','last_topic_id'),
		'post'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityPost','last_post_id'),
		'moderators'=>array(self::RELATION_TYPE_MANY_TO_MANY,'PluginForum_ModuleForum_EntityModerator','moderator_id','db.table.forum_moderator_rel','forum_id')
	);

	/**
	 * Список запрещенных URL
	 */
	protected $aBadUrl = array('admin','topic','findpost');

	/**
	 * Определяем правила валидации
	 */
	public function Init() {
		parent::Init();
		$this->aValidateRules[]=array('forum_title','string','min'=>2,'max'=>100,'allowEmpty'=>false,'label'=>$this->Lang_Get('plugin.forum.create_title'));
		$this->aValidateRules[]=array('forum_url','url','label'=>$this->Lang_Get('plugin.forum.create_url'));
		$this->aValidateRules[]=array('forum_url','url_unique','label'=>$this->Lang_Get('plugin.forum.create_url'));
		$this->aValidateRules[]=array('forum_url','url_bad','label'=>$this->Lang_Get('plugin.forum.create_url'));
		$this->aValidateRules[]=array('forum_sort','number','label'=>$this->Lang_Get('plugin.forum.create_sort'));
		$this->aValidateRules[]=array('forum_limit_rating_topic','number','label'=>$this->Lang_Get('plugin.forum.create_rating'));
	}

	/**
	 * Проверка URL форума
	 *
	 * @param $sValue
	 * @param $aParams
	 * @return bool | string
	 */
	public function ValidateUrl($sValue,$aParams) {
		if (!$sValue || func_check($sValue,'login',2,50)) {
			return true;
		}
		return $this->Lang_Get('plugin.forum.create_url_error',array('min'=>2,'max'=>50));
	}

	/**
	 * Проверка URL на уникальность
	 *
	 * @param $sValue
	 * @param $aParams
	 * @return bool | string
	 */
	public function ValidateUrlUnique($sValue,$aParams) {
		if ($sValue && $oForumExists=$this->PluginForum_Forum_GetForumByUrl($sValue)) {
			if ($iId=$this->getId() and $oForumExists->getId()==$iId) {
				return true;
			}
			return $this->Lang_Get('plugin.forum.create_url_error_used');
		}
		return true;
	}

	/**
	 * Проверка на счет плохих URL'ов
	 *
	 * @param $sValue
	 * @param $aParams
	 * @return bool | string
	 */
	public function ValidateUrlBad($sValue,$aParams) {
		if (in_array($sValue,$this->aBadUrl)) {
			return $this->Lang_Get('plugin.forum.create_url_error_badword').' '.implode(', ',$this->aBadUrl);
		}
		return true;
	}

	public function getUrlFull() {
		return Router::GetPath('forum').($this->getUrl() ? $this->getUrl() : $this->getId()).'/';
	}

	public function getSubscribeNewTopic() {
		if (!($oUserCurrent=$this->User_GetUserCurrent())) {
			return null;
		}
		return $this->Subscribe_GetSubscribeByTargetAndMail('forum_new_topic',$this->getId(),$oUserCurrent->getMail());
	}

}

?>