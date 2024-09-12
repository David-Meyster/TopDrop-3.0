<?php
if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden');

$inventory = $currentUser->getSkins(['select' => ['skins' => ['img', 'title', 'name', 'cost', 'rarity'], 'inventory' => ['id']], 'from' => 'inventory', 'where' => ['user_id' => $currentUser->id, 'skin_status' => [1]], 'order_by' => ['id' => 'DESC'], 'limit' => 20]);
$skins = $currentUser->getSkins(['select' => ['skins' => ['id', 'img', 'title', 'name', 'cost', 'rarity']], 'from' => 'skins', 'order_by' => ['cost' => 'ASC'], 'limit' => 20]);
?>

<div class="upgrade default">
  <div class="upgrade-content color--primary">
    <div class="container container--smail">
      <div class="flex column size--full position--relative">
        <div class="flex column center size--full">
          <div class="upgrade-roulette">
            <svg xmlns="http://www.w3.org/2000/svg" class="flex size--full" width="464" height="464" viewBox="0 0 464 464" fill="none">
              <circle cx="232" cy="232" r="232" fill="var(--color-dark)" fill-opacity="0.5"></circle>
              <circle cx="232" cy="232" r="217" fill="var(--color-dark)"></circle>
              <circle class="upgrade-roulette-circle" cx="232" cy="232.226" r="198.247" fill="var(--color-gray-secondary)" stroke-width="2"></circle>
              <circle cx="232" cy="232" r="135.5" fill="url(#fill-background)" stroke="var(--color-gray-primary)"></circle>
              <mask id="mask-passed-part" x="0" y="0" width="464" height="464" maskUnits="userSpaceOnUse">
                <circle r="170" cx="232" cy="232" stroke-dasharray="1.5 2.5" stroke="#fff" stroke-width="20"></circle>
              </mask>
              <circle id="upgrade-circle" mask="url(#mask-passed-part)" cx="232" cy="232" r="200" stroke-dasharray="0 18000" stroke-dashoffset="0" stroke-width="200" fill="var(--color-dark)"></circle>
              <circle cx="232" cy="232" r="141" stroke="var(--color-gray-primary)" stroke-width="12" stroke-dasharray="1 14.3"></circle>
              <radialGradient id="fill-background" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(232 232) rotate(-15.9454) scale(127.402 137.728)">
                <stop stop-color="var(--color-dark)"></stop>
                <stop offset="1" stop-color="var(--color-gray-secondary)"></stop>
              </radialGradient>
            </svg>

            <div class="chance-circle-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" width="38" height="72" viewBox="0 0 38 72">
                <path d="M20.7203 69.0987C19.9456 70.4053 18.0544 70.4053 17.2797 69.0987L4.33628 47.2701C3.54575 45.9369 4.50664 44.25 6.05659 44.25L31.9434 44.25C33.4934 44.25 34.4542 45.9369 33.6637 47.2701L20.7203 69.0987Z" fill="var(--upgrade-color)"></path>
                <path d="M20.7113 34.1706C19.9332 35.4572 18.0668 35.4572 17.2887 34.1706L11.3095 24.2851C10.5033 22.9522 11.463 21.25 13.0208 21.25L24.9792 21.25C26.537 21.25 27.4967 22.9522 26.6905 24.2851L20.7113 34.1706Z" fill="#656578" fill-opacity="0.5"></path>
                <path d="M20.703 12.2347C19.9219 13.503 18.0781 13.503 17.297 12.2347L13.9493 6.79876C13.1287 5.46623 14.0874 3.75 15.6523 3.75L22.3477 3.75C23.9126 3.75 24.8713 5.46624 24.0507 6.79876L20.703 12.2347Z" fill="#656578" fill-opacity="0.15"></path>
              </svg>
            </div>
            <div class="upgrade-info-value">
              <div class="upgrade-info-chance">0.00%</div>
              <div class="upgrade-info-result"></div>
            </div>
          </div>
          <div class="upgrade-content-gun">
            <div class="upgrade-gun skin-inventory">
              <img class="upgrade-gun-img" src="/media/image/etc/gun_upgrade.png" alt="">
            </div>
            <div class="upgrade-gun skin-upgrade">
              <img class="upgrade-gun-img" src="/media/image/etc/gun_upgrade.png" alt="">
            </div>
          </div>
        </div>
        <div class="upgrade__content-bottom">
          <button class="upgrade-button theme-button">Апгрейд</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container container--smail">
    <div class="upgrade-footer flex gap--distance size--w-full">
      <div class="flex column size--full">
        <div class="upgrade-footer-item-header color--primary">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon--medium color--primary-text" width="24" height="24" viewBox="0 0 24 24">
            <rect x="2.079" y="2.039" width="8.486" height="8.486" rx="2"></rect>
            <rect x="13.604" y="2.039" width="8.486" height="8.486" rx="2"></rect>
            <rect x="2.079" y="13.563" width="8.486" height="8.486" rx="2"></rect>
            <rect x="13.604" y="13.563" width="8.486" height="8.486" rx="2"></rect>
          </svg>
          <div class="font h3 bold uppercase color--primary-text">Инвентарь</div>
        </div>
        <div class="upgrade-footer-item-content color--primary">
          <?php if ($currentUser->authorized) { ?>
            <?php if ($inventory) { ?>
              <div class="upgrade-skins-scroll scroll--white">
                <ul class="upgrade-items skin-inventory">
                  <?php foreach ($inventory as $skin) { ?>
                    <li class="upgrade-item skin-item" data-rarity="<?= $skin['rarity']; ?>" data-id="<?= $skin['id']; ?>" data-cost="<?= $skin['cost']; ?>">
                      <button class="skin-button">
                        <img class="skin-img" src="/media/image/skins/<?= $skin['img'] ?>" alt="">
                        <div class="skin-info">
                          <div class="skin-title"><?= $skin['title']; ?></div>
                          <div class="skin-name"><?= $skin['name']; ?></div>
                        </div>
                        <div class="skin-cost"><?= round($skin['cost'], 2); ?> ₽</div>
                      </button>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            <?php } else { ?>
              <div class="upgrade-empty-alert">
                <img class="upgrade-empty-img" src="/media/image/etc/empty_gun_upgrade.png" alt="">
                <div class="upgrade-empty-desc">У вас пока нет доступных предметов. Открывайте кейсы и апгрейдите предмет</div>
                <button class="theme-button" data-href="/">Открывать кейсы</button>
              </div>
            <?php } ?>
          <?php } else { ?>
            <div class="upgrade-empty-alert">
              <img class="upgrade-empty-img" src="/media/image/etc/empty_gun_upgrade.png" alt="">
              <div class="upgrade-empty-desc">Для отображения инвентаря необходимо авторизоваться</div>
              <button class="theme-button" data-modal="sign">Войти</button>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="flex column size--full">
        <div class="upgrade-footer-item-header color--primary">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon--medium color--primary-text" width="24" height="24" viewBox="0 0 24 24">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.943 7.183l-5.595 4.8c-.504.433-1.313.43-1.813-.008l-.81-.71c-.49-.427-.506-1.116-.037-1.561l7.165-6.807c.217-.206.501-.326.796-.356.472-.14 1.016-.033 1.372.312l7.067 6.852c.46.446.44 1.129-.045 1.553l-.81.71c-.504.44-1.32.44-1.823 0l-5.467-4.785zm-.847 3.629a1.068 1.068 0 011.372-.004l4.307 3.768a.773.773 0 010 1.197l-.79.69a1.065 1.065 0 01-1.367 0l-2.834-2.48-2.834 2.48c-.377.331-.99.331-1.367 0l-.79-.69a.773.773 0 010-1.197l4.303-3.764zm.201 6.228a.89.89 0 01.842-.165c.116.033.225.09.318.171l2.095 1.834a.645.645 0 010 .997l-.586.513a.889.889 0 01-1.139 0l-.954-.835-.946.829a.889.889 0 01-1.14 0l-.585-.513a.644.644 0 010-.997l2.095-1.834z"></path>
          </svg>
          <h3 class="font h3 bold uppercase color--primary-text">Скины</h3>
        </div>
        <div class="upgrade-footer-item-content color--primary">
          <?php if ($currentUser->authorized) { ?>
            <div class="upgrade-skins-scroll scroll--white">
              <ul class="upgrade-items skin-upgrade">
                <?php foreach ($skins as $skin) { ?>
                  <li class="upgrade-item skin-item" data-rarity="<?= $skin['rarity']; ?>" data-id="<?= $skin['id']; ?>" data-cost="<?= $skin['cost']; ?>">
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
          <?php } else { ?>
            <div class="upgrade-empty-alert">
              <img class="upgrade-empty-img" src="/media/image/etc/empty_gun_upgrade.png" alt="">
              <div class="upgrade-empty-desc">Для доступа к функционалу необходимо авторизоваться</div>
              <button class="theme-button" data-href="/">На главную</button>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    var canCallFunction = true;
    $('.upgrade-skins-scroll').on('scroll', function() {
      var scrollThreshold = 100; // Порог скролла, близкий к концу, в пикселях
      if (this.scrollHeight - Math.ceil(this.scrollTop) <= this.clientHeight + scrollThreshold) {
        if (canCallFunction) {
          canCallFunction = false;
          setTimeout(function() {
            canCallFunction = true;
          }, 100); // задержка в 1 секунду (1000 миллисекунд)
          if ($(this).children('.upgrade-items').hasClass('skin-inventory')) showMoreUpgradeInventory();
          else showMoreUpgradeSkins();
        }
      }
    });


    var upgrade = $('.upgrade');
    var upgrade_status = ['default', 'active', 'animate', 'winning', 'win', 'fail'];

    function updateChanceUpgrade(chance = Number(upgrade.attr('data-chance'))) {
      let r = $('#upgrade-circle').attr('r');
      let x = (chance * (90 / 25) * r * Math.PI / 180).toFixed(1);

      upgrade.attr('data-chance', chance);
      $('#upgrade-circle').attr('stroke-dasharray', `${x} 18000`);
      $('.upgrade .upgrade-info-chance').html(`${chance.toFixed(2)}%`);
    }

    function getSkinsByCostUpgrade(skin_cost) {
      ajax({
        data: {
          do: 'getSkinsUpgrade',
          cost: skin_cost
        }
      }).then(function(response) {
        var $skinItems = $('.upgrade-items.skin-upgrade').empty();
        response.forEach(function(skin) {
          var $skinItem = $('<li>').addClass('upgrade-item skin-item').attr({'data-rarity': skin.rarity,'data-id': skin.id,'data-cost': skin.cost}).appendTo($skinItems);
          var $skinButton = $('<button>').addClass('skin-button').appendTo($skinItem);
          var $skinImg = $('<img>').addClass('skin-img').attr('src', `/media/image/skins/${skin.img}`).attr('alt', '').appendTo($skinButton);
          var $skinInfo = $('<div>').addClass('skin-info').appendTo($skinButton);
          var $skinTitle = $('<div>').addClass('skin-title').text(skin.title).appendTo($skinInfo);
          var $skinName = $('<div>').addClass('skin-name').text(skin.name).appendTo($skinInfo);
          var $skinCost = $('<div>').addClass('skin-cost money').text(round(skin.cost, 2)).appendTo($skinButton);
        });
      });
    }

    function showMoreUpgradeInventory() {
      let offset = $('.upgrade-items.skin-inventory .upgrade-item').length;
      ajax({
        data: {
          do: 'getSkinsUpgrade',
          offset: offset
        }
      }).then(function(response) {
        var $skinItems = $('.upgrade-items.skin-inventory');
        response.forEach(function(skin) {
          var $skinItem = $('<li>').addClass('upgrade-item skin-item').attr({'data-rarity': skin.rarity,'data-id': skin.id,'data-cost': skin.cost}).appendTo($skinItems);
          var $skinButton = $('<button>').addClass('skin-button').appendTo($skinItem);
          var $skinImg = $('<img>').addClass('skin-img').attr('src', `/media/image/skins/${skin.img}`).attr('alt', '').appendTo($skinButton);
          var $skinInfo = $('<div>').addClass('skin-info').appendTo($skinButton);
          var $skinTitle = $('<div>').addClass('skin-title').text(skin.title).appendTo($skinInfo);
          var $skinName = $('<div>').addClass('skin-name').text(skin.name).appendTo($skinInfo);
          var $skinCost = $('<div>').addClass('skin-cost money').text(round(skin.cost, 2)).appendTo($skinButton);
        });
      });
    }

    function showMoreUpgradeSkins() {
      let offset = $('.upgrade-items.skin-upgrade .upgrade-item').length;
      let skin_cost = $('.skin-inventory .upgrade-item.active').attr('data-cost') ?? 0;
      ajax({
        data: {
          do: 'getSkinsUpgrade',
          offset: offset,
          cost: skin_cost
        }
      }).then(function(response) {
        var $skinItems = $('.upgrade-items.skin-upgrade');
        response.forEach(function(skin) {
          var $skinItem = $('<li>').addClass('upgrade-item skin-item').attr({'data-rarity': skin.rarity,'data-id': skin.id,'data-cost': skin.cost}).appendTo($skinItems);
          var $skinButton = $('<button>').addClass('skin-button').appendTo($skinItem);
          var $skinImg = $('<img>').addClass('skin-img').attr('src', `/media/image/skins/${skin.img}`).attr('alt', '').appendTo($skinButton);
          var $skinInfo = $('<div>').addClass('skin-info').appendTo($skinButton);
          var $skinTitle = $('<div>').addClass('skin-title').text(skin.title).appendTo($skinInfo);
          var $skinName = $('<div>').addClass('skin-name').text(skin.name).appendTo($skinInfo);
          var $skinCost = $('<div>').addClass('skin-cost money').text(round(skin.cost, 2)).appendTo($skinButton);
        });
      });
    }

    var skin_img_upgrade = $('.upgrade-gun-img').attr('src');

    function skinUpgrade(skin_id, upgrade_id) {
      ajax({
        data: {
          do: 'skinUpgrade',
          skin: skin_id,
          upgrade: upgrade_id
        }
      }).then(function(response) {
        let chance = (Number(upgrade.attr('data-chance')) * 100) + 1;
        let rotate = Math.floor((response.result ? rand(1, chance) : rand(chance, 9999)) * 3.6 / 100);
        let sound_upgrade_animate = audio('/media/audio/sounds/upgrade_animate.mp3');
        sound_upgrade_animate.addEventListener('loadedmetadata', function() {
          updateStatusElement(upgrade, upgrade_status, 'animate');
          $('.upgrade.animate .chance-circle-pointer').css({
            '--upgrade-rotate': `${rotate}deg`,
            '--duration-upgrade': `${sound_upgrade_animate.duration}s`
          }).one('animationend', function() {
            if (response.result) {
              audio('/media/audio/sounds/win.mp3');
              updateStatusElement(upgrade, upgrade_status, ['winning', 'win']);
              let skin_win = $(`.upgrade-item.active[data-id=${upgrade_id}]`).clone().attr('data-id', response.skin_win).removeClass('active');
              $('.upgrade-items.skin-inventory').prepend(skin_win);
            } else {
              audio('/media/audio/sounds/fail.mp3');
              updateStatusElement(upgrade, upgrade_status, ['winning', 'fail']);
              $('.upgrade-gun .upgrade-gun-img').attr('src', skin_img_upgrade);
            }
            $('.upgrade-item.active').remove();
          });
        });
      });
    }

    $('.upgrade-button').click(function() {
      if (upgrade.hasClass('active')) {
        upgrade.removeClass('active');
        let skin_id = $('.skin-inventory .upgrade-item.active').attr('data-id');
        let upgrade_id = $('.skin-upgrade .upgrade-item.active').attr('data-id');
        skinUpgrade(skin_id, upgrade_id);
      }
    });

    click('.upgrade.default .skin-inventory .upgrade-item:not(.active), .upgrade.winning .skin-inventory .upgrade-item:not(.active)', function() {
      $('.upgrade-skins-scroll').scrollTop(0);
      let skin_img = $(this).find('.skin-img').attr('src');
      $(this).addClass('active').siblings('.active').removeClass('active');

      $('.upgrade-gun.skin-inventory .upgrade-gun-img').attr('src', skin_img);
      $('.upgrade-gun.skin-upgrade .upgrade-gun-img').attr('src', skin_img_upgrade);
      getSkinsByCostUpgrade(Number($(this).attr('data-cost')));
      updateChanceUpgrade(0);
      updateStatusElement(upgrade, upgrade_status, 'default');
    });

    click('.upgrade.default .skin-upgrade .upgrade-item:not(.active), .upgrade.winning .skin-upgrade .upgrade-item:not(.active)', function() {
      var skin_cost = Number($('.skin-inventory .upgrade-item.active').attr('data-cost'));
      var upgrade_cost = Number($(this).attr('data-cost'));
      if (skin_cost < upgrade_cost) {
        var skin_img = $(this).find('.skin-img').attr('src');
        $(this).addClass('active').siblings('.active').removeClass('active');
        $('.upgrade-gun.skin-upgrade .upgrade-gun-img').attr('src', skin_img);
        if (skin_cost !== undefined && upgrade_cost !== undefined) {
          upgrade.attr('data-chance', skin_cost / upgrade_cost * 100)
          updateChanceUpgrade();
          updateStatusElement(upgrade, upgrade_status, ['default', 'active']);
        } else updateStatusElement(upgrade, upgrade_status, 'default');
      }
    });
  });
</script>