positionUnderline($('.header-container .menu-container'));

// mobile menu
click('.mobile-show', function () {
  $('.mobile-container').addClass('show');
  $(this).toggleClass('active');
});
click('.mobile-show.active', function () {
  $('.mobile-container').removeClass('show');
});

click('.mobile-container.show', function () {
  if (event.target.className.split(' ')[0] == 'mobile-container') {
    $(this).removeClass('show');
    $('.mobile-show').removeClass('active');
  }
});

// modals
click('[data-modal]', function () {
  modal($(this).attr('data-modal'));
});

function modal(modalName) {
  if ($('.modal-container').length === 0) $('<div class="modal-container"><div class="modal"><div class="modal-content"></div></div>').appendTo($('#root'));
  ajax({
    data: {
      do: 'getModal',
      modalName: modalName
    }
  }).then(function (response) {
    $('.modal-container .modal .modal-content').html(isObject(response) ? response.error : response);
  });
}

$(document).on('click', '.modal-container', function () {
  if (in_array(event.target.classList.value, ['modal-container', 'modal-hide'])) {
    $(this).fadeOut(200, function () {
      $(this).remove();
    });
  }
});

// reg, auth
on('input', '.modal .input-container input', function () {
  ($(this).val() !== '') ? $(this).addClass('not-empty') : $(this).removeClass('not-empty');
});

on('input', 'input[data-validate-type]', function () {
  validateInput(event.target);
});
on('keyup', '#signup-input-promo', function () {
  ($(this).val() !== '') ? $(this).attr('required', 'required') : $(this).removeAttr('required');
});
validateTimeout = {};
function validateInput(validateElement) {
  if (typeof validateElement != 'object') return console.error('validateInput: Undefined `validateElement` parameter');
  else if ($(validateElement).length == 0) return console.error('validateInput: Unknown element');
  else if (typeof $(validateElement).data('validate-type') == 'undefined' || $(validateElement).data('validate-type') == '') return console.error('validateInput: Undefined or empty `data-validate-type` attribute');
  else if (validateElement.value == '') return $(validateElement).removeClass('errored').removeClass('validated').parent().find('.error-description').remove();

  if ($(validateElement).attr('id')) {
    validateID = $(validateElement).attr('id');
  } else {
    validateID = Math.random().toString(36).substr(2, 9);
    $(validateElement).attr('id', validateID);
  }

  if (typeof validateTimeout[validateID] != 'undefined') clearTimeout(validateTimeout[validateID]);
  console.log(143);
  validateTimeout[validateID] = setTimeout(function () {
    console.log(323);
    ajax({
      async: false,
      data: {
        do: 'validateInput',
        type: $(validateElement).data('validate-type'),
        text: $(validateElement).val()
      }
    }).then(function (response) {
      $(validateElement).removeClass('errored').removeClass('validated');
      if ('error' in response) {
        $(validateElement).addClass('errored').parent().find('.error-description').remove();
        $(validateElement).parent().append(`<div class="error-description">${response.error}</div>`);
      } else if ('success' in response) $(validateElement).addClass('validated').parent().find('.error-description').remove();
    });
  }, 700);
}

// reg
click('#signup-submit', function () {
  event.preventDefault();
  const form = $('.signin-form');

  $('.modal .error-box').remove();

  const email = $('#signup-input-email');
  if (email.val() == '' || email.hasClass('errored')) return $('<div').addClass('error-box').text('Заполните E-mail').prependTo(form);

  const nickname = $('#signup-input-nickname');
  if (nickname.val() == '' || nickname.hasClass('errored')) return $('<div').addClass('error-box').text('Заполните никнейм').prependTo(form);

  const password = $('#signup-input-password');
  if (password.val() == '' || password.hasClass('errored')) return $('<div').addClass('error-box').text('Заполните пароль').prependTo(form);

  const inviteCodeInput = $('#signup-input-invite-code');

  ajax({
    data: {
      do: 'signup',
      email: email.val(),
      nickname: nickname.val(),
      password: password.val(),
      invitecode: inviteCodeInput.val()
    }
  }).then(function (response) {
    isObject(response) && 'error' in response ? $('<div>').addClass('error-box').text(response.error).prependTo($('.signup-form')) : form.submit();
  });
});
click('#question-invited', function () {
  $('#question-invited').parent().remove();
  $('#invite-code-container').fadeIn('slow');
});

// auth
click('#signin-submit', function () {
  event.preventDefault();
  const form = $('.signin-form');

  $('.modal .error-box').remove();


  const email = $('#signin-input-email').val();
  if (email === '') return $('<div>').addClass('error-box').text('Заполните E-mail').prependTo(form);

  const password = $('#signin-input-password').val();
  if (password === '') return $('<div>').addClass('error-box').text('Заполните пароль').prependTo(form);

  console.log(123);


  ajax({
    data: {
      do: 'signin',
      email: email,
      password: password
    }
  }).then(function (response) {
    (isObject(response) && 'error' in response) ? $('<div>').addClass('error-box').text(response.error).prependTo(form) : form.submit();
  });
});

// livedrop toggler
click('.livedrop-toggle-item:not(.active)', function () {
  $(this).addClass('active').siblings().removeClass('active');
  fillLivedropEmptys();
  stats();
});

// livedrop
function fillLivedropEmptys() {
  $livedropContainer = $('.header-livedrop').empty();
  let $item = $('<li>').addClass('livedrop-item loading').appendTo($livedropContainer);
  for (x = 0; x <= Math.ceil(window.innerWidth / $item.outerWidth()); x++)
    $item.clone().appendTo($livedropContainer);
}
resizeWidth(fillLivedropEmptys);
fillLivedropEmptys();

// online counter, stats, livedrop
setInterval(stats, 5000);
function stats() {
  var offset_id = $('.livedrop-item[data-id]').length > 0 ? Math.max(...$('.livedrop-item[data-id]').map((_, e) => $(e).attr('data-id')).get()) : 0;
  ajax({
    data: {
      do: 'stats',
      offset_id: offset_id,
      limit: Math.ceil(window.innerWidth / $('.livedrop-item').first().outerWidth()),
      livedroptype: $('.livedrop-toggle-item.active').data('type')
    }
  }).then(function (response) {
    if (isObject(response)) {
      // online
      if ('online' in response) $('.header-online-counter').text(response.online).removeClass('loading');
      // counts
      if ('count_users' in response) $('#count-users').removeClass('loading').text(response.count_users.toLocaleString('en-US').replace(/,/g, ' '));
      if ('count_cases' in response) $('#count-cases').removeClass('loading').text(response.count_cases.toLocaleString('en-US').replace(/,/g, ' '));
      if ('count_upgrades' in response) $('#count-upgrades').removeClass('loading').text(response.count_upgrades.toLocaleString('en-US').replace(/,/g, ' '));
      if ('count_contracts' in response) $('#count-contracts').removeClass('loading').text(response.count_contracts.toLocaleString('en-US').replace(/,/g, ' '));

      // livedrop
      if ('livedrop' in response && response.livedrop.length > 0) {
        response.livedrop = response.livedrop.sort((a, b) => a.id - b.id);
        $livedropContainer = $('.header-livedrop');
        $('.livedrop-item.loading').remove();

        var timeAnimate = 5000 / response.livedrop.length;
        if (timeAnimate > 1000) timeAnimate = 1000;
        response.livedrop.forEach((item, key) => {
          var $item = $('<li>').addClass('livedrop-item').attr('data-id', item.id).prependTo($livedropContainer);
          if (offset_id !== 0) {
            $item.addClass('new').css('--duration', `${timeAnimate / 1000}s`);
            setTimeout(() => {
              $item.addClass('animate').one('animationend', function () {
                $livedropContainer.children().last().remove();
              });
            }, timeAnimate * key);
          }
          var $skin = $('<div>').addClass('livedrop-skin skin-item').attr('data-rarity', item.skin_rarity).appendTo($item);
          var $skinImg = $('<img>').addClass('skin-img').attr('src', `/media/image/skins/${item.skin_img}`).appendTo($skin);
          var $skinText = $('<span>').text(item.skin_name).appendTo($skin);
          var $gotfrom = $('<button>').addClass('livedrop-case skin-item').attr({ 'data-rarity': item.skin_rarity, 'data-href': `/user/${item.user_id}` }).appendTo($item);
          switch (item.gotfrom) {
            case 'case':
              var $gotfromImg = $('<img>').attr('src', `/media/image/cases/${item.case_img}`).appendTo($gotfrom);
              var $gotfromText = $('<span>').text(item.case_name).appendTo($gotfrom);
              break;
            case 'upgrade':
              var $gotfromImg = $('<svg class="livedrop-item-svg" fill="var(--color-white)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.943 7.183l-5.595 4.8c-.504.433-1.313.43-1.813-.008l-.81-.71c-.49-.427-.506-1.116-.037-1.561l7.165-6.807c.217-.206.501-.326.796-.356.472-.14 1.016-.033 1.372.312l7.067 6.852c.46.446.44 1.129-.045 1.553l-.81.71c-.504.44-1.32.44-1.823 0l-5.467-4.785zm-.847 3.629a1.068 1.068 0 011.372-.004l4.307 3.768a.773.773 0 010 1.197l-.79.69a1.065 1.065 0 01-1.367 0l-2.834-2.48-2.834 2.48c-.377.331-.99.331-1.367 0l-.79-.69a.773.773 0 010-1.197l4.303-3.764zm.201 6.228a.89.89 0 01.842-.165c.116.033.225.09.318.171l2.095 1.834a.645.645 0 010 .997l-.586.513a.889.889 0 01-1.139 0l-.954-.835-.946.829a.889.889 0 01-1.14 0l-.585-.513a.644.644 0 010-.997l2.095-1.834z"></path></svg>').appendTo($gotfrom);
              var $gotfromText = $('<span>').text('Апгрейд').appendTo($gotfrom);
              break;
            case 'contracts':
              var $gotfromImg = $('<svg class="livedrop-item-svg" fill="var(--color-white)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 26 26"><path d="M22.5676 10.7392L22.1175 10.433C21.6201 10.1033 21.407 9.46735 21.5728 8.90208L21.7149 8.38391C21.9517 7.58312 21.407 6.75876 20.578 6.61745L20.0332 6.52324C19.4411 6.42902 18.9674 5.98152 18.8726 5.3927L18.7779 4.85098C18.6358 4.02663 17.8068 3.50846 17.0015 3.74399L16.4804 3.90886C15.912 4.07373 15.2724 3.86176 14.9409 3.3907L14.6093 2.91964C14.1119 2.23661 13.1408 2.1424 12.5249 2.70767L12.1223 3.08451C11.6723 3.48491 11.0328 3.57912 10.488 3.27294L10.0143 3.01385C9.28004 2.61346 8.35631 2.9432 8.02471 3.72044L7.81155 4.2386C7.59838 4.80387 7.02993 5.15717 6.43779 5.11006L5.89303 5.08651C5.04035 5.0394 4.35348 5.74599 4.42453 6.57034L4.4719 7.11206C4.51927 7.70088 4.16399 8.26615 3.61923 8.50168L3.12184 8.71365C2.34022 9.04339 2.03231 9.96196 2.43496 10.6921L2.71918 11.1632C3.02709 11.6813 2.95604 12.3408 2.55339 12.7883L2.19811 13.1887C1.62966 13.8246 1.74808 14.7903 2.45864 15.2614L2.90867 15.5675C3.40606 15.8973 3.61923 16.5332 3.45343 17.0985L3.24026 17.6402C3.00341 18.441 3.54817 19.2654 4.37716 19.4067L4.92193 19.5009C5.51406 19.5951 5.98777 20.0426 6.08251 20.6314L6.17725 21.1731C6.31937 21.9975 7.14835 22.5157 7.95366 22.2801L8.47474 22.1152C9.04319 21.9504 9.68269 22.1624 10.0143 22.6334L10.3459 23.0809C10.8433 23.764 11.8144 23.8582 12.4302 23.2929L12.8329 22.916C13.2829 22.5156 13.9224 22.4214 14.4671 22.7276L14.9409 22.9867C15.6751 23.3871 16.5988 23.0574 16.9304 22.2801L17.1436 21.762C17.3568 21.1967 17.9252 20.8434 18.5173 20.8905L19.0621 20.9141C19.9148 20.9612 20.6017 20.2546 20.5306 19.4302L20.5069 18.8885C20.4596 18.2997 20.8148 17.7344 21.3596 17.4989L21.857 17.2869C22.6386 16.9572 22.9465 16.0386 22.5439 15.3085L22.2596 14.8374C21.9517 14.3192 22.0228 13.6598 22.4254 13.2123L22.7807 12.8119C23.3729 12.1995 23.2544 11.2103 22.5676 10.7392ZM12.4776 19.6186C8.80633 19.6186 5.82197 16.651 5.82197 13.0003C5.82197 9.34958 8.80633 6.38192 12.4776 6.38192C16.1488 6.38192 19.1332 9.34958 19.1332 13.0003C19.1332 16.651 16.1488 19.6186 12.4776 19.6186ZM16.6225 12.1995L14.7277 13.754L15.2961 16.0857C15.3672 16.439 15.1067 16.7216 14.8224 16.7216C14.7277 16.7216 14.6329 16.6981 14.5619 16.6274L12.4539 15.3556L10.3933 16.6274C10.2985 16.6745 10.2038 16.7216 10.1327 16.7216C9.8248 16.7216 9.56427 16.439 9.65901 16.0857L10.2275 13.754L8.35631 12.1995C8.00103 11.8933 8.2142 11.328 8.66422 11.3045L11.1038 11.1396L12.0275 8.90208C12.1223 8.6901 12.3118 8.59589 12.5013 8.59589C12.6907 8.59589 12.8802 8.6901 12.975 8.90208L13.8987 11.1396L16.3383 11.3045C16.7646 11.328 16.9541 11.8933 16.6225 12.1995Z"></path></svg>').appendTo($gotfrom);
              var $gotfromText = $('<span>').text('Контракт').appendTo($gotfrom);
              break;
          }
        });
      }

      // balance
      if ('balance' in response && 'balance_str' in response) {
        balance = response.balance;
        $('.balance').text(response.balance_str);
        if (typeof renewOpenOrPay != 'undefined' && typeof renewOpenOrPay == 'function') renewOpenOrPay();
      }
    }
  });
}
stats();

// item sell
function sellItem(itemIDs) {
  var success = false;
  $.ajax({
    async: false,
    type: 'POST',
    url: '/core/ajax.php',
    data: {
      do: 'item_sell',
      item_id: itemIDs
    }, success: function (response) {
      response = JSON.parse(response);
      if ('error' in response) {
        toast(response.error, 'error');
      } else if ('balance' in response && 'balance_str' in response) {
        balance = response.balance;
        $('.balance').text(response.balance_str);
        audio('/media/audio/sounds/money.mp3');
        success = true;
      }
    }
  });
  return success;
};

// Скопировать
click('.copy', function () {
  (copyText($(this).children().text())) ? toast('Текст успешно скопирован!', 'success') : toast('Произошла ошибка, обратитесь в техподдержку!', 'error');
});

// пасхалки
/* лого hue-rotate */
$(function () {
  let clickCountLogo = 0;
  let clickTimeoutLogo;

  $('.logo').click(function () {
    clearTimeout(clickTimeoutLogo);
    clickCountLogo++;

    if (clickCountLogo === 5) {
      $(this).addClass('animate--hue-rotate');
      clickCountLogo = 0;
    } else {
      clickTimeoutLogo = setTimeout(function () {
        clickCountLogo = 0;
      }, 500);
    }
  });
});

// Выход из аккаунта / logout
function logout() {
  ajax({
    data: {
      do: 'logout'
    }
  }).then(function () {
    location.reload()
  });
}

click('.logout', logout);

click('.select-header .signup-select', function () {
  $('.sign-container .signup').addClass('active').siblings('.signin.active').removeClass('active');
});
click('.select-header .signin-select', function () {
  $('.sign-container .signin').addClass('active').siblings('.signup.active').removeClass('active');
});

$(function () {
  click('.audio-volume-button', function () {
    if ($(this).hasClass('on')) {
      audioOff();
      $(this).removeClass('on').addClass('off');
      $('.audio-volume-slider').val(0);
    } else {
      audioOn();
      $(this).removeClass('off').addClass('on');
      $('.audio-volume-slider').val(globalVolume * 100);
    }
  });

  var timer_volume_slider;
  $('.audio-volume-button, .audio-volume-slider').mouseenter(function () {
    $(this).parent().addClass('active');
    clearTimeout(timer_volume_slider);
  }).parent().mouseleave(function () {
    timer_volume_slider = setTimeout(() => {
      $(this).removeClass('active');
    }, 500);
  });


  $('.audio-volume-slider').on('input', function () {
    clearTimeout(timer);
    var volume = $(this).val() / 100;
    (setGlobalVolume(volume)) ? ((volume > 0) ? $('.audio-volume-button').removeClass('off').addClass('on') : $('.audio-volume-button').removeClass('on').addClass('off')) : toast('Произошла ошибка, обратитесь в техподдержку!', 'error');
  });

  $('.audio-volume-button').addClass(audioStatus ? 'on' : 'off');
  $('.audio-volume-slider').val(audioStatus ? globalVolume * 100 : 0);
});

/* $(function () {
  var snowflakes = $('#root .event--snowflakes');
  if (snowflakes.length === 0) snowflakes = $('<div>').addClass('event--snowflakes').appendTo($('#root'));
  for (var i = 0; i < 50; i++) {
    $('<img>').addClass('event--snowflake').attr('src', '/media/image/etc/snowflakes.png').css({
      'left': Math.floor(Math.random() * 101) + 'vw',
      'scale': '0.' + (Math.floor(Math.random() * (1000 - 200)) + 200),
      '--left-ini': Math.floor(Math.random() * 21 - 10) + 'vw',
      '--left-end': Math.floor(Math.random() * 21 - 10) + 'vw',
      '--duration': Math.floor(Math.random() * 11 + 10) + 's',
      '--delay': -Math.floor(Math.random() * 11) + 's'
    }).appendTo(snowflakes);
  }
}); */

$(function () {
  setTimeout(function () {
    let update = updates.last;
    let v = update.v;
    let desc = update.desc;

    if (getLocalStorageValue('updateSite') != v && v.split('.').length <= 2) {
      if ($('.modal-container').length == 0) $('#root').append(`<div class="modal-container"><div class="modal"><div class="modal-content"></div></div>`)
      var content = $('.modal-container .modal .modal-content').empty();

      var $updateTitle = $('<div>').addClass('update-title').text(`Обновление ${v}!`).appendTo(content);
      var $updateNew = $('<div>').addClass('update-new').appendTo(content);
      var $updateNewTitle = $('<div>').addClass('update-new-title').html('Что нового:').appendTo($updateNew);
      var $updateNewDesc = $('<ol>').addClass('update-new-desc scroll--white').appendTo($updateNew);

      isObject(desc) ? desc.forEach(text => $('<li>').text(text).appendTo($updateNewDesc)) : $('<li>').text(desc).appendTo($updateNewDesc);

      var $buttons = $('<div>').addClass('flex gap--xs').appendTo(content);
      var $button = $('<button>').addClass('theme-button updatesButton false color--gray flex--shrink').text('Не очень').appendTo($buttons);
      var $button = $('<button>').addClass('theme-button updatesButton true size--w-full').text('Круто').appendTo($buttons);

      click('.updatesButton', function () {
        audio($(this).hasClass('true') ? '/media/audio/sounds/firework.mp3' : '/media/audio/sounds/bruh.mp3');
        $('.modal-container').fadeOut(1000, () => $('.modal-container').remove());
        setLocalStorageValue('updateSite', v);
      });
    }
  }, 5000);
});

click('.settings-theme-item', function () {
  $(this).addClass('active').siblings('.active').removeClass('active');
  const color = $(this).data('color');
  setColor(color);
});

function setColor(color) {
  setLocalStorageValue('color', color);
  $(':root').css({
    '--color': color,
    '--color-80': color + '80',
    '--color-40': color + '40',
    '--color-20': color + '20',
    '--color-10': color + '10',
    '--color-bg': color + '40'
  });
}

$(function () {
  const colorDefault = $(':root').css('--color');
  const color = getLocalStorageValue('color') ?? $('.settings-theme-item.active').data('color') ?? colorDefault;
  $(`.settings-theme-item:not(.active)[data-color="${color}"]`).addClass('active');
  setColor(color);
});

$(function () {
  if (isMobile) {
    var isInputFocused = false;
    on('focus', 'input', function () {
      isInputFocused = true;
      $('.header-wrapper').hide();
      $('.header-info').css('margin-top', '0');
    });

    on('blur', 'input', function () {
      isInputFocused = false;
      setTimeout(function () {
        if (isInputFocused) return;
        $('.header-wrapper').show();
        $('.header-info').removeAttr('style');
      }, 100);
    });
  }
});

