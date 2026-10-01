(function () {
  'use strict';

  var modal = document.getElementById('catalogue-download-modal');
  var form = document.getElementById('catalogue-download-form');

  if (!modal || !form || typeof kohlerCatalogueDownload === 'undefined') {
    return;
  }

  var dialog = modal.querySelector('.catalogue-download-modal__dialog');
  var title = document.getElementById('catalogue-download-title');
  var email = document.getElementById('catalogue-download-email');
  var error = document.getElementById('catalogue-download-error');
  var skip = document.getElementById('catalogue-download-skip');
  var submit = form.querySelector('[type="submit"]');
  var activeTrigger = null;
  var catalogue = { title: '', url: '' };

  function focusableElements() {
    return dialog.querySelectorAll('button:not([disabled]), input:not([disabled]):not([type="hidden"]), a[href]');
  }

  function openModal(trigger) {
    activeTrigger = trigger;
    catalogue.title = trigger.getAttribute('data-catalogue-title') || '';
    catalogue.url = trigger.getAttribute('data-catalogue-url') || '';
    title.textContent = catalogue.title;
    form.reset();
    error.textContent = '';
    modal.hidden = false;
    document.body.classList.add('catalogue-modal-open');
    window.setTimeout(function () { email.focus(); }, 0);
  }

  function closeModal() {
    modal.hidden = true;
    document.body.classList.remove('catalogue-modal-open');
    if (activeTrigger) {
      activeTrigger.focus();
    }
  }

  function openCatalogue() {
    var catalogueWindow = window.open(catalogue.url, '_blank');
    if (catalogueWindow) {
      catalogueWindow.opener = null;
    }
  }

  document.addEventListener('click', function (event) {
    var trigger = event.target.closest('.catalogue-download-trigger');
    if (trigger) {
      event.preventDefault();
      openModal(trigger);
      return;
    }

    if (event.target.closest('[data-catalogue-modal-close]')) {
      closeModal();
    }
  });

  document.addEventListener('keydown', function (event) {
    if (modal.hidden) {
      return;
    }

    if (event.key === 'Escape') {
      closeModal();
      return;
    }

    if (event.key !== 'Tab') {
      return;
    }

    var elements = focusableElements();
    var first = elements[0];
    var last = elements[elements.length - 1];
    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  });

  skip.addEventListener('click', function () {
    openCatalogue();
    closeModal();
  });

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    error.textContent = '';

    if (!email.value || !email.checkValidity()) {
      error.textContent = 'メールアドレスを正しく入力してください。';
      email.focus();
      return;
    }

    var catalogueWindow = window.open('about:blank', '_blank');
    if (catalogueWindow) {
      catalogueWindow.opener = null;
    }

    submit.disabled = true;
    submit.textContent = '送信中…';

    var data = new URLSearchParams();
    data.set('action', 'kohler_save_catalogue_download_email');
    data.set('nonce', kohlerCatalogueDownload.nonce);
    data.set('email', email.value);
    data.set('website', form.elements.website.value);
    data.set('catalogue_title', catalogue.title);
    data.set('catalogue_url', catalogue.url);

    fetch(kohlerCatalogueDownload.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
      body: data.toString()
    })
      .then(function (response) { return response.json(); })
      .then(function (response) {
        if (!response.success) {
          throw new Error(response.data && response.data.message ? response.data.message : '送信できませんでした。');
        }
        if (catalogueWindow) {
          catalogueWindow.location.replace(catalogue.url);
        } else {
          openCatalogue();
        }
        closeModal();
      })
      .catch(function (requestError) {
        if (catalogueWindow) {
          catalogueWindow.close();
        }
        error.textContent = requestError.message;
      })
      .finally(function () {
        submit.disabled = false;
        submit.textContent = 'ダウンロード';
      });
  });
}());
