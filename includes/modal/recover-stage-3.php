<?php if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden'); ?>
<div class="modal-title">Восстановление</div>

<div class="recover-form stage-3">
  <div class="input-container">
    <input id="recover-input-new-password" type="password" data-verify="true" data-verify-type="password" placeholder="Новый пароль">
    <div data-hint="Введите новый пароль. От 6 до 50 любых символов.">?</div>
  </div>
  <button class="recover-button" id="recover-stage-3-go">Сохранить</button>
  <div class="sign-desc">Вспомнили пароль?&nbsp;<button data-modal="sign">Войти</button></div>
</div>