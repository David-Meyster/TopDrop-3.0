<?php if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden'); ?>

<div class="modal-refill">
  <div class="modal-header">
    <h2 class="modal-title">Пополнение баланса</h2>
    <div class="modal-hide"></div>
  </div>

  <div class="refill-payments-scroll scroll--white">
    <div class="refill-payments">
      <button class="refill-payment" data-pay-min="300" data-pay-system="streampay" data-pay-type="sbp">
        <img class="refill-payment-icon" src="/media/image/payments/cards.svg" alt="">
      </button>
      <button class="refill-payment" data-pay-min="1" data-pay-system="overpay" data-pay-type="sbp">
        <img class="refill-payment-icon" src="/media/image/payments/sbp.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Не работает" data-pay-system="yookassa" data-pay-type="bank_card">
        <img class="refill-payment-icon" src="/media/image/payments/cards.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Не работает" data-pay-system="paykeeper" data-pay-type="sbp_default">
        <img class="refill-payment-icon" src="/media/image/payments/sbp.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Не работает" data-pay-system="yookassa" data-pay-type="sberbank">
        <img class="refill-payment-icon" src="/media/image/payments/sber.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Не работает" data-pay-system="yookassa" data-pay-type="tinkoff_bank">
        <img class="refill-payment-icon" src="/media/image/payments/tinkoff.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Не работает" data-pay-system="yookassa" data-pay-type="yoo_money">
        <img class="refill-payment-icon" src="/media/image/payments/ym.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Не работает" data-pay-system="yookassa" data-pay-type="wm">
        <img class="refill-payment-icon" src="/media/image/payments/wm.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Скоро" data-pay-system="yookassa" data-pay-type="beeline">
        <img class="refill-payment-icon" src="/media/image/payments/beeline.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Скоро" data-pay-system="yookassa" data-pay-type="mts">
        <img class="refill-payment-icon" src="/media/image/payments/mts.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Скоро" data-pay-system="yookassa" data-pay-type="tele2">
        <img class="refill-payment-icon" src="/media/image/payments/tele2.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Скоро" data-pay-system="yookassa" data-pay-type="megafon">
        <img class="refill-payment-icon" src="/media/image/payments/megafon.svg" alt="">
      </button>
      <button class="refill-payment" data-error-text="Скоро" data-pay-system="yookassa" data-pay-type="yota">
        <img class="refill-payment-icon" src="/media/image/payments/yota.svg" alt="">
      </button>
    </div>
  </div>
  <div class="refill-content">
    <div class="promo-type <?php if ($currentUser->invitedBy == null) echo "only-promo"; ?>">
      <?php if ($currentUser->invitedBy !== null) {
        $referralUser = new OtherUser($currentUser->invitedBy); ?>
        <div class="promo-type-select active promo-type-select-invite">
          <div class="promo-type-select-title font h4 bold uppercase color--theme-text">Инвайт-бонус</div>
          <div class="promo-type-select-description"><span class='color--green-text'>+<?= ($config['invited_bonus'] * 100); ?>%</span> к пополению</div>
        </div>
      <?php } ?>
      <div class="promo-type-select promo-type-select-promo <?= $currentUser->invitedBy == null ? 'active' : ''; ?>">
        <input class="refill-input-promo" name="promo" maxlength="60" type="text" placeholder="Промокод (при наличии)" autocomplete="off">
        <div class="refill-bonus-hint hint"></div>
      </div>
    </div>
    <div class="refill-payment-info">
      <div class="refill-amount-wrapper">
        <input class="refill-input" id="refill-sum" type="number" name="sum" value="200" placeholder="Сумма" min="1" max="1000000" require>
      </div>
      <button class="refill-button button">Пополнить</button>
    </div>
  </div>
</div>

<script>
  var promo_type = '<?= ($currentUser->invitedBy !== null) ? 'invite' : 'promo'; ?>';

  click('.modal .refill-payment:not([data-error-text])', function() {
    $(this).addClass('active').siblings('.active').removeClass('active');
    if ($(this).data('pay-min') !== undefined) {
      let inputSum = $('#refill-sum');
      inputSum.attr('min', $(this).data('pay-min'));
      if (Number(inputSum.val()) < Number($(this).data('pay-min'))) inputSum.val($(this).data('pay-min'));
    }
    $('.modal .refill-amount-wrapper').addClass('active').on('transitionend', function() {
      $('.modal .refill-button').addClass('active');
    });
  });

  $(function() {
    $('.modal .refill-payment[data-pay-min]').each(function() {
      $('<div>').addClass('refill-payment-label refill-payment-min money').text(`от ${$(this).data('pay-min')}`).appendTo($(this));
    });
  });

  on('input', '.modal .refill-input-promo', function() {
    clearTimeout(timer);
    var hint = $('.modal .refill-bonus-hint');
    var promo = $(this).val();
    if (promo === '') return hint.hide().attr('data-hint', '');
    timer = setTimeout(function() {
      checkPromo(promo, 'percent', function(response) {
        if ('error' in response) hint.show().removeClass('status-good').addClass('status-bad').text('!').attr('data-hint', response.error);
        if ('bonus' in response) hint.show().removeClass('status-bad').addClass('status-good').text(`+${response.bonus}%`).attr('data-hint', `Бонус <span class="color--green-text">${response.bonus}%</span> к пополнению!`);
      });
    }, 800);
  });

  click('.modal .refill-button.active', function() {
    
    let sum = Number($('#refill-sum').val());
    let promo = $('.modal .refill-input-promo').val();
    let pay_type = $('.modal .refill-payment.active').data('pay-type');
    let pay_system = $('.modal .refill-payment.active').data('pay-system');
    if (sum < Number($('.refill-payment.active').data('pay-min'))) return toast(`Минимальная сумма платежа через выбраный метод ${$('.refill-payment.active').data('pay-min')} ₽`, 'info')
    
    ajax({
      data: {
        do: 'create_payment',
        sum: sum,
        promo_type: promo_type,
        promo: promo,
        pay_type: pay_type,
        pay_system: pay_system
      }
    }).then(function(response) {
      if ('error' in response) return toast(response.error, 'error');
      if ('url' in response) window.location.href = response.url;
    });
  });

  click('.promo-type-select', function() {
    $('.promo-type-select.active').removeClass('active');
    $(this).addClass('active');
    promo_type = $(this).hasClass('promo-type-select-invite') ? 'invite' : ($(this).hasClass('promo-type-select-promo') ? 'promo' : promo_type);
  })
</script>