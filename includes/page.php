<?php if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden');
$page = new Page;
$page->getPage(); ?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="description" content="Бесплатные Кейсы Standoff 2! TopDrop - Лучший сайт по кейсам STANDOFF!">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="google" content="notranslate">
  <meta name="apple-mobile-web-app-title" content="TopDrop">
  <meta name="application-name" content="TopDrop">
  <meta name="msapplication-TileColor" content="#2d89ef">
  <meta name="msapplication-TileImage" content="/media/image/favicon/mstile-144x144.png?v=2">
  <meta name="msapplication-config" content="/media/image/favicon/browserconfig.xml?v=2">
  <meta name="theme-color" content="#ffffff">
  <link rel="apple-touch-icon" sizes="57x57" href="/media/image/favicon/apple-touch-icon-57x57.png?v=2">
  <link rel="apple-touch-icon" sizes="60x60" href="/media/image/favicon/apple-touch-icon-60x60.png?v=2">
  <link rel="apple-touch-icon" sizes="72x72" href="/media/image/favicon/apple-touch-icon-72x72.png?v=2">
  <link rel="apple-touch-icon" sizes="76x76" href="/media/image/favicon/apple-touch-icon-76x76.png?v=2">
  <link rel="apple-touch-icon" sizes="114x114" href="/media/image/favicon/apple-touch-icon-114x114.png?v=2">
  <link rel="apple-touch-icon" sizes="120x120" href="/media/image/favicon/apple-touch-icon-120x120.png?v=2">
  <link rel="apple-touch-icon" sizes="144x144" href="/media/image/favicon/apple-touch-icon-144x144.png?v=2">
  <link rel="apple-touch-icon" sizes="152x152" href="/media/image/favicon/apple-touch-icon-152x152.png?v=2">
  <link rel="apple-touch-icon" sizes="180x180" href="/media/image/favicon/apple-touch-icon-180x180.png?v=2">
  <link rel="icon" type="image/png" sizes="32x32" href="/media/image/favicon/favicon-32x32.png?v=2">
  <link rel="icon" type="image/png" sizes="192x192" href="/media/image/favicon/android-chrome-192x192.png?v=2">
  <link rel="icon" type="image/png" sizes="16x16" href="/media/image/favicon/favicon-16x16.png?v=2">
  <link rel="manifest" href="/media/image/favicon/site.webmanifest?v=2">
  <link rel="mask-icon" href="/media/image/favicon/safari-pinned-tab.svg?v=2" color="#5bbad5">
  <link rel="shortcut icon" href="/media/image/favicon/favicon.ico?v=2">
  <title>TopDrop – Бесплатные Кейсы Standoff 2! Лучшие Кейсы стандофф 2</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/media/css/topdrop.css?v=<?= $updates['last']['v']; ?>">
  <script>
    const updates = <?= json_encode($updates, JSON_UNESCAPED_UNICODE); ?>;
    const isAuth = <?= $currentUser->authorized ? 1 : 0; ?>;
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="/media/js/function.js?v=<?= $updates['last']['v']; ?>"></script>
  <script src="/media/js/topdrop.js?v=<?= $updates['last']['v']; ?>" defer></script>
  <script type="text/javascript" src="https://vk.com/js/api/openapi.js?168"></script>
</head>

<body>
  <div id="vk_community_messages"></div>
  <script type="text/javascript">
    VK.Widgets.CommunityMessages('vk_community_messages', 219075058, {
      expanded: 0,
      welcomeScreen: 1,
      tooltipButtonText: 'Есть вопрос?'
    });
  </script>
  <div id="root">
    <header id="header">
      <?php include_once($page->header); ?>
    </header>
    <main id="main">
      <?php include_once($page->main); ?>
    </main>
    <footer id="footer">
      <?php include_once($page->footer); ?>
    </footer>
  </div>
  <script src="/media/js/page.js?v=<?= $updates['last']['v']; ?>"></script>
</body>

</html>