(function () {
  'use strict';

  function initExecutionStory(root) {
    var phases = root.querySelectorAll('[data-story-phase]');
    var numEl = root.querySelector('[data-story-num]');
    var titleEl = root.querySelector('[data-story-title]');
    var progressFill = root.querySelector('[data-story-progress]');
    var markers = root.querySelectorAll('[data-story-marker]');
    var rail = root.querySelector('.execution-story__rail');

    if (!phases.length || !numEl || !titleEl) {
      return;
    }

    var activeIndex = -1;
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var stickyQuery = window.matchMedia('(min-width: 769px)');

    function updateProgress(index) {
      if (!stickyQuery.matches) {
        return;
      }

      if (progressFill) {
        var total = phases.length;
        var fillPercent = total <= 1 ? 100 : (index / (total - 1)) * 100;
        progressFill.style.height = fillPercent + '%';
      }

      markers.forEach(function (marker, markerIndex) {
        marker.classList.toggle('is-active', markerIndex === index);
        marker.classList.toggle('is-complete', markerIndex < index);
      });
    }

    function setActive(index) {
      if (index === activeIndex || index < 0 || index >= phases.length) {
        return;
      }

      activeIndex = index;
      var phase = phases[index];
      var num = phase.getAttribute('data-story-num') || '';
      var title = phase.getAttribute('data-story-title') || '';

      phases.forEach(function (item, itemIndex) {
        item.classList.toggle('is-active', itemIndex === index);
        item.classList.toggle('is-complete', itemIndex < index);
      });

      updateProgress(index);

      if (reducedMotion) {
        numEl.textContent = num;
        titleEl.textContent = title;
        return;
      }

      numEl.classList.add('is-changing');
      titleEl.classList.add('is-changing');

      window.setTimeout(function () {
        numEl.textContent = num;
        titleEl.textContent = title;
        numEl.classList.remove('is-changing');
        titleEl.classList.remove('is-changing');
      }, 180);
    }

    function resolveActivePhase() {
      if (!stickyQuery.matches || !rail) {
        return;
      }

      var anchor = window.innerHeight * 0.36;
      var nextIndex = 0;

      phases.forEach(function (phase, index) {
        var rect = phase.getBoundingClientRect();

        if (rect.top <= anchor) {
          nextIndex = index;
        }
      });

      setActive(nextIndex);
    }

    var ticking = false;

    function onScroll() {
      if (ticking) {
        return;
      }

      ticking = true;
      window.requestAnimationFrame(function () {
        resolveActivePhase();
        ticking = false;
      });
    }

    function onBreakpointChange() {
      if (!stickyQuery.matches) {
        activeIndex = -1;
        phases.forEach(function (phase) {
          phase.classList.remove('is-active');
          phase.classList.remove('is-complete');
        });

        if (progressFill) {
          progressFill.style.height = '0%';
        }

        markers.forEach(function (marker, markerIndex) {
          marker.classList.remove('is-active');
          marker.classList.remove('is-complete');
          if (markerIndex === 0) {
            marker.classList.add('is-active');
          }
        });

        return;
      }

      resolveActivePhase();
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });

    if (typeof stickyQuery.addEventListener === 'function') {
      stickyQuery.addEventListener('change', onBreakpointChange);
    } else if (typeof stickyQuery.addListener === 'function') {
      stickyQuery.addListener(onBreakpointChange);
    }

    onBreakpointChange();
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-execution-story]').forEach(initExecutionStory);
  });
})();
