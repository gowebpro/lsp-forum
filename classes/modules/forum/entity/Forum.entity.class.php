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
	protected $__aRelationsData = array();
	protected $__aCustomData = array();

	/**
	 * Определяем правила валидации
	 *
	 * @var array
	 */
	protected $aValidateRules=array(
		array('forum_sort','number','integerOnly'=>true),
		array('forum_parent_id','parent_forum')
	);

	protected $aRelations = array(
		self::RELATION_TYPE_TREE,
	//	'post'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityPost','last_post_id'),
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
		$this->aValidateRules[]=array('forum_limit_rating_topic','number','label'=>$this->Lang_Get('plugin.forum.create_rating'));
		$this->aValidateRules[]=array('forum_sort','sort_check','label'=>$this->Lang_Get('plugin.forum.create_sort'));
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

	/**
	 * Проверка родительского форума
	 *
	 * @param string $sValue
	 * @param array $aParams
	 * @return bool
	 */
	public function ValidateParentForum($sValue,$aParams) {
		if ($this->getParentId()) {
			if ($oParent=$this->PluginForum_Forum_GetForumById($this->getParentId())) {
				if ($oParent->getId()==$this->getId()) {
					return $this->Lang_Get('plugin.forum.create_parent_error_descendants');;
				}
				$aDescendants=$this->getDescendants();
				$aDescendantsIds=array();
				foreach ($aDescendants as $oDescendant) {
					$aDescendantsIds[]=$oDescendant->getId();
				}
				if (in_array($oParent->getId(),$aDescendantsIds)) {
					return $this->Lang_Get('plugin.forum.create_parent_error_descendants');
				}
			} else {
				return $this->Lang_Get('plugin.forum.create_parent_error');;
			}
		} else {
			$this->setParentId(0);
		}
		return true;
	}

	/**
	 * Установка дефолтной сортировки
	 *
	 * @param string $sValue
	 * @param array $aParams
	 * @return bool
	 */
	public function ValidateSortCheck($sValue,$aParams) {
		if (!$this->getSort()) {
			$this->setSort($this->PluginForum_Forum_GetMaxSortByPid($this->getParentId())+1);
		}
		return true;
	}

	/**
	 * Возвращает окончательный тип форума
	 *		archive			; архив только для чтения
	 *		link			; включен редирект
	 *		category		; запрещен постинг
	 *		category_closed	; запрещен постинг, установлен пароль
	 *		forum			; разрешен постинг
	 *		forum_closed	; разрешен постинг, установлен пароль
	 */
	public function getTyped() {
		if (!$this->getType()) return 'archive';
		if ($this->getRedirectOn()) return 'link';
		$suffix = $this->getPassword()?'_closed':'';
		return ($this->getCanPost() ? 'category' : 'forum' . $suffix);
	}

	/**
	 * Возвращает иконку нужного размера
	 */
	public function getIconPath($iSize=48) {
		if ($sPath=$this->getIcon()) {
			return preg_replace("#_\d{1,3}x\d{1,3}(\.\w{3,4})$#", ((($iSize==0)?'':"_{$iSize}x{$iSize}") . "\\1"),$sPath);
		} else {
			return Plugin::GetTemplateWebPath(__CLASS__)."icons/{$this->getTyped()}_icon_{$iSize}x{$iSize}.png";
		}
	}

	/**
	 * Возвращает полный URL до форума
	 */
	public function getUrlFull() {
		return Router::GetPath('forum').($this->getUrl() ? $this->getUrl() : $this->getId()).'/';
	}

	/**
	 * Возвращает состояние подписки на форум
	 */
	public function getSubscribeNewTopic() {
		if (!($oUserCurrent=$this->User_GetUserCurrent())) {
			return null;
		}
		return $this->Subscribe_GetSubscribeByTargetAndMail('forum_new_topic',$this->getId(),$oUserCurrent->getMail());
	}

	/**
	 * Возвращает название форума завернутый в ссылку
	 */
	public function getUrlHtml($bStrong=false) {
		return "<b><a href='{$this->getUrlFull()}'>{$this->getTitle()}</a></b>";
	}


	/**
	 * Опции модератора
	 */
	public function isModerator() {
		$oModerator = $this->getModerator();
		return (LS::Adm() || $oModerator);
	}
	public function getModViewIP() {
		$oModerator = $this->getModerator();
		return (LS::Adm() || ($oModerator && $oModerator->getViewIp()));
	}
	public function getModDeletePost() {
		$oModerator = $this->getModerator();
		return (LS::Adm() || ($oModerator && $oModerator->getAllowDeletePost()));
	}
	public function getModDeleteTopic() {
		$oModerator = $this->getModerator();
		return (LS::Adm() || ($oModerator && $oModerator->getAllowDeleteTopic()));
	}
	public function getModMovePost() {
		$oModerator = $this->getModerator();
		return (LS::Adm() || ($oModerator && $oModerator->getAllowMovePost()));
	}
	public function getModMoveTopic() {
		$oModerator = $this->getModerator();
		return (LS::Adm() || ($oModerator && $oModerator->getAllowMoveTopic()));
	}
	public function getModOpencloseTopic() {
		$oModerator = $this->getModerator();
		return (LS::Adm() || ($oModerator && $oModerator->getAllowOpencloseTopic()));
	}
	public function getModPinTopic() {
		$oModerator = $this->getModerator();
		return (LS::Adm() || ($oModerator && $oModerator->getAllowPinTopic()));
	}


	/**
	 * Опции форума
	 */
	public function getOptions() {
		$aValue = unserialize(stripslashes((string)$this->_getDataOne('forum_options')));
		return $aValue ? $aValue : array();
	}

	public function getOptionsValue($sName) {
		$aOptions = $this->getOptions();
		if (isset($aOptions[$sName])) {
			return $aOptions[$sName];
		}
		return null;
	}

	public function setOptionsValue($sName,$sValue) {
		$aOptions = $this->getOptions();
		$aOptions[$sName] = $sValue;
		$this->setOptions(addslashes(serialize($aOptions)));
	}


	/**
	 * Relations data
	 */
	protected function _getDataRelation($sKey) {
		if (isset($this->__aRelationsData[$sKey])) {
			return $this->__aRelationsData[$sKey];
		}
		return null;
	}

	// relation Post
	public function getPost() {
		return $this->_getDataRelation('Post');
	}
	public function getModerator() {
		return $this->_getDataRelation('Moderator');
	}

	public function setPost($data) {
		$this->__aRelationsData['Post']=$data;
	}
	public function setModerator($data) {
		$this->__aRelationsData['Moderator']=$data;
	}


	/**
	 * Custom Data
	 */
	protected function _getDataCustom($sKey) {
		if (isset($this->__aCustomData[$sKey])) {
			return $this->__aCustomData[$sKey];
		}
		return null;
	}

	/**
	 * Права доступа
	 */
	public function getAllowShow() {
		return $this->_getDataCustom('allow_show');
	}
	public function getAllowRead() {
		return $this->_getDataCustom('allow_read');
	}
	public function getAllowReply() {
		return $this->_getDataCustom('allow_reply');
	}
	public function getAllowStart() {
		return $this->_getDataCustom('allow_start');
	}
	public function getAutorization() {
		return $this->_getDataCustom('autorization');
	}
	public function getRead() {
		return $this->_getDataCustom('marker');
	}

	public function setAllowShow($data) {
		$this->__aCustomData['allow_show']=$data;
	}
	public function setAllowRead($data) {
		$this->__aCustomData['allow_read']=$data;
	}
	public function setAllowReply($data) {
		$this->__aCustomData['allow_reply']=$data;
	}
	public function setAllowStart($data) {
		$this->__aCustomData['allow_start']=$data;
	}
	public function setAutorization($data) {
		$this->__aCustomData['autorization']=$data;
	}
	public function setRead($data) {
		$this->__aCustomData['marker']=$data;
	}

}
?>