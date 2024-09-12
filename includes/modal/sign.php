<?php if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden'); ?>
<div class="modal-sign">
  <div class="modal-header">
    <div class="select-header">
      <button class="modal-title signin-select select select-title active effect--hover" tabindex="-1">Вход</button>
      <button class="modal-title signup-select select select-title effect--hover" tabindex="-1">Регистрация</button>
      <div class="select-title-underline underline"></div>
    </div>
    <div class="modal-hide"></div>
  </div>

  <div class="sign-container">
    <div class="signin active">
      <form class="signin-form" action="/">
        <div class="input-container">
          <input id="signin-input-email" type="text" autocomplete="signin-email" placeholder="">
          <label for="signin-input-email">E-mail или Никнейм</label>
        </div>
        <div class="input-container">
          <input id="signin-input-password" type="password" autocomplete="signin-password" placeholder="">
          <label for="signin-input-password">Пароль</label>
        </div>
        <button class="theme-button size--w-full size" type="submit" id="signin-submit">Войти</button>
      </form>

      <div class="flex center">
        <div class="sign-desc">Забыли пароль?&nbsp;<button data-modal="recover-stage-1" tabindex="-1">Восстановить</button></div>
      </div>

      <fieldset class="social-auth">
        <legend>Или авторизуйтесь через</legend>
        <ul class="auth-list">
          <li class="size auth-item vk">
            <a class="auth-link" href="/auth/vk">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#fff">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.076 14.203a30.54 30.54 0 0 1 2.189 2.221c.302.351.566.735.789 1.146.3.591.032 1.24-.494 1.274h-3.267a2.507 2.507 0 0 1-2.077-.854c-.451-.463-.87-.953-1.304-1.438a3.032 3.032 0 0 0-.585-.522.662.662 0 0 0-.612-.154.677.677 0 0 0-.472.416 3.552 3.552 0 0 0-.348 1.538c-.033.78-.263.982-1.042 1.014a8.265 8.265 0 0 1-4.663-1.009 10.477 10.477 0 0 1-3.144-2.967A40.032 40.032 0 0 1 .914 7.431c-.263-.587-.07-.902.574-.918a91.11 91.11 0 0 1 3.192 0 .944.944 0 0 1 .887.672 20.007 20.007 0 0 0 2.167 4.05c.216.347.493.653.816.905a.51.51 0 0 0 .728-.01.494.494 0 0 0 .12-.24c.104-.272.168-.557.187-.847a12.86 12.86 0 0 0-.054-2.979 1.234 1.234 0 0 0-1.046-1.135c-.31-.058-.268-.176-.112-.357a1.164 1.164 0 0 1 .998-.5h3.691c.58.11.71.377.784.964l.005 4.135c-.005.229.113.9.52 1.055a.711.711 0 0 0 .734-.368 12.834 12.834 0 0 0 2.084-3.224c.243-.513.467-1.036.67-1.567a.798.798 0 0 1 .837-.575l3.537.01c.106-.002.212.004.317.017.6.101.761.362.58.953-.341.897-.82 1.73-1.418 2.468-.59.825-1.222 1.625-1.807 2.456-.537.762-.5 1.14.171 1.807Z"></path>
              </svg>
            </a>
          </li>
          <li class="size auth-item google">
            <a class="auth-link" href="/auth/google">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#fff">
                <path d="M21.803 10.125c.129.67.197 1.37.197 2.1C22 17.937 18.097 22 12.204 22 6.566 22 2 17.525 2 12S6.566 2 12.204 2c2.755 0 5.058.993 6.824 2.607l-2.877 2.82v-.008c-1.07-1-2.429-1.513-3.947-1.513-3.367 0-6.103 2.787-6.103 6.088 0 3.3 2.736 6.094 6.103 6.094 3.055 0 5.133-1.713 5.562-4.062h-5.562v-3.9h9.6Z"></path>
              </svg>
            </a>
          </li>
          <li class="size auth-item telegram">
            <a class="auth-link" href="/auth/telegram">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#fff">
                <path fill-rule="evenodd" d="M22.161 3.36a.706.706 0 0 0-.689-.118c-3.64 1.3-14.828 5.372-19.403 7.01a.686.686 0 0 0 .044 1.318c2.052.59 4.743 1.42 4.743 1.42s1.26 3.682 1.916 5.558a.744.744 0 0 0 .892.483.794.794 0 0 0 .333-.174c1.05-.965 2.681-2.457 2.681-2.457s3.097 2.202 4.853 3.412a1.04 1.04 0 0 0 1.363-.148.977.977 0 0 0 .224-.433c.756-3.433 2.583-12.114 3.266-15.237a.633.633 0 0 0-.224-.635l.001.001Zm-3.567 3.156-8.825 7.716-.324 2.946-1.455-4.654 10.308-6.382a.254.254 0 0 1 .329.054.226.226 0 0 1 .049.167.23.23 0 0 1-.082.153Z" clip-rule="evenodd"></path>
              </svg>
            </a>
          </li>
          <li class="size auth-item steam">
            <a class="auth-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#fff" style="filter: grayscale(1)" title="Скоро сделаем ;)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.834 9.5a2.547 2.547 0 0 1-2.556 2.555A2.549 2.549 0 0 1 12.721 9.5a2.548 2.548 0 0 1 2.556-2.555c1.388 0 2.556 1.166 2.556 2.555Zm-4.447 0c0 1.055.834 1.889 1.89 1.889A1.873 1.873 0 0 0 17.164 9.5a1.873 1.873 0 0 0-1.887-1.889c-1.057 0-1.89.834-1.89 1.889Zm-3.942 4.889-1.279-.555a2.473 2.473 0 0 1 1.556 0c.556.221.944.611 1.167 1.166a2.163 2.163 0 0 1 0 1.666 2.127 2.127 0 0 1-2.778 1.168A2.287 2.287 0 0 1 7 16.778l1.223.5c.777.333 1.722-.055 2.054-.833.334-.779-.054-1.723-.832-2.056ZM12 22c-4.5 0-8.334-3-9.611-7.055L6.166 16.5a2.665 2.665 0 0 0 1.668 1.945 2.713 2.713 0 0 0 3.611-1.5c.166-.39.221-.779.221-1.168l3.5-2.5h.113c2.11 0 3.776-1.722 3.776-3.832a3.781 3.781 0 0 0-3.777-3.779A3.781 3.781 0 0 0 11.5 9.445V9.5L9 13.111a2.9 2.9 0 0 0-1.166.223c-.168.055-.334.166-.445.221L2 11.334C2.334 6.11 6.666 2 12 2c5.555 0 10 4.5 10 10s-4.5 10-10 10Z"></path>
              </svg>
            </a>
          </li>
      </fieldset>
    </div>

    <div class="signup">
      <form class="signup-form" action="/">
        <div class="input-container">
          <input id="signup-input-email" type="email" placeholder="" autocomplete="signup-email" data-validate-type="signup-email" required minlength="6" maxlength="100">
          <label for="signup-input-email">E-mail</label>
          <div data-hint="Требуется для восстановления доступа к аккаунту.<br>Вводите <span class='font bold color--red-text'>реальный</span> адрес электронной почты, чтобы иметь возможность восстановить доступ к аккаунту.">?</div>
        </div>
        <div class="input-container">
          <input id="signup-input-nickname" type="text" placeholder="" autocomplete="signup-username" data-validate-type="signup-nickname" required minlength="3" maxlength="30" pattern="/^([a-zA-Zа-яА-Я0-9_.\-]{3,30})$/v">
          <label for="signup-input-nickname">Никнейм</label>
          <div data-hint="Имя, отображаемое в вашем профиле. От 3 до 30 символов. Допустимо: кириллица, латиница, нижнее подчеркивание, дефис, точки, цифры.">?</div>
        </div>
        <div class="input-container">
          <input id="signup-input-password" type="password" placeholder="" autocomplete="signup-password" data-validate-type="password" required minlength="6" maxlength="50">
          <label for="signup-input-password">Пароль</label>
          <div data-hint="Используйте сложный пароль. Сложный пароль – гарант безопасности вашего аккаунта.<br>От 6 до 50 любых символов.">?</div>
        </div>
        <div class="flex end--x">
          <div id="question-invited">Есть инвайт-код?</div>
        </div>
        <div class="input-container" id="invite-code-container">
          <input id="signup-input-invite-code" type="text" value="<?= $refPromo; ?>" placeholder="" data-validate-type="signup-invite-code" maxlength="10" pattern="/^([A-Za-z0-9]{1,10})$/">
          <label for="signup-input-invite-code">Инвайт-код</label>
          <div data-hint="Укажите инвайт-код друга, который он может найти в своём профиле.<br>Вы получите постоянный бонус к пополнению <span class='color--green-text'>+<?= $config['invited_bonus'] * 100; ?>%</span>, а друг, пригласивший вас, будет дополнительно получать <span class='color--green-text'><?= $config['referral_promo_bonus'] * 100; ?>%</span> от суммы вашего платежа.">?</div>
        </div>
        <button class="theme-button size--w-full size" type="submit" id="signup-submit">Зарегистрироваться</button>
      </form>
    </div>
  </div>
</div>

<script>
  $(function() {
    positionUnderline($('.modal .select-header'));
    if ($('#signup-input-invite-code').val() != '') {
      $('#question-invited').remove();
      $('#invite-code-container').show();
      validateInput($('#signup-input-invite-code'));
    }

    doc('keydown', function() {
      if (event.code === 'Enter') $($('.signin').hasClass('active') ? '#signin-submit:not(:focus)' : '#signup-submit:not(:focus)').click()
    });
    $('#signin-submit').focus();
  });
</script>