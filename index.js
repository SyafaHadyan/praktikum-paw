$(function () {
  var $cards = $('.card');
  var $noResults = $('#no-results');

  $('#search-input').on('input', function () {
    var query = $(this).val().trim().toLowerCase();

    var visibleCount = 0;

    $cards.each(function () {
      var name = $(this).find('.card-name').text().toLowerCase();
      if (query === '' || name.includes(query)) {
        $(this).removeClass('card--hidden');
        visibleCount++;
      } else {
        $(this).addClass('card--hidden');
      }
    });

    if (visibleCount === 0) {
      $noResults.removeClass('hidden');
    } else {
      $noResults.addClass('hidden');
    }
  });

  $('#random-btn').on('click', function () {
    var $visible = $cards.not('.card--hidden');

    if ($visible.length === 0) return;

    var randomIndex = Math.floor(Math.random() * $visible.length);
    var destination = $visible.eq(randomIndex).attr('href');

    window.location.href = destination;
  });

});
