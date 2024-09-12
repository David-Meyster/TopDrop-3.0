<?php
if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden');

$inventory = $currentUser->getSkins(['select' => ['skins' => ['img', 'title', 'name', 'cost', 'rarity'], 'inventory' => ['id']], 'from' => 'inventory', 'where' => ['user_id' => $currentUser->id, 'skin_status' => [1]], 'order_by' => ['id' => 'DESC'], 'limit' => 30]);

?>

<div class="contract default">
  <section>
    <div class="container flex center column">
      <div class="contract-drum-wrapper">
        <div class="contract-drum-container">
          <ul class="contract-drum">
            <div class="contract-drum-result">
              <div class="contract-drum-pointer"></div>
              <div class="contract-drum-animate">
                <div class="fail">Не окуп</div>
                <div class="win">Окуп</div>
              </div>
            </div>
            <?php for ($i = 0; $i < 12; $i += 1) { ?>
              <li class="contract-drum-item-container">
                <button class="contract-drum-item" data-contract="<?= $i + 1; ?>" style="--i: <?= $i; ?>s;">
                  <img class="contract-skin-img" src="" alt="">
                </button>
              </li>
            <?php } ?>
            <div class="contract-winning-svg" style="width: 0%;">
              <svg xmlns="http://www.w3.org/2000/svg" class="flex size--full" width="464" height="464" viewBox="0 0 464 464" fill="none">
                <mask id="mask-passed-part" x="0" y="0" maskUnits="userSpaceOnUse">
                  <circle r="238.5" cx="232" cy="232" stroke-dasharray="20 10 75 10" stroke="#fff" stroke-width="150"></circle>
                </mask>
                <circle class="contract-winning-circle" mask="url(#mask-passed-part)" cx="232" cy="232" r="231" opacity="0.5"></circle>
              </svg>
            </div>
            <div class="contract-info-container">
              <div class="contract-paint-container size--full">
                <div class="flex center size--full position--absolute pointer-events--none" id="contract-brush-icon">
                  <img src="/media/image/etc/brush.png" height="30%" width="30%" alt="">
                </div>
                <canvas id="contract-paint"></canvas>
                <div class="contract-paint-style">
                  <button class="contract-paint-clear size effect--hover">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="32" viewBox="0 0 13 16" fill="var(--color-red)">
                      <path fill-rule="evenodd" d="M11 2H9c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1H2c-.55 0-1 .45-1 1v1c0 .55.45 1 1 1v9c0 .55.45 1 1 1h7c.55 0 1-.45 1-1V5c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1zm-1 12H3V5h1v8h1V5h1v8h1V5h1v8h1V5h1v9zm1-10H2V3h9v1z" />
                    </svg>
                  </button>
                  <button class="contract-button theme-button size">Подписать</button>
                  <label class="contract-paint-color size">
                    <input type="color" name="" id="" value="#2d6bfb">
                  </label>
                </div>
              </div>
              <div class="contract-winning-container">
                <div class="contract-winning">
                  <img class="contract-winning-img" src="" alt="">
                  <div class="contract-winning-info">
                    <div class="contract-winning-title"></div>
                    <div class="contract-winning-name"></div>
                    <div class="flex gap--xs" style="margin-top: var(--distance-xs);">
                      <button class="contract-winning-again button h5 font bold uppercase color--theme effect--hover">Ещё раз</button>
                      <button class="contract-winning-sell button h5 font bold uppercase color--green effect--hover">Продать</button>
                    </div>
                  </div>
                  <div class="contract-winning-cost money"></div>
                </div>
              </div>
            </div>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <?php if ($currentUser->authorized) { ?>
    <?php if ($inventory) { ?>
      <div class="contract-footer-container">
        <section>
          <div class="container container--small">
            <div class="contract-footer">
              <div class="font h2 bold uppercase">Инвентарь</div>
              <div class="contract-skins-scroll scroll--white">
                <ul class="contract-items skin-items">
                  <?php foreach ($inventory as $skin) { ?>
                    <li class="contract-item skin-item" data-cost="<?= $skin['cost']; ?>" data-rarity="<?= $skin['rarity']; ?>" data-id="<?= $skin['id']; ?>">
                      <button class="skin-button">
                        <img class="skin-img" src="/media/image/skins/<?= $skin['img'] ?>" alt="">
                        <div class="skin-info">
                          <div class="skin-title"><?= $skin['title']; ?></div>
                          <div class="skin-name"><?= $skin['name']; ?></div>
                        </div>
                        <div class="skin-cost money"><?= round($skin['cost'], 2); ?></div>
                      </button>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        </section>
      </div>
    <?php } else { ?>
      <div class="container container--small">
        <div class="contract-empty-alert">
          <div class="contract-empty-desc">У вас пока нет доступных предметов. Открывайте кейсы и апгрейдите предмет!</div>
          <button class="theme-button" data-href="/">Открывать кейсы</button>
        </div>
      </div>
    <?php } ?>
  <?php } else { ?>
    <div class="container container--small flex center">
      <div class="container--unauth">
        <div class="font--unauth">Для отображения инвентаря необходимо авторизоваться</div>
        <button class="theme-button" data-modal="sign">Войти</button>
      </div>
    </div>
  <?php } ?>
</div>
<script>
  $(function() {
    var contract = $('.contract');
    var max_item = 12;
    var min_item = 2;
    var contract_status = ['default', 'animate', 'winning', 'win', 'fail'];

    var contract_brush_icon = $('#contract-brush-icon');
    var $canvas = $('#contract-paint');
    $canvas.ready(function() {
      var canvas = document.getElementById('contract-paint');
      var ctx = canvas.getContext('2d');
      click('.contract-paint-clear', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        contract_brush_icon.show();
      });

      $canvas.attr({
        height: $canvas.height(),
        width: $canvas.width()
      });

      var isDrawing = false;

      if (isMobile) {
        canvas.addEventListener('touchstart', startDrawing, {
          passive: true
        });
        canvas.addEventListener('touchmove', draw, {
          passive: true
        });
        canvas.addEventListener('touchend', stopDrawing);
        canvas.addEventListener('touchcancel', stopDrawing);
      } else {
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);
      }

      function startDrawing(e) {
        isDrawing = true;
        draw(isMobile ? e.touches[0] : e);
      }

      function draw(e) {
        if (!isDrawing) return;
        contract_brush_icon.hide();

        const x = isMobile ? (e.touches[0].clientX - $canvas.offset().left) : e.clientX - $canvas.offset().left;
        const y = isMobile ? (e.touches[0].clientY - $canvas.offset().top + window.scrollY) : (e.clientY - $canvas.offset().top + window.scrollY);

        ctx.lineWidth = 5;
        ctx.lineCap = 'round';
        ctx.strokeStyle = $('.contract-paint-color input[type="color"]').val();

        ctx.lineTo(x, y);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(x, y);
      }

      function stopDrawing() {
        isDrawing = false;
        ctx.beginPath();
      }
    });

    var $drum = $('.contract-drum');
    var $drumSize = $('.contract-drum').width();
    var $drumItem = $('.contract-drum-item-container');

    resizeWidth(function() {
      if ($drumSize != $drum.width()) {
        $drumSize = $drum.width();
        alignItemDrum($drumItem);
      }
    });


    alignItemDrum($drumItem);

    function showMoreContractInventory() {
      var offset = $('.contract-items .contract-item').length;
      ajax({
        data: {
          do: 'getSkinsContract',
          offset: offset
        }
      }).then(function(response) {
        var $skinItems = $('.contract-items');
        response.forEach(function(skin) {
          var $skinItem = $('<li>').addClass('contract-item skin-item').attr({
            'data-rarity': skin.rarity,
            'data-id': skin.id,
            'data-cost': skin.cost
          }).appendTo($skinItems);
          var $skinButton = $('<button>').addClass('skin-button').appendTo($skinItem);
          var $skinImg = $('<img>').addClass('skin-img').attr('src', `/media/image/skins/${skin.img}`).attr('alt', '').appendTo($skinButton);
          var $skinInfo = $('<div>').addClass('skin-info').appendTo($skinButton);
          var $skinTitle = $('<div>').addClass('skin-title').text(skin.title).appendTo($skinInfo);
          var $skinName = $('<div>').addClass('skin-name').text(skin.name).appendTo($skinInfo);
          var $skinCost = $('<div>').addClass('skin-cost money money').text(round(skin.cost, 2)).appendTo($skinButton);
        });
      });
    }

    var canCallFunction = true;
    $('.contract-skins-scroll').on('scroll', function() {
      var scrollThreshold = 100; // Порог скролла, близкий к концу, в пикселях
      if (this.scrollHeight - Math.ceil(this.scrollTop) <= this.clientHeight + scrollThreshold) {
        if (canCallFunction) {
          canCallFunction = false;
          setTimeout(function() {
            canCallFunction = true;
          }, 100); // задержка в 1 секунду (1000 миллисекунд)
          showMoreContractInventory();
        }
      }
    });


    function updateContractItem() {
      $('.contract-drum-item.active').removeClass('active');
      var sumSkins = 0;
      $('.contract-item.active').each(function() {
        sumSkins += Number($(this).attr('data-cost'));
        var item = $('.contract-drum-item:not(.active)').first();
        item.addClass('active').attr({
          'data-cost': $(this).attr('data-cost'),
          'data-rarity': $(this).attr('data-rarity'),
          'data-id': $(this).attr('data-id'),
        }).children('.contract-skin-img').attr('src', $(this).find('.skin-img').attr('src'));
      });
      $('.contract-sum').text(round(sumSkins, 2));
      $('.contract-count-items .value').text($('.contract-drum-item.active').length);
    }
    click('.contract.default .contract-item', function() {
      if ($(this).siblings('.active').length < max_item) {
        $(this).toggleClass('active');
        updateContractItem();
      } else toast('Вы выбрали максимальное количество предметов', 'info');
    });
    click('.contract.winning .contract-item', function() {
      updateStatusElement(contract, contract_status, 'default');
    });


    click('.contract-winning-sell', function() {
      sellItem($(this).attr('data-id'));
      $(`.contract-item[data-id=${$(this).attr('data-id')}]`).remove();
      updateContractItem();
      updateStatusElement(contract, contract_status, 'default');
    });

    click('.contract-drum-item.active', function() {
      $(`.contract-item.active[data-id=${$(this).attr('data-id')}]`).removeClass('active');
      updateContractItem();
    });

    click('.contract.winning .contract-winning-again', function() {
      updateContractItem();
      updateStatusElement(contract, contract_status, 'default');
    });


    click('.contract.default .contract-button', function() {
      if ($('.contract-drum-item.active').length >= 2) {
        var skins_id = $('.contract-drum-item.active').map((index, e) => $(e).attr('data-id')).get();
        ajax({
          data: {
            do: 'createContract',
            skins_id: skins_id
          }
        }).then(function(response) {
          try {
            if ('error' in response) return toast(response.error, 'error');
            var rotate = (response.result) ? rand(181, 359) : rand(1, 179);
            var rotatePointer = (rand(0, 1)) ? 0 : 180;

            $('.contract-winning').attr('data-rarity', response.skin.rarity);
            $('.contract-winning-img').attr('src', `/media/image/skins/${response.skin.img}`);
            $('.contract-winning-sell').attr('data-id', response.skin.id);
            $('.contract-winning-title').text(response.skin.title);
            $('.contract-winning-name').text(response.skin.name);
            $('.contract-winning-cost').text(round(response.skin.cost, 2));

            var $winning_skin = $('<li>').addClass('contract-item skin-item').attr('data-rarity', response.skin.rarity).attr('data-id', response.skin.id).attr('data-cost', response.skin.cost);
            var $winning_skin_button = $('<button>').addClass('skin-button').appendTo($winning_skin);
            var $winning_skin_img = $('<img>').addClass('skin-img').attr('src', `/media/image/skins/${response.skin.img}`).appendTo($winning_skin_button);
            var $winning_skin_info = $('<div>').addClass('skin-info').appendTo($winning_skin_button)
            var $winning_skin_title = $('<div>').addClass('skin-title').attr('src', `/media/image/skins/${response.skin.img}`).text(response.skin.title).appendTo($winning_skin_info);
            var $winning_skin_name = $('<div>').addClass('skin-name').text(response.skin.name).appendTo($winning_skin_info);
            var $winning_skin_cost = $('<div>').addClass('skin-cost money').text(round(response.skin.cost, 2)).appendTo($winning_skin_button);

            var resultAudio = audio(`/media/audio/sounds/${response.result ? 'win': 'fail'}.mp3`, false);

            var sound_contract_animate = audio('/media/audio/sounds/contract_animate.mp3');
            sound_contract_animate.addEventListener('loadedmetadata', function() {
              updateStatusElement(contract, contract_status, 'animate');
              $('.contract-drum-result').css({
                '--contract-rotate-pointer': `${rotatePointer}deg`,
                '--contract-rotate': `${rotate + rotatePointer}deg`,
                '--duration-contract': `${sound_contract_animate.duration}s`,
              });
              $('.contract-drum-animate').one('animationend', function() {
                $('.contract-item.active').remove();
                updateStatusElement(contract, contract_status, ['winning', response.result ? 'win' : 'fail']);
                resultAudio.play();
                $('.contract-items').prepend($winning_skin);
              });
            });
          } catch (error) {
            console.error(error);
            console.log(response);
            toast('Ошибка, обратитесь в техподдержку или попробуйте перезагрузить страницу', 'error');
          }
        });
      } else toast('Для создания контракта необходимо минимум 2 предмета!', 'info');
    });
  });
</script>