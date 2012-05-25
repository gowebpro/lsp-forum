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
 */
if (!function_exists('forum_create_list')) {
	function forum_create_list($aForums=array(),$aList=array(),$sDepthGuide="") {
		if (is_array($aForums) && !empty($aForums)) {
			foreach ($aForums as $oForum) {
				$aList[] = array(
					'id' => $oForum->getId(),
					'title' => $sDepthGuide . $oForum->getTitle()
				);

				if ($aSubForums = $oForum->getChildren()) {
					$aList = forum_create_list($aSubForums, $aList, $sDepthGuide . PluginForum_ModuleForum::DEPTH_GUIDE);
				}
			}
		}
		return $aList;
	}
}

/**
 * Проверяет введен ли пароль
 */
function forum_compare_password($oForum) {
	$sCookiePass=fGetCookie("chiffaforumpass_{$oForum->getId()}");
	return (bool)($sCookiePass == md5($oForum->getPassword()));
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