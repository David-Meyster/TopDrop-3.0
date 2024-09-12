<?php
if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden');
if ($currentUser->authorized) $currentUser->getInfoPrize();
?>

<div class="flex column gap--distance prize">
  <div class="modal-header">
    <div class="modal-title">Ежедневные призы</div>
    <div class="modal-hide"></div>
  </div>
  <div class="flex gap--inherit size--w-full prize-content">
    <?php if ($currentUser->authorized) { ?>
      <div class="prize__block">
        <?php if ($currentUser->prize_lvl < $currentUser->prize_max_lvl) { ?>
          <div class="prize__content-level"><?= $currentUser->prize_lvl; ?></div>
        <?php } else { ?>
          <div class="prize__content-level max">Max</div>
        <?php } ?>
        <div class="prize__xp">
          <div class="prize__xp-header">
            <div class="prize__xp-title">Очки</div>
            <div class="prize__xp-points">
              <span class="prize__xp-min"><?= $currentUser->prize_xp_lvl; ?></span>
              <span class="prize__xp-max"><?= $currentUser->prize_xp_next_lvl; ?></span>
            </div>
          </div>
          <div class="prize__xp-progress-bar">
            <div class="prize__xp-progress" style="width: <?= $currentUser->prize_percent_lvl; ?>%;"></div>
          </div>
        </div>
        <div class="prize__content-desc">Открывайте кейсы для получения очков опыта и повышения уровня</div>
      </div>
      <div class="prize__block">
        <div class="prize__content-title">Ваш ежедневный бонус</div>
        <div class="prize__content-val"><?= $currentUser->prize_sum; ?> ₽</div>
        <?php if ($currentUser->prize_status) { ?>
          <button class="prize-button" id="take_prize">Забрать</button>
        <?php } else { ?>
          <div class="prize-timer"></div>
        <?php } ?>
        <div class="prize__content-desc">Повышайте уровень для<br>увеличения бонуса</div>
      </div>
    <?php } else { ?>
      <div class="prize__block">
        <div class="flex column gap--l">
          <div class="font h4 font--600 uppercase">Пройдите авторизацию</div>
          <button class="flex center size--w-full h4 button color--theme font uppercase bold" data-modal="sign">Войти</button>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="flex gap--xs">
    <div class="flex size--w-full color--gray-secondary container--distance radius--m">
      <ul class="prize__everyday-items">
        <?php for ($i = 0; $i < 9; $i++) { ?>
          <li class="prize__everyday-item <?= ($currentUser->authorized) ? $currentUser->prize_class_day[$i] : null; ?>">
            <div class="font bold h4"><?= $i + 1; ?></div>
          </li>
        <?php } ?>
      </ul>
    </div>
    <div class="color--gray-secondary container--distance radius--m">
      <div class="prize-grand-container <?= ($currentUser->authorized && $currentUser->prize_day == 10) ? 'animate--hue-rotate' : null; ?>">
        <div class="font prize-grand">X10</div>
        <div class="font prize-grand-desc">Мегаприз</div>
      </div>
    </div>
  </div>
  <div class="prize-footer flex gap--inherit">
    <div class="flex center size--w-full color--gray-secondary container--distance radius--m">
      <div class="prize-day-progress-bar">
        <div class="prize-day-progress" style="--i: <?= ($currentUser->authorized) ? $currentUser->prize_percent_next_day : 0; ?>%;"></div>
        <div class="prize-day-title"><?= ($currentUser->authorized) ? 'День&nbsp;' . $currentUser->prize_day : 'Вы не авторизованы'; ?></div>
      </div>
    </div>
    <div class="color--gray-secondary container--distance radius--m prize-everyday-desc">
      <div class="font">В течение 9 дней ежедневно получай бонусы и на 10 день получи бонус в десятикратном размере!</div>
      <div class="font">Когда шкала дойдёт до конца, вы получите бонус X10</div>
    </div>
  </div>
</div>
<?php if ($currentUser->authorized) { ?>
  <script>
    timer(<?= $currentUser->prize_seconds_get_prize; ?>, $('.prize-timer'));
    var isset;
    /* Prize sound notes */
    function setPrize() {
      // Получить приз / Take prize
      click('#take_prize', function() {
        ajax({
          data: {
            do: 'take_prize'
          },
        }).then(function(response) {
          if (isObject(response) && 'error' in response) return toast(response.error, 'info');
          modal('prize');
        });
      });

      function animatePrizeEl(element) {
        element.removeClass('animate');
        setTimeout(function() {
          element.addClass('animate').one('animationend', function() {
            $(this).removeClass('animate');
          });
        }, 0);
      }

      function musicPrize() {
        let clickCountDayPrize = 0;
        let clickTimeoutDayPrize;
        click('.prize__everyday-item', function() {
          clearTimeout(clickTimeoutDayPrize);
          clickCountDayPrize++;
          audio(`/media/audio/notes/notes${$(this).index() + 1}.mp3`);
          animatePrizeEl($(this));

          if (clickCountDayPrize === 10) {
            $.ajax({
              url: '/media/audio/music',
              success: function(data) {
                var $files = $($.parseHTML(data)).find('a');

                var fileNames = $files.map(function() {
                  return $(this).text();
                }).get();

                var randomIndex = Math.floor(Math.random() * fileNames.length);
                file = fileNames[randomIndex].trim();
                var music = audio(`/media/audio/music/${file}`);
                var interval = setInterval(function() {
                  var randomElements = $('.prize__everyday-item').get().sort(function() {
                    return 0.5 - Math.random();
                  }).slice(0, Math.floor(Math.random() * 3) + 1);
                  randomElements.forEach(element => {
                    animatePrizeEl($(element));
                  });
                }, 200)
                $(music).on('ended', function() {
                  clearInterval(interval);
                });
              }
            });
            clickCountDayPrize = 0;
          } else {
            clickTimeoutDayPrize = setTimeout(function() {
              clickCountDayPrize = 0;
            }, 500);
          }
        });
        doc('keydown', function() {
          if ($('.prize__everyday-item').length > 0) {
            var allowedKeys = [49, 50, 51, 52, 53, 54, 55, 56, 57];
            if (allowedKeys.includes(event.keyCode)) {
              var pressedKey = String.fromCharCode(event.keyCode);
              let element = $('.prize__everyday-item').eq(Number(pressedKey - 1));
              animatePrizeEl(element);
              audio(`/media/audio/notes/notes${Number(pressedKey) + 1}.mp3`);
            }
          }
        });
      }
      musicPrize();
      isset = true;
    }
    if (isset !== true) setPrize();
  </script>
<?php } ?>
