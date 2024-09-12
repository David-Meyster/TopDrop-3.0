<?php
if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden');

$errors = [
  '401' => 'Для доступа на эту страницу требуется авторизация',
  '403' => 'У вас нет доступа к данной странице',
  '404' => 'Запрашиваемая страница не найдена',
  '500' => 'Внутренняя ошибка сервера',
  '502' => 'Сервер получил недействительный ответ от шлюза и не смог обработать запрос',
  '503' => 'Сервер временно недоступен',
  '504' => 'Сервер не получил ответ вовремя'
];

$errorDesctiption = $errors[$page->subaction] ?? 'Неизвестная ошибка';

?>
<section>
  <div class="container container--small">
    <div class="flex center size--full">
      <div class="flex column gap--l container--error color--primary container--xxl">
        <div class="font bold">Ошибка <?= $page->subaction; ?></div>
        <div class="color--gray-text"><?= $errorDesctiption; ?></div>
        <div class="flex center gap--s">
          <button class="size button color--gray radius--m font font--600" onclick="history.back();">Назад</button>
          <button class="size button color--gray radius--m font font--600" data-href="/">На главную</button>
        </div>
        <div class="font color--gray-text">
          <div>Вы можете сообщить о данной ошибке и обстоятельствах того, как она произошла:</div>
          <a class="color--theme-text effect--hover" href="mailto:support@topdrop.fun">support@topdrop.fun</a>
        </div>
      </div>
    </div>
  </div>
</section>