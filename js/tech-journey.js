(function () {
  'use strict';

  function initTechJourney() {
    var navCards = document.querySelectorAll('[data-tech-nav]');

    if (!navCards.length) {
      return;
    }

    navCards.forEach(function (card) {
      card.addEventListener('click', function (event) {
        var targetId = card.getAttribute('data-tech-nav');
        var section = document.getElementById('detail-' + targetId);

        if (!section) {
          return;
        }

        event.preventDefault();
        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        history.replaceState(null, '', '#detail-' + targetId);
      });
    });
  }

  document.addEventListener('DOMContentLoaded', initTechJourney);
})();
