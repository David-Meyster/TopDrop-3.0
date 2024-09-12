<div class="sapper-container">
  <div id="sapper">
    <div class="sapper-content">
      <div class="sapper-items">
        <?php for ($i = 0; $i < 5 * 5; $i++) { ?>
          <button class="sapper-item"></button>
        <?php } ?>
      </div>
      <div class="sapper-options">
        <input type="number">
        <div></div>
      </div>
    </div>
  </div>
</div>

<script>
  click('#sapper .play-button', function () {
    ajax({
      data: {
        do: 'createSapper',
        sum: sum
      }
    }).then(function(response) {
      $('.sapper-item').removeClass('fail win');
      $('#sapper').removeClass('fail').data('game-id', response);
    });
  });

  click('#sapper:not(.fail) .sapper-item:not(.win)', function() {
    ajax({
      data: {
        do: 'checkSapper',
        sum: sum
      }
    }).then(function(response) {
      $(this).addClass(response.result ? 'win' : 'fail');
    });
  });
</script>
