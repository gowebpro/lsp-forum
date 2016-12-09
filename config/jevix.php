<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet version: 1.0
* @File Name: jevix.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/


/**
 * Настройка Jevix
 */
$aJevix = array(
    'cfgAllowTags' => array(
        array(
            array('spoiler')
        ),
    ),
    'cfgAllowTagParams' => array(
        array(
            'spoiler',
            array('name' => '#text')
        ),
        array(
            'blockquote',
            array('reply' => '#int')
        )
    ),
    'cfgSetTagCallbackFull' => array(
        array(
            'spoiler',
            array('_this_', 'CallbackTagSpoiler'),
        ),
        array(
            'blockquote',
            array('_this_', 'CallbackTagQuote'),
        ),
    )
);

Config::Set('jevix.forum', array_merge_recursive(Config::Get('jevix.default'), $aJevix));

?>