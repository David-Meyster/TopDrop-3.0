<?php
if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden');

$cases = new Cases;

$obj = $cases->getOne($page->subaction);

$case = $obj['case'];
$skins = $obj['skins'];

/* function calculateChances($costOpen, $skins)
{
  $numMin = min(array_column($skins, 'cost'));
  $numMax = max(array_column($skins, 'cost'));
  $diff = $numMax - $numMin;
  foreach ($skins as &$skin) {
    $skin['chance'] = max(0, min(1, (1 - abs(($costOpen - $skin['cost']) / $diff))));
  }

  $totalChance = array_sum(array_column($skins, 'chance'));

  if ($totalChance > 0) {
    foreach ($skins as &$skin) {
      $skin['chance'] = ($skin['chance'] / $totalChance) * 100;
    }
  }

  return $skins;
}

$skins = calculateChances($case['cost'], $skins); */

if ($currentUser->authorized) {
  // Если кейс открывается раз в определённое время, узнаём, может ли его открыть текущий пользователь
  $isTimerCase = 0;
  if (!empty($case['one_open_per']) && $case['one_open_per'] > 0) {
    $isTimerCase = 1;
    $lastOpen = isset($currentUser->casesLastOpen[$case['title']]) ? $currentUser->casesLastOpen[$case['title']] : 0;
    $timerRemains = $case['one_open_per'] - (time() - $lastOpen); // Если $timerRemains > 0, значит прошло времени менее $case['one_open_per']
  }
  // Если кейс даётся за подписку на что-то - создаём переменные, чтоб формировать ссылки на странице
  switch ($case['title']) {
    case 'free_vk':
      $isSubscribeCase = true;
      $subscribeURL = 'https://vk.com/topdrop_case'; // ссылка на то, на что пользователю нужно будет подписаться
      $subscribeCookie = 'subscribed_vk'; // кука, по которой проверяем, подписывался ли пользователь
      break;
    case 'free_youtube':
      $isSubscribeCase = true;
      $subscribeURL = 'https://youtube.com/@topdrop_case';
      $subscribeCookie = 'subscribed_youtube';
      break;
    case 'free_telegram':
      $isSubscribeCase = true;
      $subscribeURL = 'https://t.me/topdrop_case';
      $subscribeCookie = 'subscribed_telegram';
      break;
    default:
      $isSubscribeCase = false;
      // Проверяем, есть ли у пользователя в инвентаре не открытые кейсы, которые он мог бы открыть сейчас
  }

  $countCasesFromInventory = $db->safeQuery("SELECT COUNT(*) FROM `inventory` WHERE `type` = 'case' AND `status` = '1' AND `user_id` = ? AND `item_id` = ?", [$currentUser->id, $case['id']])->fetch_column();
}
?>

<svg xmlns="http://www.w3.org/2000/svg" width="0" height="0">
  <filter x="0" y="0" width="100%" height="100%" id="blurFilterSkin">
    <feGaussianBlur in="SourceGraphic" stdDeviation="50" />
  </filter>
</svg>

<div class="case">
  <img class="case-img-bg" src="/media/image/cases/<?= $case['img']; ?>" alt="<?= $case['name']; ?>">
  <div class="container container--small case-container">
    <div class="case-header">
      <button class="case-back-button size button font uppercase bold decoration--none gap--none" title="Вернуться назад" data-href="/">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon--big" viewBox="0 0 24 24" fill="#aeb6c2">
          <path d="M15.001 8.115a.997.997 0 0 0-1.412-1.41l-4.587 4.588a1 1 0 0 0 0 1.414l4.588 4.588a.998.998 0 0 0 1.412-1.41L11.124 12l3.876-3.885Z"></path>
        </svg>
      </button>
      <h2 class="case-name"><?= $case['name']; ?></h2>
    </div>
    <div class="case-content">
      <div class="case-img-container">
        <img src="/media/image/cases/<?= $case['img']; ?>" class="case-img" alt="<?= $case['name']; ?>">
      </div>
    </div>
    <div class="case-control">
      <?php if (!$currentUser->authorized) { ?>
        <div class="case-not-authorized flex gap--s">
          <div class="theme-button color--red container--xxl">Вы не авторизованы</div>
          <button class="theme-button container--xxl size--h-auto" data-modal="sign">Войти</button>
        </div>
      <?php } else if ($isSubscribeCase && !isset($_COOKIE[$subscribeCookie])) { ?>
        <div class="font h6 color--primary-text">Подпишитесь, чтобы открыть кейс</div>
        <button class="case-subscribe-button theme-button container--xxl" data-subscribe-cookie="<?= $subscribeCookie; ?>" data-subscribe-url="<?= $subscribeURL; ?>">Подписаться</button>
      <?php } else { ?>
        <div class="case-timer-content">
          <div class="font h5">Можно открыть через:</div>
          <div class="case-timer"></div>
        </div>
        <div class="size exist-cases-in-inventory theme-button container--xxl">Кейсов в инвентаре:&nbsp;<span></span></div>
        <div class="case-open flex gap--inherit">
          <button class="case-open-button theme-button container--xxl" title="Открыть кейс">Открыть за&nbsp;<span class="money"><?= $case['cost'] - ($case['cost'] * $countCasesFromInventory); ?></span></button>
          <button class="case-open-button theme-button container--xxl fast" title="Открыть быстро">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon--big position--absolute" fill="var(--color-gray-light)" viewBox="0 0 64 64">
              <path d="M28.371,31.879c0,2.19,1.777,3.966,3.966,3.966c1.538,0,2.856-0.884,3.514-2.163l0.011,0.01l7.24-13.062l-12.71,7.794   l0.012,0.012C29.197,29.117,28.371,30.395,28.371,31.879z"></path>
              <path d="M48.315,12.981C44.251,9.429,39,7.161,33,6.822v6.027c5,0.318,7.946,1.906,10.904,4.384L48.315,12.981z"></path>
              <path d="M51.146,30h6.02c-0.404-6-2.751-10.93-6.395-14.97l-4.259,4.233C49.078,22.203,50.766,26,51.146,30z"></path>
              <path d="M51.174,33c-0.637,10-8.922,17.931-19.042,17.931c-10.535,0-19.421-8.544-19.421-19.078C12.711,21.825,21,13.62,30,12.85   V6.823C17,7.602,6.711,18.54,6.711,31.879c0,13.843,11.42,25.052,25.263,25.052C45.406,56.931,56.564,46,57.205,33H51.174z"></path>
            </svg>
          </button>
        </div>
        <div class="case-factor">
          <button class="button case-factor-option select active" data-factor="1" title="Открыть 1 кейс">x1</button>
          <button class="button case-factor-option select" data-factor="2" title="Открыть 2 кейса">x2</button>
          <button class="button case-factor-option select" data-factor="3" title="Открыть 3 кейса">x3</button>
          <button class="button case-factor-option select" data-factor="4" title="Открыть 4 кейса">x4</button>
          <button class="button case-factor-option select" data-factor="5" title="Открыть 5 кейсов">x5</button>
        </div>
        <div class="case-not_money flex gap--inherit">
          <div class="size case-not_money-desc font--nowrap theme-button color--red size--h-auto container--xxl">Не хватает&nbsp;<span class="money user-select--text"></span></div>
          <button class="size theme-button color--green size--h-auto container--xxl gap--xs font--nowrap" data-modal="pay">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon--small" viewBox="0 0 32 32">
              <path d="m30 24v2.5c0 1.379-1.122 2.5-2.5 2.5h-21.5c-2.206 0-4-1.794-4-4 0 0 0-16.985 0-17 0-2.206 1.794-4 4-4h18.5c.829 0 1.5.672 1.5 1.5s-.671 1.5-1.5 1.5h-18.5c-.551 0-1 .448-1 1s.449 1 1 1h21.5c1.378 0 2.5 1.121 2.5 2.5v2.5h-5c-2.757 0-5 2.243-5 5s2.243 5 5 5z"></path>
              <path d="m30 16v6h-5c-1.657 0-3-1.343-3-3s1.343-3 3-3z"></path>
            </svg>
            <div>Пополнить</div>
          </button>
        </div>
        <div class="case-loading flex gap--inherit">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="case-winning flex gap--inherit">
          <button class="case-again-button theme-button size--h-auto container--xxl font--nowrap">Ещё раз</button>
          <button class="case-sell-all-button theme-button container--xxl color--green-primary item-sell">Продать всё</button>
        </div>
      <?php } ?>
    </div>
  </div>
  <section class="case-skins-wrapper">
    <div class="font font--h bold uppercase h2" style="padding-bottom: calc(var(--distance-xl) * 1.5);">Скины</div>
    <div class="container container--small">
      <ul class="skin-items">
        <?php foreach ($skins as $skin) { ?>
          <li class="skin-item hover" data-rarity="<?= $skin['rarity']; ?>">
            <img class="skin-img" src="/media/image/skins/<?= $skin['img']; ?>" alt="<?= $skin['title']; ?> | <?= $skin['name']; ?>">
            <div class="skin-info">
              <div class="skin-title"><?= $skin['title']; ?></div>
              <div class="skin-name"><?= $skin['name']; ?></div>
            </div>
            <div class="skin-cost money"><?= round($skin['cost'], 2); ?></div>
            <!-- <div class="skin-chance"><?= round($skin['chance'], 3); ?>%</div> -->
          </li>
        <?php } ?>
      </ul>
    </div>
  </section>
</div>

<?php if ($currentUser->authorized) { ?>
  <script>
    var caseElement = $('.case');

    var case_title = '<?= $case['title'] ?>';
    var case_cost = <?= $case['cost']; ?>;
    var case_img = $('.case .case-img-container').clone();
    var casesInInventory = <?= $countCasesFromInventory; ?>;
    var factor = 1;

    var skins = <?= json_encode($skins); ?>;

    balance = <?= $currentUser->balance; ?>;

    var isTimerCase = <?= $isTimerCase; ?>;
    var timerRemains = <?= isset($timerRemains) ? $timerRemains : 0; ?>;

    $(function() {
      function calcOpenableCases() {
        count_cases_opened_free = (casesInInventory > factor) ? factor : casesInInventory;
        open_cost = round(case_cost * (factor - count_cases_opened_free), 2);
        count_openable_cases = Math.floor(balance / case_cost) + casesInInventory;
      }

      function updateStatusCase(status = '', element = caseElement, list = ['default', 'not_money', 'animate', 'winning', 'timer', 'fast']) {
        updateStatusElement(element, list, status);
        if (status == 'default' || status.includes('default')) {
          if (!isTimerCase) {
            calcOpenableCases()
            $('.exist-cases-in-inventory').toggle(casesInInventory > 0).children('span').text(casesInInventory);
            $('.case.default .case-factor-option').each(function() {
              $(this).attr('disabled', ($(this).data('factor') > count_openable_cases) ? true : false);
            });
            var lastActiveOption = $('.case-factor-option:not(:disabled)').last();
            if ($('.case-factor-option.active:disabled').length > 0) {
              $('.case-factor-option').removeClass('active');
              lastActiveOption.addClass('active');
              factor = lastActiveOption.data('factor');
              calcOpenableCases();
            }

            $('.case.default .case-content').empty().append(Array(factor).fill().map(() => case_img.clone()));
            $('.case.default .case-open-button:not(.fast) .money').text(open_cost);
            if (count_openable_cases <= 0) {
              updateStatusElement(element, list, 'not_money');
              $('.case.not_money .case-not_money-desc .money').text(round((case_cost - balance), 2));
            }
          } else {
            $('.case.default .case-content').empty().append(case_img.clone());
            if (timerRemains > 0) {
              timer(timerRemains, $('.case-timer'));
              updateStatusElement(element, list, 'timer');
            } else {
              $('.case.default .case-open-button:not(.fast)').text('Открыть');
              updateStatusElement(element, list, ['default', 'open_one']);
            }
          }
        }
      }
      updateStatusCase('default');

      click('.case.default .case-factor .case-factor-option:not(.active):not(:disabled)', function() {
        $(this).addClass('active').siblings('.active').removeClass('active');
        factor = $(this).data('factor');
        updateStatusCase('default');
      });

      // free cases
      click('.case-subscribe-button', function() {
        var subscribeURL = $(this).data('subscribe-url');
        var subscribeCookie = $(this).data('subscribe-cookie');
        window.open(subscribeURL, '_blank');
        setTimeout(function() {
          setCookieValue(subscribeCookie, true);
          location.reload()
        }, 10000);
      });

      // open case
      click('.case.default .case-open-button', function() {
        var isFastOpen = $(this).hasClass('fast');
        updateStatusCase(isFastOpen ? ['animate', 'fast'] : 'animate');
        ajax({
          data: {
            do: 'case_open',
            case: case_title,
            factor: factor
          }
        }).then(function(response) {
          if ('error' in response) {
            toast(response.error, 'error');
            console.error(response.error);
            updateStatusCase('default');
            return;
          }
          if ('balance' in response && 'balance_str' in response) {
            balance = response.balance;
            $('.balance').text(response.balance_str);
          }
          if ('dropped' in response) {

            var soundCaseOpen = audio(`/media/audio/sounds/${isFastOpen ? 'case-open-fast' : 'case-open'}.mp3`, false);

            soundCaseOpen.addEventListener('loadedmetadata', function() {
              $(':root').css('--case-duration', `${soundCaseOpen.duration * 1.1}s`);

              var caseOpenContainer = $('<div>').addClass(`case-open-container ${response.roulette_type}`);
              var caseOpenPointer = $('<svg class="case-open-pointer" xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="var(--color)"><path d="M11.6368 1.22721C10.553 1.40783 9.44687 1.40862 8.36285 1.22954L2.47238 0.256424C0.757494 -0.0268788 -0.477626 1.86144 0.469138 3.31908L8.32593 15.4155C9.11489 16.6302 10.8933 16.6295 11.6813 15.4141L19.5317 3.30674C20.4777 1.84784 19.2399 -0.0399807 17.5248 0.245866L11.6368 1.22721Z"/></svg>');
              var caseOpenWrapper = $('<div>').addClass('case-open-wrapper');
              caseOpenContainer.append(caseOpenPointer, caseOpenPointer.clone(), caseOpenWrapper);

              var skinsWinId = [];
              var skinsWinCost = 0;
              $('.case.animate .case-content').html(caseOpenContainer);
              var count_item = (isFastOpen) ? 20 : 55;
              response.dropped.forEach(function(drop) { // Распределяем количество прокрутов
                var randomSkins = [];
                for (var x = 0; x < count_item; x++) randomSkins.push(skins[x % skins.length]);
                randomSkins.sort(() => {
                  return 0.5 - Math.random();
                });

                win_index = (response.roulette_type == 'roulette') ? count_item - 5 : count_item - 2; // Определяем где будет нахрдится выигрышный предмет
                randomSkins[win_index] = drop;
                var caseOpenInner = $('<div>').addClass('case-open-inner');
                var caseOpenItems = $('<ul>').addClass('case-open-items');
                randomSkins.forEach(function(skin, x) { // Распределяем скины
                  var caseOpenItem = $('<li>').addClass(`case-open-item skin-item ${(x === win_index) ? 'win' : ''}`).attr('data-rarity', skin.rarity).appendTo(caseOpenItems);
                  var skinImg = $('<img>').addClass('skin-img').attr('src', `/media/image/skins/${skin.img}`).appendTo(caseOpenItem);
                  var skinInfo = $('<div>').addClass('skin-info').appendTo(caseOpenItem);
                  var skinTitle = $('<div>').addClass('skin-title').text(skin.title).appendTo(skinInfo);
                  var skinName = $('<div>').addClass('skin-name').text(skin.name).appendTo(skinInfo);
                  if (x === win_index) {
                    var caseOpenCost = $('<div>').addClass('case-open-cost skin-cost money').text(round(skin.cost, 2)).appendTo(caseOpenItem);
                    var sellButton = $('<button>').addClass('case-open-sell-button skin-sell button item-sell').attr('data-id', skin.insert_id).text('Продать').appendTo(caseOpenItem);
                    skinsWinId.push(skin.insert_id);
                    skinsWinCost += Number(skin.cost);
                    caseOpenItemWin = caseOpenItem;
                  }
                });
                caseOpenInner.html(caseOpenItems);
                caseOpenWrapper.append(caseOpenInner)

                function calcDistance() {
                  if (response.roulette_type == 'roulette') {
                    var container_size = caseOpenWrapper.width();
                    var win_size = caseOpenItemWin.width();
                    var win_offset = caseOpenItemWin.position().left;
                  } else {
                    var container_size = caseOpenWrapper.height();
                    var win_size = caseOpenItemWin.height();
                    var win_offset = caseOpenItemWin.position().top;
                  }
                  let win_rand = rand(1, win_size);
                  caseOpenItems.css({
                    '--roulette-distance': `-${((win_offset - container_size / 2) + (win_size / 2))}px`,
                    '--roulette-distance-rand': `-${(win_offset - container_size / 2) + win_rand}px`
                  });
                }
                $(window).resize(calcDistance);
                calcDistance();

                soundCaseOpen.play();
              });
              $('.case-control .case-sell-all-button').data('id', arrayToString(skinsWinId)).text(`Продать за ${round(skinsWinCost, 2)} ₽`);

              on('animationend', '.case-open-items', function() {
                $(this).children('.case-open-item.win').find('.case-open-cost, .case-open-sell-button').animate({
                  opacity: 1
                }, 300);
              });

              caseOpenContainer.one('animationend', function() {
                audio('/media/audio/sounds/case-open-end.mp3');
                updateStatusCase('winning');
                casesInInventory = response.casesLeft;
              });
            });
          }
          if ('next_open_in' in response) timerRemains = response.next_open_in;
        });
      });

      click('.case.winning .case-again-button', () => updateStatusCase('default'));

      // item sell
      click('.case-open-item.win .item-sell', function() {
        if (sellItem($(this).data('id'))) {
          if ($('.case-open-inner').length <= 1) updateStatusCase('default');
          else {
            $(this).closest('.case-open-inner').remove();
            var sum = round($('.case-open-item.win .case-open-cost').get().reduce((acc, el) => acc + Number($(el).text()), 0), 2);
            var skins_id = arrayToString($('.case-open-item.win .case-open-sell-button').map((index, element) => $(element).data('id')).get());
            $('.case-control .case-sell-all-button').text(`Продать за ${sum} ₽`).data('id', skins_id);
          }
        }
      });

      // all items sell
      click('.case-control .case-sell-all-button', function() {
        if (sellItem($(this).data('id'))) updateStatusCase('default');
      });
    });
  </script>
<?php } ?>