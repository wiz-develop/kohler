jQuery(function($){ 

  /*-------------------------------------------*/
  /* jsでサイトのURL・テーマのパスを使えるようにする
  /*-------------------------------------------*/
  // var wp_temp_uri = tmp_path.temp_uri;
  // var wp_home_url = tmp_path.home_url;

  /*-------------------------------------------*/
  /* スムーススクロール
  /*-------------------------------------------*/
  var HeaderHeight = $('.site-header').outerHeight();
  var speed = 100;
	$('a[href^="#"]').on('click', function() {
    $(this).off('click');
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top - HeaderHeight;
		$('body,html').animate({scrollTop:position}, speed, 'swing');
		return false;
  });

  $(document).ready(function(){
    var urlHash = location.hash;
    if(urlHash) {
        hashposi = $(urlHash).offset().top - HeaderHeight;
        setTimeout(function () {
          $('body,html').animate({scrollTop:hashposi}, speed, 'swing');
        }, 100);
    }
  });

  // $(window).scroll(function () {
  //   if($(window).scrollTop() > 20) {
  //     $('.app_func_business').addClass('scroll');
  //   } else {
  //     $('.app_func_business').removeClass('scroll');
  //   }
  // });

  /*-------------------------------------------*/
  /* アニメーション
  /*-------------------------------------------*/
  $(function () {
    if ($('.anime').length) {
        scrollAnimation();
    }
    function scrollAnimation() {
        $(window).scroll(function () {
            $(".anime").each(function () {
                let position = $(this).offset().top,
                    scroll = $(window).scrollTop(),
                    windowHeight = $(window).height();

                if (scroll > position - windowHeight + 200) {
                    $(this).addClass('is-animated');
                }
            });
        });
    }
    $(window).trigger('scroll');
  });

  $('.leftAnime').each(function(){ 
    var elemPos = $(this).offset().top-50;
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight){
      $(this).addClass("slideAnimeLeftRight");
      $(this).children(".leftAnimeInner").addClass("slideAnimeRightLeft");
    }else{
      $(this).removeClass("slideAnimeLeftRight");
      $(this).children(".leftAnimeInner").removeClass("slideAnimeRightLeft");
      
    }
  });

  $(function() {
    const targets = $('.anime_zoom_merit');
    if(!targets.length) return;

    $(window).scroll(function () {
        const slideBorder = $(this).scrollTop() + ($(this).outerHeight() * 0.7);
        targets.each(function() {
            if(slideBorder > $(this).offset().top) {
                $(this).addClass('active');
            }
        });
    });
  });

  // $(window).on('load',function(){
  //   $('body').addClass('appear');
  // });


  /*-------------------------------------------*/
  /* ポップアップ
  /*-------------------------------------------*/
  // デフォルト
  $(document).on('click','.modal_trigger', function(){
    var modal_box = $(this).next('.modal_box');
    modal_box.fadeIn(); // モーダルを表示する
    $('body').addClass('overflow-hidden');
  });

  // ポップアップを閉じる
  $(document).on('click','.modal_close , .modal_bg', function(){
    $('.modal_box').fadeOut(); // モーダルを非表示にする
    $('body').removeClass('overflow-hidden');
  });
  $(document).on('click','.js-modal_trigger', function(){
    var modal_box = $(this).next('.js-modal_box');
    modal_box.fadeIn(); // モーダルを表示する
    $('body').addClass('overflow-hidden');
  });
  $(document).on('click','.js-modal_close , .js-modal_bg', function(){
    $('.js-modal_box').fadeOut(); // モーダルを非表示にする
    $('body').removeClass('overflow-hidden');
  });

  // メニュー用
  $(document).on('click','#js-sitemap_trigger', function(){
    $('#js-sitemap_modal').fadeIn();
    $('body').addClass('overflow-hidden');
  });
  $(document).on('click','#js-search_trigger', function(){
    $('#js-search_modal').fadeIn();
    $('body').addClass('overflow-hidden');
  });
  $(document).on('click','#js-search_trigger_pc', function(){
    $('#js-search_modal_pc').fadeIn();
    $('body').addClass('overflow-hidden');
  });
  
  $(function () {
    $('.slick-first_view')
    .on("init", function () {
      $('.slick-first_view .slick-slide[data-slick-index="0"]').addClass("add-animation");
    })
    .slick({
      autoplay: true,
      speed: 2000,
      autoplaySpeed: 4000,
      dots: true,
      arrows: true,
      infinite: true,
      pauseOnFocus: false,
      pauseOnHover: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      prevArrow: '<button type="button" class="prev-btn"><i class="fa-solid fa-chevron-right fa-rotate-180"></i></button>',
      nextArrow: '<button type="button" class="next-btn"><i class="fa-solid fa-chevron-right"></i></button>',
      fade: true,
      cssEase: 'ease-out',
      dotsClass: "slider-dots",
      asNavFor: ".slick-first_view_text",
    })
    .on({
      beforeChange: function (event, slick, currentSlide, nextSlide) {
        $(".slick-slide", this).eq(nextSlide).addClass("add-animation");
        $(".slick-slide", this).eq(currentSlide).addClass("remove-animation");
      },
      afterChange: function () {
        $(".remove-animation", this).removeClass(
          "remove-animation add-animation"
        );
      },
    });
  });

  $('.slick-first_view_text').slick({
    autoplay: true,
    speed: 2000,
    autoplaySpeed: 4000,
    dots: false,
    arrows: false,
    infinite: true,
    pauseOnFocus: false,
    pauseOnHover: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    cssEase: 'ease-out',
    asNavFor: ".slick-first_view",
  });

  $('.slick-portfolio').slick({
    autoplay: true,
    speed: 2000,
    autoplaySpeed: 4000,
    dots: true,
    arrows: true,
    infinite: true,
    pauseOnFocus: false,
    pauseOnHover: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    centerPadding: false,
    centerMode: true,
    prevArrow: '<button type="button" class="prev-btn"><i class="fa-solid fa-circle-chevron-right fa-flip-horizontal rounded-pill"></i></button>',
    nextArrow: '<button type="button" class="next-btn"><i class="fa-solid fa-circle-chevron-right rounded-pill"></i></button>',
    dotsClass: "slider-dots",
    responsive: [{
    breakpoint: 576,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
    },
    }]
  });

  $('.slick-product_main').slick({
    autoplay: false,
    speed: 800,
    dots: false,
    arrows: true,
    infinite: true,
    pauseOnHover: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    lazyLoad: 'ondemand',
    asNavFor: '.slick-product_sub',
    prevArrow: '<button type="button" class="prev-btn"><img class="link-arrow rotate-90" src="/cms/wp-content/themes/maker/assets/img/common/link-arrow_black.png"></button>',
    nextArrow: '<button type="button" class="next-btn"><img class="link-arrow" src="/cms/wp-content/themes/maker/assets/img/common/link-arrow_black.png"></button>',
  });

  $('.slick-product_sub').slick({
    autoplay: false,
    speed: 800,
    dots: false,
    arrows: false,
    infinite: true,
    pauseOnHover: false,
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.slick-product_main',
    focusOnSelect: true,
    // centerPadding: '10%',
    // centerMode: false,
    // lazyLoad: 'ondemand',
    // prevArrow: '<button type="button" class="prev-btn"><img class="link-arrow rotate-90" src="/cms/wp-content/themes/maker/assets/img/common/link-arrow_black.png"></button>',
    // nextArrow: '<button type="button" class="next-btn"><img class="link-arrow" src="/cms/wp-content/themes/maker/assets/img/common/link-arrow_black.png"></button>',
  });

  // function slideAlignHeight($class) {
  //   window.addEventListener('load', function() {
  //     var maxSliderHeight = 0;
  //     $($class).each(function(idx, elem) {
  //       var sliderHeight = $(elem).height();
  //       if(maxSliderHeight < sliderHeight) {
  //         maxSliderHeight = sliderHeight;
  //       }
  //     });
  //     $($class).height(maxSliderHeight);
  //   });
  // }

  /*-------------------------------------------*/
  /* アコーディオン
  /*-------------------------------------------*/
  // 上から下へ表示
  $('.ac-parent').on('click', function() {
    $(this).toggleClass('open');
    $(this).next('.ac-child').slideToggle();
  });
  $('.acor-menu').on('click', function() {
    $(this).toggleClass('open');
    $(this).next('.acor-menu-child').slideToggle();
  });

  /*-------------------------------------------*/
  /* アーカイブ ページネーション
  /*-------------------------------------------*/
  if ($('.pnavi').length) {
    $("a.page-numbers").each( function(index, element) {
        var pageNumbers = $(element).attr('href');
        if (pageNumbers == '') {
          $(element).attr('href', location.pathname);
        }
    });
  }

  /*-------------------------------------------*/
  /* SPメニュー
  /*-------------------------------------------*/
  $('.js-menu_child_open').on('click', function(event) {
    event.preventDefault();
    $(this).toggleClass('js-open');
    $(this).next('.js-menu_child').toggleClass('js-open');
  });
  $('.js-ac-parent-left').on('click', function() {
    $(this).parent().toggleClass('js-open');
    $(this).toggleClass('js-open');
    $(this).next('.js-ac-child-left').toggleClass('js-open');
  });

  if (window.matchMedia('(min-width:768px)').matches) {
    $('.nav-page_link').addClass('open');
    $('.nav-page_link__btn').addClass('open');
    $('.nav-page_link__btn').next('.ac-child-left').addClass('open');
  }  
  $(window).scroll(function () {
    var scrollAmount = $(window).scrollTop();
    if (scrollAmount > 0) {
      $('body').addClass('scrolled');
      $('.nav-page_link').removeClass('open');
      $('.nav-page_link__btn').removeClass('open');
      $('.nav-page_link__btn').next('.ac-child-left').removeClass('open');
    } else {
      $('body').removeClass('scrolled');
    }
  });
  $('.ac-parent-left').on('click', function() {
    $(this).parent().toggleClass('open');
    $(this).toggleClass('open');
    $(this).next('.ac-child-left').toggleClass('open');
  });

  /*-------------------------------------------*/
  /* 商品詳細ページ
  /*-------------------------------------------*/
  // カラー・バリエーション切り替え
  $('.js-switch-btn').on('click', function() {
    var data = $(this).data();
    var key = Object.keys(data);
    var value = $(this).data(key[0]);
    var url = new URL(location.href);
    url.searchParams.set(key,value);
    window.location.href = url;
  });

  function getParam(name, url) {
      if (!url) url = window.location.href;
      name = name.replace(/[\[\]]/g, "\\$&");
      var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
          results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  /*-------------------------------------------*/
  /*  トップページ ポートフォリオ
  /*-------------------------------------------*/
  $('#domestic-tab').click(function(){
    $('#domestic').addClass('active');
    $('#domestic-tab').addClass('active');
    $('#foreign').removeClass('active');
    $('#foreign-tab').removeClass('active');
  });
  $('#foreign-tab').click(function(){
    $('#foreign').addClass('active');
    $('#foreign-tab').addClass('active');
    $('#domestic').removeClass('active');
    $('#domestic-tab').removeClass('active');
  });
  // $('#js-portfolio-tab')
  // $('#foreign').css('z-index', '-1');
  // $('#foreign').css('z-index', '-1');

  /*-------------------------------------------*/
  /* 商品検索
  /*-------------------------------------------*/
  // var url = new URL(window.location.href);
  // var params = url.searchParams;

  // params.forEach(function(value,key){
  //     // console.log(key + " => " + value);
  //     if (key == "s" && value != "") {
  //         $('input[name=s]').val(value);
  //     } else if (key == "cat[]" && value != "") {
  //         $('input[name="cat[]"]' + 'input[value="' + value + '"]').prop('checked', true);
  //         technology_accordion = true;
  //     }
  // });

});
