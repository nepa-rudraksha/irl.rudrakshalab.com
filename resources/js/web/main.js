$(document).ready(function () {
  _mobileMenu();
  _slider();
  _news();
  _partners();
});

function _slider() {
  $(".slider__owl-carousel").owlCarousel({
    loop: true,
    margin: 10,
    autoplay: true,
    nav: true,
    dots: false,
    margin: 20,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      },
    },
  });
}

function _news() {
  $(".news__owl-carousel").owlCarousel({
    loop: true,
    margin: 10,
    autoplay: true,
    nav: true,
    dots: true,
    margin: 20,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 3,
      },
    },
  });
}

function _partners() {
  $(".partners__owl-carousel").owlCarousel({
    loop: false,
    margin: 10,
    autoplay: true,
    nav: false,
    dots: true,
    margin: 20,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 4,
      },
    },
  });
}

function _mobileMenu() {
  $(".navbar-toggler").on("click", function () {
    if ($(window).innerWidth() < 769) {
      $(this).toggleClass("active");
      $(".navdiv ").toggleClass("active");
      $(".bsnav-mobile-overlay").toggleClass("active");
      $(".sub-menu").stop().slideUp();
    }
  });

  var $dropDown = $(".dropdown > a");

  $dropDown.each(function () {
    console.log("lbfdgik");

    $(this).on("click", function (e) {
      if ($(window).innerWidth() < 769) {
        e.preventDefault();

        $(this).parents("li").siblings("li").find(".sub-menu").slideUp();

        $(this).siblings(".sub-menu").stop().slideToggle();
      }
    });
  });

  $(".bsnav-mobile-overlay").on("click", function () {
    if ($(window).innerWidth() < 769) {
      console.log("lik");
      $(this).removeClass("active");
      $(".navdiv ").toggleClass("active");
      $(".navbar-toggler").toggleClass("active");
    }
  });
}

$(document).ready(function () {
  $("#scrollTop").click(function () {
    $("html").animate({ scrollTop: 0 }, "slow");
  });

  $(window).scroll(function () {
    if ($(window).scrollTop() < 200) {
      $("#scrollTop").fadeOut();
    } else {
      $("#scrollTop").fadeIn();
    }
  });
});
