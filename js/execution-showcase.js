(function () {
  'use strict';

  function initExecutionShowcase(root) {
    var tabs = root.querySelectorAll('[data-overview-tab]');
    var panels = root.querySelectorAll('[data-overview-panel]');

    if (!tabs.length || !panels.length) {
      return;
    }

    function activate(tabId) {
      if (!tabId) {
        return;
      }

      tabs.forEach(function (tab) {
        var isActive = tab.getAttribute('data-overview-tab') === tabId;
        tab.classList.toggle('is-active', isActive);
        tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
        tab.setAttribute('tabindex', isActive ? '0' : '-1');
      });

      panels.forEach(function (panel) {
        var isActive = panel.getAttribute('data-overview-panel') === tabId;
        panel.classList.toggle('is-active', isActive);

        if (isActive) {
          panel.removeAttribute('hidden');
        } else {
          panel.setAttribute('hidden', '');
        }
      });
    }

    tabs.forEach(function (tab, index) {
      tab.addEventListener('click', function () {
        activate(tab.getAttribute('data-overview-tab'));
      });

      tab.addEventListener('keydown', function (event) {
        var nextIndex = index;

        if (event.key === 'ArrowRight') {
          nextIndex = (index + 1) % tabs.length;
        } else if (event.key === 'ArrowLeft') {
          nextIndex = (index - 1 + tabs.length) % tabs.length;
        } else if (event.key === 'Home') {
          nextIndex = 0;
        } else if (event.key === 'End') {
          nextIndex = tabs.length - 1;
        } else {
          return;
        }

        event.preventDefault();
        var nextTab = tabs[nextIndex];
        activate(nextTab.getAttribute('data-overview-tab'));
        nextTab.focus();
      });
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-execution-showcase]').forEach(initExecutionShowcase);
  });
})();
