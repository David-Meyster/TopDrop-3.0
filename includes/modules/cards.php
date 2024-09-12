<?php if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden'); ?>

<section>
  <div class="container container--small">
    <div class="cards">
      <div class="cards-body">
        <ul class="cards-items"></ul>
        <div class="cards-menu">
          <div class="flex column gap--xs cards-menu-item">
            <div class="flex gap--xs center--y">
              <svg class="icon--medium" fill="var(--color)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 24 24">
                <path d="M21.47,4.35L20.13,3.79V12.82L22.56,6.96C22.97,5.94 22.5,4.77 21.47,4.35M1.97,8.05L6.93,20C7.24,20.77 7.97,21.24 8.74,21.26C9,21.26 9.27,21.21 9.53,21.1L16.9,18.05C17.65,17.74 18.11,17 18.13,16.26C18.14,16 18.09,15.71 18,15.45L13,3.5C12.71,2.73 11.97,2.26 11.19,2.25C10.93,2.25 10.67,2.31 10.42,2.4L3.06,5.45C2.04,5.87 1.55,7.04 1.97,8.05M18.12,4.25A2,2 0 0,0 16.12,2.25H14.67L18.12,10.59" />
              </svg>
              <div class="font bold h3 uppercase color--theme-text">Кол-во карт</div>
            </div>
            <div class="cards-menu-select flex gap--xs">
              <button class="cards-menu-option theme-button dark" data-x="3">3</button>
              <button class="cards-menu-option theme-button dark" data-x="6">6</button>
              <button class="cards-menu-option theme-button active dark" data-x="8">8</button>
              <button class="cards-menu-option theme-button dark" data-x="9">9</button>
              <button class="cards-menu-option theme-button dark" data-x="10">10</button>
              <button class="cards-menu-option theme-button dark" data-x="12">12</button>
            </div>
            <button class="cards-menu-button generate theme-button dark">Сгененировать</button>
          </div>
          <div class="flex column gap--m cards-menu-item">
            <div class="flex gap--xs center--y">
              <svg class="icon--medium" fill="var(--color)" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 10c3.976 0 8-1.374 8-4s-4.024-4-8-4-8 1.374-8 4 4.024 4 8 4z" />
                <path d="M4 10c0 2.626 4.024 4 8 4s8-1.374 8-4V8c0 2.626-4.024 4-8 4s-8-1.374-8-4v2z" />
                <path d="M4 14c0 2.626 4.024 4 8 4s8-1.374 8-4v-2c0 2.626-4.024 4-8 4s-8-1.374-8-4v2z" />
                <path d="M4 18c0 2.626 4.024 4 8 4s8-1.374 8-4v-2c0 2.626-4.024 4-8 4s-8-1.374-8-4v2z" />
              </svg>
              <div class="font bold h3 uppercase color--theme-text">Сумма ставки</div>
            </div>
            <div class="cards-menu-sum flex">
              <input class="cards-menu-input sum" min="1" type="number" name="" id="">
            </div>
            <div class="cards-menu-select flex gap--xs">
              <button class="cards-menu-option theme-button dark money" data-sum="50">50</button>
              <button class="cards-menu-option theme-button dark money" data-sum="100">100</button>
              <button class="cards-menu-option theme-button dark money" data-sum="200">200</button>
              <button class="cards-menu-option theme-button dark money" data-sum="500">500</button>
            </div>
          </div>
          <button class="cards-menu-button play theme-button">Играть</button>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  var items = $('.cards-items');

  var colors = [{
    x: 0,
    color: '#e84c4c',
    color80: '#90373a',
    color40: '#572b30',
    color20: '#332129',
    color10: '#271d27'
  }, {
    x: 0.1,
    color: '#f18686',
    color80: '#93565c',
    color40: '#553940',
    color20: '#322731',
    color10: '#26202b'
  }, {
    x: 0.5,
    color: '#ef8253',
    color80: '#935441',
    color40: '#593a34',
    color20: '#32272b',
    color10: '#262028'
  }, {
    x: 1,
    color: '#5db4ec',
    color80: '#406f95',
    color40: '#2d485f',
    color20: '#212b3b',
    color10: '#1d2230'
  }, {
    x: 2,
    color: '#ecec5d',
    color80: '#8f8f46',
    color40: '#575837',
    color20: '#32332c',
    color10: '#262628'
  }, {
    x: 3,
    color: '#ec5dd4',
    color80: '#913f87',
    color40: '#582e59',
    color20: '#332139',
    color10: '#271d2f'
  }, {
    x: 5,
    color: '#8d6df8',
    color80: '#5a479b',
    color40: '#3b3363',
    color20: '#26243e',
    color10: '#201e31'
  }, {
    x: 10,
    color: '#53f05b',
    color80: '#3e9245',
    color40: '#2d5a37',
    color20: '#20342d',
    color10: '#1d2628'
  }];

  var countRows = 0;

  function updateGridRows() {
    var item = items.children();
    items.ready(function() {
      var containerWidth = item.outerWidth();

      var minItemWidth = 150;

      countRows = Math.ceil(items.length * minItemWidth / containerWidth);

      items.css('grid-template-rows', `repeat(${countRows}, 1fr)`);
    });
  }

  // Вызовите функцию при загрузке страницы и при изменении размера окна
  $(function() {
    updateGridRows();
  });

  function generateRandColors(count) {
    var colors_less_than_1 = colors.filter(color => color.x < 1);
    var colors_greater_than_1 = colors.filter(color => color.x > 1);

    var result = [];

    for (var i = 0; i < Math.ceil(count / 4); i++) {
      result.push(colors_less_than_1[rand(0, colors_less_than_1.length - 1)]);
      result.push(colors_greater_than_1[rand(0, colors_greater_than_1.length - 1)]);
    }

    var remaining = count - result.length;

    while (remaining > 0) {
      result.push(colors[rand(0, colors.length - 1)]);
      remaining--;
    }

    return result;
  }



  function generateRandCards(cardsCount = 8) {
    $('.cards-menu').css('width', `${250 * (Math.max(...$('.cards-menu-option[data-x]').map((_, e) => $(e).data('x'))) / $('.cards-menu-option.active[data-x]').data('x'))}px`);
    var colorsRand = generateRandColors(Number(cardsCount));
    items.empty();
    for (const c of colorsRand) {
      var item = $('<li>').addClass('cards-item').attr('data-x', c.x,).appendTo(items);
      var itemWrapper = $('<div>').addClass('cards-item-wrapper').appendTo(item);
      var itemInner = $('<div>').addClass('cards-item-inner').appendTo(itemWrapper);
      var cardsX = $('<div>').addClass('cards-item-x').css('font-size', '1rem').text(c.x).appendTo(itemInner);

      var itemWrapper = $('<div>').addClass('cards-item-wrapper info').appendTo(item);
      var itemInner = $('<div>').addClass('cards-item-inner').appendTo(itemWrapper);
      var cardsX = $('<div>').addClass('cards-item-x').css('font-size', '1rem').appendTo(itemInner);

      item.css({
        '--color-card': c.color,
        '--color-card-80': c.color80,
        '--color-card-40': c.color40,
        '--color-card-20': c.color20,
        '--color-card-10': c.color10
      });
    }
    updateGridRows();
  }

  click('.cards-items.animatePlay .cards-item-wrapper.info', function() {
    let $item = $(this).parent();

    var cards = $('.cards-item').get().map(e => ({
      x: Number($(e).attr('data-x')),
      index: $(e).index()
    }));

    ajax({
      data: {
        do: 'createCards',
        cards: cards
      }
    }).then(function(response) {
      if ('error' in response) return toast(response.error, 'error');
      if ('balance' in response && 'balance_str' in response) {
        balance = response.balance;
        $('.balance').text(response.balance_str);
      }
      if ('win' in response) {

        items.removeClass('animatePlay').addClass('animateWinning');
        $item.addClass('active').siblings().first().one('animationend', () => items.removeClass('animateWinning').children('.active').removeClass('active'));

        $item.index();
        $(`.cards-item[data-id=${response.win.id - 1}]`).after($item);
        console.log(response);
      }
    });
  });

  $('.cards-menu-input.sum').on('input', function() {
    $('.cards-menu-option[data-sum]').removeClass('active');
  });

  click('.cards-menu-option[data-x]:not(.active)', function() {
    $(this).addClass('active').siblings('.active').removeClass('active');
    generateRandCards($(this).data('x'));
  });

  click('.cards-menu-option[data-sum]:not(.active)', function() {
    $(this).addClass('active').siblings('.active').removeClass('active');
    $('.cards-menu-input').val($(this).data('sum'));
  });

  generateRandCards($('.cards-menu-option.active').data('x'));
  click('.cards-menu-button.generate', function() {
    generateRandCards($('.cards-menu-option.active').data('x'));
  });
  click('.cards-menu-button.play', function() {
    var sum = $('.cards-menu-input').val();
    if (sum === '') return toast('Введите сумму ставки', 'info')
    if (items.hasClass('animateWinning')) return;
    $('.cards-items').removeClass('animateWinning').addClass('animatePlay');
  });
</script>