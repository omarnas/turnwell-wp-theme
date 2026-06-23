(function () {
  'use strict';

  function initExecutionTabs(root) {
    var buttons = root.querySelectorAll('.execution-tabs__btn[data-tab]');
    var panels = root.querySelectorAll('.execution-tabs__panel[data-panel]');

    if (!buttons.length || !panels.length) {
      return;
    }

    function activate(tabId) {
      if (!tabId) {
        return;
      }

      buttons.forEach(function (button) {
        var isActive = button.getAttribute('data-tab') === tabId;
        button.classList.toggle('is-active', isActive);
        button.setAttribute('aria-selected', isActive ? 'true' : 'false');
        button.setAttribute('tabindex', isActive ? '0' : '-1');
      });

      panels.forEach(function (panel) {
        var isActive = panel.getAttribute('data-panel') === tabId;
        panel.classList.toggle('is-active', isActive);
        if (isActive) {
          panel.removeAttribute('hidden');
        } else {
          panel.setAttribute('hidden', '');
        }
      });
    }

    root.activateTab = activate;

    buttons.forEach(function (button, index) {
      button.addEventListener('click', function () {
        activate(button.getAttribute('data-tab'));
      });

      button.addEventListener('keydown', function (event) {
        var nextIndex = index;

        if (event.key === 'ArrowRight') {
          nextIndex = (index + 1) % buttons.length;
        } else if (event.key === 'ArrowLeft') {
          nextIndex = (index - 1 + buttons.length) % buttons.length;
        } else if (event.key === 'Home') {
          nextIndex = 0;
        } else if (event.key === 'End') {
          nextIndex = buttons.length - 1;
        } else {
          return;
        }

        event.preventDefault();
        var nextButton = buttons[nextIndex];
        activate(nextButton.getAttribute('data-tab'));
        nextButton.focus();
      });
    });

    var initialHash = window.location.hash.replace('#', '');
    if (initialHash && root.querySelector('[data-panel="' + initialHash + '"]')) {
      activate(initialHash);
    }
  }

  function initTabDeepLinks() {
    document.querySelectorAll('[data-tab-target]').forEach(function (link) {
      link.addEventListener('click', function (event) {
        var tabId = link.getAttribute('data-tab-target');
        var root = document.querySelector('[data-execution-tabs]');

        if (!root || !tabId || typeof root.activateTab !== 'function') {
          return;
        }

        event.preventDefault();
        root.activateTab(tabId);

        var detailSection = document.getElementById('services-detail') || root;
        detailSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        history.replaceState(null, '', '#' + tabId);
      });
    });

    window.addEventListener('hashchange', function () {
      var tabId = window.location.hash.replace('#', '');
      var root = document.querySelector('[data-execution-tabs]');

      if (root && tabId && typeof root.activateTab === 'function' && root.querySelector('[data-panel="' + tabId + '"]')) {
        root.activateTab(tabId);
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-execution-tabs]').forEach(initExecutionTabs);
    initTabDeepLinks();
  });
})();
