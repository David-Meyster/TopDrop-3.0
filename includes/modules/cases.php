<?php if (!defined('TopDrop')) header('HTTP/1.1 403 Forbidden');

$cases = new Cases;
$casesSplitted = $cases->getAllSplittedByCategories(['Новогодние кейсы', 'Новые кейсы', 'Кейсы от нейросети', 'Бесплатные кейсы']);

$event_webp_files = [];
foreach (scandir("$_SERVER[DOCUMENT_ROOT]/media/image/event-fon") as $event_file) if (pathinfo($event_file, PATHINFO_EXTENSION) == 'webp') $event_webp_files[] = $event_file; ?>

<div class="cases-page">
  <div class="event" style="--event-fon: url(/media/image/event-fon/<?= return_array_rand($event_webp_files); ?>);">
    <!-- <button style="z-index: 1; color: #fff; background: #ff1b1b;" class="theme-button animate--hue-rotate" onclick="toast('<div><b>ВНИМАНИЕ!</b><br>Сайт может перестать работать на пару часов, мы покупаем новый сервер для более быстрой работы сайта, перенос займёт какое то время :(</div>', false)">Нажми!</button> -->
  </div>
  <?php foreach ($casesSplitted as $category => $casesList) { ?>
    <section>
      <div class="container flex column">
        <h2 class="cases-category-title"><?= $category; ?></h2>
        <ul class="cases-items">
          <?php foreach ($casesList as $case) { ?>
            <li class="case-item">
              <button class="case-link" data-href="/case/<?= $case['title']; ?>">
                <div class="case-img-inner">
                  <img class="case-img" src="/media/image/cases/<?= $case['img']; ?>" alt="<?= $case['name']; ?>">
                </div>
                <div class="case-info">
                  <div class="case-costs">
                    <?php if ($case['cost']) { ?>
                      <div class="case-cost-current money"><?= $case['cost']; ?></div>
                      <div class="case-cost-old money"><?= substr_replace(round($case['cost'] * 2.1), '9', -1); ?></div>
                    <?php } else { ?>
                      <div class="case-cost-free">Бесплатно</div>
                    <?php } ?>
                  </div>
                  <div class="case-name"><?= $case['name']; ?></div>
                </div>
              </button>
            </li>
          <?php } ?>
        </ul>
      </div>
    </section>
  <?php } ?>
</div>