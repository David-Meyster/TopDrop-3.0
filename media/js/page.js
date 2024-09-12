let main = $('#main');
let loadingPageElement = $(`
<div class="loading-page">
  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="85" height="100" fill="#09f">
    <polygon points="40 0, 40 45, 0 70, 0 25" />
    <polygon points="45 0, 45 45, 85 70, 85 25" />
    <polygon points="42.5 50, 82.5 75, 42.5 100, 2.5 75" />
  </svg>
</div>`);

main.prepend(loadingPageElement);

function setStatusLoadPage(status = true) {
  if (status) {
    if (loadingPageElement.parent().length === 0) main.prepend(loadingPageElement);
    main.children().hide()
    loadingPageElement.show();
  } else {
    main.children().show()
    loadingPageElement.hide();
  }
}

setStatusLoadPage(true);
$(() => setStatusLoadPage(false));

function getMain(path) {
  setStatusLoadPage(true);
  ajax({
    data: {
      do: 'parse_main',
      path: path
    }
  }).then(function (response) {
    main.html(response.main);
    $(document).trigger('navigation');
    setStatusLoadPage(true);
    window.history.pushState(null, '', response.path);
    $(() => setStatusLoadPage(false));
  });
}

win('popstate', function () {
  let path = window.location.pathname;
  getMain(path);
});

click('button[data-href]', function () {
  let path = $(this).data('href');
  if (path != window.location.pathname) getMain(path);
  if ($('.modal-container').length > 0) $('.modal-container').remove();
});

/* function isInViewport(element) {
  var rect = element[0].getBoundingClientRect();
  return (
    rect.bottom >= 0 &&
    rect.right >= 0 &&
    rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.left <= (window.innerWidth || document.documentElement.clientWidth)
  );
}
function lazyLoadImages() {
  $('[data-src]').each(function () {
    if (isInViewport($(this)) && !$(this).data('loaded')) {
      $(this).attr('src', $(this).attr('data-src'));
      $(this).data('loaded', true); // Устанавливаем атрибут, чтобы изображение не загружалось повторно
    }
  });
}
$(() => setInterval(lazyLoadImages, 200)); */
/* 
$(function () {
  $('img').each(function () {
    $(this).on('load', function () {
      $(this).siblings('.case-img.placeholder').remove();
    });
  });
});
 */


/* win('scroll', lazyLoadImages); */
