// Хранит тип девайся
const screenWidth = window.innerWidth
const screenHeight = window.innerHeight
const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

// Обновление статусов
function updateStatusElement(element, status_list = [], status = '') {
  if (element.length > 0) element.removeClass(status_list).addClass(status);
  else return false;
  return true;
}

// Проверяет налицие элемента в массиве
function in_array(mixed, array) {
  return array.includes(mixed);
}

// Генерация рандомных чисел
function rand(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

// Выбор рандомного элемента из массива
function arrayRand(array) {
  return array[Math.floor(Math.random() * array.length)];
}

// Массив в строку
function arrayToString(array) {
  return array.join(',');
}

// Строку в массив
function stringToArray(string) {
  return string.split(',');
}

// Округление
function round(num, precision) {
  return parseFloat(Number(num).toFixed(precision));
}

// Проверка является ли параметр строкой
function isString(param) {
  return (typeof (param) === 'string');
}

// Проверка является ли параметр целым числом
function isInt(param) {
  return Number.isInteger(param);
}
// Проверка является ли параметр числом
function isNum(param) {
  return (typeof param === 'number');
}
// Проверка является ли параметр объектом
function isObject(param) {
  return (typeof (param) === 'object');
}
// Проверка является ли строка json
function isJSON(string) {
  if (!isString(string)) return false;
  try {
    JSON.parse(string);
    return true;
  } catch (e) {
    return false;
  }
}

// Строку в bool
function stringToBool(param) {
  if (param === 'true') return true;
  return false;
}

// Текст с ссылкой в html тег
function linkToHTML(text) {
  var linkPattern = /(\S+) (https?:\/\/[^\s]+) \(([^)]+)\)/g;
  return text.replace(linkPattern, '<a href="$1">$3</a>');
}

// Получение значения из localStorage по его имени
function getLocalStorageValue(name) {
  return localStorage.getItem(name);
}

// Удалить значение из localStorage по его имени
function removeLocalStorageValue(name) {
  localStorage.removeItem(name);
}

// Установка значения в localStorage
function setLocalStorageValue(name, value) {
  localStorage.setItem(name, value);
}

// Получение значения куки по её имени
function getCookieValue(cookieName) {
  var name = cookieName + '=';
  var decodedCookie = decodeURIComponent(document.cookie);
  var cookieArray = decodedCookie.split(';');
  for (var i = 0; i < cookieArray.length; i++) {
    var cookie = cookieArray[i];
    while (cookie.charAt(0) == ' ') cookie = cookie.substring(1);
    if (cookie.indexOf(name) == 0) return cookie.substring(name.length, cookie.length);
  }
  return false;
}

// Изменение значения куки по её имени
function setCookieValue(cookieName, value, expires = 10e11) {
  document.cookie = `${cookieName}=${value}; path=/; expires='${expires}`;
}

// Проверка на существование куки по её имени
function issetCookie(cookieName) {
  return document.cookie.split(';').some((item) => item.trim().startsWith(cookieName + '='));
}

// Громкость Audio
let audioStatus = getLocalStorageValue('audioStatus');
audioStatus = (audioStatus) ? stringToBool(audioStatus) : true;
let globalVolume = getLocalStorageValue('audioVolume');
globalVolume = (globalVolume) ? globalVolume : 0.5;

// Включить звук
function audioOn() {
  $('audio').each(function () {
    this.volume = globalVolume;
  });
  setLocalStorageValue('audioStatus', audioStatus = true);
}


// Выключить звук
function audioOff() {
  $('audio').each(function () {
    this.volume = 0;
  });
  setLocalStorageValue('audioStatus', audioStatus = false);
}

// Установать громкость звука
function setGlobalVolume(volume) {
  if (!isNum(volume) || volume > 1 || volume < 0) return false;
  (volume == 0) ? audioOff() : audioOn();
  globalVolume = volume;
  setLocalStorageValue('audioVolume', globalVolume);
  $('audio').each(function () {
    this.volume = globalVolume;
  });
  return true;
}

// Воспроизведение Audio
function audio(path, play = true) {
  var audio = new Audio(path);
  if ($('audio').length > 10) $('audio').slice(0, 5).remove();
  $('#root').append(audio);
  audio.volume = (audioStatus) ? globalVolume : 0;
  if (play) audio.play();
  return audio;
}

doc('navigation', function () {
  $('audio').remove();
});

// Обработка нажатий
function click(selector, callback) {
  var executing = false;
  $(document).off('click', selector).on('click', selector, function () {
    if (!executing) {
      executing = true;
      callback.call(this);
      setTimeout(() => executing = false, 100);
    } else toast('Не так быстро!', 'info');
  });
}

// Обработка событий
function on(event, selector, callback) {
  $(document).off(event, selector).on(event, selector, function () {
    callback.call(this);
  });
}

// Обработка событий документа
function doc(event, callback) {
  $(document).off(event).on(event, function () {
    callback.call(this);
  });
}

// Обработка событий окна
function win(event, callback) {
  $(window).off(event).on(event, function () {
    callback.call(this);
  });
}

// Выполнение при изменении ширины окна
function resizeWidth(callback) {
  let currentWidth = $(window).width();

  $(window).resize(function () {
    if (this.innerWidth !== currentWidth) {
      currentWidth = this.innerWidth;
      callback();
    }
  });
}

// Раставить элементы в круг
function alignItemDrum(item) {
  item.ready(function () {
    let itemCount = item.length;

    let itemWidth = item.outerWidth();
    let itemHeight = item.outerHeight();

    let containerWidth = item.parent().outerWidth();
    let containerHeight = item.parent().outerHeight();

    let radius = Math.min(containerWidth - itemWidth, containerHeight - itemHeight) / 2;
    let centerX = containerWidth / 2;
    let centerY = containerHeight / 2;

    let angle = 2 * Math.PI / itemCount;
    item.each(function (index) {
      let item = $(this);
      let angleRad = angle * (index - 3);

      let x = Math.round(centerX + radius * Math.cos(angleRad)) - itemWidth / 2;
      let y = Math.round(centerY + radius * Math.sin(angleRad)) - itemHeight / 2;

      item.css({
        top: y,
        left: x
      });
    });
  });
}

// toast
function toast(text = '', status = 'error') {
  if ($('.toast-container').length === 0) $('<div>').addClass('toast-container').appendTo($('#root'));

  let isTextRepeated = false;
  $('.toast-body').each(function () {
    if (text == $(this).html()) {
      isTextRepeated = true
      toastRepeated = $(this).closest('.toast');
    }
    return;
  });
  if (isTextRepeated) toastRepeated.attr('data-count', ((toastRepeated.attr('data-count') != undefined) ? Number(toastRepeated.attr('data-count')) + 1 : 2));
  else {
    $('.toast-container').prepend(`<div class="toast ${status}"><div class="toast-body">${text}</div><div class="toast-progressbar"><div class="inner"></div></div></div>`);

    click('.toast', function () {
      $(this).remove();
      if ($('.toast-container').is(':empty')) $('.toast-container').remove();
    });

    on('animationend', '.toast-progressbar .inner', function () {
      $(this).closest('.toast').remove();
      if ($('.toast-container').is(':empty')) $('.toast-container').remove();
    });
  }
}


function ajax(params) {
  return new Promise((resolve, reject) => {
    if (!navigator.onLine) {
      toast('Нет подключения к интернету', 'info');
      reject('Нет подключения к интернету');
      return;
    }

    $.ajax({
      async: params.async || true,
      type: params.type || 'POST',
      url: params.url || '/core/ajax.php',
      data: params.data,
      headers: params.headers || {},
      success: function (response) {
        try {
          resolve(isJSON(response) ? JSON.parse(response) : response);
        } catch (error) {
          reject(`Произошла ошибка при выполнении запроса: ${error}`);
        }
      },
      error: function (xhr, status, error) {
        reject(`Произошла ошибка при выполнении запроса: ${error}`);
      }
    });
  });
}


// Скопировать текст
function copyText(text) {
  try {
    if (text == undefined && text == '') return false;
    var tempTextarea = $('<textarea>');
    $('#root').append(tempTextarea);
    tempTextarea.val(text).select();
    document.execCommand('copy');
    tempTextarea.remove();
  } catch (error) {
    return false;
  }
  return true;
}

// Текст в время за которое его можно прочитать
function calculateReadingTime(text) {
  var wordsPerMinute = 150; // Среднее количество слов, которое пользователь может прочитать за минуту
  var wordCount = text.split(/\s/g).length; // Подсчитываем количество слов в тексте
  var readingTimeInMilliseconds = (wordCount / wordsPerMinute) * 60 * 1000; // Вычисляем время чтения в миллисекундах
  return readingTimeInMilliseconds;
}


// Hint
$(function () {
  var root = $('#root');
  $(document).on('mouseenter', '[data-hint]', function () {
    let text = $(this).attr('data-hint');
    let hint = $('<div>').addClass('hint-text').html(text).appendTo(root);

    let elementTop = $(this).offset().top - root.scrollTop();
    let elementLeft = $(this).offset().left - root.scrollLeft();

    let left = elementLeft - (hint.outerWidth() / 2 - $(this).outerWidth() / 2);
    let top = elementTop - hint.outerHeight() - 10;

    hint.css({
      top: top,
      left: left
    }).fadeIn(150);
    if (isMobile) {
      setTimeout(() => {
        $('.hint-text').fadeOut(150, function () {
          $(this).remove();
        });
      }, calculateReadingTime(text));
    }
  }).on('mouseleave', '[data-hint]', function () {
    $('.hint-text').fadeOut(150, function () {
      $(this).remove();
    });
  });
});

// Секунды в время
function secondsToTime(seconds) {
  return {
    hours: ('0' + Math.floor(seconds / 3600)).slice(-2),
    minutes: ('0' + Math.floor((seconds % 3600) / 60)).slice(-2),
    seconds: ('0' + seconds % 60).slice(-2)
  }
}

// timestamp в дату
function formatDate(timestamp) {
  let date = new Date(timestamp * 1000);
  let day = ('0' + date.getDate()).slice(-2);
  let month = ('0' + date.getMonth() + 1).slice(-2);
  let year = (date.getFullYear().toString());
  return `${day}.${month}.${year}`;
}

// Таймер
function timer(seconds, element) {
  let time = secondsToTime(seconds);

  let $hours = $('<div>').addClass('timer-text hours').text(time.hours);
  let $minutes = $('<div>').addClass('timer-text minutes').text(time.minutes);
  let $seconds = $('<div>').addClass('timer-text seconds').text(time.seconds);

  $(element).append($hours, $minutes, $seconds);

  var interval = setInterval(function () {
    seconds--;
    time = secondsToTime(seconds);
    $hours.text(time.hours);
    $minutes.text(time.minutes);
    $seconds.text(time.seconds);
    if (seconds < 0) clearInterval(interval);
  }, 1000);
  return true;
}

// Расположить линию почёркивания
function positionUnderline(block) {
  let underline = block.children('.underline');
  let elements = block.children(':not(.underline)');
  if (underline.length === 1) {
    underline.show();
    function updateUnderline() {
      let elementActive = elements.filter('.active');
      if (elementActive.length === 0) return;
      $(underline).css({
        'width': elementActive.outerWidth(),
        'left': elementActive.position().left,
      });
    }
    $(document.fonts).on('loadingdone', updateUnderline);
    $(elements).click(function () {
      $(elements).removeClass('active');
      $(this).addClass('active');
      updateUnderline();
    });
    updateUnderline();
  } else underline.hide();
}

function checkPromo(promo, status, callback) {
  ajax({
    data: {
      do: 'checkPromo',
      promo: promo,
      status: status
    }
  }).then(function (response) {
    callback(response);
  });
}