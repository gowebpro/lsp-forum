<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Topic.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityTopic extends EntityORM {
	protected $_aDataMore = array();

	protected $aRelations = array(
		'user'=>array(self::RELATION_TYPE_BELONGS_TO,'ModuleUser_EntityUser','user_id'),
		'forum'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityForum','forum_id'),
		'post'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityPost','last_post_id'),
	//	'polls'=>array(self::RELATION_TYPE_MANY_TO_MANY,'PluginForum_ModuleForum_EntityPoll','poll_id','db.table.forum_poll_rel','topic_id')
	);

	protected function _getDataMore($sKey) {
		if (isset($this->_aDataMore[$sKey])) {
			return $this->_aDataMore[$sKey];
		}
		return null;
	}

	/**
	 * Определяем правила валидации
	 */
	public function Init() {
		parent::Init();
		$this->aValidateRules[]=array('topic_title','string','min'=>Config::Get('plugin.forum.topic.title_min_length'),'max'=>Config::Get('plugin.forum.topic.title_max_length'),'allowEmpty'=>false,'label'=>$this->Lang_Get('plugin.forum.new_topic_title'));
		$this->aValidateRules[]=array('topic_description','string','max'=>Config::Get('plugin.forum.topic.descr_max_length'),'allowEmpty'=>true,'label'=>$this->Lang_Get('plugin.forum.new_topic_description'));
	}

	public function getPaging() {
		$iCountItems=$this->getCountPost();
		$oForum=$this->getForum();
		$iPerPage=($oForum&&$oForum->getOptionsValue('posts_per_page'))?$oForum->getOptionsValue('posts_per_page'):Config::Get('plugin.forum.post_per_page');
		if (Config::Get('plugin.forum.topic_line_mod')) {
			$iCountItems--;
			$iPerPage--;
		}
		$oEngine=Engine::getInstance();
		$aPaging=$oEngine->Viewer_MakePaging(
			$iCountItems,
			1,$iPerPage,
			Config::Get('pagination.pages.count'),
			$this->getUrlFull()
		);
		return $aPaging;
	}

	public function getUrlFull() {
		return Router::GetPath('forum').'topic/'.$this->getId().'/';
	}

	public function getSubscribeNewPost() {
		if (!($oUserCurrent=$this->User_GetUserCurrent())) {
			return null;
		}
		return $this->Subscribe_GetSubscribeByTargetAndMail('topic_new_post',$this->getId(),$oUserCurrent->getMail());
	}

	public function getViews() {
		$oView = null;
		if (false === ($data = $this->Cache_Get("topic_views_{$this->getId()}"))) {
			$oView = $this->PluginForum_Forum_GetTopicViewByTopicId($this->getId());
		} else {
			$oView = $data['obj'];
		}
		return $oView ? $oView->getTopicViews() : 0;
	}

	/**
	 * Отметка о прочтении топика
	 */
	public function getRead() {
		return $this->_getDataMore('marker');
	}
	public function setRead($data) {
		$this->_aDataMore['marker']=$data;
	}

	/**
	 * Дата последнего прочтения топика
	 */
	public function getReadDate() {
		return $this->_getDataMore('marker_date');
	}
	public function setReadDate($data) {
		$this->_aDataMore['marker_date']=$data;
	}
}

?>