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
      
      const backgroundsRoot = document.querySelector('.pu-backgrounds');

      setInterval(function() {
        // Flytta första bakgrunden så den är sist i ordningen och visas över dom andra
        const nextBg = backgroundsRoot.querySelector('.pu-background');
        backgroundsRoot.appendChild(nextBg);

        // Vi behöver vänta på nästa frame innan vi ändrar klasserna så att dom inte hamnar
        // i samma frame som vi flyttade nextBg i, annars så hoppar den över CSS animationen.
        window.requestAnimationFrame(function() {
          // Ta bort 'previous' så den blir dold och kan visas igen senare.
          const previousBg = backgroundsRoot.querySelector('.pu-previous');
          previousBg.classList.remove('pu-previous');

          // Ändra 'current' till 'previous' så den den fortfarande syns, men kan bli dold nästa gång.
          const currentBg = backgroundsRoot.querySelector('.pu-current');
          currentBg.classList.remove('pu-current');
          currentBg.classList.add('pu-previous');

          // Sätt nästa till 'current' så den syns.
          nextBg.classList.add('pu-current');
        });
      }, 4000); // Millisekunder
    });
  },
};
