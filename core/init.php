<?php
if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden');

date_default_timezone_set('Europe/Moscow');

include_once("$_SERVER[DOCUMENT_ROOT]/core/config.php");

if ($config['debug']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

include_once("$_SERVER[DOCUMENT_ROOT]/core/function.php");
include_once("$_SERVER[DOCUMENT_ROOT]/core/classes.php");

try {
    $db = new db($dbConf['host'], $dbConf['user'], $dbConf['password'], $dbConf['database']);
} catch (mysqli_sql_exception $e) {
    die('Ошибка подключения к базе данных: ' . str_replace($dbConf, '...', $e->getMessage()));
}

$currentUser = new CurrentUser;

if (is_file($sxg = "$_SERVER[DOCUMENT_ROOT]/core/SxGeo/SxGeo.php")) {
    include_once($sxg);
    $sxg = new SxGeo("$_SERVER[DOCUMENT_ROOT]/core/SxGeo/SxGeoCity.dat");
}

if (isset($_GET['ref']) && preg_match("/^[A-Za-z0-9]{1,10}$/", $_GET['ref'])) setcookie('referral', $_GET['ref'], 0, '');
$refPromo = isset($_COOKIE['referral']) ? $_COOKIE['referral'] : (isset($_GET['ref']) ? $_GET['ref'] : '');