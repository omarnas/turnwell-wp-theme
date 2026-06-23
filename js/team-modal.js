(function () {
  var modal = document.getElementById('team-member-modal');
  if (!modal) {
    return;
  }

  var dialog = modal.querySelector('.team-modal__dialog');
  var panels = modal.querySelectorAll('[data-team-modal-panel]');
  var closeControls = modal.querySelectorAll('[data-team-modal-close]');
  var lastFocused = null;
  var activeSlug = '';

  function getPanel(slug) {
    return modal.querySelector('[data-team-modal-panel="' + slug + '"]');
  }

  function setPanelVisible(slug) {
    panels.forEach(function (panel) {
      var isActive = panel.getAttribute('data-team-modal-panel') === slug;
      panel.hidden = !isActive;
    });
    activeSlug = slug;
  }

  function openModal(slug) {
    var panel = getPanel(slug);
    if (!panel) {
      return;
    }

    lastFocused = document.activeElement;
    setPanelVisible(slug);
    dialog.setAttribute('aria-labelledby', 'team-modal-title-' + slug);
    dialog.setAttribute('aria-describedby', 'team-modal-bio-' + slug);
    modal.hidden = false;
    modal.setAttribute('aria-hidden', 'false');
    modal.classList.add('is-open');
    document.body.classList.add('team-modal-open');

    var closeButton = modal.querySelector('.team-modal__close');
    if (closeButton) {
      closeButton.focus();
    }
  }

  function closeModal() {
    if (modal.hidden) {
      return;
    }

    modal.classList.remove('is-open');
    modal.hidden = true;
    modal.setAttribute('aria-hidden', 'true');
    dialog.removeAttribute('aria-labelledby');
    dialog.removeAttribute('aria-describedby');
    document.body.classList.remove('team-modal-open');
    activeSlug = '';

    panels.forEach(function (panel) {
      panel.hidden = true;
    });

    if (lastFocused && typeof lastFocused.focus === 'function') {
      lastFocused.focus();
    }
  }

  function handleTrigger(event) {
    if (event.target.closest('.team-profile-card__linkedin')) {
      return;
    }

    var trigger = event.target.closest('[data-team-modal]');
    if (!trigger || trigger.closest('#team-member-modal')) {
      return;
    }

    var slug = trigger.getAttribute('data-team-modal');
    if (slug) {
      event.preventDefault();
      openModal(slug);
    }
  }

  document.addEventListener('click', handleTrigger);

  document.addEventListener('keydown', function (event) {
    if (event.target.closest('.team-profile-card__linkedin')) {
      return;
    }

    var trigger = event.target.closest('[data-team-modal]');
    if (!trigger || trigger.closest('#team-member-modal')) {
      return;
    }

    if (event.key === 'Enter' || event.key === ' ') {
      event.preventDefault();
      var slug = trigger.getAttribute('data-team-modal');
      if (slug) {
        openModal(slug);
      }
    }
  });

  closeControls.forEach(function (control) {
    control.addEventListener('click', closeModal);
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && !modal.hidden) {
      event.preventDefault();
      closeModal();
    }

    if (event.key === 'Tab' && !modal.hidden && dialog) {
      var focusable = dialog.querySelectorAll(
        'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
      );
      if (!focusable.length) {
        return;
      }

      var first = focusable[0];
      var last = focusable[focusable.length - 1];

      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    }
  });
})();
