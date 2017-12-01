<?php
/**
 * Created by PhpStorm.
 * User: marabar
 * Date: 01.12.17
 * Time: 2:03
 *
 * id webhook 7XG57371DJ5189544
 *
 * Секрет EL1ac2gxUYrHPEU39zsnICXY3ODCNfwrpxVjcAmf9PbYQhF6BFKNZfCzFlkLKFpAfrk2jiMRHMGH0tVj
 */

define('MODX_API_MODE', true);
/** @noinspection PhpIncludeInspection */
require dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/index.php';

/** @var modX $modx */
$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');

$modx->log(modX::LOG_LEVEL_ERROR, print_r($_GET . $_POST, 1));