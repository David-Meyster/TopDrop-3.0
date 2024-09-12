<?php if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden'); ?>

<div class="modal-sign">
  <div class="modal-header">
    <div class="modal-title">Восстановление</div>
    <div class="modal-hide"></div>
  </div>


  <div class="recover-form">
    <div class="input-container">
      <input id="recover-input-email" type="text" placeholder=" ">
      <label for="recover-input-email">E-mail</label>
      <div data-hint="Введите адрес электронной почты, на который был зарегистрирован аккаунт.">?</div>
    </div>
    <button class="theme-button size size--w-full" id="recover-stage-1-go" onclick="toast('Скоро...', 'info')">Далее</button>
  </div>
  <div class="sign-desc">Вспомнили пароль?&nbsp;<button data-modal="sign">Войти</button></div>
</div>