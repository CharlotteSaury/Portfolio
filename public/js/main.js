$(function () {

  /** navbav display on scroll */

  $(document).scroll(function () {
    $(".nav").toggleClass('scrolled', $(this).scrollTop() > $(".nav").height());
  });

  /** back-to-top button display on scroll */

  $(document).scroll(function () {
    $("#back-to-top").toggleClass('scrolled-arrow', $(this).scrollTop() > 200 );
  });

  /** responsive navigation menu */

  var content = $('.top-nav');
  var sidebar = $('#nav-burger-sidebar');

  sidebar.html(content.html());

  $('#nav-burger-button').click(function (e) {
    e.preventDefault();
    $('#nav-burger-sidebar').css('transform', 'translateX(0)');
    $('#nav-overlay').css('display', 'block');
    $('nav').addClass('nav-transparent');
    $(this).css('display', 'none');
  });

  $('#nav-overlay').click(function(e) {
    e.preventDefault();
    $('#nav-burger-sidebar').css('transform', 'translateX(-100%)');
    $('#nav-overlay').css('display', 'none');
    $('nav').removeClass('nav-transparent');
    $('#nav-burger-button').css('display', 'block');
  });

  $('#nav-burger-sidebar a').click(function(e) {
    $('#nav-burger-sidebar').css('transform', 'translateX(-100%)');
    $('#nav-overlay').css('display', 'none');
    $('nav').removeClass('nav-transparent');
    $('#nav-burger-button').css('display', 'block');
  });


});