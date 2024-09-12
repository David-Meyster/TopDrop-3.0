<?php
define('TopDrop', true);

include_once("$_SERVER[DOCUMENT_ROOT]/core/init.php");
include_once("$_SERVER[DOCUMENT_ROOT]/includes/page.php");
/* 
if (!isset($_GET['admin_debug'])) die('<div style="margin-top: 50px; text-align: center; font-size: 14pt; font-family: Segoe UI;">Сладенькие, у нас тут обновление накатывается 😳<br>Подождите немножко 🙂<br>Любим 💖<br>А пока что вот вам няшные котятки 😽<br><iframe width="560" height="315" src="https://www.youtube.com/embed/y0sF5xhGreA?si=t-Muz22kwn4CI-fD" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="margin-top: 20px"></iframe></div>');
$params = [
  [
    'img' => 'ice.png',
    'title' => 'ice',
    'name' => 'Лёд',
    'cost' => 9,
    'category' => 'Новогодние кейсы',
    'skins_limit' => 30
  ],
  [
    'img' => 'christmas_tree.png',
    'title' => 'christmas_tree',
    'name' => 'Новогодняя Ёлка',
    'cost' => 19,
    'category' => 'Новогодние кейсы',
    'skins_limit' => 30
  ],
  [
    'img' => 'holidays.png',
    'title' => 'holidays',
    'name' => 'Каникулы',
    'cost' => 29,
    'category' => 'Новогодние кейсы',
    'skins_limit' => 30
  ],
  [
    'img' => 'old_year.png',
    'title' => 'old_year',
    'name' => 'Старый Год',
    'cost' => 49,
    'category' => 'Новогодние кейсы',
    'skins_limit' => 30
  ],
  [
    'img' => 'new_year.png',
    'title' => 'new_year',
    'name' => 'Новый Год',
    'cost' => 99,
    'category' => 'Новогодние кейсы',
    'skins_limit' => 30
  ],


  [
    'img' => 'free_vk.png',
    'title' => 'free_vk',
    'name' => 'За подписку на ВК',
    'cost' => 0,
    'category' => 'Бесплатные кейсы',
    'skins_limit' => 30,
    'time' => 86400
  ],

  [
    'img' => 'free_youtube.png',
    'title' => 'free_youtube',
    'name' => 'За подписку на YT',
    'cost' => 0,
    'category' => 'Бесплатные кейсы',
    'skins_limit' => 30,
    'time' => 86400
  ],

  [
    'img' => 'free_telegram.png',
    'title' => 'free_telegram',
    'name' => 'За подписку на ТГ',
    'cost' => 0,
    'category' => 'Бесплатные кейсы',
    'skins_limit' => 30,
    'time' => 86400
  ],

  [
    'img' => 'free_12.png',
    'title' => 'free_12',
    'name' => '12 Часов',
    'cost' => 0,
    'category' => 'Бесплатные кейсы',
    'skins_limit' => 30,
    'time' => 43200
  ],

  [
    'img' => 'free_23.png',
    'title' => 'free_23',
    'name' => '23 Часа',
    'cost' => 0,
    'category' => 'Бесплатные кейсы',
    'skins_limit' => 30,
    'time' => 82800
  ],


  [
    'img' => 'neurogift.png',
    'title' => 'neurogift',
    'name' => 'Нейроподарок',
    'cost' => 9,
    'category' => 'Кейсы от нейросети',
    'skins_limit' => 30
  ],
  [
    'img' => 'neuropocalypse.png',
    'title' => 'neuropocalypse',
    'name' => 'Нейропокалипсис',
    'cost' => 9,
    'category' => 'Кейсы от нейросети',
    'skins_limit' => 30
  ],
  [
    'img' => 'neurocrystal.png',
    'title' => 'neurocrystal',
    'name' => 'Нейрокристалл',
    'cost' => 9,
    'category' => 'Кейсы от нейросети',
    'skins_limit' => 30
  ],
  [
    'img' => 'permafrost.png',
    'title' => 'permafrost',
    'name' => 'Мерзлота',
    'cost' => 9,
    'category' => 'Кейсы от нейросети',
    'skins_limit' => 30
  ],
  [
    'img' => 'killer.png',
    'title' => 'killer',
    'name' => 'Убийца',
    'cost' => 9,
    'category' => 'Кейсы от нейросети',
    'skins_limit' => 30
  ],


  [
    'img' => 'crystal.png',
    'title' => 'crystal',
    'name' => 'Кристалл',
    'cost' => 99,
    'category' => 'Новые кейсы',
    'skins_limit' => 30
  ],
  [
    'img' => 'ice_cream.png',
    'title' => 'ice_cream',
    'name' => 'Мороженка',
    'cost' => 139,
    'category' => 'Новые кейсы',
    'skins_limit' => 30
  ],
  [
    'img' => 'cybersport.png',
    'title' => 'cybersport',
    'name' => 'Нейроподарок',
    'cost' => 199,
    'category' => 'Новые кейсы',
    'skins_limit' => 30
  ],
  [
    'img' => 'province.png',
    'title' => 'province',
    'name' => 'Провинция',
    'cost' => 259,
    'category' => 'Новые кейсы',
    'skins_limit' => 30
  ],
  [
    'img' => 'capital.png',
    'title' => 'capital',
    'name' => 'Столица',
    'cost' => 299,
    'category' => 'Новые кейсы',
    'skins_limit' => 30
  ],


  [
    'img' => 'rare.webp',
    'title' => 'rare',
    'name' => 'Редкий',
    'cost' => 19,
    'category' => 'Редкие кейсы',
    'skins_limit' => 60
  ],
  [
    'img' => 'epic.png',
    'title' => 'epic',
    'name' => 'Эпический',
    'cost' => 29,
    'category' => 'Редкие кейсы',
    'skins_limit' => 60
  ],
  [
    'img' => 'legendary.png',
    'title' => 'legendary',
    'name' => 'Легендарный',
    'cost' => 99,
    'category' => 'Редкие кейсы',
    'skins_limit' => 60
  ],
  [
    'img' => 'arcane.png',
    'title' => 'arcane',
    'name' => 'Тайный',
    'cost' => 329,
    'category' => 'Редкие кейсы',
    'skins_limit' => 60
  ],
  [
    'img' => 'knife.png',
    'title' => 'knife',
    'name' => 'Ножевой',
    'cost' => 999,
    'category' => 'Редкие кейсы',
    'skins_limit' => 60
  ],
  [
    'img' => 'gloves.png',
    'title' => 'gloves',
    'name' => 'Перчаточный',
    'cost' => 999,
    'category' => 'Редкие кейсы',
    'skins_limit' => 60
  ],


  [
    'img' => 'schoolboy.webp',
    'title' => 'schoolboy',
    'name' => 'Школьник',
    'cost' => 9,
    'category' => 'Наши сборки',
    'skins_limit' => 30
  ],
  [
    'img' => 'anime.webp',
    'title' => 'anime',
    'name' => 'Аниме',
    'cost' => 19,
    'category' => 'Наши сборки',
    'skins_limit' => 30
  ],
  [
    'img' => 'pc.png',
    'title' => 'pc',
    'name' => 'Игровой ПК',
    'cost' => 29,
    'category' => 'Наши сборки',
    'skins_limit' => 30
  ],
  [
    'img' => 'jungle.png',
    'title' => 'jungle',
    'name' => 'Джунгли',
    'cost' => 49,
    'category' => 'Наши сборки',
    'skins_limit' => 30
  ],
  [
    'img' => 'death.webp',
    'title' => 'death',
    'name' => 'Смерть',
    'cost' => 59,
    'category' => 'Наши сборки',
    'skins_limit' => 30
  ],
  [
    'img' => 'summer.webp',
    'title' => 'summer',
    'name' => 'Лето',
    'cost' => 69,
    'category' => 'Наши сборки',
    'skins_limit' => 30
  ],
  [
    'img' => 'winter.webp',
    'title' => 'winter',
    'name' => 'Зима',
    'cost' => 79,
    'category' => 'Наши сборки',
    'skins_limit' => 30
  ],
  [
    'img' => 'golden_tree.png',
    'title' => 'golden_tree',
    'name' => 'Золотое дерево',
    'cost' => 199,
    'category' => 'Наши сборки',
    'skins_limit' => 30
  ],
  [
    'img' => 'easy_knife.png',
    'title' => 'easy_knife',
    'name' => 'Изи нож',
    'cost' => 749,
    'category' => 'Наши сборки',
    'skins_limit' => 30
  ],


  [
    'img' => 'revenge.png',
    'title' => 'revenge',
    'name' => 'Revenge Case',
    'cost' => 39,
    'category' => 'Коллекции',
    'skins_limit' => 30
  ],
  [
    'img' => 'sharp.webp',
    'title' => 'sharp',
    'name' => 'Sharp Case',
    'cost' => 39,
    'category' => 'Коллекции',
    'skins_limit' => 30
  ],
  [
    'img' => 'empire.webp',
    'title' => 'empire',
    'name' => 'Empire Case',
    'cost' => 39,
    'category' => 'Коллекции',
    'skins_limit' => 30
  ],
  [
    'img' => 'revival.webp',
    'title' => 'revival',
    'name' => 'Revival Case',
    'cost' => 39,
    'category' => 'Коллекции',
    'skins_limit' => 30
  ],
  [
    'img' => 'project_z9.webp',
    'title' => 'project_z9',
    'name' => 'Project Z9 Case',
    'cost' => 39,
    'category' => 'Коллекции',
    'skins_limit' => 30
  ],
  [
    'img' => 'scorpion.webp',
    'title' => 'scorpion',
    'name' => 'Scorpion Case',
    'cost' => 59,
    'category' => 'Коллекции',
    'skins_limit' => 30
  ],
  [
    'img' => 'origin.webp',
    'title' => 'origin',
    'name' => 'Origin Case',
    'cost' => 399,
    'category' => 'Коллекции',
    'skins_limit' => 30
  ],
  [
    'img' => 'furios.webp',
    'title' => 'furios',
    'name' => 'Furios Case',
    'cost' => 159,
    'category' => 'Коллекции',
    'skins_limit' => 30
  ],
  [
    'img' => 'rival.webp',
    'title' => 'rival',
    'name' => 'Rival Case',
    'cost' => 109,
    'category' => 'Коллекции',
    'skins_limit' => 30
  ],
  [
    'img' => 'fable.webp',
    'title' => 'fable',
    'name' => 'Fable Case',
    'cost' => 39,
    'category' => 'Коллекции',
    'skins_limit' => 30
  ],
];
 
foreach ($params as $item) {
  $cost_fill = ($item['cost'] == 0) ? 1 : $item['cost'];

  $min = $cost_fill / 2;
  $max = $cost_fill * 5;
  switch ($item['title']) {
    case 'rare':
      $skins1 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$cost_fill' AND `cost` < '$max' AND `rarity` = 'rare'")->fetch_all(MYSQLI_ASSOC);
      $skins2 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$min' AND `cost` < '$cost_fill' AND `rarity` = 'rare'")->fetch_all(MYSQLI_ASSOC);
      break;
    case 'epic':
      $skins1 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$cost_fill' AND `cost` < '$max' AND `rarity` = 'epic'")->fetch_all(MYSQLI_ASSOC);
      $skins2 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$min' AND `cost` < '$cost_fill' AND `rarity` = 'epic'")->fetch_all(MYSQLI_ASSOC);
      break;
    case 'legendary':
      $skins1 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$cost_fill' AND `cost` < '$max' AND `rarity` = 'legendary'")->fetch_all(MYSQLI_ASSOC);
      $skins2 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$min' AND `cost` < '$cost_fill' AND `rarity` = 'legendary'")->fetch_all(MYSQLI_ASSOC);
      break;
    case 'arcane':
      $skins1 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$cost_fill' AND `cost` < '$max' AND `rarity` = 'arcane'")->fetch_all(MYSQLI_ASSOC);
      $skins2 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$min' AND `cost` < '$cost_fill' AND `rarity` = 'arcane'")->fetch_all(MYSQLI_ASSOC);
      break;
    case 'knife':
      $skins1 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$cost_fill' AND `cost` < '$max' AND `title` IN ('jKommando', 'Karambit', 'Kunai', 'Scorpion', 'Stiletto', 'Tanto', 'FlipKnife', 'Dual Daggers', 'Butterfly')")->fetch_all(MYSQLI_ASSOC);
      $skins2 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$min' AND `cost` < '$cost_fill' AND `title` IN ('jKommando', 'Karambit', 'Kunai', 'Scorpion', 'Stiletto', 'Tanto', 'FlipKnife', 'Dual Daggers', 'Butterfly')")->fetch_all(MYSQLI_ASSOC);
      break;
    case 'gloves':
      $skins1 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$cost_fill' AND `cost` < '$max' AND `title` = 'gloves'")->fetch_all(MYSQLI_ASSOC);
      $skins2 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$min' AND `cost` < '$cost_fill' AND `title` = 'gloves'")->fetch_all(MYSQLI_ASSOC);
      break;
    default:
      $skins1 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$cost_fill' AND `cost` < '$max'")->fetch_all(MYSQLI_ASSOC);
      $skins2 = $db->query("SELECT `id` FROM `skins1` WHERE `cost` > '$min' AND `cost` < '$cost_fill'")->fetch_all(MYSQLI_ASSOC);
      break;
  }


  $num1 = min(($item['skins_limit'] / 2), count($skins1));
  $num2 = min(($item['skins_limit'] / 2), count($skins2));
  
  $keys1 = array_rand($skins1, $num1);
  $keys2 = array_rand($skins2, $num2);
  
  $skins1 = array_intersect_key($skins1, array_flip((array) $keys1));
  $skins2 = array_intersect_key($skins2, array_flip((array) $keys2));

  $skins = [];
  foreach ($skins1 as $skin) $skins[] = (int) $skin['id'];
  foreach ($skins2 as $skin) $skins[] = (int) $skin['id'];

  $skins = json_encode($skins, JSON_UNESCAPED_UNICODE);

  if ($item['cost'] == 0)
    $db->query("INSERT INTO `cases`(`img`, `title`, `name`, `cost`, `category`, `one_open_per`, `skins`) VALUES ('$item[img]','$item[title]','$item[name]','$item[cost]','$item[category]', '$item[time]' ,'$skins')");
  else
    $db->query("INSERT INTO `cases`(`img`, `title`, `name`, `cost`, `category`, `skins`) VALUES ('$item[img]','$item[title]','$item[name]','$item[cost]','$item[category]','$skins')");
}

set_time_limit(0);

function getRandomSkin($skins, $caseCost, $coeff)
{
  // Просчёт шансов
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
    if ($skin['cost'] < $caseCost) $skin['chance'] *= ($coefficientBottom * $coeff);
    else $skin['chance'] *= ($coefficientTop / $coeff);
  }
  $totalChance = array_reduce($skins, function ($acc, $skin) {
    return $acc + $skin['chance'];
  }, 0);
  // Выбор скинов

  $randNum = rand(0, round($totalChance * 10000)) / 10000;
  $currentSum = 0;
  foreach ($skins as &$skin) {
    $currentSum += $skin['chance'];
    if ($randNum <= $currentSum) {
      return $skin;
      break;
    }
  }
}

5   10  20
0   100 0  
10  85  5  
20  70  10 
30  55  15 
40  40  20 
50  25  25 
60  10  30 
66… 0   33…

5$ - 0%, 10%, 20%, 30%, 40%, 50%, 60%, 66.666…%
10$ - 100%, 85%, 70%, 55%, 40%, 25%, 10%, 0%
20$ -0%, 5%, 10%, 15%, 20%, 25%, 30%, 33.333…%
$cases = $db->query("SELECT `cost`, `title`, `coefficient` FROM `cases`")->fetch_all(MYSQLI_ASSOC);


foreach ($cases as $case) {
  $skins = $db->query("SELECT
    `skins`.* 
  FROM
    `cases` 
  JOIN
    `skins` ON JSON_CONTAINS(cases.skins, CAST(skins.id AS JSON), '$') 
  WHERE
    `cases`.`title` = '$case[title]'")->fetch_all(MYSQLI_ASSOC);

  if ($case['cost'] == 0) $case['cost'] = 1;


  $coeff = $case['coefficient'];
  for ($i = 0; $i < 100; $i++) {
    $sum_skins = 0;
    for ($open = 0; $open < 1000; $open++)
      $sum_skins += getRandomSkin($skins, $case['cost'], $coeff)['cost'];

    if (($open * $case['cost']) > $sum_skins) $coeff -= 0.001;
    else $coeff += 0.001;
  }
  echo $coeff;
  $db->query("UPDATE `cases` SET `coefficient` = '$coeff' WHERE `title` = '$case[title]'");
}

 */