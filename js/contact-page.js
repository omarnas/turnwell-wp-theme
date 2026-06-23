(function () {
  var inquirySelect = document.getElementById('contact-inquiry');
  var quickCards = document.querySelectorAll('[data-inquiry-target]');
  var formAnchor = document.getElementById('contact-form');

  if (!inquirySelect || !quickCards.length) {
    return;
  }

  function setSelectedCard(inquiry) {
    quickCards.forEach(function (card) {
      var isSelected = card.getAttribute('data-inquiry-target') === inquiry;
      card.classList.toggle('is-selected', isSelected);
      card.setAttribute('aria-pressed', isSelected ? 'true' : 'false');
    });
  }

  quickCards.forEach(function (card) {
    card.addEventListener('click', function () {
      var inquiry = card.getAttribute('data-inquiry-target');
      if (!inquiry) {
        return;
      }

      inquirySelect.value = inquiry;
      setSelectedCard(inquiry);

      if (formAnchor && typeof formAnchor.scrollIntoView === 'function') {
        formAnchor.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }

      inquirySelect.focus();
    });
  });

  inquirySelect.addEventListener('change', function () {
    if (inquirySelect.value) {
      setSelectedCard(inquirySelect.value);
    }
  });
})();
