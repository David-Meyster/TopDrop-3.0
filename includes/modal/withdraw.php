<?php if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden'); ?>

<?php $items_withdraw = $currentUser->getSkins(['select' => ['skins' => ['img', 'title', 'name', 'cost', 'rarity'], 'inventory' => ['id']], 'from' => 'inventory', 'where' => ['user_id' => $currentUser->id, 'skin_status' => [1]], 'order_by' => ['id' => 'DESC'], 'limit' => 20]); ?>

<div class="modal-withdraw">
  <div class="modal-header">
    <h2 class="modal-title">Вывод голды</h2>
    <div class="modal-hide"></div>
  </div>
  <div class="withdraw-select active">
    <div class="withdraw-scroll scroll--white">
      <ul class="withdraw-items"></ul>
    </div>
    <div class="withdraw-content">
      <div class="withdraw-sum theme-button color--green-dark">Сумма&nbsp;<span class="money">0.00</span></div>
      <button class="withdraw-button theme-button" disabled>Далее</button>
    </div>
  </div>
  <div class="withdraw-instruction">
    <div class="withdraw-instruction-header flex center--y">
      <button class="withdraw-instruction-back-button" title="Вернуться назад">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon--big" viewBox="0 0 24 24" fill="#aeb6c2">
          <path d="M15.001 8.115a.997.997 0 0 0-1.412-1.41l-4.587 4.588a1 1 0 0 0 0 1.414l4.588 4.588a.998.998 0 0 0 1.412-1.41L11.124 12l3.876-3.885Z"></path>
        </svg>
      </button>
      <div class="font h5 font--600 color--text">Для того чтобы получить ваш скин в виде голды на ваш аккаунт необходимо:</div>
    </div>
    <div class="withdraw-instruction-desc" data-counter="1">
      <header>Установить одинаковые аватарки</header>
      <p>В профиле Standoff 2, а также в профиле сайта.</p>
    </div>

    <div class="withdraw-instruction-desc" data-counter="2">
      <header>Купить или взять</header>
      <p>Из инвентаря <span class="withdraw-instruction-skin">TEC-9 "Tie Dye"</span>, выставить его на рынок за <button class="withdraw-instruction-cost copy"><span>34.30</span>&nbsp;G</button>. Обязательно посмотрев его pattern, укажите его в поле ниже. Обязательно выполните эти действия, иначе вывод не будет произведен!</p>
    </div>

    <div class="withdraw-instruction-desc" data-counter="3">
      <header>Ждать вывод голды на ваш аккаунт</header>
      <p>В течении 24 часов вам поступит приз на ваш аккаунт, если что-то пошло не так обращайтесь в тех поддержку вк или на почту <a class="withdraw-instruction-mail" href="mailto:support@topdrop.fun">support@topdrop.fun</a>, в случае если вы не выполнили условия, мы не несём ответственность и не гарантируем поступление голды на счёт.</p>
      <div class="withdraw-instruction-form">
        <div class="withdraw-instruction-pattern">
          <input type="text" maxlength="3" placeholder="000" name="pattern" require>
        </div>
        <button class="withdraw-instruction-button">Готово</button>
      </div>
    </div>

  </div>
</div>

<script>
  $(function() {
    var items_withdraw = <?= $items_withdraw ? json_encode($items_withdraw) : 0; ?>;
    var $profileWithdraw = $('.modal .withdraw-items');
    if (items_withdraw) {
      items_withdraw.forEach(function(skin) {
        var $skinItem = $('<li>').addClass('withdraw-item skin-item').attr('data-rarity', skin.rarity).attr('data-id', skin.id).attr('data-cost', skin.cost).appendTo($profileWithdraw);
        var $skinButton = $('<button>').addClass('skin-button').appendTo($skinItem);
        var $skinImg = $('<img>').addClass('skin-img').attr('src', `/media/image/skins/${skin.img}`).attr('alt', skin.title).appendTo($skinButton);
        var $skinCost = $('<div>').addClass('skin-cost money').text(round(skin.cost, 2)).appendTo($skinButton);
        var $skinInfo = $('<div>').addClass('skin-info').appendTo($skinButton);
        var $skinName = $('<div>').addClass('skin-name').text(skin.name).appendTo($skinInfo);
      });
    } else $('.withdraw-select').html($('<div>').addClass('profile-empty-alert').text('Нет скинов для вывода!'));

    var withdrawCost = 0;
    click('.withdraw-item .skin-button', function() {
      var item = $(this).closest('.withdraw-item');
      item.toggleClass('active');
      if (item.hasClass('active'))
        withdrawCost += Number(item.attr('data-cost'));
      else
        withdrawCost -= Number(item.attr('data-cost'));

      withdrawCost = round(withdrawCost, 2);
      $('.withdraw-button').attr('disabled', withdrawCost > 0 ? false : true);
      $('.withdraw-sum .money').text(withdrawCost);
    });

    click('.withdraw-select .withdraw-button', function() {
      if (withdrawCost >= 10) {
        $('.withdraw-select').removeClass('active');
        $('.withdraw-instruction').addClass('active');
        $('.withdraw-instruction-cost span').text((withdrawCost * 1.252).toFixed(2));
      } else toast('Минимальная сумма скинов для вывода 10 ₽', 'info');
    });

    click('.withdraw-instruction-back-button', function() {
      $('.withdraw-select').addClass('active');
      $('.withdraw-instruction').removeClass('active');
    });

    click('.withdraw-instruction-button', function() {
      var skins_id = $('.withdraw-item.active').map((index, element) => Number($(element).attr('data-id'))).get();

      var pattern = $('.withdraw-instruction-pattern input').val();
      if (pattern !== '') {
        if (pattern.length === 3) {
          if (isInt(Number(pattern))) {
            if ('<?= $currentUser->avatar ?>' !== 'noAvatar.png') {
              ajax({
                data: {
                  do: 'createWithdraw',
                  pattern: pattern,
                  skins_id: skins_id
                }
              }).then(function(response) {
                if (isObject(response)) {
                  if ('error' in response) toast(response.error, 'error');
                } else location.reload();
              });
            } else toast('Не поставлена аватарка', 'info');
          } else toast('Паттерн должен состоять только из чисел', 'info');
        } else toast('Паттерн должен состоять из 3 символов', 'info');
      } else toast('Заполните поле паттерна', 'info');
    });
  });
</script>