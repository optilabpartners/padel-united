export default {
  init() {
    window.trackBrokerLink = function(brokerName) {
      gtag('event', 'click', {
        'event_category': 'outclick',
        'event_label': brokerName,
        'transport_type': 'beacon',
        'event_callback': function(){}
      });
    }
  },
  finalize() {
    $('.btn-bars', '.nav-primary-responsive').on('click', function() {
      $(this).siblings('div').toggleClass('d-block');
      $(this).parent('.nav-primary-responsive').toggleClass('show-nav');
    });

    $(window).scroll(function () {
      var scroll = $(window).scrollTop();
      if (scroll >= 300) {
        $("#ct-menu").addClass("addWhiteBg");
      } else {
        $("#ct-menu").removeClass("addWhiteBg");
      }
    });

	$(document).ready(function() {
      var scroll = $(window).scrollTop();
      if (scroll >= 300) {
        $("#ct-menu").addClass("addWhiteBg");
      } else {
        $("#ct-menu").removeClass("addWhiteBg");
      }
      
      //Fixing so that accordions scroll to open
      $('.accordion-collapse').on('shown.bs.collapse', function () {
        var $panel = $(this).closest('.accordion-item');
        $('html,body').animate({
            scrollTop: $panel.offset().top
        }, 500); 
      }); 
    });
  },
};
