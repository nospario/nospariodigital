/* Nospario Digital — interactivity (vanilla JS, no framework)
   - Mobile slide-out menu
   - Single-open accordions (native <details>)
   - Progressive form enhancement (inline success panel)
*/
(function () {
  'use strict';

  /* ---------------------------------------------------------------------
     Mobile menu
  --------------------------------------------------------------------- */
  var menu = document.getElementById('mobile-menu');
  var overlay = document.querySelector('.menu-overlay');
  var toggleBtn = document.querySelector('[data-menu-open]');

  function openMenu() {
    if (!menu) return;
    menu.classList.add('is-open');
    menu.setAttribute('aria-hidden', 'false');
    if (overlay) { overlay.hidden = false; overlay.classList.add('is-open'); }
    if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    if (!menu) return;
    menu.classList.remove('is-open');
    menu.setAttribute('aria-hidden', 'true');
    if (overlay) { overlay.classList.remove('is-open'); overlay.hidden = true; }
    if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (toggleBtn) toggleBtn.addEventListener('click', openMenu);
  document.querySelectorAll('[data-menu-close]').forEach(function (el) {
    el.addEventListener('click', closeMenu);
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && menu && menu.classList.contains('is-open')) closeMenu();
  });
  // Close the drawer when the viewport grows back to desktop.
  window.addEventListener('resize', function () {
    if (window.innerWidth >= 880 && menu && menu.classList.contains('is-open')) closeMenu();
  });

  /* ---------------------------------------------------------------------
     Accordions — keep only one panel open per group
  --------------------------------------------------------------------- */
  document.querySelectorAll('.accordion').forEach(function (group) {
    var items = group.querySelectorAll('details.accordion__item');
    items.forEach(function (item) {
      item.addEventListener('toggle', function () {
        if (!item.open) return;
        items.forEach(function (other) {
          if (other !== item) other.open = false;
        });
      });
    });
  });

  /* ---------------------------------------------------------------------
     Forms — progressive enhancement
     Falls back to a normal POST + redirect when JS or fetch is unavailable.
  --------------------------------------------------------------------- */
  document.querySelectorAll('form[data-form]').forEach(function (form) {
    var wrap = form.parentElement;
    var success = wrap ? wrap.querySelector('[data-form-success]') : null;

    form.addEventListener('submit', function (e) {
      if (!window.fetch) return; // let the browser POST normally
      e.preventDefault();

      var submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) { submitBtn.disabled = true; }

      fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
      })
        .then(function (r) { return r.json().catch(function () { return { ok: r.ok }; }); })
        .then(function (data) {
          if (data && data.ok) {
            if (success) { form.classList.add('is-hidden'); success.classList.remove('is-hidden'); }
            form.reset();
          } else {
            showError(form, data && data.error);
          }
        })
        .catch(function () { showError(form); })
        .finally(function () { if (submitBtn) submitBtn.disabled = false; });
    });
  });

  function showError(form, msg) {
    var existing = form.querySelector('.form__error');
    if (!existing) {
      existing = document.createElement('p');
      existing.className = 'form__error';
      existing.setAttribute('role', 'alert');
      form.insertBefore(existing, form.firstChild);
    }
    existing.textContent = msg || 'Sorry — something went wrong. Please try again or email us directly.';
  }

  // "Send another" / "Raise another" — flip success panel back to the form.
  document.querySelectorAll('[data-form-reset]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var wrap = btn.closest('.contact__form-col, .support__block');
      if (!wrap) return;
      var success = wrap.querySelector('[data-form-success]');
      var form = wrap.querySelector('form[data-form]');
      if (success) success.classList.add('is-hidden');
      if (form) form.classList.remove('is-hidden');
    });
  });
})();
