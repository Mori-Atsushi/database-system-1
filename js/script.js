$(function() {
  $('#menu-button').on('click', function() {
    $('#nav').toggleClass('open');
  });

  $('#purchase').on('click', function() {
    $('#purchase-pop').addClass('show');
  });

  $('#purchase-pop').on('click', function() {
    $('#purchase-pop').removeClass('show');
  });

  $('#purchase-pop .card').on('click', function() {
    event.stopPropagation();
  });

  $('#new-review').on('click', function() {
    $('#review-pop').addClass('show');
  });

  $('#review-pop').on('click', function() {
    $('#review-pop').removeClass('show');
  });

  $('#review-pop .card').on('click', function() {
    event.stopPropagation();
  });
});
