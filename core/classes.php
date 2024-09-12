<?php
if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden');

class db extends MySQLi
{
  public function safeQuery($query, $parameters = [], $pattern = '')
  {
    if (empty($query)) {
      $debug = debug_backtrace()[0];
      printf('Empty query in %s on line %d', $debug['file'], $debug['line']);
      return false;
    }

    if (isset($parameters) && !in_array(gettype($parameters), ['string', 'integer', 'float', 'double', 'array'])) {
      $debug = debug_backtrace()[0];
      printf('Parameters is not an array, string, or number in %s on line %d', $debug['file'], $debug['line']);
      return false;
    }

    $stmt = $this->prepare($query);
    if (is_array($parameters) && count($parameters) > 0) {
      if (strlen($pattern) != count($parameters) || preg_match('/^([isdb]+)$/', $pattern))
        $pattern = str_repeat('s', count($parameters));
      $stmt->bind_param($pattern, ...$parameters);
    } else if (gettype($parameters) == 'string') $stmt->bind_param('s', $parameters);
    else if (gettype($parameters) == 'integer') $stmt->bind_param('i', $parameters);
    else if (gettype($parameters) == 'integer' || gettype($parameters) == 'float') $stmt->bind_param('d', $parameters);

    $stmt->execute();

    preg_match('/\b(UPDATE|SELECT|INSERT INTO|DELETE)\b/i', $query, $matches);
    $queryType = strtoupper($matches[1]);

    $result = (in_array($queryType, ['UPDATE', 'INSERT INTO', 'DELETE'])) ? $stmt->affected_rows : $stmt->get_result();
    $stmt->reset();
    return $result;
  }
}
/*

Класс регистрации и авторизации

Проверка валидности (проверка на пустое значение и соответствие шаблону ($preg в config.php)):
- validateEmail($email)         - Валидация E-mail
- validateNickname($nickname)   - Валидация ника
- validatePassword($password)   - Валидация пароля
- validateRefCode($referral)    - Валидация реферального кода
Возврат:
- true, если значение не пустое и соответствует шаблону
- false, если значение пустое или не соответствует шаблону

Проверка существования:
- existEmail($email)            - Валидация E-mail и проверка его по базе.
Вернёт false, если в базе нет пользователя с таким E-mail
Вернёт true, если в базе существует пользователь с этим адресом
- existNickname($nickname)      - Валидация ника и проверка его по базе
Вернёт false, если в базе нет пользователя с таким ником
Вернёт true, если в базе существует пользователь с этим ником
- existRefCode($referral)       - Валидация реферального кода и проверка его по базе
Если найден пользователь с этим реферальным кодом, вернёт id этого пользователя
Если реферальный код не найден, вернёт false

Регистрация (по нику/мылу-паролю):
- setEmail($email)              - Запись почты $email внутрь экземпляра класса
- setNickname($nickname)        - Запись ника $nickname внутрь экземпляра класса
- setPassword($password)        - Запись пароля $password внутрь экземпляра класса
- setRefCode($refCode)          - Запись реферального кода $refCode внутрь экземпляра класса (не обязательно)
- signup('default')             - Выполнение регистрации (на основе заполненных предыдущими функциями данных)
                                  Вернёт true в случае успеха, false в случае ошибки (ошибка внутри переменной error экземпляра класса)
Регистрация oAuth:
- setEmail($email)
- setNickname($nickname)
- setPassword($password)
- setRefCode($refCode)              - Не обязательно
- setOAuthData([$system, $unique])  - Указывает, от какой системы проходит регистрация (список разрешённых в config.php), и какое-либо уникальное значение, с которым будет сравниваться значение при авторизации
- signup("oauth")

Авторизация (по нику/мылу-паролю):
- setEmail($email)              - Запись почты $email внутрь экземпляра класса
- setPassword($password)        - Запись пароля $password внутрь экземпляра класса
- signin("default")             - Выполнение авторизации (на основе заполненных предыдущими функциями данных)
                                  Вернёт true в случае успеха, false в случае ошибки (ошибка внутри переменной error экземпляра класса)
Авторизация (oAuth):
- setOAuthData([$system, $unique])  - Указывает, от какой системы проходит авторизация (список разрешённых в config.php) и ключ, по которому надо сравнивать с тем, что есть в базе
- signin("oauth")                   - Выполнение авторизации (на основе заполненных предыдущими функциями данных)
                                    Вернёт true в случае успеха, false в случае ошибки (ошибка внутри переменной error экземпляра класса)

!!! НЕ НАДО ЗАПИХИВАТЬ В $unique ТОКЕН ПОЛЬЗОВАТЕЛЯ !!!
У ВК токен изменяется при каждом запросе! У других сервисов, скорее всего, тоже. Нужно записывать что-то, что не будет меняться, например ID аккаунта

Описание ошибок всегда в Auth->error, например:
$auth = new Auth;
if (!$auth->signup()) {
    echo $auth->error;
}

Сатусы скинов:
sold - 0 - продано
exist - 1 - существует
withdrawn - 2 - где-то на выводе
lost_upgrade - 3 - проиграно в апгрейде
lost_contracts - 4 - проиграно в контрактах

*/
class Auth
{
  private $email, $password, $nickname, $refCode = '', $oauthSystem, $oauthUnique;
  public $error, $uid;

  // Фукнции валидации
  function validateEmail($input)
  {
    global $preg;
    if (!isset($input) && empty($input)) {
      $this->error = "E-mail не заполнен";
      return false;
    }
    if (!preg_match(isset($preg['email']) ? $preg['email'] : '/^([\w\-\.]+)\@([a-zA-Z0-9\-]+)\.([a-zA-Z]{2,5})$/', $input)) {
      $this->error = "E-mail имеет некорректный формат";
      return false;
    }
    return true;
  }
  function validateNickname($input)
  {
    global $preg;
    if (!isset($input) && empty($input)) {
      $this->error = "Никнейм не заполнен";
      return false;
    }
    return true;
  }
  function validatePassword($input)
  {
    global $preg;
    if (!isset($input) && empty($input)) {
      $this->error = "Пароль не заполнен";
      return false;
    }
    if (!preg_match(isset($preg['password']) ? $preg['password'] : '/^(.{6,50})$/', $input)) {
      $this->error = "Пароль имеет некорректный формат";
      return false;
    }
    return true;
  }
  function validateRefCode($input)
  {
    global $preg;
    if (!isset($input) && empty($input)) {
      $this->error = "Инвайт-код не заполнен";
      return false;
    }
    if (!preg_match(isset($preg['referral_code']) ? $preg['referral_code'] : '/^[a-zA-Z0-9]{1,10}$/', $input)) {
      $this->error = "Инвайт-код имеет некорректный формат";
      return false;
    }
    return true;
  }

  // Функции проверки существования
  function existEmail($input)
  {
    global $db;
    if ($db->safeQuery("SELECT `id` FROM `users` WHERE `email` = ? LIMIT 1", $input)->num_rows == 0) {
      $this->error = "Пользователь с указанным E-mail не зарегистрирован";
      return false;
    } else {
      $this->error = "Пользователь с указанным E-mail уже зарегистрирован";
      return true;
    }
  }
  function existNickname($input)
  {
    global $db;
    if ($db->safeQuery("SELECT `id` FROM `users` WHERE `name` = ? LIMIT 1", $input)->num_rows == 0) {
      $this->error = "Пользователь с указанным никнеймом не зарегистрирован";
      return false;
    } else {
      $this->error = "Никнейм занят";
      return true;
    }
  }
  function existRefCode($input)
  {
    global $db;
    $ref = $db->safeQuery("SELECT `id` FROM `users` WHERE `referral_code` = ?", $input)->fetch_column();
    if (!$ref) {
      $this->error = "Инвайт-код не найден";
      return false;
    }
    return $ref;
  }

  // Функции заполнения переменных экземпляра
  function setEmail($input)
  {
    if (!$this->validateEmail($input)) return false;
    $this->email = htmlspecialchars(trim($input));
    return true;
  }
  function setNickname($input)
  {
    if (!$this->validateNickname($input)) return false;
    $this->nickname = htmlspecialchars(trim($input));
    return true;
  }
  function setRefCode($input)
  {
    if (!$this->validateRefCode($input)) return false;
    $this->refCode = htmlspecialchars(trim($input));
    return true;
  }
  function setPassword($input)
  {
    if (!$this->validatePassword($input)) return false;
    $this->password = htmlspecialchars(trim($input));
    return true;
  }
  function setOAuthData($input)
  {
    global $oauthConfig;
    if (!is_array($input) || count($input) != 2 || gettype($input[0]) != "string") {
      $this->error = "Некорректные параметры OAuth: " . print_r($input, true);
      return false;
    }
    if (!in_array($input[0], $oauthConfig['allowsystems'])) {
      $this->error = "{$input[0]} не является допустимой системой для OAuth";
      return false;
    }
    $this->oauthSystem = $input[0];
    $this->oauthUnique = $input[1];
    return true;
  }


  // Функция регистрации
  function signup($signupType = 'default')
  {
    global $db, $currentUser, $oauthConfig;;
    if ($currentUser->authorized) return false;

    if (is_file($sxg = $_SERVER['DOCUMENT_ROOT'] . '/core/SxGeo/SxGeo.php')) {
      include_once($sxg);
      $sxg = new SxGeo($_SERVER['DOCUMENT_ROOT'] . "/core/SxGeo/SxGeoCity.dat");
    }

    switch ($signupType) {
      case 'default':
        $email = $this->email;
        $password = $this->password;
        $nickname = $this->nickname;
        $refCode = $this->refCode;
        if (!$this->validateEmail($email) || $this->existEmail($email)) return false;
        if (!$this->validateNickname($nickname) || $this->existNickname($nickname)) return false;
        if (!$this->validatePassword($password)) return false;
        $password = password_hash($password, PASSWORD_DEFAULT);
        break;
      case 'oauth':
        if ($this->oauthSystem == null || $this->oauthUnique == null) {
          $this->error = 'Указан тип регистрации - OAuth, но не переданы параметры OAuth';
          return false;
        } else $oauthData = json_encode([$this->oauthSystem => $this->oauthUnique]);
        $dbUser = $db->safeQuery("SELECT `id`,`sessions` FROM `users` WHERE JSON_CONTAINS(`oauth`, JSON_OBJECT(?, ?)) LIMIT 1", [$this->oauthSystem, $this->oauthUnique]);
        if ($dbUser->num_rows > 0) {
          $this->error = 'Пользователь уже зарегистрирован';
          return false;
        }
        // Префикс для ника
        if (isset($oauthConfig[$this->oauthSystem]['db_username_prefix'])) {
          $nicknamePrefix = $oauthConfig[$this->oauthSystem]['db_username_prefix'];
        } else {
          $nicknamePrefix = strtoupper($this->oauthSystem);
        }

        break;
      default:
        $this->error = 'Неизвестный тип регистрации';
        return false;
    }

    $invitedby = (isset($refCode) && $this->validateRefCode($refCode)) ? (($refCode = $this->existRefCode($refCode)) ? $refCode : null) : null;

    // Генерация информации о сессии
    $session = [];
    do {
      $session['token'] = bin2hex(random_bytes(20));
      $getCollisionTokenSQL = $db->safeQuery("SELECT `id` FROM `users` WHERE JSON_CONTAINS(`sessions`, JSON_OBJECT('token', ?)) LIMIT 1", $session['token']);
    } while ($getCollisionTokenSQL->num_rows > 0);
    $session['ip'] = getIP();
    if (class_exists("SxGeo")) {
      if ($sxg->get($session['ip']) != false) {
        $tmp_city = $sxg->get($session['ip'])['city']['name_en'];
        $tmp_country = $sxg->get($session['ip'])['country']['iso'];
        $session['geo'] = sprintf("%s, %s", ($tmp_city == "") ? "Unknown city" : $tmp_city, ($tmp_country == "") ? "Unknown country" : $tmp_country);
      }
    }
    $session['time'] = time();
    $session['ua'] = md5($_SERVER['HTTP_USER_AGENT']);

    // Генерация реферального кода

    $maxRefCode = $db->safeQuery("SELECT MAX(`referral_code`) FROM `users`")->fetch_column();
    $refCode = strtoupper(base_convert(max(18036903, base_convert($maxRefCode, 36, 10) + 1), 10, 36));

    // Отправка запроса на добавление записи в БД
    switch ($signupType) {
      case 'default':
        $db->safeQuery("INSERT INTO `users` (`email`,`name`,`password`,`sessions`,`referral_code`,`invited_by`,`seen`,`reg_time`) VALUES (?,?,?,?,?,?,?,?)", [$email, $nickname, $password, json_encode([$session], JSON_UNESCAPED_UNICODE), $refCode, $invitedby, time(), time()]);
        break;
      case 'oauth':
        $db->safeQuery("INSERT INTO `users` (`name`,`sessions`,`referral_code`,`invited_by`,`oauth`,`seen`,`reg_time`) VALUES (?,?,?,?,?,?,?)", ['temp', json_encode([$session], JSON_UNESCAPED_UNICODE), $refCode, $invitedby, $oauthData, time(), time()]);
        $this->uid = $db->insert_id;
        $db->safeQuery("UPDATE `users` SET `name` = ? WHERE `id` = ?", ["{$nicknamePrefix}_{$this->uid}", $this->uid]);
        if (isset($this->email) && $this->email != '') $db->safeQuery("UPDATE `users` SET `email` = ? WHERE `id` = ?", [$this->email, $this->uid]);
        break;
    }

    if ($db->errno != 0) {
      $this->error = "Ошибка выполнения запроса к базе данных: $db->error";
      return false;
    }

    setcookie('auth_token', $session['token'], ['expires' => time() + 2592000, 'path' => '/', 'httponly' => true]);

    return true;
  }

  // Функция входа
  function signin($signinType = "default")
  {
    global $db, $currentUser;
    if ($currentUser->authorized) return false;

    switch ($signinType) {
      case "default": // Авторизация по мылу/нику и паролю
        $emailOrNick = ($this->email != null) ? $this->email : $this->nickname;
        $password = $this->password;

        if (!$this->validateEmail($emailOrNick) && !$this->validateNickname($emailOrNick)) {
          $this->error = "Некорректный формат E-mail или никнейма";
          return false;
        }
        if (!$this->validatePassword($password)) return false;

        // Проверка существования пользователя с таким E-mail или никнеймом
        $dbUser = $db->safeQuery("SELECT `id`,`password`,`sessions`,`last_auth_errors` FROM `users` WHERE `email` = ? OR `name` = ? LIMIT 1", [$emailOrNick, $emailOrNick]);
        if ($dbUser->num_rows == 0) {
          $this->error = "Пользователь с таким E-mail или никнеймом не найден";
          return false;
        }
        $dbUser = $dbUser->fetch_assoc();

        // Проверяем, допускал ли пользователь 10 ошибок при вводе пароля за последние 15 минут
        $dbErrors = (!empty($dbUser['lash_auth_errors']) && json_decode($dbUser['last_auth_errors'])) ? json_decode($dbUser['last_auth_errors'], true) : [];
        $authFails = 0;
        foreach ($dbErrors as $errorTime)
          if ($errorTime > (time() - 900))
            $authFails++;

        if ($authFails == 10) {
          $this->error = "Слишком много неудачных попыток входа в эту учётную запись. Попробуйте снова через 15 минут.";
          return;
        }

        $dbUserPasswordHash = $dbUser['password'];
        if (!password_verify($password, $dbUserPasswordHash)) {
          $this->error = "Неверный пароль";
          // Если в базе уже есть 10 записей о том, что пользователь допускал ошибки при вводе пароля, стираем самую старую
          if (count($dbErrors) >= 10) {
            unset($dbErrors[0]);
            $dbErrors = array_values($dbErrors);
          }
          // Записываем timestamp текущей неудачной попытки входа в учётку и пишем изменения в базу
          $dbErrors[] = time();
          $db->safeQuery("UPDATE `users` SET `last_auth_errors` = ? WHERE `id` = ? LIMIT 1", [json_encode($dbErrors), $dbUser['id']]);
          return false;
        }
        break;
      case "oauth": // Авторизация через OAuth
        if ($this->oauthSystem == null || $this->oauthUnique == null) {
          $this->error = "Указан тип авторизации - OAuth, но не переданы параметры OAuth";
          return false;
        }
        $dbUser = $db->safeQuery("SELECT `id`,`sessions` FROM `users` WHERE JSON_CONTAINS(`oauth`, JSON_OBJECT(?, ?)) LIMIT 1", [$this->oauthSystem, $this->oauthUnique]);
        if ($dbUser->num_rows == 0) {
          $this->error = "Пользователь не зарегистрирован";
          return false;
        }
        $dbUser = $dbUser->fetch_assoc();
        break;
      default:
        $this->error = "Неизвестный параметр типа авторизации";
        return false;
    }

    // Генерация информации о новой сессии
    if (is_file($sxg = $_SERVER['DOCUMENT_ROOT'] . '/core/SxGeo/SxGeo.php')) {
      include_once($sxg);
      $sxg = new SxGeo($_SERVER['DOCUMENT_ROOT'] . "/core/SxGeo/SxGeoCity.dat");
    }
    $session = [];
    do {
      $session['token'] = bin2hex(random_bytes(20));
      $getCollisionTokenSQL = $db->safeQuery("SELECT `id` FROM `users` WHERE JSON_CONTAINS(`sessions`, JSON_OBJECT('token', ?)) LIMIT 1", $session['token']);
    } while ($getCollisionTokenSQL->num_rows > 0);
    $session['ip'] = getIP();
    if (class_exists("SxGeo")) {
      if ($sxg->get($session['ip']) != false) {
        $session['geo'] = sprintf("%s, %s", $sxg->get($session['ip'])['city']['name_en'], $sxg->get($session['ip'])['country']['iso']);
      }
    }
    $session['ua'] = md5($_SERVER['HTTP_USER_AGENT']);
    $session['time'] = time();

    // Получение сессий, удаление старых сессий, дополнение их новой сессией
    $dbSessions = json_decode($dbUser['sessions']) ? json_decode($dbUser['sessions'], true) : [];
    foreach ($dbSessions as $key => $dbSession) {
      if ($dbSession['time'] < 2592000) unset($dbSessions[$key]); // Удаление сессий с последней активностью - месяц назад и более
    }
    $dbSessions[] = $session; // Дополняем список сессий новой сессией
    $sessions = json_encode(array_values($dbSessions), JSON_UNESCAPED_UNICODE); // Засовываем в переменную восстановленный массив (т.к. нумерация была сбита unset-ами), преобразованный в JSON-строку

    // Запись новой сессии в базу
    $db->safeQuery("UPDATE `users` SET `sessions` = ?, `seen` = ? WHERE `id` = ?", [$sessions, time(), $dbUser['id']]);
    if ($db->errno != 0) {
      $this->error = "Ошибка выполнения запроса к базе данных: $db->error";
      return false;
    }

    $this->uid = $dbUser['id'];

    setcookie("auth_token", $session['token'], ['expires' => time() + 2592000, 'path' => '/', 'httponly' => true]);

    return true;
  }
}

function getIP()
{
  $ip = '';
  $ipAll = []; // networks IP
  $ipSus = []; // suspected IP
  $serverVariables = [
    'HTTP_X_FORWARDED_FOR',
    'HTTP_X_FORWARDED',
    'HTTP_X_CLUSTER_CLIENT_IP',
    'HTTP_X_COMING_FROM',
    'HTTP_FORWARDED_FOR',
    'HTTP_FORWARDED',
    'HTTP_COMING_FROM',
    'HTTP_CLIENT_IP',
    'HTTP_FROM',
    'HTTP_VIA',
    'REMOTE_ADDR',
  ];
  foreach ($serverVariables as $serverVariable) {
    $value = '';
    if (isset($_SERVER[$serverVariable])) {
      $value = $_SERVER[$serverVariable];
    } elseif (getenv($serverVariable)) {
      $value = getenv($serverVariable);
    }
    if (!empty($value)) {
      $tmp = explode(',', $value);
      $ipSus[] = $tmp[0];
      $ipAll = array_merge($ipAll, $tmp);
    }
  }
  $ipSus = array_unique($ipSus);
  $ipAll = array_unique($ipAll);
  $ip = (sizeof($ipSus) > 0) ? $ipSus[0] : $ip;
  return $ip;
}

class User
{
  public $avatar = 'noAvatar.png', $count = [];
  public $id, $favorite, $topdrop, $inventory;

  function __construct($id)
  {
    $this->id = $id;
  }
  public function getAvatar(): void
  {
    if (is_file("$_SERVER[DOCUMENT_ROOT]/media/avatar/$this->id.webp")) $this->avatar = "$this->id.webp?" . uniqid();
    elseif (is_file("$_SERVER[DOCUMENT_ROOT]/media/avatar/$this->id.jpg")) $this->avatar = "$this->id.jpg?" . uniqid();
    elseif (is_file("$_SERVER[DOCUMENT_ROOT]/media/avatar/$this->id.png")) $this->avatar = "$this->id.png?" . uniqid();
  }
  private function arrayToWhere(array $array): string
  {
    return (count($array) === 1) ? "='" . current($array) . "'" : "IN(" . implode(', ', $array) . ")";
  }

  public function getSkins(array $params)
  {
    global $db;

    // HELPER
    /* ob_start();
    print_r($sql);
    file_put_contents('log.txt', "\n" . ob_get_clean(), FILE_APPEND); */
   

    // Пример параметров ['select' => ['name', 'title', 'rarity', 'cost'], 'from' => 'inventory', 'where' => ['user_id' => 'DESC']];
    $select = '*';
    $from = 'inventory';
    $inner_join = null;
    $where = null;
    $order_by = null;
    $offset = null;
    $limit = null;

    // FROM
    if (isset($params['from'])) $from = $params['from'];

    // SELECT
    if (isset($params['select']['skins'])) $select_arr[] = "`skins`.`" . implode("`,`skins`.`", $params['select']['skins']) . "`";
    if (isset($params['select'][$from]) && $from != 'skins') $select_arr[] = "`$from`.`" . implode("`,`$from`.`", $params['select'][$from]) . "`";
    if (isset($params['select']['sum'])) $select_arr[] = "SUM(`{$params['select']['sum']}`)";
    if (!empty($select_arr)) $select = implode(',', $select_arr);

    // INNER JOIN
    switch ($from) {
      case 'inventory':
        $inner_join = "INNER JOIN `inventory` ON `skins`.`id` = `inventory`.`item_id`";
        break;
      case 'cases':
        $inner_join = "INNER JOIN `cases` ON JSON_CONTAINS(`cases`.`skins`, CAST(`skins`.`id` AS JSON), '$')";
        break;
      case 'skins':
        break;
    }

    // WHERE
    if (isset($params['where'])) {
      $where = 'WHERE ';

      $where_arr = [];
      if (isset($params['where']['user_id'])) $where_arr[] = "`$from`.`user_id` = '{$params['where']['user_id']}'";
      if (isset($params['where']['id'])) $where_arr[] = "`$from`.`id`" . $this->arrayToWhere($params['where']['id']);
      if (isset($params['where']['skin_status']) && $from == 'inventory') $where_arr[] = "`inventory`.`status`" . $this->arrayToWhere($params['where']['skin_status']);
      if (isset($params['where']['sql'])) $where_arr[] = $params['where']['sql'];
      $where .= implode(' AND ', $where_arr);
    }
    // ORDER BY
    if (isset($params['order_by'])) {
      $order_by = 'ORDER BY';
      if (isset($params['order_by']['rarity'])) $order_by .= " CASE `skins`.`rarity` WHEN 'gold' THEN 1 WHEN 'arcane' THEN 2 WHEN 'legendary' THEN 3 WHEN 'epic' THEN 4 WHEN 'rare' THEN 5 WHEN 'uncommon' THEN 6 WHEN 'common' THEN 7 ELSE 8 END " . $params['order_by']['rarity'];
      if (isset($params['order_by']['cost'])) $order_by .= " `skins`.`cost` " . $params['order_by']['cost'];
      if (isset($params['order_by']['id'])) $order_by .= " `$from`.`id` " . $params['order_by']['id'];
      if (isset($params['order_by']['nearest']['cost'])) $order_by .= " ABS(`cost` - " . $params['order_by']['nearest']['cost'] . ")";
    }
    // LIMIT
    if (isset($params['limit'])) $limit = "LIMIT $params[limit]";
    // OFFSET
    if (isset($params['offset'])) $offset = "OFFSET $params[offset]";

    $sql = "SELECT $select FROM `skins` $inner_join $where $order_by $limit $offset";

    /* ob_start();
    print_r($sql);
    file_put_contents('log.txt', "\n" . ob_get_clean(), FILE_APPEND); */

    mysqli_real_escape_string($db, $sql);

    $result = $db->query($sql);

    // fetch
    if (isset($params['fetch'])) {
      switch ($params['fetch']) {
        case 'assoc':
          $result = $result->fetch_assoc();
          break;
        case 'column':
          $result = $result->fetch_column();
          break;
        case 'all':
        default:
          $result = $result->fetch_all(MYSQLI_ASSOC);
          break;
      }
    } else $result = $result->fetch_all(MYSQLI_ASSOC);

    return $result;
  }

  public function getHistory($offset = 0, $limit = 18)
  {
    if ($this->id) {
      global $db;
      $inventory = $db->safeQuery("SELECT
        i.`id`,
        i.`type`,
        i.`status`,
        i.`gotfrom`,
        i.`item_id`,
        i.`dropped_from_case`,
        c.`img` AS `case_img`,
        c.`title` AS `case_title`,
        s.`img`,
        s.`name`,
        s.`cost`,
        s.`title`,
        s.`rarity`,
        JSON_UNQUOTE(JSON_EXTRACT(w.`status`, '$.status')) AS withdrawal_status
      FROM
        `skins` s
        LEFT JOIN `inventory` i ON s.`id` = i.`item_id`
        LEFT JOIN `cases` c ON i.`dropped_from_case` = c.`title`
        LEFT JOIN `withdrawals` w ON JSON_CONTAINS(w.`skins_id`, CAST(i.`item_id` AS JSON), '$')
      WHERE i.`user_id` = ?
        AND `type` = 'skin'
      ORDER BY i.`id` DESC
      LIMIT ? OFFSET ?", [$this->id, $limit, $offset])->fetch_all(MYSQLI_ASSOC);
      $offset_next = $limit + $offset;
      $isMore = $db->safeQuery("SELECT '' FROM `inventory` WHERE `user_id` = ? LIMIT 1 OFFSET ?", [$this->id, $offset_next])->num_rows;

      return ['result' => $inventory, 'isMore' => $isMore];
    }
  }
  public function getInventory($offset = 0, $limit = 18)
  {
    if ($this->id) {
      global $db;
      $inventory = $db->safeQuery("SELECT
        i.`id`,
        i.`type`,
        i.`status`,
        i.`gotfrom`,
        i.`item_id`,
        i.`dropped_from_case`,
        c.`img` AS `case_img`,
        c.`title` AS `case_title`,
        s.`img`,
        s.`name`,
        s.`cost`,
        s.`title`,
        s.`rarity`,
        c_i.`img` AS `case_i_img`,
        c_i.`cost` AS `case_i_cost`,
        c_i.`name` AS `case_i_name`,
        c_i.`title` AS `case_i_title`,
        JSON_UNQUOTE(JSON_EXTRACT(w.`status`, '$.status')) AS withdrawal_status
      FROM
        `inventory` i
        LEFT JOIN `skins` s ON s.`id` = i.`item_id` AND i.`type` = 'skin'
        LEFT JOIN `cases` c ON i.`dropped_from_case` = c.`title` AND i.`type` = 'skin'
        LEFT JOIN `cases` c_i ON i.`item_id` = c_i.`id` AND i.`type` = 'case'
        LEFT JOIN `withdrawals` w ON JSON_CONTAINS(w.`skins_id`, CAST(i.`item_id` AS JSON), '$') AND i.`type` = 'skin'
      WHERE i.`user_id` = ?
        AND i.`status` = '1'
      ORDER BY i.`id` DESC
      LIMIT ? OFFSET ?", [$this->id, $limit, $offset])->fetch_all(MYSQLI_ASSOC);
      $offset_next = $limit + $offset + 1;
      $isMore = $db->safeQuery("SELECT '' FROM `inventory` WHERE `user_id` = ? AND `status` = '1' LIMIT 1 OFFSET ?", [$this->id, $offset_next])->num_rows;

      return ['result' => $inventory, 'isMore' => $isMore];
    }
  }

  public function getContracts($offset = 0, $limit = 6): array|bool
  {
    if ($this->id) {
      global $db;
      $contracts = $db->safeQuery("SELECT
        c.`id`,
        c.`result`,
        c.`skins`,
        s.`img` AS skin_win_img, 
        s.`title` AS skin_win_title,
        s.`name` AS skin_win_name,
        s.`cost` AS skin_win_cost,
        s.`rarity` AS skin_win_rarity
      FROM
        `contracts` c
        LEFT JOIN `inventory` i ON c.`skin_win` = i.`id`
        LEFT JOIN `skins` s ON i.`item_id` = s.`id`
      WHERE c.`user_id` = ?
      ORDER BY c.`id` DESC
      LIMIT ? OFFSET ?", [$this->id, $limit, $offset])->fetch_all(MYSQLI_ASSOC);

      if ($contracts) {
        $skins_ids = [];
        foreach ($contracts as &$contract) $skins_ids = array_merge($skins_ids, json_decode($contract['skins'], true));

        $skins = $this->getSkins(['select' => ['skins' => ['img', 'title', 'name', 'cost', 'rarity'], 'inventory' => ['id']], 'from' => 'inventory', 'where' => ['id' => $skins_ids, 'user_id' => $this->id]]);

        foreach ($contracts as &$contract) {
          $contract_skins = [];
          $skins_id = json_decode($contract['skins'], true);

          foreach ($skins as $skin) {
            if (in_array($skin['id'], $skins_id)) $contract_skins[] = $skin;
          }

          $contract['skins'] = $contract_skins;
        }
      }

      $isMore = $db->safeQuery("SELECT '' FROM `contracts` WHERE `user_id` = ? ORDER BY `id` DESC LIMIT 1 OFFSET ?", [$this->id, $limit + $offset])->num_rows;

      return ['result' => $contracts, 'isMore' => $isMore];
    }
  }

  public function getUpgrades($offset = 0, $limit = 9): array|bool
  {
    if ($this->id) {
      global $db;
      $upgrades = $db->safeQuery("SELECT
        u.`result`,
        s1.`img` AS first_item_img,
        s1.`title` AS first_item_title,
        s1.`name` AS first_item_name,
        s1.`cost` AS first_item_cost,
        s1.`rarity` AS first_item_rarity,
        s2.`img` AS second_item_img,
        s2.`title` AS second_item_title,
        s2.`name` AS second_item_name,
        s2.`cost` AS second_item_cost,
        s2.`rarity` AS second_item_rarity,
        u.`id`
      FROM
        `upgrades` u
        LEFT JOIN `inventory` i ON u.`first_item_id` = i.`id`
        LEFT JOIN `skins` s1 ON i.`item_id` = s1.`id`
        LEFT JOIN `skins` s2 ON u.`second_item_id` = s2.`id`
      WHERE u.`user_id` = ?
      ORDER BY u.`id` DESC
      LIMIT ? OFFSET ?", [$this->id, $limit, $offset])->fetch_all(MYSQLI_ASSOC);

      $isMore = $db->safeQuery("SELECT '' FROM `upgrades` WHERE `user_id` = ? ORDER BY `id` DESC LIMIT 1 OFFSET ?", [$this->id, $limit + $offset])->num_rows;

      return ['result' => $upgrades, 'isMore' => $isMore];
    }
  }

  public function getWithdrawals($offset = 0, $limit = 10): array|bool
  {
    if ($this->id) {
      global $db;
      $withdrawals = $db->safeQuery("SELECT
        `withdrawal_time`,
        `add_time`,
        `pattern`,
        `status`,
        `desc`,
        `sum`
      FROM `withdrawals`
      WHERE `user_id` = ?
      ORDER BY `id` DESC
      LIMIT ? OFFSET ?", [$this->id, $limit, $offset])->fetch_all(MYSQLI_ASSOC);

      $isMore = $db->safeQuery("SELECT '' FROM `withdrawals` WHERE `user_id` = ? ORDER BY `id` DESC LIMIT 1 OFFSET ?", [$this->id, $limit + $offset])->num_rows;

      return ['result' => $withdrawals, 'isMore' => $isMore];
    }
  }

  public function count(): void
  {
    global $db;
    $this->count = $db->safeQuery("SELECT COUNT(*) AS `history`,
      (SELECT COUNT(*) FROM `upgrades` WHERE `user_id` = ?) AS `upgrades`,
      (SELECT COUNT(*) FROM `contracts` WHERE `user_id` = ?) AS `contracts`,
      (SELECT COUNT(*) FROM `withdrawals` WHERE `user_id` = ?) AS `withdrawals`,
      (SELECT COUNT(*) FROM `inventory` WHERE `user_id` = ? AND `status` = '1') AS `inventory`
      FROM `inventory` WHERE `user_id` = ?", [$this->id, $this->id, $this->id, $this->id, $this->id])->fetch_assoc();
  }
  public function secondaryUserData()
  {
    global $db;
    $this->favorite = $db->safeQuery("SELECT c.`img`, c.`name` FROM `cases` c INNER JOIN `inventory` i ON c.`title` = i.`dropped_from_case` WHERE i.`user_id` = ? GROUP BY c.`img`, c.`title`, c.`name` ORDER BY COUNT(*) DESC LIMIT 1", $this->id)->fetch_assoc();
    $this->topdrop = $db->safeQuery("SELECT s.`img`, s.`name`, s.`title`, s.`rarity`, s.`cost` FROM `inventory` i INNER JOIN `skins` s ON s.`id` = i.`item_id` WHERE i.`user_id` = ? ORDER BY s.`cost` DESC LIMIT 1", $this->id)->fetch_assoc();
    if ($this->topdrop) $this->topdrop['cost'] = round($this->topdrop['cost'], 2);
  }
}


class Upgrade
{
  public $error = false;
  public $result;

  public function upgrade($skin_cost, $upgrade_cost, $coefficient): void
  {
    if ($coefficient) {
      if ($skin_cost < $upgrade_cost) {
        $rand = rand(1, 10000) / 100;
        $chance = round((($skin_cost / $upgrade_cost) * 100) * $coefficient, 2);
        $this->result = ($rand <= $chance) ? 1 : 0;
      } else $this->error = 'Стоимость скина меньше стоимости скина для апгрейда';
    } else $this->error = 'Ошибка коэффициента';
  }
}
class Contracts
{
  public $error = false;
  public $result_cost, $result;

  public function contract(array $skins_cost, float $coefficient): void
  {
    if ($coefficient) {
      $skins_sum = array_sum(array_column($skins_cost, 'cost'));

      $min = round(($skins_sum / 2) * 100);
      $max = round(($skins_sum * 1.75) * $coefficient * 100);

      $this->result_cost = rand($min, $max) / 100;
      $this->result = ($this->result_cost > $skins_sum) ? 1 : 0;
    } else $this->error = 'Ошибка коэффициента';
  }
}

class Pay
{
  function pay(int $order_id): bool
  {
    global $db, $config;
    $order = $db->safeQuery("SELECT `user_id`, `sum`, `promo` FROM `payments` WHERE `id` = ? AND `status` = '0'", $order_id)->fetch_assoc();
    if ($order) {
      $orderSum = $order['sum'];
      // Если указано промокод - работаем с ним
      if ($order['promo'] != null) {
        $promoData = $db->safeQuery("SELECT
          p.`id`, 
          p.`activations`, 
          p.`expiration`, 
          p.`bonus`, 
          p.`type`
        FROM `promo` p
          LEFT JOIN `promo_users` u ON p.`id` = u.`promo_id` AND u.`user_id` = ?
        WHERE p.`promo` = ?
          AND p.`type` = 'percent'
          AND (p.`expiration` IS NULL OR p.`expiration` < ?)
          AND (p.`activations` IS NULL OR p.`activations` > 0)
          AND u.`id` IS NULL
        LIMIT 1", [$order['user_id'], $order['promo'], date('Y-m-d')])->fetch_assoc();
        // Если код существует и он активен
        if ($promoData) {
          if (!empty($promoData['activations'])) $db->safeQuery("UPDATE `promo` SET `activations` = `activations` - 1 WHERE `id` = ?", $promoData['id']);
          switch ($promoData['type']) {
            case 0: // 0 - Бонус к пополнению в %: 100₽ + 60% = 160₽
              $orderSum *= $promoData['bonus'] / 100 + 1;
              break;
            case 1: // 1 - Бонус к пополнению в ₽: 100₽ + 100₽ = 200₽
              $orderSum += $promoData['bonus'];
              break;
            case 2: // 2 - Бонус к пополнению множитель: 100₽ + 3x = 300₽
              $orderSum *= $promoData['bonus'];
              break;
            case 3: // 3 - Бесплатный скин от 1000₽
              $rand_skin_id = $db->query("SELECT `id` FROM `skins` WHERE `cost` > '1000' AND `cost` < '1500' ORDER BY RAND() LIMIT 1")->fetch_column();
              $db->safeQuery("INSERT INTO `inventory`(`user_id`, `gotfrom`, `type`, `item_id`, `status`, `time`) VALUES(?,'bonus','skin', ?, '1', ?)", [$order['user_id'], $rand_skin_id, time()]);
              break;
            case 4: // 4 - Бесплатные скины до 100₽
              for ($i = 0; $i < $promoData['bonus']; $i++) {
                $rand_skin_id = $db->query("SELECT `id` FROM `skins` WHERE `cost` < '100' ORDER BY RAND() LIMIT 1")->fetch_column();
                $db->safeQuery("INSERT INTO `inventory`(`user_id`, `gotfrom`, `type`, `item_id`, `status`, `time`) VALUES(?, 'bonus', 'skin', ?, '1', ?)", [$order['user_id'], $rand_skin_id, time()]);
              }
              break;
          }
        }
      } else { // Если промокод не указан и у пользователя есть invited_by, начисляем инвайт-бонус
        $orderReferral = $db->safeQuery("SELECT `invited_by` FROM `users` WHERE `id` = ?", $order['user_id'])->fetch_column();

        if ($orderReferral != null) {
          $db->safeQuery("UPDATE `users` SET `balance` = `balance` + ? WHERE `id` = ?", [$order['sum'] * $config['referral_promo_bonus'], $orderReferral]);
          $orderSum *= (1 + $config['invited_bonus']);
        }
      }

      $db->safeQuery("UPDATE `users` SET `balance` = `balance` + ?, `replenished` = `replenished` + ? WHERE `id` = ?", [$orderSum, $orderSum, $order['user_id']]);

      $db->safeQuery("UPDATE `payments` SET `status` = '1' WHERE `id` = ?", $order_id);

      return true;
    }
    return false;
  }
}


class CurrentUser extends User
{
  public $authorized = false, $ip = null, $geo = null;
  public $id, $email, $name, $balance, $balance_str, $replenished, $coefficient, $refCode, $invitedBy, $sessions, $casesLastOpen, $regTime, $inventory;

  function __construct()
  {
    $this->ip = getIP();
    if (class_exists("SxGeo")) {
      $sxg = new SxGeo;
      if ($sxg->get($this->ip) != false) {
        $this->geo = sprintf("%s, %s", $sxg->get($this->ip)['city']['name_en'], $sxg->get($this->ip)['country']['iso']);
      }
    }
    if ($this->authorized = $this->checkAuth()) {
      $this->getAvatar();
    }
  }

  function checkAuth()
  {
    if (!isset($_COOKIE['auth_token'])) return false;
    global $db;
    $dbUser = $db->safeQuery("SELECT * FROM `users` WHERE JSON_CONTAINS(`sessions`, JSON_OBJECT('token', ?)) LIMIT 1", $_COOKIE['auth_token'])->fetch_assoc();
    if ($dbUser) {
      $dbSessions = json_decode($dbUser['sessions'], true);
      foreach ($dbSessions as $session) {
        if ($session['ua'] == md5($_SERVER['HTTP_USER_AGENT'])) {
          $this->id = $dbUser['id'];
          $this->email = $dbUser['email'];
          $this->name = $dbUser['name'];
          $this->balance = $dbUser['balance'];
          $this->balance_str = number_format($dbUser['balance'], 2, '.', ' ');
          $this->replenished = $dbUser['replenished'];
          $this->coefficient = $dbUser['coefficient'];
          $this->refCode = $dbUser['referral_code'];
          $this->invitedBy = $dbUser['invited_by'];
          $this->sessions = $dbUser['sessions'];
          $this->casesLastOpen = (!empty($dbUser['cases_last_open'])) ? json_decode($dbUser['cases_last_open'], true) : [];
          $this->regTime = $dbUser['reg_time'];
          setcookie("auth_token", $_COOKIE['auth_token'], ['expires' => time() + 2592000, 'path' => '/', 'httponly' => true, 'samesite' => 'Strict']);
          return true;
        }
      }
    }
    setcookie('auth_token', '', time() - 1, '/');
    return false;
  }

  function renewBalance()
  {
    if ($this->authorized) {
      global $db;
      $balanceQuery = $db->safeQuery("SELECT `balance` FROM `users` WHERE `id` = ?", $this->id);
      if ($balanceQuery->num_rows > 0) {
        $this->balance = $balanceQuery->fetch_column();
        $this->balance_str = number_format($this->balance, 2, '.', ' ');
        return true;
      }
    }
    return false;
  }

  function updateOnline()
  {
    global $db;
    if ($this->authorized) {
      $sessions = json_decode($this->sessions, true);
      for ($x = 0; $x < count($sessions); $x++)
        if ($sessions[$x]['token'] == $_COOKIE['auth_token'])
          $sessions[$x]['time'] = time();
      $this->sessions = json_encode($sessions);
      $db->safeQuery("UPDATE `users` SET `seen` = ?, `sessions` = ? WHERE `id` = ?", [time(), $this->sessions, $this->id]);
      return ($db->errno == 0) ? true : $db->errno;
    }
    return false;
  }

  function getSumOfPaymentsInLastDays($dayCount = 7, $successed = true)
  {
    if ($this->authorized) {
      global $db;
      return floatval($db->safeQuery($successed ? "SELECT SUM(`sum`) FROM `payments` WHERE `user_id` = ? AND `time_creation` > ? AND `status` = '1'" : "SELECT SUM(`sum`) FROM `payments` WHERE `user_id` = ? AND `time_creation` > ?", [$this->id, time() - $dayCount * 86400])->fetch_column());
    }
    return false;
  }

  // Функция проверки, может ли пользователь открыть бесплатный кейс (если включен контроль того, что кейсы открываются при донатах)
  function canOpenFreeCase($caseName = null)
  {
    if ($caseName == null && $this->authorized == false) return false;

    global $config, $db;
    // Узнаём, включен ли контроль открытия кейсов, и если отключен - разрешаем открывать кейсы
    if (!isset($config['control_free_cases']) || $config['control_free_cases'] == false) return true;
    // Берём переменные из $config или объявляем, если переменных нет
    $paymentsToOpenFreeCases = isset($config['payments_to_open_free_cases']) ? $config['payments_to_open_free_cases'] : 20;
    $daysToOpenFreeCases = isset($config['days_to_open_free_cases']) ? $config['days_to_open_free_cases'] : 7;
    $allowOpenFirstFreeCaseIfNotPay = isset($config['allow_open_first_free_case_if_not_pay']) ? $config['allow_open_first_free_case_if_not_pay'] : true;
    // Узнаём, открывал ли пользователь этот кейс хоть раз
    $userAlredyOpenThisCase = array_key_exists($caseName, $this->casesLastOpen);
    // Если разрешаем открывать первый кейс бесплатно и пользователь не открывал такой кейс, отдаём true
    if ($allowOpenFirstFreeCaseIfNotPay && !$userAlredyOpenThisCase) return true;
    // Получаем сумму того, сколько пользователь надонатил за последние N дней
    $sumOfPayments = $this->getSumOfPaymentsInLastDays($daysToOpenFreeCases);
    // Если пользователь надонатил больше, чем нужно, то разрешаем открывать кейс
    return ($sumOfPayments >= $paymentsToOpenFreeCases) ? true : $paymentsToOpenFreeCases - $sumOfPayments;
  }
  // Функция проверки, может ли пользователь получить приз
  function canGetPrize()
  {
    global $config, $db;
    if (!$this->authorized) return false;
    // Если контроль призов отключен - разрешаем
    if (!isset($config['control_prizes']) || $config['control_prizes'] == false) return true;
    // Получаем количество уже полученных призов, и если разрешено получать первый приз без доната и пользователь не получал призы - даём добро
    $gotTimeOfLastPrize = $db->safeQuery("SELECT `time` FROM `prizes` WHERE `user_id` = ?", $this->id)->fetch_column();
    if ($config['allow_get_first_prize_if_not_pay'] && $gotTimeOfLastPrize == 0) return true;
    // Если пользователь уже получал призы, или если не разрешено получать первый приз бесплатно - проверяем, надонатил ли он на первый приз
    $paymentsToGetPrize = isset($config['payments_to_get_prizes']) ? $config['payments_to_get_prizes'] : 20;
    $daysToGetPrize = isset($config['days_to_get_prizes']) ? $config['days_to_get_prizes'] : 7;
    $sumOfPayments = $this->getSumOfPaymentsInLastDays($daysToGetPrize);

    return ($sumOfPayments >= $paymentsToGetPrize) ? true : $paymentsToGetPrize - $sumOfPayments;
  }

  public $prize_max_lvl, $prize_min_lvl, $prize_xp_next_lvl, $prize_time_get_prize, $prize_xp_increase_per_lvl;
  public $prize_lvl, $prize_day, $prize_xp, $prize_time, $prize_status, $prize_xp_lvl, $prize_percent_lvl, $prize_next_day, $prize_sum, $prize_seconds_get_prize, $prize_current_time, $prize_class_day, $prize_percent_next_day;

  public function getLvlPrize($prize_xp): bool
  {
    if ($this->authorized) {
      $prize_lvl = $this->prize_min_lvl;
      while ($prize_xp >= $this->prize_xp_next_lvl) {
        $prize_xp -= $this->prize_xp_next_lvl;
        $this->prize_xp_next_lvl = round($this->prize_xp_next_lvl * $this->prize_xp_increase_per_lvl, -1);
        $prize_lvl++;
      }
      $this->prize_lvl = ($this->prize_lvl > $this->prize_max_lvl) ? $this->prize_max_lvl : $prize_lvl;
      $this->prize_xp_lvl = round($prize_xp);
      return true;
    }
    return false;
  }
  public function getInfoPrize(): bool
  {
    if ($this->authorized) {
      global $db;
      $prize = $db->safeQuery("SELECT `day`, `xp`, `time` FROM `prizes` WHERE `user_id` = ?", $this->id)->fetch_assoc();

      if (!$prize) {
        $prize = ['day' => 1, 'xp' => 0, 'time' => time()];
        $db->safeQuery("INSERT INTO `prizes`(`user_id`, `day`, `xp`, `time`) VALUES (?,?,?,?)", [$this->id, $prize['day'], $prize['xp'], $prize['time']]);
      }
      global $prizeConfig;
      $this->prize_max_lvl = $prizeConfig['max_lvl'];
      $this->prize_min_lvl = $prizeConfig['min_lvl'];
      $this->prize_xp_next_lvl = $prizeConfig['xp_next_lvl'];
      $this->prize_time_get_prize = $prizeConfig['time_get_prize'];
      $this->prize_xp_increase_per_lvl = $prizeConfig['xp_increase_per_lvl'];
      $this->prize_current_time = time();

      $this->prize_xp = $prize['xp'];
      $this->prize_day = $prize['day'];
      $this->prize_time = $prize['time'];
      $this->getLvlPrize($this->prize_xp);

      $this->prize_seconds_get_prize = - ($this->prize_current_time - $this->prize_time - $this->prize_time_get_prize);
      $this->prize_status = ($this->prize_seconds_get_prize <= 0) ? 1 : 0;
      $this->prize_percent_lvl = $this->prize_xp_lvl / $this->prize_xp_next_lvl * 100;
      $this->prize_next_day = ($this->prize_day < 10) ? $this->prize_day + 1 : 1;
      $this->prize_sum = ($this->prize_day >= 10) ? $this->prize_lvl * 10 : $this->prize_lvl;

      $this->prize_class_day = array_fill(0, $this->prize_day - 1, 'active') + array_fill($this->prize_day - 1, 1, 'current_day') + array_fill($this->prize_day, 9, '');
      $this->prize_percent_next_day = round(($this->prize_time_get_prize - $this->prize_seconds_get_prize) / $this->prize_time_get_prize * 100, 2);
      if ($this->prize_percent_next_day > 100) $this->prize_percent_next_day = 100;
      return true;
    }
    return false;
  }
  public function takePrize(): bool
  {
    if ($this->getInfoPrize()) {
      if ($this->prize_status) {
        global $db, $prizeConfig;
        $rows = $db->safeQuery("UPDATE `prizes` SET `time` = ?, `day` = ? WHERE `user_id` = ? AND `time` < ?", [$this->prize_current_time, $this->prize_next_day, $this->id, time() - $prizeConfig['time_get_prize']]);
        if ($rows < 1) return false;
        $rows = $db->safeQuery("UPDATE `users` SET `balance` = `balance` + ? WHERE `id` = ?", [$this->prize_sum, $this->id]);
        if ($rows < 1) return false;
        return true;
      }
    }
    return false;
  }
  public function prizeAddXp($xp = 0): bool
  {
    if ($this->authorized) {
      if (intval($xp) > 0) {
        global $db;
        $db->safeQuery("UPDATE `prizes` SET `xp` = `xp` + ? WHERE `user_id` = ?", [$xp, $this->id]);
        return true;
      }
    }
    return false;
  }

  public function setAvatar($avatar)
  {
    if ($avatar['type'] == 'image/jpeg' || $avatar['type'] == 'image/png') {
      if ($avatar['size'] <= 5000000) {
        $tempFile = $avatar['tmp_name'];
        $image = imagecreatefromstring(file_get_contents($tempFile));

        $outputFileWebp = "$_SERVER[DOCUMENT_ROOT]/media/avatar/$this->id.webp";
        $outputFileJPG = "$_SERVER[DOCUMENT_ROOT]/media/avatar/$this->id.jpg";
        if (function_exists('imagewebp')) {
          if (is_file($outputFileJPG)) unlink($outputFileJPG);
          imagepalettetotruecolor($image);
          imagewebp($image, $outputFileWebp, 80);
        } else {
          if (is_file($outputFileWebp)) unlink($outputFileWebp);
          imagejpeg($image, $outputFileJPG, 80);
        }

        imagedestroy($image);
        return true;
      }
    }
  }


  function logout()
  {
    if ($this->authorized) {
      global $db;

      $sessions = $db->safeQuery("SELECT `sessions` FROM `users` WHERE `id` = ?", $this->id)->fetch_column();
      $sessions = json_decode($sessions, true);
      $token = $_COOKIE['auth_token'];
      $sessions = array_filter($sessions, function ($element) use ($token) {
        return $element['token'] !== $token;
      });

      $db->safeQuery("UPDATE `users` SET `sessions` = ? WHERE `id` = ?", [json_encode($sessions), $this->id]);
      setcookie('auth_token', '', time() - 1, '/');
      return true;
    }
    return false;
  }
}


class OtherUser extends User
{
  public $id, $name, $refCode, $reg_time, $isset;

  function __construct($id)
  {
    $this->id = $id;
    $this->isset = $this->userData();
    $this->getAvatar();
  }

  function userData()
  {
    global $db;
    $db_user = $db->safeQuery("SELECT `id`, `name`, `referral_code`, `reg_time` FROM `users` WHERE `id` = ?", $this->id)->fetch_assoc();
    if ($db_user) {
      $this->id = $db_user['id'];
      $this->name = $db_user['name'];
      $this->refCode = $db_user['referral_code'];
      $this->reg_time = $db_user['reg_time'];
      return true;
    }
    return false;
  }
}

class Cases
{
  function getOne($caseName)
  {
    if (empty($caseName)) return false;
    global $db;
    $case = $db->safeQuery("SELECT * FROM `cases` WHERE `title` = ? LIMIT 1", $caseName)->fetch_assoc();
    if (!$case) return false;

    return ['case' => $case, 'skins' => $db->safeQuery("SELECT s.* 
    FROM `cases` c
    JOIN `skins` s ON JSON_CONTAINS(c.skins, CAST(s.`id` AS JSON), '$') 
    WHERE c.`title` = ? 
    ORDER BY 
    CASE s.`rarity`
      WHEN 'gold' THEN 1
      WHEN 'arcane' THEN 2
      WHEN 'legendary' THEN 3
      WHEN 'epic' THEN 4
      WHEN 'rare' THEN 5
      WHEN 'uncommon' THEN 6
      WHEN 'common' THEN 7
      ELSE 8
    END, 
    s.`cost` DESC", $caseName)->fetch_all(MYSQLI_ASSOC)];
  }
  function getAll($categoryPriority = '')
  {
    global $db;
    if (!is_array($categoryPriority)) $categoryPriority = [];
    return empty($categoryPriority) ? $db->safeQuery("SELECT * FROM `cases` WHERE 1")->fetch_all(MYSQLI_ASSOC) : $db->safeQuery("SELECT * FROM `cases` WHERE 1 ORDER BY field(`category`, " . implode(', ', str_split(str_repeat('?', count($categoryPriority)))) . ") DESC", $categoryPriority)->fetch_all(MYSQLI_ASSOC);
  }
  function getAllSplittedByCategories($categoryPriority = '')
  {
    $cases = $this->getAll($categoryPriority);
    $result = [];
    foreach ($cases as $case) {
      if (!isset($result[$case['category']])) $result[$case['category']] = [];
      $result[$case['category']][] = $case;
    }
    return $result;
  }
}


class Page
{
  public $header, $main, $footer;
  public $path, $uri, $action, $subaction;

  public function validatePath(string $path): bool
  {
    $path = parse_url($path, PHP_URL_PATH);
    if (empty($path) || substr($path, 0, 1) !== '/' || preg_match('/[^a-zA-Z0-9\/\_]/', $path)) return false;
    return true;
  }
  public function splitURI(string $uri): array
  {
    $path = parse_url($uri, PHP_URL_PATH);
    $uri = explode('/', trim($path));

    if (!isset($uri[1])) $uri[1] = null;
    if (!isset($uri[2])) $uri[2] = null;

    return $uri;
  }
  public function renewURI(string $uri): void
  {
    global $pageConfig;

    $path = parse_url($uri, PHP_URL_PATH);
    $uri = $this->splitURI($path);

    if ($this->validatePath($path) && isset($pageConfig['public'][$uri[1]]) && is_file($main = "$_SERVER[DOCUMENT_ROOT]/includes/modules/{$pageConfig['public'][$uri[1]]}")) {
      $this->main = $main;
      $this->action = $uri[1];
      $this->subaction = $uri[2];
    } else {
      $this->main = "$_SERVER[DOCUMENT_ROOT]/includes/modules/{$pageConfig['private']['error']}";
      $this->action = 'error';
      $this->subaction = '404';
    }
    $this->uri = $uri;
    $this->path = $path;
  }
  public function getPage(): void
  {
    $this->renewURI($_SERVER['REQUEST_URI']);
    $this->header = "$_SERVER[DOCUMENT_ROOT]/includes/header.php";
    $this->footer = "$_SERVER[DOCUMENT_ROOT]/includes/footer.php";
  }
}
