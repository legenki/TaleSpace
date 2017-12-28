$(function() {
  var special = ['reveal', 'top', 'boring', 'perspective', 'extra-pop'];
  // Toggle Nav on Click
  $('#hearts a').click(function() {
    var transitionClass = $(this).data('transition');
    if ($.inArray(transitionClass, special) > -1) {
      $('body').removeClass();
      $('body').addClass(transitionClass);
    } else {
      $('body').removeClass();
      $('#site-canvas').removeClass();
      $('#site-canvas').addClass(transitionClass);
    }
    $('#site-wrapper').toggleClass('show-nav');
    return false;
  });
});