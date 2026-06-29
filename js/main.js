(function () {
  var responsiveVideos = document.querySelectorAll('.turnwell-responsive-video[data-video-desktop][data-video-mobile]');

  if (responsiveVideos.length) {
    var videoMq = window.matchMedia('(max-width: 768px)');

    function responsiveVideoSrc(video) {
      return videoMq.matches ? video.getAttribute('data-video-mobile') : video.getAttribute('data-video-desktop');
    }

    function playVideo(video) {
      var playPromise = video.play();

      if (playPromise && playPromise.catch) {
        playPromise.catch(function () {});
      }
    }

    function applyResponsiveVideo(video, force) {
      var nextSrc = responsiveVideoSrc(video);

      if (!nextSrc) {
        return;
      }

      if (!force && video.currentSrc && video.currentSrc.indexOf(nextSrc) !== -1) {
        return;
      }

      while (video.firstChild) {
        video.removeChild(video.firstChild);
      }

      video.src = nextSrc;
      video.load();
      playVideo(video);
    }

    responsiveVideos.forEach(function (video) {
      if (!video.currentSrc) {
        applyResponsiveVideo(video, true);
      }
    });

    if (videoMq.addEventListener) {
      videoMq.addEventListener('change', function () {
        responsiveVideos.forEach(function (video) {
          applyResponsiveVideo(video, true);
        });
      });
    }
  }

  var toggle = document.querySelector('.nav-toggle');
  var nav = document.querySelector('.primary-nav');
  var header = document.querySelector('.site-header');
  var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (toggle && nav) {
    function setOpen(open) {
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      nav.classList.toggle('is-open', open);
      document.body.style.overflow = open ? 'hidden' : '';
    }

    toggle.addEventListener('click', function () {
      setOpen(!nav.classList.contains('is-open'));
    });

    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        if (window.matchMedia('(max-width: 768px)').matches) {
          setOpen(false);
        }
      });
    });

    window.addEventListener('resize', function () {
      if (window.matchMedia('(min-width: 769px)').matches) {
        setOpen(false);
      }
    });
  }

  if (header) {
    function updateHeaderScroll() {
      header.classList.toggle('is-scrolled', window.scrollY > 8);
    }
    updateHeaderScroll();
    window.addEventListener('scroll', updateHeaderScroll, { passive: true });
  }

  /* AOS — index.html */
  if (typeof AOS !== 'undefined' && document.querySelector('[data-aos]')) {
    AOS.init({
      duration: 800,
      easing: 'ease-out-cubic',
      once: true,
      offset: 80,
      mirror: false,
      disable: prefersReducedMotion
    });

    window.addEventListener('load', function () {
      AOS.refresh();
    });
    return;
  }

  /* Scroll reveal — indexv2.html and fallback */
  var revealEls = document.querySelectorAll('.reveal, .reveal-child, .reveal-image-wrap');
  if (!revealEls.length) {
    return;
  }

  document.documentElement.classList.add('js-reveal-ready');

  var hero = document.querySelector('.hero--fullbleed');

  function showReveals() {
    revealEls.forEach(function (el) {
      el.classList.add('is-visible');
    });
  }

  if (prefersReducedMotion) {
    showReveals();
    return;
  }

  if (hero) {
    hero.classList.add('is-visible');
    hero.querySelectorAll('.reveal-image-wrap, .reveal-image').forEach(function (el) {
      el.classList.add('is-visible');
    });
  }

  document.querySelectorAll('.team-grid, .execution-grid, .partners-grid, .technology-grid').forEach(function (grid) {
    grid.querySelectorAll('.reveal-child').forEach(function (el, i) {
      el.style.transitionDelay = (i % 8) * 0.07 + 's';
    });
  });

  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { root: null, rootMargin: '0px 0px -6% 0px', threshold: 0.1 }
    );

    revealEls.forEach(function (el) {
      if (hero && hero.contains(el)) {
        return;
      }
      observer.observe(el);
    });
  } else {
    showReveals();
  }
})();

