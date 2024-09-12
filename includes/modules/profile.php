<?php
if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden');

$user = $page->subaction == $currentUser->id || $page->subaction === null ? new OtherUser($currentUser->id) :  new OtherUser($page->subaction);
$user->count();
$user->secondaryUserData();

$inventory = $user->getInventory();
?>

<section>
  <div class="container container--small">
    <div class="profile-header flex gap--inherit size--full">
      <div class="flex column color--primary container--distance center--x">
        <?php if ($user->id === $currentUser->id) { ?>
          <div class="flex gap--xs between">
            <div class="size flex center--y gap--inherit">
              <input id="fileAvatar" type="file" accept="image/jpeg, image/png" require style="display: none;">
              <label for="fileAvatar">
                <div class="user--avatar effect--hover-dark">
                  <img src="/media/avatar/<?= $currentUser->avatar; ?>" alt="Аватарка">
                </div>
              </label>
              <div class="flex column center--x size--h-full">
                <div class="flex center--y gap--s">
                  <div class="font h4 bold uppercase"><?= $currentUser->name; ?></div>
                  <button class="flex center color--gray radius--s padding--s font font--600 h6 copy">ID&nbsp;<span class="font"><?= $currentUser->id; ?></span></button>
                </div>
                <div class="balance font h4 bold"><?= $currentUser->balance_str; ?></div>
              </div>
            </div>
            <button class="logout size radius--m button size--content color--red square effect--hover">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon--small" viewBox="0 0 24 24" fill="var(--color-gray-light)">
                <path d="M15 13a1 1 0 00-1 1v4a1 1 0 01-1 1h-3V4c0-.854-.544-1.617-1.362-1.901l-.296-.1H13c.552 0 1 .45 1 1.001v3a1 1 0 102 0V3c0-1.654-1.346-3-3-3H2.25c-.038 0-.07.017-.107.022C2.095.018 2.049 0 2 0 .897 0 0 .897 0 2v18c0 .854.544 1.617 1.362 1.9l6.018 2.007c.204.063.407.093.62.093 1.103 0 2-.897 2-2v-1h3c1.654 0 3-1.346 3-3v-4a1 1 0 00-1-1z"></path>
                <path d="M23.707 9.293l-4-4A1 1 0 0018 6v3h-4a1 1 0 000 2h4v3a1 1 0 001.707.707l4-4a.999.999 0 000-1.414z"></path>
              </svg>
            </button>
          </div>
          <div class="profile-header-buttons flex gap--s">
            <button class="size button color--green size--w-full" data-modal="pay">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon--small" viewBox="0 0 32 32">
                <path d="m30 24v2.5c0 1.379-1.122 2.5-2.5 2.5h-21.5c-2.206 0-4-1.794-4-4 0 0 0-16.985 0-17 0-2.206 1.794-4 4-4h18.5c.829 0 1.5.672 1.5 1.5s-.671 1.5-1.5 1.5h-18.5c-.551 0-1 .448-1 1s.449 1 1 1h21.5c1.378 0 2.5 1.121 2.5 2.5v2.5h-5c-2.757 0-5 2.243-5 5s2.243 5 5 5z"></path>
                <path d="m30 16v6h-5c-1.657 0-3-1.343-3-3s1.343-3 3-3z"></path>
              </svg>
              <span class="font h5 bold uppercase">Пополнить</span>
            </button>
            <button class="promo size radius--m flex center color--gray-border dashed font font--600 h5 button copy size--w-full nowrap" data-hint="Поделись инвайт-кодом с другом, и получай <span class='color--green-text'><?= $config['referral_promo_bonus'] * 100; ?>%</span> от суммы его пополнения! Другу нужно указать этот код при регистрации учётной записи и он получит <span class='color--green-text'>+<?= $config['invited_bonus'] * 100; ?>%</span> ко всем пополнениям.">Инвайт-код:<span class="font--700"><?= $currentUser->refCode; ?></span></button>
          </div>
          <?php if ($currentUser->invitedBy !== null) : $referralUser = new OtherUser($currentUser->invitedBy); ?>
            <div>
              <button data-href="/user/<?= $referralUser->id; ?>" class="invited-by size radius--m flex center color--gray-border button size--w-full" data-hint="Игрок, пригласивший вас на сайт">
                <div>
                  <div class="caption">Вас пригласил:</div>
                  <div class="font h6 uppercase"><?= $referralUser->name; ?></div>
                </div>
                <img src="/media/avatar/<?= $referralUser->avatar; ?>">
              </button>
            </div>
          <?php endif; ?>
        <?php } else { ?>
          <div class="flex center gap--l size--full container--xxl">
            <div class="user--avatar cursor--default">
              <img src="/media/avatar/<?= $user->avatar; ?>" alt="Аватарка">
            </div>
            <div class="font h2 bold uppercase"><?= $user->name; ?></div>
          </div>
        <?php } ?>
      </div>

      <div class="flex gap--xxs">
        <div class="profile-favorite flex column between container--distance position--relative color--primary overflow--hidden">
          <div class="font h4 bold uppercase center color--primary-text">Любимый кейс</div>
          <img class="profile-favorite-img profile-favorite-img-bg" src="/media/image/cases/<?= $user->favorite['img'] ?? 'placeholder.webp'; ?>" alt="">
          <img class="profile-favorite-img" src="/media/image/cases/<?= $user->favorite['img'] ?? 'placeholder.webp'; ?>" alt="">
          <div class="font h5 font--600 font--shadow center"><?= $user->favorite['name'] ?? 'Пусто'; ?></div>
        </div>
        <div class="profile-topdrop flex column between container--distance position--relative color--primary overflow--hidden skin-item" data-rarity="<?= $user->topdrop['rarity'] ?? 'placeholder'; ?>">
          <div class="font h4 bold uppercase center color--primary-text">Топ дроп</div>
          <img class="profile-topdrop-img" src="/media/image/<?= isset($user->topdrop['img']) ? 'skins/' . $user->topdrop['img'] : 'etc/gun_none.webp'; ?>" alt="">
          <div class="font h5 font--600 font--shadow center"><?= isset($user->topdrop['title']) ? $user->topdrop['title'] . ' | ' . $user->topdrop['name'] : 'Пусто'; ?></div>
        </div>
      </div>
      <div class="flex column between container--distance position--relative color--primary overflow--hidden size--w-full">
        <form class="flex column gap--m size--h-full" action="" method="post">
          <div class="flex gap--inherit">
            <input class="size radius--m flex center button padding--xl font font--700 color--gray size--w-full" placeholder="Оставить отзыв" type="text">
            <button class="size theme-button flex--shrink">Отправить</button>
          </div>
          <input id="feedbackInput" type="file" style="display: none;">
          <label class="flex column gap--s button" for="feedbackInput" style="cursor: pointer; min-height: 120px; height: 100%; border: dashed 3px var(--color-gray);">
            <img class="" src="/media/image/etc/2965705.png" alt="" style="height: 50px;">
            <div class="font h5 font--600" style="color: var(--color-gray-primary);">Загрузить отзыв</div>
          </label>
        </form>
      </div>
    </div>
  </div>
  <div class="container container--small">
    <div class="profile-tabs flex color--primary gap--xs container--distance">
      <div class="profile-tabs-buttons">
        <button class="profile-tabs-button size gap--xs theme-button color--gray active" data-type="inventory">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon--small" viewBox="0 0 24 24" fill="var(--color-gray-light)">
            <rect x="2.079" y="2.039" width="8.486" height="8.486" rx="1"></rect>
            <rect x="13.604" y="2.039" width="8.486" height="8.486" rx="1"></rect>
            <rect x="2.079" y="13.563" width="8.486" height="8.486" rx="1"></rect>
            <rect x="13.604" y="13.563" width="8.486" height="8.486" rx="1"></rect>
          </svg>
          <div class="font h6 bold">Инвентарь</div>
          <div class="container--xs color--gray-light font h6 bold"><?= $user->count['inventory']; ?></div>
        </button>
        <button class="profile-tabs-button size gap--xs theme-button color--gray" data-type="contracts">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon--small" viewBox="0 0 24 24" fill="var(--color-gray-light)">
            <path d="M22.5676 10.7392L22.1175 10.433C21.6201 10.1033 21.407 9.46735 21.5728 8.90208L21.7149 8.38391C21.9517 7.58312 21.407 6.75876 20.578 6.61745L20.0332 6.52324C19.4411 6.42902 18.9674 5.98152 18.8726 5.3927L18.7779 4.85098C18.6358 4.02663 17.8068 3.50846 17.0015 3.74399L16.4804 3.90886C15.912 4.07373 15.2724 3.86176 14.9409 3.3907L14.6093 2.91964C14.1119 2.23661 13.1408 2.1424 12.5249 2.70767L12.1223 3.08451C11.6723 3.48491 11.0328 3.57912 10.488 3.27294L10.0143 3.01385C9.28004 2.61346 8.35631 2.9432 8.02471 3.72044L7.81155 4.2386C7.59838 4.80387 7.02993 5.15717 6.43779 5.11006L5.89303 5.08651C5.04035 5.0394 4.35348 5.74599 4.42453 6.57034L4.4719 7.11206C4.51927 7.70088 4.16399 8.26615 3.61923 8.50168L3.12184 8.71365C2.34022 9.04339 2.03231 9.96196 2.43496 10.6921L2.71918 11.1632C3.02709 11.6813 2.95604 12.3408 2.55339 12.7883L2.19811 13.1887C1.62966 13.8246 1.74808 14.7903 2.45864 15.2614L2.90867 15.5675C3.40606 15.8973 3.61923 16.5332 3.45343 17.0985L3.24026 17.6402C3.00341 18.441 3.54817 19.2654 4.37716 19.4067L4.92193 19.5009C5.51406 19.5951 5.98777 20.0426 6.08251 20.6314L6.17725 21.1731C6.31937 21.9975 7.14835 22.5157 7.95366 22.2801L8.47474 22.1152C9.04319 21.9504 9.68269 22.1624 10.0143 22.6334L10.3459 23.0809C10.8433 23.764 11.8144 23.8582 12.4302 23.2929L12.8329 22.916C13.2829 22.5156 13.9224 22.4214 14.4671 22.7276L14.9409 22.9867C15.6751 23.3871 16.5988 23.0574 16.9304 22.2801L17.1436 21.762C17.3568 21.1967 17.9252 20.8434 18.5173 20.8905L19.0621 20.9141C19.9148 20.9612 20.6017 20.2546 20.5306 19.4302L20.5069 18.8885C20.4596 18.2997 20.8148 17.7344 21.3596 17.4989L21.857 17.2869C22.6386 16.9572 22.9465 16.0386 22.5439 15.3085L22.2596 14.8374C21.9517 14.3192 22.0228 13.6598 22.4254 13.2123L22.7807 12.8119C23.3729 12.1995 23.2544 11.2103 22.5676 10.7392ZM12.4776 19.6186C8.80633 19.6186 5.82197 16.651 5.82197 13.0003C5.82197 9.34958 8.80633 6.38192 12.4776 6.38192C16.1488 6.38192 19.1332 9.34958 19.1332 13.0003C19.1332 16.651 16.1488 19.6186 12.4776 19.6186ZM16.6225 12.1995L14.7277 13.754L15.2961 16.0857C15.3672 16.439 15.1067 16.7216 14.8224 16.7216C14.7277 16.7216 14.6329 16.6981 14.5619 16.6274L12.4539 15.3556L10.3933 16.6274C10.2985 16.6745 10.2038 16.7216 10.1327 16.7216C9.8248 16.7216 9.56427 16.439 9.65901 16.0857L10.2275 13.754L8.35631 12.1995C8.00103 11.8933 8.2142 11.328 8.66422 11.3045L11.1038 11.1396L12.0275 8.90208C12.1223 8.6901 12.3118 8.59589 12.5013 8.59589C12.6907 8.59589 12.8802 8.6901 12.975 8.90208L13.8987 11.1396L16.3383 11.3045C16.7646 11.328 16.9541 11.8933 16.6225 12.1995Z"></path>
          </svg>
          <div class="font h6 bold">Контракты</div>
          <div class="container--xs color--gray-light font h6 bold"><?= $user->count['contracts']; ?></div>
        </button>
        <button class="profile-tabs-button size gap--xs theme-button color--gray" data-type="upgrades">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon--small" viewBox="0 0 24 24" fill="var(--color-gray-light)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.943 7.183l-5.595 4.8c-.504.433-1.313.43-1.813-.008l-.81-.71c-.49-.427-.506-1.116-.037-1.561l7.165-6.807c.217-.206.501-.326.796-.356.472-.14 1.016-.033 1.372.312l7.067 6.852c.46.446.44 1.129-.045 1.553l-.81.71c-.504.44-1.32.44-1.823 0l-5.467-4.785zm-.847 3.629a1.068 1.068 0 011.372-.004l4.307 3.768a.773.773 0 010 1.197l-.79.69a1.065 1.065 0 01-1.367 0l-2.834-2.48-2.834 2.48c-.377.331-.99.331-1.367 0l-.79-.69a.773.773 0 010-1.197l4.303-3.764zm.201 6.228a.89.89 0 01.842-.165c.116.033.225.09.318.171l2.095 1.834a.645.645 0 010 .997l-.586.513a.889.889 0 01-1.139 0l-.954-.835-.946.829a.889.889 0 01-1.14 0l-.585-.513a.644.644 0 010-.997l2.095-1.834z"></path>
          </svg>
          <div class="font h6 bold">Апгрейды</div>
          <div class="container--xs color--gray-light font h6 bold"><?= $user->count['upgrades']; ?></div>
        </button>
        <button class="profile-tabs-button size gap--xs theme-button color--gray" data-type="history">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon--small" viewBox="0 0 24 24" fill="var(--color-gray-light)">
            <rect x="2.079" y="2.039" width="8.486" height="8.486" rx="1"></rect>
            <rect x="13.604" y="2.039" width="8.486" height="8.486" rx="1"></rect>
            <rect x="2.079" y="13.563" width="8.486" height="8.486" rx="1"></rect>
            <rect x="13.604" y="13.563" width="8.486" height="8.486" rx="1"></rect>
          </svg>
          <div class="font h6 bold">История</div>
          <div class="container--xs color--gray-light font h6 bold"><?= $user->count['history']; ?></div>
        </button>
        <?php if ($user->id === $currentUser->id) { ?>
          <button class="profile-tabs-button size gap--xs theme-button color--gray" data-type="withdrawals">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon--small" viewBox="0 0 24 24" fill="var(--color-gray-light)">
              <path d="M20.639 12.856h-2.881a.36.36 0 0 0-.361.359v2.858a.36.36 0 0 1-.362.358H6.961a.36.36 0 0 1-.361-.358v-2.858a.36.36 0 0 0-.361-.359H3.36a.357.357 0 0 0-.361.359v4.999C3 19.202 3.804 20 4.8 20h14.4c.996 0 1.8-.798 1.8-1.786v-5a.36.36 0 0 0-.361-.358Z"></path>
              <path d="M11.738 14.593c.124.165.4.165.528 0l4.153-4.803c.141-.186-.011-.432-.263-.432h-2.111a.218.218 0 0 1-.224-.214v-4.93c0-.12-.099-.214-.223-.214H10.43a.218.218 0 0 0-.223.214v4.93c0 .12-.1.214-.223.214h-2.13c-.251 0-.404.246-.262.432l4.146 4.803Z"></path>
            </svg>
            <div class="font h6 bold">Выводы</div>
            <div class="container--xs color--gray-light font h6 bold"><?= $user->count['withdrawals']; ?></div>
          </button>
        <?php } ?>
      </div>
      <?php if ($user->id === $currentUser->id) { ?>
        <div class="profile-tabs-buttons component flex gap--inherit size--w-full end--x">
          <button class="profile-tabs-button profile-tabs-button-withdraw size theme-button" data-modal="withdraw">Вывести</button>
          <button class="profile-tabs-button profile-tabs-button-promo size theme-button color--red" data-modal="promo">Промокоды</button>
          <button class="profile-tabs-button profile-tabs-button-sell-all size theme-button color--green-dark">Продать всё</button>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="container container--small">
    <div class="profile-content"></div>
  </div>
</section>

<script>
  var profile_status = ['history', 'contracts', 'upgrades', 'withdrawals', 'inventory'];

  updateProfileItems($('.profile-tabs-button.active').data('type'));

  click('.profile-tabs-button-sell-all', function() {
    let items = $('.profile-content-items.skin-items .skin-item');
    let content = (items.length > 0) ? $('.profile-content') : false;
    ajax({
      data: {
        do: 'item_sell_all'
      }
    }).then(function(response) {
      if ('error' in response) return toast(response.error, 'info');
      if ('balance' in response && 'balance_str' in response) {
        balance = response.balance;
        $('.balance').text(response.balance_str);
        audio('/media/audio/sounds/money.mp3');
        if (content) {
          items.hide();
          content.html($('<div>').addClass('profile-empty-alert').text('Нет скинов!'));
        }
      }
    });
  });


  on('change', '#fileAvatar', function() {
    if (this.files.length > 0) {
      var fileSize = this.files[0].size; // размер файла в байтах
      var maxSize = 5000000; // 5 МБ в байтах

      if (in_array(this.files[0]['type'], ['image/jpeg', 'image/png'])) {
        if (fileSize <= maxSize) {
          toast('Загрузка аватарки...', 'info')
          var formData = new FormData();
          formData.append('do', 'setAvatar');
          formData.append('file_avatar', this.files[0]);
          $.ajax({
            type: 'POST',
            url: '/core/ajax.php',
            data: formData,
            processData: false,
            contentType: false
          }).then(function(response) {
            response ? location.reload() : toast('Ошибка, обратитесь в техподдержку', 'error');
          });
        } else toast(`Слишком большой размер файла, максимальный размер ${maxSize / 1000000}мб, размер вашего файла ${round(fileSize / 1000000, 1)}мб, пожалуйста выбирите другое изображение!`, 'info');
      } else toast('Неверный формат изображения. Поддерживаются только файлы JPEG, JPG и PNG!', 'info');
    } else toast('Файл не выбран!', 'info');
  });

  function updateProfileItems(type, offset = 0) {
    ajax({
      data: {
        do: 'getProfileInventory',
        type: type,
        offset: offset,
        user_id: <?= $user->id; ?>
      }
    }).then(function(response) {
      var items = response.result;

      let content = $('.profile-content');

      if (offset === 0) content.empty()
      var $profileItems = (items && offset === 0) ? $('<ul>').addClass(`profile-content-items skin-items ${type}`).appendTo(content) : $('.profile-content-items');

      switch (type) {
        case 'history':
        case 'inventory':
          if (items.length > 0) {
            items.forEach(function(item) {
              switch (item.type) {
                case 'skin':
                  var $skinItem = $(<?= $user->id === $currentUser->id ? 1 : 0; ?> ? (item.status === 1 ? '<div>' : '<button>') : '<button>').addClass('skin-item big').attr({'data-rarity': item.rarity, 'data-id': item.id}).appendTo($profileItems);
                  var $skinImg = $('<img>').addClass('skin-img').attr({src: `/media/image/skins/${item.img}`, alt: item.title}).appendTo($skinItem);

                  if ($skinItem.prop('tagName') === 'BUTTON') {
                    switch (item.gotfrom) {
                      case 'case':
                        $skinItem.attr('data-href', `/case/${item.case_title}`);
                        var $gotfromImg = $('<img>').addClass('skin-case-img').attr({src: `/media/image/cases/${item.case_img}`, alt: ''}).appendTo($skinItem);
                        break;
                      case 'upgrade':
                        $skinItem.attr('data-href', '/upgrade');
                        var $gotfromImg = $('<svg class="skin-case-img" fill="var(--color-white)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.943 7.183l-5.595 4.8c-.504.433-1.313.43-1.813-.008l-.81-.71c-.49-.427-.506-1.116-.037-1.561l7.165-6.807c.217-.206.501-.326.796-.356.472-.14 1.016-.033 1.372.312l7.067 6.852c.46.446.44 1.129-.045 1.553l-.81.71c-.504.44-1.32.44-1.823 0l-5.467-4.785zm-.847 3.629a1.068 1.068 0 011.372-.004l4.307 3.768a.773.773 0 010 1.197l-.79.69a1.065 1.065 0 01-1.367 0l-2.834-2.48-2.834 2.48c-.377.331-.99.331-1.367 0l-.79-.69a.773.773 0 010-1.197l4.303-3.764zm.201 6.228a.89.89 0 01.842-.165c.116.033.225.09.318.171l2.095 1.834a.645.645 0 010 .997l-.586.513a.889.889 0 01-1.139 0l-.954-.835-.946.829a.889.889 0 01-1.14 0l-.585-.513a.644.644 0 010-.997l2.095-1.834z"></path></svg>').appendTo($skinItem);
                        break;
                      case 'contracts':
                        $skinItem.attr('data-href', '/contracts');
                        var $gotfromImg = $('<svg class="skin-case-img" fill="var(--color-white)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 26 26"><path d="M22.5676 10.7392L22.1175 10.433C21.6201 10.1033 21.407 9.46735 21.5728 8.90208L21.7149 8.38391C21.9517 7.58312 21.407 6.75876 20.578 6.61745L20.0332 6.52324C19.4411 6.42902 18.9674 5.98152 18.8726 5.3927L18.7779 4.85098C18.6358 4.02663 17.8068 3.50846 17.0015 3.74399L16.4804 3.90886C15.912 4.07373 15.2724 3.86176 14.9409 3.3907L14.6093 2.91964C14.1119 2.23661 13.1408 2.1424 12.5249 2.70767L12.1223 3.08451C11.6723 3.48491 11.0328 3.57912 10.488 3.27294L10.0143 3.01385C9.28004 2.61346 8.35631 2.9432 8.02471 3.72044L7.81155 4.2386C7.59838 4.80387 7.02993 5.15717 6.43779 5.11006L5.89303 5.08651C5.04035 5.0394 4.35348 5.74599 4.42453 6.57034L4.4719 7.11206C4.51927 7.70088 4.16399 8.26615 3.61923 8.50168L3.12184 8.71365C2.34022 9.04339 2.03231 9.96196 2.43496 10.6921L2.71918 11.1632C3.02709 11.6813 2.95604 12.3408 2.55339 12.7883L2.19811 13.1887C1.62966 13.8246 1.74808 14.7903 2.45864 15.2614L2.90867 15.5675C3.40606 15.8973 3.61923 16.5332 3.45343 17.0985L3.24026 17.6402C3.00341 18.441 3.54817 19.2654 4.37716 19.4067L4.92193 19.5009C5.51406 19.5951 5.98777 20.0426 6.08251 20.6314L6.17725 21.1731C6.31937 21.9975 7.14835 22.5157 7.95366 22.2801L8.47474 22.1152C9.04319 21.9504 9.68269 22.1624 10.0143 22.6334L10.3459 23.0809C10.8433 23.764 11.8144 23.8582 12.4302 23.2929L12.8329 22.916C13.2829 22.5156 13.9224 22.4214 14.4671 22.7276L14.9409 22.9867C15.6751 23.3871 16.5988 23.0574 16.9304 22.2801L17.1436 21.762C17.3568 21.1967 17.9252 20.8434 18.5173 20.8905L19.0621 20.9141C19.9148 20.9612 20.6017 20.2546 20.5306 19.4302L20.5069 18.8885C20.4596 18.2997 20.8148 17.7344 21.3596 17.4989L21.857 17.2869C22.6386 16.9572 22.9465 16.0386 22.5439 15.3085L22.2596 14.8374C21.9517 14.3192 22.0228 13.6598 22.4254 13.2123L22.7807 12.8119C23.3729 12.1995 23.2544 11.2103 22.5676 10.7392ZM12.4776 19.6186C8.80633 19.6186 5.82197 16.651 5.82197 13.0003C5.82197 9.34958 8.80633 6.38192 12.4776 6.38192C16.1488 6.38192 19.1332 9.34958 19.1332 13.0003C19.1332 16.651 16.1488 19.6186 12.4776 19.6186ZM16.6225 12.1995L14.7277 13.754L15.2961 16.0857C15.3672 16.439 15.1067 16.7216 14.8224 16.7216C14.7277 16.7216 14.6329 16.6981 14.5619 16.6274L12.4539 15.3556L10.3933 16.6274C10.2985 16.6745 10.2038 16.7216 10.1327 16.7216C9.8248 16.7216 9.56427 16.439 9.65901 16.0857L10.2275 13.754L8.35631 12.1995C8.00103 11.8933 8.2142 11.328 8.66422 11.3045L11.1038 11.1396L12.0275 8.90208C12.1223 8.6901 12.3118 8.59589 12.5013 8.59589C12.6907 8.59589 12.8802 8.6901 12.975 8.90208L13.8987 11.1396L16.3383 11.3045C16.7646 11.328 16.9541 11.8933 16.6225 12.1995Z"></path></svg>').appendTo($skinItem);
                        break;
                    }
                  }
                  var $skinCost = $('<div>').addClass('skin-cost money').text(round(item.cost, 2)).appendTo($skinItem);
                  var $skinInfo = $('<div>').addClass('skin-info').appendTo($skinItem);
                  var $skinTitle = $('<div>').addClass('skin-title').text(item.title).appendTo($skinInfo);
                  var $skinName = $('<div>').addClass('skin-name').text(item.name).appendTo($skinInfo);

                  switch (item.status) {
                    case 0:
                      $('<div>').addClass('skin-sold').attr('data-hint', 'Продано').text('$').appendTo($skinItem);
                      break;
                    case 1:
                      if (<?= $user->id === $currentUser->id ? 1 : 0; ?>) $('<button>').addClass('skin-sell').text('Продать').appendTo($skinItem);
                      break;
                    case 2:
                      $('<div>').addClass('skin-status').attr('data-hint', item.withdrawal_status === 'withdrawing' ? 'Выводится' : item.withdrawal_status === 'withdrawn' ? 'Выведено' : item.withdrawal_status === 'error' ? 'Ошибка вывода' : 'Неизвестный статус').appendTo($skinItem);
                      break;
                    case 3:
                      $('<div>').addClass('skin-lost').attr('data-hint', 'Апгрейд').html('<svg xmlns="http://www.w3.org/2000/svg" class="icon--small" width="24" height="24" viewBox="0 0 24 24" fill="var(--color-red)"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.943 7.183l-5.595 4.8c-.504.433-1.313.43-1.813-.008l-.81-.71c-.49-.427-.506-1.116-.037-1.561l7.165-6.807c.217-.206.501-.326.796-.356.472-.14 1.016-.033 1.372.312l7.067 6.852c.46.446.44 1.129-.045 1.553l-.81.71c-.504.44-1.32.44-1.823 0l-5.467-4.785zm-.847 3.629a1.068 1.068 0 011.372-.004l4.307 3.768a.773.773 0 010 1.197l-.79.69a1.065 1.065 0 01-1.367 0l-2.834-2.48-2.834 2.48c-.377.331-.99.331-1.367 0l-.79-.69a.773.773 0 010-1.197l4.303-3.764zm.201 6.228a.89.89 0 01.842-.165c.116.033.225.09.318.171l2.095 1.834a.645.645 0 010 .997l-.586.513a.889.889 0 01-1.139 0l-.954-.835-.946.829a.889.889 0 01-1.14 0l-.585-.513a.644.644 0 010-.997l2.095-1.834z"></path></svg></div>').appendTo($skinItem);
                      break;
                    case 4:
                      $('<div>').addClass('skin-lost').attr('data-hint', 'Контракт').html('<svg xmlns="http://www.w3.org/2000/svg" class="icon--small" width="24" height="24" viewBox="0 0 26 26" fill="var(--color-red)"><path d="M22.5676 10.7392L22.1175 10.433C21.6201 10.1033 21.407 9.46735 21.5728 8.90208L21.7149 8.38391C21.9517 7.58312 21.407 6.75876 20.578 6.61745L20.0332 6.52324C19.4411 6.42902 18.9674 5.98152 18.8726 5.3927L18.7779 4.85098C18.6358 4.02663 17.8068 3.50846 17.0015 3.74399L16.4804 3.90886C15.912 4.07373 15.2724 3.86176 14.9409 3.3907L14.6093 2.91964C14.1119 2.23661 13.1408 2.1424 12.5249 2.70767L12.1223 3.08451C11.6723 3.48491 11.0328 3.57912 10.488 3.27294L10.0143 3.01385C9.28004 2.61346 8.35631 2.9432 8.02471 3.72044L7.81155 4.2386C7.59838 4.80387 7.02993 5.15717 6.43779 5.11006L5.89303 5.08651C5.04035 5.0394 4.35348 5.74599 4.42453 6.57034L4.4719 7.11206C4.51927 7.70088 4.16399 8.26615 3.61923 8.50168L3.12184 8.71365C2.34022 9.04339 2.03231 9.96196 2.43496 10.6921L2.71918 11.1632C3.02709 11.6813 2.95604 12.3408 2.55339 12.7883L2.19811 13.1887C1.62966 13.8246 1.74808 14.7903 2.45864 15.2614L2.90867 15.5675C3.40606 15.8973 3.61923 16.5332 3.45343 17.0985L3.24026 17.6402C3.00341 18.441 3.54817 19.2654 4.37716 19.4067L4.92193 19.5009C5.51406 19.5951 5.98777 20.0426 6.08251 20.6314L6.17725 21.1731C6.31937 21.9975 7.14835 22.5157 7.95366 22.2801L8.47474 22.1152C9.04319 21.9504 9.68269 22.1624 10.0143 22.6334L10.3459 23.0809C10.8433 23.764 11.8144 23.8582 12.4302 23.2929L12.8329 22.916C13.2829 22.5156 13.9224 22.4214 14.4671 22.7276L14.9409 22.9867C15.6751 23.3871 16.5988 23.0574 16.9304 22.2801L17.1436 21.762C17.3568 21.1967 17.9252 20.8434 18.5173 20.8905L19.0621 20.9141C19.9148 20.9612 20.6017 20.2546 20.5306 19.4302L20.5069 18.8885C20.4596 18.2997 20.8148 17.7344 21.3596 17.4989L21.857 17.2869C22.6386 16.9572 22.9465 16.0386 22.5439 15.3085L22.2596 14.8374C21.9517 14.3192 22.0228 13.6598 22.4254 13.2123L22.7807 12.8119C23.3729 12.1995 23.2544 11.2103 22.5676 10.7392ZM12.4776 19.6186C8.80633 19.6186 5.82197 16.651 5.82197 13.0003C5.82197 9.34958 8.80633 6.38192 12.4776 6.38192C16.1488 6.38192 19.1332 9.34958 19.1332 13.0003C19.1332 16.651 16.1488 19.6186 12.4776 19.6186ZM16.6225 12.1995L14.7277 13.754L15.2961 16.0857C15.3672 16.439 15.1067 16.7216 14.8224 16.7216C14.7277 16.7216 14.6329 16.6981 14.5619 16.6274L12.4539 15.3556L10.3933 16.6274C10.2985 16.6745 10.2038 16.7216 10.1327 16.7216C9.8248 16.7216 9.56427 16.439 9.65901 16.0857L10.2275 13.754L8.35631 12.1995C8.00103 11.8933 8.2142 11.328 8.66422 11.3045L11.1038 11.1396L12.0275 8.90208C12.1223 8.6901 12.3118 8.59589 12.5013 8.59589C12.6907 8.59589 12.8802 8.6901 12.975 8.90208L13.8987 11.1396L16.3383 11.3045C16.7646 11.328 16.9541 11.8933 16.6225 12.1995Z"></path></svg>').appendTo($skinItem);
                      break;
                  }
                  break;
                case 'case':
                  var $caseItem = $('<li>').addClass('skin-item big').attr('data-rarity', (item.case_i_cost > 500) ? 'gold' : (item.case_i_cost > 150) ? 'arcane' : (item.case_i_cost > 80) ? 'legendary' : (item.case_i_cost > 40) ? 'epic' : (item.case_i_cost > 10) ? 'rare' : 'uncommon').appendTo($profileItems);
                  var $caseImg = $('<img>').addClass('case-item-img').attr({src: `/media/image/cases/${item.case_i_img}`, alt: ''}).appendTo($caseItem);
                  var $caseInfo = $('<div>').addClass('case-item-info').appendTo($caseItem);
                  var $skinName = $('<div>').addClass('case-item-name').text(item.case_i_name).appendTo($caseInfo);
                  var $caseButton = $('<button>').addClass('theme-button size shadow--standard').attr('data-href', `/case/${item.case_i_title}`).text('Открыть').appendTo($caseInfo);
                  break;
              }
            });
          } else content.html($('<div>').addClass('profile-empty-alert').text('Нет скинов!'));
          break;
        case 'contracts':
          if (items.length > 0) {
            items.forEach(function(contract) {
              var result_str = contract.result ? 'win' : 'fail';
              var $contractItem = $('<li>').addClass('profile-contract-item').appendTo($profileItems);
              var $contractContainer = $('<div>').addClass('flex gap--inherit').appendTo($contractItem);
              var $secondaryContainer1 = $('<div>').addClass('profile-contract-item-secondary').appendTo($contractContainer);
              var $secondaryContainer2 = $('<div>').addClass('profile-contract-item-secondary').appendTo($contractContainer);

              for (var i = 0; i < 12; i++) {
                var $currentContainer = i < 6 ? $secondaryContainer1 : $secondaryContainer2;
                $('<div>').addClass('profile-contract-skin skin-item').attr('data-rarity', contract.skins[i] ? contract.skins[i].rarity : 'placeholder').html($('<img>').addClass('skin-img').attr({src: contract.skins[i] ? `/media/image/skins/${contract.skins[i].img}` : '/media/image/etc/gun_none.webp', alt: ''})).appendTo($currentContainer);
              }

              var $skinWinItem = $('<div>').addClass('profile-contract-skin win skin-item').attr('data-rarity', contract.skin_win_rarity);
              $secondaryContainer1.after($skinWinItem);
              var $skinWinImg = $('<img>').addClass('skin-img').attr({src: `/media/image/skins/${contract.skin_win_img}`, alt: ''}).appendTo($skinWinItem);
              var $skinWinCost = $('<div>').addClass('skin-cost money').text(round(contract.skin_win_cost, 2)).appendTo($skinWinItem);
              var $skinWinInfo = $('<div>').addClass('skin-info').appendTo($skinWinItem);
              var $skinWinTitle = $('<div>').addClass('skin-title').text(contract.skin_win_title).appendTo($skinWinInfo);
              var $skinWinName = $('<div>').addClass('skin-name').text(contract.skin_win_name).appendTo($skinWinInfo);

              var $contractInfoContainer = $('<div>').addClass('profile-contract-info-container gap--inherit').appendTo($contractItem);

              var $skinsCount = $('<div>').addClass('profile-contract-info profile-contract-info-count').appendTo($contractInfoContainer);
              $('<div>').addClass('font h4 bold color--gray-text').text(contract.skins.length).appendTo($skinsCount);
              $('<div>').addClass('font h6 color--disable').text('Скинов').appendTo($skinsCount);

              var $contractInfoResult = $('<div>').addClass(`profile-contract-info ${contract.result ? 'color--green-dark' : 'color--red'}`).appendTo($contractInfoContainer);
              $('<div>').addClass(`profile-contract-info-result font h4 bold uppercase ${result_str}`).appendTo($contractInfoResult);

              var $sumInfo = $('<div>').addClass('profile-contract-info profile-contract-info-sum').appendTo($contractInfoContainer);
              $('<div>').addClass(`font h4 bold money ${contract.result ? 'color--green-text' : 'color--red-text'}`).text(round(contract.skins.reduce((total, skin) => total + Number(skin.cost), 0), 2)).appendTo($sumInfo);
              $('<div>').addClass('font h6 color--disable').text('Сумма').appendTo($sumInfo);
            });
          } else content.html($('<div>').addClass('profile-empty-alert').text('Нет контрактов!'));
          break;
        case 'upgrades':
          if (items.length > 0) {
            items.forEach(function(upgrade) {
              var result_str = upgrade.result ? 'win' : 'fail';

              var $upgradeItem = $('<li>').addClass('profile-upgrade-item').appendTo($profileItems);
              var $upgradeContainer = $('<div>').addClass('flex gap--inherit').appendTo($upgradeItem);

              var $firstSkin = $('<div>').addClass('profile-upgrade-skin skin-item').attr('data-rarity', upgrade.first_item_rarity).appendTo($upgradeContainer);
              var $firstSkinImg = $('<img>').addClass('skin-img').attr('src', `/media/image/skins/${upgrade.first_item_img}`).attr('alt', '').appendTo($firstSkin);
              var $firstSkinCost = $('<div>').addClass('skin-cost money').text(round(upgrade.first_item_cost, 2)).appendTo($firstSkin);
              var $firstSkinInfo = $('<div>').addClass('skin-info').appendTo($firstSkin);
              var $firstSkinTitle = $('<div>').addClass('skin-title').text(upgrade.first_item_title).appendTo($firstSkinInfo);
              var $firstSkinName = $('<div>').addClass('skin-name').text(upgrade.first_item_name).appendTo($firstSkinInfo);

              var $upgradeArrow = $(`<div class="flex center size--full position--absolute" style="z-index: 2; --size: 60px;"><div class="flex center size container--xl radius--xl shadow--standard ${upgrade.result ? 'color--green-dark' : 'color--red'}"><svg class="size--full" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="307.046px" height="307.046px" viewBox="0 0 307.046 307.046" style="enable-background:new 0 0 307.046 307.046;" xml:space="preserve"><path d="M239.087,142.427L101.259,4.597c-6.133-6.129-16.073-6.129-22.203,0L67.955,15.698c-6.129,6.133-6.129,16.076,0,22.201l115.621,115.626L67.955,269.135c-6.129,6.136-6.129,16.086,0,22.209l11.101,11.101c6.13,6.136,16.07,6.136,22.203,0l137.828-137.831C245.222,158.487,245.222,148.556,239.087,142.427z"/></svg></div></div>`).appendTo($upgradeContainer);

              var $secondSkin = $('<div>').addClass('profile-upgrade-skin skin-item').attr('data-rarity', upgrade.second_item_rarity).appendTo($upgradeContainer);
              var $secondSkinImg = $('<img>').addClass('skin-img').attr('src', `/media/image/skins/${upgrade.second_item_img}`).attr('alt', '').appendTo($secondSkin);
              var $secondSkinCost = $('<div>').addClass('skin-cost money').text(round(upgrade.second_item_cost, 2)).appendTo($secondSkin);
              var $secondSkinInfo = $('<div>').addClass('skin-info').appendTo($secondSkin);
              var $secondSkinTitle = $('<div>').addClass('skin-title').text(upgrade.second_item_title).appendTo($secondSkinInfo);
              var $secondSkinName = $('<div>').addClass('skin-name').text(upgrade.second_item_name).appendTo($secondSkinInfo);

              var $upgradeInfoContainer = $('<div>').addClass('profile-upgrade-info-container').appendTo($upgradeItem);

              var $upgradeInfo = $('<div>').addClass('profile-upgrade-info').appendTo($upgradeInfoContainer);

              var $upgradeInfoChance = $('<div>').addClass('profile-upgrade-info-chance flex column center').appendTo($upgradeInfo);
              $('<div>').addClass('color--theme-text font h5 bold').text(`${round((upgrade.first_item_cost / upgrade.second_item_cost) * 100, 2)}%`).appendTo($upgradeInfoChance);
              $('<div>').addClass('color--gray-text font h6 bold uppercase').text('Шанс').appendTo($upgradeInfoChance);

              var $upgradeInfo = $('<div>').addClass(`profile-upgrade-info ${result_str}`).appendTo($upgradeInfoContainer);
              var $upgradeInfoResult = $('<div>').addClass('profile-upgrade-info-result font h5 bold uppercase').appendTo($upgradeInfo);
            });
          } else content.html($('<div>').addClass('profile-empty-alert').text('Нет апгрейдов!'));
          break;
        case 'withdrawals':
          if (items.length > 0) {
            items.forEach(function(withdrawal) {
              var $withdrawalItem = $('<li>').addClass('profile-withdrawal-item').attr('data-rarity', withdrawal.rarity).appendTo($profileItems);
              var $withdrawalInfo = $('<div>').addClass('profile-withdrawal-info').appendTo($withdrawalItem);
              switch (withdrawal.status) {
                case 'withdrawing':
                  var $withdrawalSum = $('<div>').addClass('profile-withdrawal-sum').text(`${withdrawal.sum} G`).appendTo($withdrawalInfo);
                  var $withdrawalPattern = $('<div>').addClass('profile-withdrawal-pattern').text(withdrawal.pattern).appendTo($withdrawalInfo);
                  var $withdrawalDate = $('<div>').addClass('profile-withdrawal-date').text(formatDate(withdrawal.add_time)).appendTo($withdrawalInfo);
                  break;
                case 'withdrawn':
                  var $withdrawalSum = $('<div>').addClass('profile-withdrawal-sum').text(`${withdrawal.sum} G`).appendTo($withdrawalInfo);
                  var $withdrawalPattern = $('<div>').addClass('profile-withdrawal-pattern').text(('00' + withdrawal.pattern).slice(-3)).appendTo($withdrawalInfo);
                  var $withdrawalDate = $('<div>').addClass('profile-withdrawal-time').appendTo($withdrawalInfo);
                  var timeWithdraw = secondsToTime(withdrawal.withdrawal_time - withdrawal.add_time);
                  if (timeWithdraw.hours != 0) $withdrawalDate.text($withdrawalDate.text() + `${timeWithdraw.hours}ч `);
                  if (timeWithdraw.minutes != 0) $withdrawalDate.text($withdrawalDate.text() + `${timeWithdraw.minutes}мин`);
                  if (timeWithdraw.seconds != 0 && timeWithdraw.hours == 0) $withdrawalDate.text($withdrawalDate.text() + `${timeWithdraw.seconds} сек`);
                  break;
                case 'error':
                  var $withdrawalDesc = $('<div>').addClass('profile-withdrawal-desc').html(withdrawal.desc).appendTo($withdrawalInfo);
                  break;
                default:
                  toast('Статус вывода не определён, обратитесь в техподдержку!', 'error');
                  break;
              }
              var $withdrawalStatus = $('<div>').addClass(`profile-withdrawal-status ${withdrawal.status}`).appendTo($withdrawalItem);
            });
          } else content.html($('<div>').addClass('profile-empty-alert').text('Нет выводов!'));
          break;
      }

      response.isMore ? (content.find('.show-more').length === 0 ? $('<button>').addClass('show-more theme-button color--gray').text('Показать ещё').appendTo(content) : false) : content.find('.show-more').remove();
      $('.show-more.loading-button').removeClass('loading-button');
    });
  }

  click('.profile-content .show-more:not(.loading-button)', function() {
    $(this).addClass('loading-button').css({
      '--height': `${$(this).height()}px`,
      '--color': $(this).css('color')
    });
    let type = $('.profile-tabs-button.active').data('type');
    let offset = $('.profile-content-items').children().length;
    updateProfileItems(type, offset);
  });

  click('.profile-tabs-buttons:not(.component) .profile-tabs-button:not(.active)', function() {
    $(this).addClass('active').siblings('.active').removeClass('active');
    let type = $(this).data('type');
    $('.profile-content-items').empty();
    updateProfileItems(type);
  });

  click('.profile-content .skin-sell', function() {
    let item_id = $(this).parent().data('id');
    if (sellItem(item_id)) $(this).closest('.skin-item').remove();
    if ($('.profile-content-items').children().length === 0) updateProfileItems($('.profile-tabs-button.active').data('type'))
  });
</script>