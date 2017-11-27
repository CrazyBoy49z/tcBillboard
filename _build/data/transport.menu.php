<?php
/** @var modX $modx */
/** @var array $sources */

$menus = array();

$tmp = array(
    'tcbillboard' => array(
        'description' => 'tcbillboard_menu_desc',
        'action' => 'mgr/billboards',
        //'icon' => '<i class="icon icon-large icon-modx"></i>',
    ),
    'tcbillboard_settings' => array(
        'description' => 'tcbillboard_settings_desc',
        'parent' => 'tcbillboard',
        'menuindex' => 0,
        'action' => 'mgr/settings',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modMenu $menu */
    $menu = $modx->newObject('modMenu');
    $menu->fromArray(array_merge(array(
        'text' => $k,
        'parent' => 'components',
        'namespace' => PKG_NAME_LOWER,
        'icon' => '',
        'menuindex' => 0,
        'params' => '',
        'handler' => '',
    ), $v), '', true, true);
    $menus[] = $menu;
}
unset($menu, $i);

return $menus;