<?php if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden'); ?>
<div class="modal-promo">
  <div class="modal-header">
    <div class="modal-title">Ввести промокод</div>
    <div class="modal-hide"></div>
  </div>
  <div class="flex column gap--s">
    <div class="flex gap--xxs">
      <input class="promo-input radius--m flex center padding--xl font font--700 color--gray size--w-full" placeholder="Промокод" type="text">
      <button class="promo-button theme-button flex--shrink">Ввести</button>
    </div>
  </div>
</div>

<script>
  click('.modal-promo .promo-button', function() {
    var promo = $('.modal-promo .promo-input').val();
    if (promo === '') return toast('Заполните поле промокода', 'error');
    checkPromo(promo, 'case', function(response) {
      if ('error' in response) return toast(response.error, 'error');
      if ('bonus' in response) return toast(`Вам начислен кейс ${response.bonus}, он у вас в инвентаре!`, 'success');
    });
  });

</script>