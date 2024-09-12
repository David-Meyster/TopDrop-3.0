<?php
define('TopDrop', true);
$do = (isset($_POST['do']) || empty($_POST['do'])) ? htmlspecialchars($_POST['do']) : die(json_encode(["error" => "Empty or undefined `do` parameter"]));
include("$_SERVER[DOCUMENT_ROOT]/core/init.php");

if ($config['debug']) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
} else {
  ini_set('display_errors', 0);
  ini_set('display_startup_errors', 0);
  error_reporting(0);
}

switch ($do) {
  case 'getModal':
    $modalName = (isset($_POST['modalName']) && !empty($_POST['modalName'])) ? preg_replace('/[\\/\\.]/', '', htmlspecialchars($_POST['modalName'])) : exit;
    if (is_file($includeFile = "$_SERVER[DOCUMENT_ROOT]/includes/modal/$modalName.php")) include_once($includeFile);
    break;
  case 'validateInput':
    if ($currentUser->authorized) exit;
    $type = (isset($_POST['type']) && !empty($_POST['type'])) ? preg_replace('/[\\/\\.]/', '', htmlspecialchars($_POST['type'])) : exit;
    $text = (isset($_POST['text']) && !empty($_POST['text'])) ? preg_replace('/[\/\\\]/', '', htmlspecialchars($_POST['text'])) : exit;
    $auth = new Auth;
    switch ($type) {
      case 'signup-email':
        die(json_encode((!$auth->validateEmail($text) || $auth->existEmail($text)) ? ['error' => $auth->error] : ['success' => true]));
      case 'signup-invite-code':
        die(json_encode((!$auth->validateRefCode($text) || !$auth->existRefCode($text)) ? ['error' => $auth->error] : ['success' => true]));
      case 'password':
        die(json_encode((!$auth->validatePassword($text)) ? ['error' => $auth->error] : ['success' => true]));
      case 'signup-nickname':
        die(json_encode((!$auth->validateNickname($text) || $auth->existNickname($text)) ? ['error' => $auth->error] : ['success' => true]));
      default:
        exit;
    }
  case 'signup':
    if ($currentUser->authorized) exit;
    $auth = new Auth;
    $auth->setEmail($_POST['email']);
    $auth->setPassword($_POST['password']);
    $auth->setNickname($_POST['nickname']);
    $auth->setRefCode($_POST['invitecode']);
    $auth->signup('default') ? exit : die(json_encode(['error' => $auth->error]));
  case 'signin':
    if ($currentUser->authorized) exit;
    $auth = new Auth;
    if (!$auth->setEmail($_POST['email']) && !$auth->setNickname($_POST['email'])) die(json_encode(['error' => $auth->error]));
    if (!$auth->setPassword($_POST['password'])) die(json_encode(['error' => $auth->error]));
    $auth->signin('default') ? exit : die(json_encode(['error' => $auth->error]));
  case 'stats':
    global $db;

    if ($currentUser->authorized) $currentUser->updateOnline();

    // online, counts
    $stats = $db->safeQuery("SELECT COUNT(*) AS `count_users`,
    (SELECT COUNT(*) FROM `users` WHERE `seen` >= ?) AS `online`,
    (SELECT COUNT(*) FROM `inventory` WHERE `gotfrom` = 'case') AS `count_cases`,
    (SELECT COUNT(*) FROM `upgrades` WHERE 1) AS `count_upgrades`,
    (SELECT COUNT(*) FROM `contracts` WHERE 1) AS `count_contracts`
    FROM `users` WHERE 1", time() - 60)->fetch_assoc();

    if ($db->errno != 0) die(json_encode(['error' => $db->error]));

    $livedroptype = (!isset($_POST['livedroptype'])) ? 'all' : $_POST['livedroptype'];

    // livedrop
    switch ($livedroptype) {
      case 'best':
        $livedrop = (abs(intval($_POST['limit'])) !== 0) ? ((abs(intval($_POST['offset_id'])) !== 0)
          ? $db->safeQuery("SELECT
              s.`img` AS skin_img,
              s.`name` AS skin_name,
              s.`rarity` AS skin_rarity,
              c.`img` AS case_img,
              c.`name` AS case_name,
              i.`user_id`,
              i.`gotfrom`,
              i.`id`
            FROM `inventory` i
              INNER JOIN `skins` s ON i.`item_id` = s.`id`
              LEFT JOIN `cases` c ON i.`dropped_from_case` = c.`title`
            WHERE i.`id` > ?
              AND i.`type` = 'skin'
              AND s.`cost` >= c.`cost` * 2 
              AND c.`cost` > 0 
            LIMIT 100", abs(intval($_POST['offset_id'])))->fetch_all(MYSQLI_ASSOC)
          : $db->safeQuery("SELECT
              s.`img` AS skin_img,
              s.`name` AS skin_name,
              s.`rarity` AS skin_rarity,
              c.`img` AS case_img,
              c.`name` AS case_name,
              c.`title` AS case_title,
              i.`user_id`,
              i.`gotfrom`,
              i.`id`
            FROM `inventory` i
              INNER JOIN `skins` s ON i.`item_id` = s.`id`
              LEFT JOIN `cases` c ON i.`dropped_from_case` = c.`title`
            WHERE i.`type` = 'skin'
              AND s.`cost` >= c.`cost` * 2 
              AND c.`cost` > 0 
            ORDER BY i.`id` DESC
            LIMIT ?", [abs(intval($_POST['limit']))])->fetch_all(MYSQLI_ASSOC))
          : false;
        break;
      case 'all':
        $livedrop = (abs(intval($_POST['limit'])) !== 0) ? ((abs(intval($_POST['offset_id'])) !== 0)
          ? $db->safeQuery("SELECT
              s.`img` AS skin_img,
              s.`name` AS skin_name,
              s.`rarity` AS skin_rarity,
              c.`img` AS case_img,
              c.`name` AS case_name,
              i.`user_id`,
              i.`gotfrom`,
              i.`id`
            FROM `inventory` i
              INNER JOIN `skins` s ON i.`item_id` = s.`id`
              LEFT JOIN `cases` c ON i.`dropped_from_case` = c.`title`
            WHERE i.`id` > ? AND i.`type` = 'skin'
            LIMIT 100", abs(intval($_POST['offset_id'])))->fetch_all(MYSQLI_ASSOC)
          : $db->safeQuery("SELECT
              s.`img` AS skin_img,
              s.`name` AS skin_name,
              s.`rarity` AS skin_rarity,
              c.`img` AS case_img,
              c.`name` AS case_name,
              c.`title` AS case_title,
              i.`user_id`,
              i.`gotfrom`,
              i.`id`
            FROM `inventory` i
              INNER JOIN `skins` s ON i.`item_id` = s.`id`
              LEFT JOIN `cases` c ON i.`dropped_from_case` = c.`title`
            WHERE i.`type` = 'skin'
            ORDER BY i.`id` DESC
            LIMIT ?", [abs(intval($_POST['limit']))])->fetch_all(MYSQLI_ASSOC))
          : false;
        break;
    }
    if ($db->errno != 0) die(json_encode(['error' => $db->error]));

    $time = time() % 84600; // кол-во секунд от начала суток
    $coefficient = $time <= 72000 ? 1 + $time / 72000 : 3 - $time / 72000;

    $stats['online'] += round(100 * $coefficient);

    $return = ['online' => $stats['online'], 'count_users' => $stats['count_users'], 'count_cases' => $stats['count_cases'], 'count_upgrades' => $stats['count_upgrades'], 'count_contracts' => $stats['count_contracts'], 'livedrop' => $livedrop];

    if ($currentUser->authorized) {
      $return['balance'] = $currentUser->balance;
      $return['balance_str'] = $currentUser->balance_str;
    }

    // return
    die(json_encode($return, JSON_UNESCAPED_UNICODE));
  case 'case_open':
    if (!$currentUser->authorized) die(json_encode(['error' => 'Для совершения данного действия необходимо авторизоваться']));

    $caseName = htmlspecialchars($_POST['case']);
    $factor = abs(intval($_POST['factor']));

    $casesObj = new Cases;
    // Проверка на существование кейса
    if (!$case = $casesObj->getOne($caseName)) die(json_encode(['error' => "Неизвестный кейс: $caseName"], JSON_UNESCAPED_UNICODE));
    // Проверка на factor
    if ($factor < 1 || $factor > 5) die(json_encode(['error' => "Недопустимый параметр количества открываемых кейсов: $factor"], JSON_UNESCAPED_UNICODE));
    // Проверка на время последнего открытия кейса (для кейсов, открываемых раз в определённый промежуток времени)
    if (!empty($case['case']['one_open_per']) && $case['case']['one_open_per'] > 0 && isset($currentUser->casesLastOpen[$caseName]) && time() - $currentUser->casesLastOpen[$caseName] < $case['case']['one_open_per']) {
      $timeBeforeOpen = $case['case']['one_open_per'] - (time() - $currentUser->casesLastOpen[$caseName]);
      $h = str_pad(floor($timeBeforeOpen / 3600), 2, '0', STR_PAD_LEFT);
      $m = str_pad(floor(($timeBeforeOpen % 3600) / 60), 2, '0', STR_PAD_LEFT);
      $s = str_pad($timeBeforeOpen % 60, 2, '0', STR_PAD_LEFT);
      die(json_encode(['error' => "Вы сможете открыть этот кейс через $h:$m:$s"], JSON_UNESCAPED_UNICODE));
    }
    // Проверка на то, может ли пользователь открыть этот кейс, если он бесплатный
    if ((!empty($case['case']['one_open_per']) || $case['case']['cost'] == 0)) {
      $canOpenThisFreeCase = $currentUser->canOpenFreeCase($case['case']['title']);
      if ($canOpenThisFreeCase !== true) die(json_encode(['error' => "<div class=\"flex column gap--xxs\"><div class=\"font h4 bold uppercase color--theme-text\">Вы уже открывали кейс!</div><div class=\"font h5\">Для фарма бесплатных кейсов требуется пополнить баланс минимум на <span class=\"money\">$config[payments_to_open_free_cases]</span> за последние $config[days_to_open_free_cases] дней. Пополните ещё на <span class=\"money\">$canOpenThisFreeCase</span></div><button class=\"theme-button color--green size\" data-modal=\"pay\">Пополнить</button></div>"], JSON_UNESCAPED_UNICODE));
    }
    // Проверяем, есть ли у пользователя в инвентаре не открытые кейсы, которые он мог бы открыть сейчас
    $countCasesFromInventory = $db->safeQuery("SELECT COUNT(*) FROM `inventory` WHERE `type` = 'case' AND `status` = '1' AND `user_id` = ? AND `item_id` = ?", [$currentUser->id, $case['case']['id']])->fetch_column();
    if ($countCasesFromInventory >= $factor) {
      $countOpenedCasesForFee = 0;
      $countOpenedCasesFromInventory = $factor;
    } else {
      $countOpenedCasesFromInventory = $countCasesFromInventory;
      $countOpenedCasesForFee = $factor - $countCasesFromInventory;
    }
    // Проверка на баланс
    if (!$currentUser->renewBalance() || $currentUser->balance < ($case['case']['cost'] * $countOpenedCasesForFee)) die(json_encode(['error' => 'Недостаточно средств. <button class="theme-button color--green size" data-modal="pay">Пополнить</button>'], JSON_UNESCAPED_UNICODE));

    $type = ($factor === 1) ? 'roulette' : 'drum';

    // Выбираем скины столько раз, сколько указано в factor, и помещаем скины в массив dropped
    $caseCost = ($case['case']['cost'] == 0) ? 1 : $case['case']['cost'];
    $skins = $case['skins'];
    $dropped = [];

    // Просчёт шансов
    /*     $totalChance = 0;
    $costs = array_column($skins, 'cost');
    $diff = max($costs) - min($costs);
    foreach ($skins as &$skin) $totalChance += $skin['chance'] = max(0, min(1, (1 - abs(($caseCost - $skin['cost']) / $diff))));
    foreach ($skins as &$skin) $skin['chance'] /= $totalChance;
    // Выбор скинов

    for ($i = 0; $i < 100000; $i++) {
      $randNum = rand(1, 10000) / 10000;
      $currentSum = 0;
      foreach ($skins as $skin) {
        $currentSum += $skin['chance'];
        if ($randNum <= $currentSum) {
          $dropped[] = $skin;
          break;
        }
      }
    }
 */


    $chanceSummary = 0;
    foreach ($skins as &$skin) {
      if ($caseCost >= $skin['cost']) $skin['chance'] = $skin['cost'] / $caseCost;
      else $skin['chance'] = $caseCost / $skin['cost'];
      $chanceSummary += $skin['chance'];
    }
    $coefficientMultiplier = $chanceSummary / 100;
    $sumChanceTop = $sumChanceBottom = 0;
    foreach ($skins as &$skin) {
      $skin['chance'] /= $coefficientMultiplier;
      if ($skin['cost'] < $caseCost) $sumChanceBottom += $skin['chance'];
      else $sumChanceTop += $skin['chance'];
    }
    $coefficientBottom = 50 / $sumChanceBottom;
    $coefficientTop = 50 / $sumChanceTop;
    foreach ($skins as &$skin) {
      if ($skin['cost'] < $caseCost) $skin['chance'] *= ($coefficientBottom * $case['case']['coefficient']) / $currentUser->coefficient;
      else $skin['chance'] *= ($coefficientTop / $case['case']['coefficient']) * $currentUser->coefficient;
    }
    $totalChance = array_reduce($skins, function ($acc, $skin) {
      return $acc + $skin['chance'];
    }, 0);
    // Выбор скинов
    for ($i = 0; $i < $factor; $i++) {
      $randNum = rand(1, round($totalChance * 10000)) / 10000;
      $currentSum = 0;
      foreach ($skins as &$skin) {
        $currentSum += $skin['chance'];
        if ($randNum <= $currentSum) {
          $dropped[] = $skin;
          break;
        }
      }
    }

    //die(json_encode(['error' => $skins]));


    // Запросы на внесение скинов в базу
    $insertedIds = [];
    foreach ($dropped as &$drop) {
      $db->safeQuery("INSERT INTO `inventory` (`user_id`, `gotfrom`, `type`, `item_id`, `dropped_from_case`, `status`, `time`) VALUES (?, 'case', 'skin', ?, ?, '1', ?)", [$currentUser->id, $drop['id'], $caseName, time()]);
      $insertedIds[] = $drop['insert_id'] = $db->insert_id;
    }
    // Если кейс открывается раз в какое-то время - вносим информацию об этом кейсе в строку пользователя в базе
    if (!empty($case['case']['one_open_per']) && $case['case']['one_open_per'] > 0) {
      $openedCases = $db->safeQuery("SELECT `cases_last_open` FROM `users` WHERE `id` = ?", $currentUser->id)->fetch_column();
      $openedCases = json_decode($openedCases, true);
      if (json_last_error() !== JSON_ERROR_NONE) $openedCases = [];

      $openedCases[$caseName] = time();
      $db->safeQuery("UPDATE `users` SET `cases_last_open` = ? WHERE `id` = ?", [json_encode($openedCases), $currentUser->id]);
    }

    // Если не выбило ошибку при добавлении скинов, и кейс не бесплатный - обновляем статус кейсов в инвентаре и баланс
    if ($case['case']['cost'] != 0) {
      // Обновляем статус кейсов в инвентаре, если они вообще есть
      if ($countCasesFromInventory > 0) $db->safeQuery("UPDATE `inventory` SET `status` = '0' WHERE `type` = 'case' AND `status` = '1' AND `user_id` = ? AND `item_id` = ? LIMIT ?", [$currentUser->id, $case['case']['id'], $countOpenedCasesFromInventory]);
      // Если количество кейсов, открываемых платно, > 0, то обновляем баланс
      if ($countOpenedCasesForFee > 0) {
        $balancestmt = $db->safeQuery("UPDATE `users` SET `balance` = `balance` - ? WHERE `id` = ?", [$caseCost * $countOpenedCasesForFee, $currentUser->id]);
        $currentUser->prizeAddXp(abs(intval($caseCost * $countOpenedCasesForFee) * 0.5));
      }
      if ($db->errno != 0 || $db->affected_rows == 0) { // Если баланс обновить не удалось - сносим все добавленные в базу скины и выводим ошибку
        $error = $db->error;

        die(json_encode(['error' => "Что-то пошло не так: $error"], JSON_UNESCAPED_UNICODE));
      }
    }
    // Если всё ок, записываем в $currentUser->balance баланс пользователя, в переменную $casesLeft количество оставшихся в инвентаре кейсов, и очищаем mysqli-statements
    $currentUser->balance = $currentUser->balance - ($caseCost * $countOpenedCasesForFee);
    $casesLeft = $countCasesFromInventory - $countOpenedCasesFromInventory;

    $return = ['balance' => $currentUser->balance, 'balance_str' => number_format($currentUser->balance, 2, '.', ' '), 'casesLeft' => $casesLeft, 'dropped' => $dropped, 'roulette_type' => $type];
    // Если это периодический кейс, записываем время следующего открытия для обработки через JS
    if (!empty($case['case']['one_open_per']) && $case['case']['one_open_per'] > 0) $return['next_open_in'] = $case['case']['one_open_per'];

    die(json_encode($return, JSON_UNESCAPED_UNICODE));
  case 'item_sell':
    if (!isset($_POST['item_id'])) die(json_encode(['error' => 'Не найден id скина, обратитесь в техподдержку']));
    if (!$currentUser->authorized) die(json_encode(['error' => 'Для совершения этого действия необходимо авторизоваться']));
    $skins_id = explode(',', htmlspecialchars($_POST['item_id']));

    $skins = $currentUser->getSkins(['select' => ['skins' => ['cost'], 'inventory' => ['id']], 'from' => 'inventory', 'where' => ['user_id' => $currentUser->id, 'id' => $skins_id, 'skin_status' => [1]]]);
    if (count($skins) !== count($skins_id) || !$skins_id) die(json_encode(['error' => 'Ошибка продажи, обратитесь в техподдержку']));

    $skins_id = array_column($skins, 'id');
    $skins_sum = array_sum(array_column($skins, 'cost'));
    $placeholders = implode(',', array_fill(0, count($skins_id), '?'));

    $rows = $db->safeQuery("UPDATE `inventory` SET `status` = '0', `time_loss` = ? WHERE `user_id` = ? AND `status` = '1' AND `id` IN ($placeholders)", [time(), $currentUser->id, ...$skins_id]);
    if ($rows < 1) die(json_encode(['error' => 'Ошибка продажи: статус предмета не обновлён. Обратитесь к администратору']));

    $rows = $db->safeQuery("UPDATE `users` SET `balance` = `balance` + ? WHERE `id` = ?", [$skins_sum, $currentUser->id]);
    if ($rows < 1) {
      $db->safeQuery("UPDATE `inventory` SET `status` = '1', `time_loss` = NULL WHERE `user_id` = ? AND `status` = '0' AND `id` IN ($placeholders)", [$currentUser->id, ...$skins_id]);
      die(json_encode(['error' => 'Ошибка продажи: баланс не обновлён. Обратитесь к администратору']));
    }

    if ($currentUser->renewBalance()) die(json_encode(['balance' => $currentUser->balance, 'balance_str' => $currentUser->balance_str]));
    break;
  case 'item_sell_all':
    if (!$currentUser->authorized) die(json_encode(['error' => 'Для совершения этого действия необходимо авторизоваться']));
    $skins_sum = $currentUser->getSkins(['select' => ['sum' => 'cost'], 'from' => 'inventory', 'where' => ['user_id' => $currentUser->id, 'skin_status' => [1]], 'fetch' => 'column']);

    $rows = $db->safeQuery("UPDATE `inventory` SET `status` = '0', `time_loss` = ? WHERE `user_id` = ? AND `status` = '1'", [time(), $currentUser->id]);
    if ($rows < 1) die(json_encode(['error' => 'Нет предметов для продажи!']));

    $rows = $db->safeQuery("UPDATE `users` SET `balance` = `balance` + ? WHERE `id` = ?", [$skins_sum, $currentUser->id]);
    if ($rows < 1) {
      $db->safeQuery("UPDATE `inventory` SET `status` = '1', `time_loss` = NULL WHERE `user_id` = ? AND `status` = '0'", $currentUser->id);
      die(json_encode(['error' => 'Ошибка продажи: баланс не обновлён. Обратитесь к администратору']));
    }
    if ($currentUser->renewBalance()) die(json_encode(['balance' => $currentUser->balance, 'balance_str' => $currentUser->balance_str]));
    break;
  case 'parse_main':
    if (isset($_POST['path'])) {
      $path = $_POST['path'];

      $page = new Page;
      $page->renewURI($path);

      ob_start();
      include_once($page->main);
      $main = ob_get_clean();

      die(json_encode(['main' => $main, 'path' => $page->path]));
    }
    break;
  case 'take_prize':
    global $config;
    $canGetPrize = $currentUser->canGetPrize();
    ($canGetPrize === true) ? $currentUser->takePrize() : die(json_encode(['error' => "<div class=\"flex column gap--xxs\"><div class=\"font h4 bold uppercase color--theme-text\">Вы уже получали приз!</div><div class=\"font h5\">Для фарма ежедневных призов требуется пополнить баланс минимум на <span class=\"money\">$config[payments_to_get_prizes]</span> за последние $config[days_to_get_prizes] дней. Пополните ещё на <span class=\"money\">$canGetPrize</span></div><button class=\"theme-button color--green size\" data-modal=\"pay\">Пополнить</button></div>"], JSON_UNESCAPED_UNICODE));
    break;
  case 'logout':
    $currentUser->logout();
    break;
  case 'skinUpgrade':
    if (isset($_POST['skin']) && isset($_POST['upgrade'])) {
      $skin_cost = $currentUser->getSkins(['select' => ['skins' => ['cost']], 'from' => 'inventory', 'where' => ['user_id' => $currentUser->id, 'id' => [$_POST['skin']], 'skin_status' => [1]], 'fetch' => 'column']);
      $upgrade_cost = $currentUser->getSkins(['select' => ['skins' => ['cost']], 'from' => 'skins', 'where' => ['id' => [$_POST['upgrade']]], 'fetch' => 'column']);
      if ($skin_cost && $upgrade_cost) {
        $upgrade = new Upgrade;
        $upgrade->upgrade($skin_cost, $upgrade_cost, $currentUser->coefficient);
        if (!$upgrade->error) {
          $rows = $db->safeQuery("UPDATE `inventory` SET `status` = '3', `time_loss` = ? WHERE `user_id` = ? AND `status` = '1' AND `id` = ?", [time(), $currentUser->id, $_POST['skin']]);
          if ($rows < 1) die(json_encode(['error' => 'Ошибка обновления статуса, обратитесь в техподдержку!']));

          if ($upgrade->result) {
            $rows = $db->safeQuery("INSERT INTO `inventory`(`user_id`, `gotfrom`, `type`, `item_id`, `status`, `time`) VALUES (?,'upgrade','skin',?,'1',?)", [$currentUser->id, $_POST['upgrade'], time()]);
            if ($rows < 1) die(json_encode(['error' => 'Ошибка добавления предмета, обратитесь в техподдержку!']));
            $skin_id_win = $db->insert_id;
          }
          $rows = $db->safeQuery("INSERT INTO `upgrades`(`user_id`, `first_item_id`, `second_item_id`, `result`) VALUES (?,?,?,?)", [$currentUser->id, $_POST['skin'], $_POST['upgrade'], $upgrade->result]);
          if ($rows < 1) die(json_encode(['error' => 'Ошибка создания апгрейда, обратитесь в техподдержку!']));

          die(json_encode(['result' => $upgrade->result, 'skin_win' => $skin_id_win]));
        } else die($upgrade->error);
      }
    }
    break;
  case 'getSkinsUpgrade':
    $skins = isset($_POST['cost']) ? $currentUser->getSkins(['select' => ['skins' => ['id', 'img', 'title', 'name', 'cost', 'rarity']], 'where' => ['sql' => "`skins`.`cost` > '" . abs(floatval($_POST['cost']) * 1.2) . "'"], 'from' => 'skins', 'order_by' => ['cost' => 'ASC'], 'limit' => 20, 'offset' => isset($_POST['offset']) ? abs(intval($_POST['offset'])) : 0]) : (isset($_POST['offset']) ? $currentUser->getSkins(['select' => ['skins' => ['img', 'title', 'name', 'cost', 'rarity'], 'inventory' => ['id']], 'from' => 'inventory', 'where' => ['user_id' => $currentUser->id, 'skin_status' => [1]], 'order_by' => ['id' => 'DESC'], 'limit' => 20, 'offset' => $_POST['offset']]) : exit);
    die(json_encode($skins));
  case 'createContract':
    if (!empty($skins_id = array_map('intval', $_POST['skins_id']))) {
      if (count($skins_id) < 2 && count($skins_id) > 12) die(json_encode(['error' => 'Ошибка, не верное количество элементов, обратитесь в техподдержку']));
      $skins_cost = $currentUser->getSkins(['select' => ['skins' => ['cost']], 'from' => 'inventory', 'where' => ['id' => $skins_id, 'skin_status' => [1], 'user_id' => $currentUser->id], 'limit' => count($skins_id)]);

      if (count($skins_cost) !== count($skins_id)) die(json_encode(['error' => 'Ошибка скинов, обратитесь в техподдержку, или сообщите в техподдержку']));
      $contracts = new Contracts;
      $contracts->contract($skins_cost, $currentUser->coefficient);
      if ($contracts->error) die($contracts->error);

      $result_skin = $currentUser->getSkins(['select' => ['skins' => ['id', 'img', 'title', 'name', 'cost', 'rarity']], 'from' => 'skins', 'order_by' => ['nearest' => ['cost' => $contracts->result_cost]], 'limit' => 1, 'fetch' => 'assoc']);

      $placeholders = implode(',', array_fill(0, count($skins_id), '?'));
      $rows = $db->safeQuery("UPDATE `inventory` SET `status` = '4', `time_loss` = ? WHERE `user_id` = ? AND `status` = '1' AND `id` IN($placeholders)", [time(), $currentUser->id, ...$skins_id]);
      if ($rows < count($skins_id)) die(json_encode(['error' => 'Ошибка, статус предмета не поменялся, обратитесь в техподдержку!']));

      $rows = $db->safeQuery("INSERT INTO `inventory` (`user_id`, `gotfrom`, `type`, `item_id`, `status`, `time`) VALUE (?, 'contracts', 'skin', ?, '1', ?)", [$currentUser->id, $result_skin['id'], time()]);
      if ($rows < 1) die(json_encode(['error' => 'Ошибка, предмет не добавился, обратитесь в техподдержку!']));
      $result_skin['id'] = $db->insert_id;

      $rows = $db->safeQuery("INSERT INTO `contracts`(`user_id`, `skins`, `skin_win`, `result`) VALUES (?,?,?,?)", [$currentUser->id, json_encode($skins_id, JSON_UNESCAPED_UNICODE), $result_skin['id'], $contracts->result]);
      if ($rows < 1) die(json_encode(['error' => 'Ошибка создания контракта, обратитесь в техподдержку!']));

      die(json_encode(['result' => $contracts->result, 'skin' => $result_skin]));
    }
    break;
  case 'getSkinsContract':
    if (isset($_POST['offset'])) die(json_encode($currentUser->getSkins(['select' => ['skins' => ['img', 'title', 'name', 'cost', 'rarity'], 'inventory' => ['id']], 'from' => 'inventory', 'where' => ['user_id' => $currentUser->id, 'skin_status' => [1]], 'order_by' => ['id' => 'DESC'], 'limit' => 20, 'offset' => abs(intval($_POST['offset']))])));
    break;
  case 'getProfileInventory':
    if (!isset($_POST['type']) && !isset($_POST['user_id']) && !isset($_POST['offset'])) return false;
    $type = htmlspecialchars($_POST['type']);
    $offset = abs(intval($_POST['offset']));
    $user_id = abs(intval($_POST['user_id']));
    $user = $user_id == $currentUser->id ? $currentUser : new OtherUser($user_id);

    if ($type == 'withdrawals' && $user_id != $currentUser->id) exit;

    $method = [
      'inventory' => 'getInventory',
      'contracts' => 'getContracts',
      'upgrades' => 'getUpgrades',
      'withdrawals' => 'getWithdrawals',
      'history' => 'getHistory'
    ][$type];

    die(json_encode($user->$method($offset)));
  case 'create_payment':
    if (isset($_POST['sum']) && isset($_POST['pay_system']) && isset($_POST['pay_type'])) {
      $promo = (isset($_POST['promo_type']) && isset($_POST['promo']) && $_POST['promo_type'] != 'invite' && !empty($promo)) ? substr(trim(htmlspecialchars($_POST['promo'])), 0, 60) : null;

      $sum = abs(floatval($_POST['sum']));
      $pay_type = substr(trim(htmlspecialchars($_POST['pay_type'])), 0, 60);
      $pay_system = substr(trim(htmlspecialchars($_POST['pay_system'])), 0, 60);

      $db->safeQuery("INSERT INTO `payments`(`user_id`, `sum`, `promo`, `pay_system`, `pay_type`, `time_creation`, `status`) VALUES (?,?,?,?,?,?,'0')", [$currentUser->id, $sum, $promo, $pay_system, $pay_type, time()]);
      $order_id = $db->insert_id;

      switch ($pay_system) {
        case 'paykeeper':
          die('Error! Pay system not found');
          $url = 'https://top-drop.server.paykeeper.ru/create/';
          $dataFields = [
            'sum' => $sum,
            'pstype' => $pay_type,
            'orderid' => $order_id,
            'clientid' => $currentUser->id,
          ];

          $curl = curl_init($url);
          curl_setopt_array($curl, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $dataFields,
          ]);
          $result = curl_exec($curl);
          $result = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
          break;
        case 'yookassa':
          die('Error! Pay system not found');
          $url = 'https://api.yookassa.ru/v3/payments';

          $shop_id = '319711';
          $secret_key = 'live_m8Vi63rKsoautldeyWUuah5GVqRWqsUAKE21eL9Xoso';

          $dataFields = [
            'amount' => [
              'value' => $sum,
              'currency' => 'RUB'
            ],
            'confirmation' => [
              'type' => 'redirect',
              'return_url' => "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]"
            ],
            'description' => "Заказ №$order_id",
            'metadata' => [
              'order_id' => $order_id
            ],
            'payment_method_data' => [
              'type' => $pay_type
            ],
            'capture' => true
          ];
          $dataFields = json_encode($dataFields);

          $curl = curl_init($url);

          $headers = [
            'Content-Type: application/json',
            'Idempotence-Key: ' . md5($order_id)
          ];

          curl_setopt_array($curl, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => $dataFields,
            CURLOPT_USERPWD        => "$shop_id:$secret_key"
          ]);
          $result = curl_exec($curl);
          break;
        case 'overpay':
          $url = 'https://checkout.overpay.io/ctp/api/checkouts';

          $shop_id = 26738;
          $secret_key = 'fb237baa944cbb58eb9f6590ae06dc919a8c8845a104f313239cb592cef9b160';


          $dataFields = [
            'checkout' => [
              'test' => true,
              'transaction_type' => 'payment',
              'attempts' => 5,
              'order' => [
                'currency' => 'RUB',
                'amount' => $sum,
                'description' => "Заказ №$order_id",
                'tracking_id' => strval($order_id),
              ],
              'settings' => [
                'save_card_toggle' => [
                  'text' => 'Сохранить карту',
                  'hint' => 'Сохраните карту для последующих операций, чтобы не вводить данные повторно'
                ],
                'return_url' => "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]",
                'cancel_url' => "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]",
                'notification_url' => "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]/pay",
                'button_text' => 'Привязать карту',
                'button_next_text' => 'Вернуться в магазин',
                'language' => 'ru',
                'customer_fields' => [
                  'visible' => [
                    'email'
                  ]
                ]
              ],
              'customer' => [
                'first_name' => strval($currentUser->name),
                'last_name' => strval($currentUser->id),
                'country' => 'RU'
              ],
              'payment_method' => [
                'types' => [
                  'credit_card'
                ]
              ]
            ]
          ];

          $dataFields = json_encode($dataFields);

          $curl = curl_init($url);

          $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-Version: 2',
            'Authorization: Basic ' . base64_encode("$shop_id:$secret_key")
          ];

          curl_setopt_array($curl, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST   => true,
            CURLOPT_HTTPHEADER  => $headers,
            CURLOPT_POSTFIELDS  => $dataFields
          ]);

          $result = json_decode(curl_exec($curl));
          curl_close($curl);
          die($result->checkout->redirect_url);
        case 'atolpay':
          die('Error! Pay system not found');
          //$url = 'https://lk.atolpay.ru/v1/ecom/payments';
          $url = 'https://croc-sandbox-api-mobile.atolpay.ru/v1/ecom/';

          //$secret_key = 'f52ba0e20d370876e2c4a93688afc0b2'; основа
          $secret_key = '7e35049e6da045f5abd9c976e0d4e106';

          $dataFields = [
            'amount' => $sum,
            'orderId' => strval($order_id),
            'sessionType' => 'oneStep',
            'additionalProps' => [
              'returnUrl' => "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]",
              'notificationUrl' => "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]/pay",
            ],
            'receipt' => [
              'positions' => [
                [
                  'name' => 'Баланс',
                  'price' => 1,
                  'quantity' => 1000,
                  'measure' => 0,
                  'tax' => 5
                ]
              ],
              'providerId' => 100,
              // 'type' => ,
              'sno' => 1
            ],
            'inn' => '720200995965',
            'paymentMethods' => [
              [
                'paymentType' => $pay_type,
                'bankId' => 700
              ]
            ]
          ];
          $dataFields = json_encode($dataFields);

          $curl = curl_init($url);

          $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . $secret_key
          ];
          curl_setopt_array($curl, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST   => true,
            CURLOPT_HTTPHEADER  => $headers,
            CURLOPT_POSTFIELDS  => $dataFields
          ]);

          break;
        case 'streampay':
          $url = 'https://api.streampay.org/api/payment/create';

          $shop_id = 298;
          $secret_key = hex2bin('b6ec450be0ac19a860fa75fce1f79db692379cd19525c963b531e0920448c178f1dc319bd9f3e4790daf5b19baf31e987c0014e43dd49827acc0833aa271d58e');

          $dataFields = json_encode([
            'store_id' => $shop_id,
            'customer' => strval($currentUser->id),
            'external_id' => strval($order_id),
            'description' => 'Пополнение баланса',
            'system_currency' => 'USDT',
            'payment_type' => 1,
            'currency' => 'RUB',
            'amount' => abs(floatval($sum)),
            'success_url' => "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]/pay",
            'lang' => 'ru',
          ]);

          $utc_now = new \DateTime('now', new \DateTimeZone('UTC'));
          $toSign = $dataFields . $utc_now->format('Ymd:Hi');
          $signature = bin2hex(sodium_crypto_sign_detached($toSign, $secret_key));

          $curl = curl_init($url);
          try {
            curl_setopt_array($curl, [
              CURLOPT_POST => true,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_HTTPHEADER => [
                'Signature:' . $signature,
                'Content-type: application/json'
              ],
              CURLOPT_POSTFIELDS => $dataFields
            ]);

            $response = curl_exec($curl);
            if ($response === false) {
              $response = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
              die(json_encode(['error' => $response === 406 ? 'No available currencies' : ($response === 500 ? 'Internal server error' : curl_error($curl))]));
            } else {
              $response = json_decode($response);
              if (isset($response->messages[0])) die(json_encode(['error' => $response->messages[0]]));
              die(json_encode(['url' => $response->data->pay_url]));
            }
          } finally {
            curl_close($curl);
          }
          break;
        default:
          die(json_encode(['error' => 'Error! Pay system not found']));
      }
    }
    break;
  case 'checkPromo':
    if (isset($_POST['promo']) && isset($_POST['status'])) {
      global $db;
      $promo = substr(trim(htmlspecialchars($_POST['promo'])), 0, 60);
      $promoStatus = substr(trim(htmlspecialchars($_POST['status'])), 0, 60);
      $promoData = $db->safeQuery("SELECT
        u.`id` AS isPromoUse,
        p.`activations`,
        p.`expiration`,
        p.`bonus`,
        p.`type`,
        p.`id`
      FROM `promo` p
        LEFT JOIN `promo_users` u ON p.`id` = u.`promo_id` AND u.`user_id` = ?
      WHERE p.`promo` = ?
        AND p.`type` = ?
      LIMIT 1", [$currentUser->id, $promo, $promoStatus])->fetch_assoc();

      if ($promoData) {
        if (!$promoData['isPromoUse']) {
          if (empty($promoData['expiration']) || $promoData['expiration'] > date('Y-m-d')) {
            if ($promoData['activations'] === null || $promoData['activations'] > 0) {
              switch ($promoStatus) {
                case 'percent':
                  // if ($db->safeQuery("INSERT INTO `promo_users`(`user_id`, `promo_id`, `time`) VALUES (?, ?, ?)", [$currentUser->id, $promoData['id'], time()]) === 0) die(json_encode(['error' => 'Использование не засчиталось, обратитесь в техподдержку']));
                  die(json_encode(['bonus' => $promoData['bonus']]));
                case 'case':
                  $bonus = $db->safeQuery("SELECT `name` FROM `cases` WHERE `id` = ?", $promoData['bonus']);
                  if (!$bonus->num_rows) die(json_encode(['error' => 'Кейс не найден, либо удалён']));
                  if ($db->safeQuery("INSERT INTO `promo_users`(`user_id`, `promo_id`, `time`) VALUES (?, ?, ?)", [$currentUser->id, $promoData['id'], time()]) === 0) die(json_encode(['error' => 'Использование не засчиталось, обратитесь в техподдержку']));
                  if ($db->safeQuery("INSERT INTO `inventory`(`user_id`, `gotfrom`, `type`, `item_id`, `status`, `time`) VALUES (?, 'promo', 'case', ?, '1', ?)", [$currentUser->id, $promoData['bonus'], time()]) === 0) die(json_encode(['error' => 'Кейс не добавлен, обратитесь в техподдержку']));
                  if ($db->safeQuery("UPDATE `promo` SET `activations` = `activations` - 1 WHERE `id` = ?", $promoData['id']) === 0) die(json_encode(['error' => 'Ошибка обновления активаций, обратитесь в техподдержку']));
                  die(json_encode(['bonus' => $bonus->fetch_column()]));
                default:
                  die(json_encode(['error' => 'Не найден тип промокода, обратитесь в техподдержку']));
              }
            } else die(json_encode(['error' => 'Количество активаций закончилось']));
          } else die(json_encode(['error' => 'Акция закончилась']));
        } else die(json_encode(['error' => 'Вы уже вводили промокод']));
      } else die(json_encode(['error' => 'Промокод не найден']));
    }
    break;
  case 'createWithdraw':
    if (isset($_POST['pattern']) && isset($_POST['skins_id'])) {
      if ($currentUser->replenished >= 1) {
        $pattern = abs(intval($_POST['pattern']));
        $skins_id = array_map('intval', $_POST['skins_id']);

        $skins_cost = $currentUser->getSkins(['select' => ['skins' => ['cost']], 'from' => 'inventory', 'where' => ['user_id' => $currentUser->id, 'id' => $skins_id, 'skin_status' => [1]], 'limit' => count($skins_id)]);
        if ($skins_cost && count($skins_cost) === count($skins_id)) {
          $skins_id_json = json_encode($skins_id, JSON_UNESCAPED_UNICODE);
          $withdraw_sum = round(array_sum(array_column($skins_cost, 'cost')) * 1.252, 2);
          $placeholders = implode(',', array_fill(0, count($skins_id), '?'));
          global $db;
          $rows = $db->safeQuery("UPDATE `inventory` SET `status` = '2' WHERE `user_id` = ? AND `status` = '1' AND `id` IN ($placeholders)", [$currentUser->id, ...$skins_id]);
          if ($rows != count($skins_cost)) die(json_encode(['error' => 'Ошибка, обратитесь в техподдержку']));
          $db->safeQuery("INSERT INTO `withdrawals`(`user_id`, `skins_id`, `pattern`, `status`, `sum`, `add_time`) VALUES (?, ?, ?, 'withdrawing', ?, ?)", [$currentUser->id, $skins_id_json, $pattern, $withdraw_sum, time()]);
        } else die(json_encode(['error' => 'Ошибка, обратитесь в техподдержку']));
      } else die(json_encode(['error' => 'Пополните баланс минимум на 1₽']));
    }
    break;
  case 'setAvatar':
    if (isset($_FILES['file_avatar'])) die($currentUser->setAvatar($_FILES['file_avatar']));
    break;
  case 'createSapper':
    if (isset($_POST['sum'])) {
      $sum = round(abs(floatval($_POST['sum'])), 2);
      if ($sum < 1) die(json_encode('Минимальная ставка 1₽'));
      if ($sum > $currentUser->balance) die(json_encode('Недостаточно средств'));

      $db->safeQuery("INSERT INTO `sapper`(`user_id`, `cells`, `mines`, `result`) VALUES (?,?,?,?)", [$currentUser->id,]);
      $db->safeQuery("SELECT `id`, `success`, `mines`, `result` FROM `sapper` WHERE `user_id` = ? AND ``", [$currentUser->id]);
    }
    break;
  case 'createCards':
    if (isset($_POST['cards'])) {
      if (!$currentUser->authorized) die(json_encode(['error' => 'Для совершения данного действия необходимо авторизоваться']));
      function calculateChances(array $items, $average = 1): array
      {
        global $currentUser;
        $average *= $currentUser->coefficient;
        $numMin = min(array_column($items, 'x'));
        $numMax = max(array_column($items, 'x'));
        $diff = $numMax - $numMin;
        foreach ($items as &$skin)
          $skin['chance'] = max(0, min(1, (1 - abs(($average - $skin['x']) / $diff))));


        $totalChance = array_sum(array_column($items, 'chance'));

        if ($totalChance > 0)
          foreach ($items as &$skin)
            $skin['chance'] /= $totalChance;

        return $items;
      }
      function selectRandItem(array $items)
      {
        foreach ($items as $key => &$item)
          if ($key > 0) $item['chance'] += $items[--$key]['chance'];

        $randNum = rand(1, round($item['chance'] * 10000)) / 10000;
        foreach ($items as $item)
          if ($randNum <= $item['chance']) return $item;
      }
      $cards = calculateChances($_POST['cards'], 1);
      $cardWin = selectRandItem($cards);

      if ($currentUser->renewBalance()) die(json_encode(['balance' => $currentUser->balance, 'balance_str' => $currentUser->balance_str, 'win' => $cardWin]));
    }
    break;
  default:
    die(json_encode(['error' => "Unknown `do` parameter: $do"]));
}
