<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: forum.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

/**
 * Строит дерево форумов
 *
 * @param	array	$aForums
 * @param	array	$aList
 * @param	string	$sDepthGuide
 * @param	integer $iLevel
 * @return	array
 */
if (!function_exists('forum_create_list')) {
	function forum_create_list($aForums=array(),$aList=array(),$sDepthGuide="",$iLevel=0) {
		if (is_array($aForums) && !empty($aForums)) {
			foreach ($aForums as $oForum) {
				$aList[] = array(
					'id' => $oForum->getId(),
					'title' => $sDepthGuide . $oForum->getTitle(),
					'level' => $iLevel
				);

				if ($aSubForums = $oForum->getChildren()) {
					$aList = forum_create_list($aSubForums, $aList, $sDepthGuide . PluginForum_ModuleForum::DEPTH_GUIDE, $iLevel+1);
				}
			}
		}
		return $aList;
	}
}

/**
 * Проверяет введен ли пароль
 *
 * @param	object $oForum
 * @return	boolean
 */
function forum_compare_password($oForum) {
	$sCookiePass=fGetCookie("chiffaforumpass_{$oForum->getId()}");
	return (bool)($sCookiePass == md5($oForum->getPassword()));
}

/**
 * Проверяет права доступа
 *
 * @param	array	$aPermissions
 * @param	object	$oUser
 * @param	boolean	$bGuestDef
 * @return	boolean
 */
function check_perms($aPermissions,$oUser=null,$bGuestDef=false) {
	$sPermId=is_null($oUser)
		? PluginForum_ModuleForum::MASK_PERM_GUEST
		: ($oUser->isAdministrator() ? PluginForum_ModuleForum::MASK_PERM_ADMIN : PluginForum_ModuleForum::MASK_PERM_USER);
	if (!is_array($aPermissions)) {
		if (is_null($aPermissions) && PluginForum_ModuleForum::MASK_PERM_GUEST === $sPermId) {
			return $bGuestDef;
		}
		if (is_null($aPermissions) || (string)$aPermissions === '*') {
			return true;
		}
	}
	$aGroupPermArray=explode(',',(string)$sPermId);
	foreach ($aGroupPermArray as $sUid) {
		if (isset($aPermissions[$sUid])) {
			return true;
		}
	}
	return false;
}

function fSetCookie($sName=null, $sValue='', $bSticky=1, $iExpiresDays=0, $iExpiresMinutes=0, $iExpiresSeconds=0) {
	if (!($sName)) return;

	if ($bSticky) $iExpires = time() + (60*60*24*365);
	else $iExpires = time() + ($iExpiresDays * 86400) + ($iExpiresMinutes * 60) + $iExpiresSeconds;

	if ($iExpires <= time()) $iExpires = false;

	@setcookie($sName,$sValue,$iExpires,Config::Get('sys.cookie.path'),Config::Get('sys.cookie.host'));
}

function fGetCookie($sName) {
	if (isset($_COOKIE[$sName])) {
		return htmlspecialchars(urldecode(trim($_COOKIE[$sName])));
	}
	return false;
}

?>