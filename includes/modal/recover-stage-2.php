<?php if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden'); ?>
<a class="modal-back" data-modal="recover-stage-1"></a>

<div class="modal-title">Восстановление</div>

<div class="recover-form stage-2">
  <div class="input-container">
    <input id="recover-input-code" type="text" placeholder="Код восстановления">
    <div data-hint="Введите код, полученный на адрес электронной почты.">?</div>
  </div>
  <button class="recover-button" id="recover-stage-2-go">Далее</button>
  <div class="sign-desc">Вспомнили пароль?&nbsp;<button data-modal="sign">Войти</button></div>
</div>