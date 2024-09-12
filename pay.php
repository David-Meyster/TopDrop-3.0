<?php
define('TopDrop', true);

include_once("$_SERVER[DOCUMENT_ROOT]/core/init.php");

$json = file_get_contents('php://input');
$source = json_decode($json);

// file_put_contents('log.txt', 'PHPInput: ' . print_r($source, true) . "\r\nPOST: " . print_r($_POST, true) . "\r\n\r\n", FILE_APPEND);

isset($source->external_id) ? $order_id = $source->external_id : die('Error! No order id');
$order = $db->safeQuery("SELECT `pay_system` FROM `payments` WHERE `id` = ? AND `status` = '0'", $order_id)->fetch_assoc();

if (!$order) die('Error! Order not found');

$pay = new Pay;

switch ($order['pay_system']) {
  case 'streampay':
    $secret_key = hex2bin('f1dc319bd9f3e4790daf5b19baf31e987c0014e43dd49827acc0833aa271d58e');
    $signature = hex2bin($_SERVER['HTTP_SIGNATURE']);

    $utc_now = new \DateTime('now', new \DateTimeZone('UTC'));
    for ($i = 0; $i < 2; $i++) {
      $toSign = $json . $utc_now->format('Ymd:Hi');
      if (sodium_crypto_sign_verify_detached($signature, $toSign, $secret_key) !== false) {
        $pay->pay($order_id);
        return;
      }
      $utc_now->modify('-1 minutes');
    }
    die('Invalid signature');
    break;
  default:
    die('Error! Payment system not found');
}
