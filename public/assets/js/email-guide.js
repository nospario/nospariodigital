/*
 * Email setup guide (/email-setup) — progressive enhancement.
 * Without JS every device guide, app version and IMAP/POP value is shown.
 * With JS: device tabs, app-version tabs, an IMAP/POP switch and copy buttons.
 * Loaded (not deferred) straight after #email-guide so it runs before first paint.
 */
(function () {
  'use strict';

  var root = document.getElementById('email-guide');
  if (!root) return;
  root.classList.add('is-enhanced');

  function all(sel, ctx) { return Array.prototype.slice.call((ctx || root).querySelectorAll(sel)); }
  function unhide(sel) { all(sel).forEach(function (el) { el.hidden = false; }); }

  // ---- IMAP / POP switch --------------------------------------------------
  unhide('[data-proto-switch]');
  unhide('[data-proto-switch-wrap]');

  function setProto(p) {
    root.setAttribute('data-proto', p);
    all('[data-proto-btn]').forEach(function (b) {
      b.setAttribute('aria-pressed', String(b.getAttribute('data-proto-btn') === p));
    });
  }
  all('[data-proto-btn]').forEach(function (b) {
    b.addEventListener('click', function () { setProto(b.getAttribute('data-proto-btn')); });
  });

  // ---- Device tabs ----------------------------------------------------------
  var tabList = root.querySelector('[data-device-tabs]');
  var tabs = all('[data-device-tab]');
  var panels = all('[data-device-panel]');

  if (tabList && tabs.length) {
    tabList.setAttribute('role', 'tablist');
    tabs.forEach(function (t) {
      var id = t.getAttribute('data-device-tab');
      t.setAttribute('role', 'tab');
      t.setAttribute('aria-controls', 'guide-' + id);
      t.id = 'tab-' + id;
    });
    panels.forEach(function (p) {
      p.setAttribute('role', 'tabpanel');
      p.setAttribute('aria-labelledby', 'tab-' + p.getAttribute('data-device-panel'));
    });
  }

  function setDevice(id, focus) {
    tabs.forEach(function (t) {
      var on = t.getAttribute('data-device-tab') === id;
      t.setAttribute('aria-selected', String(on));
      t.tabIndex = on ? 0 : -1;
      if (on && focus) t.focus();
    });
    panels.forEach(function (p) { p.hidden = p.getAttribute('data-device-panel') !== id; });
  }

  tabs.forEach(function (t, i) {
    t.addEventListener('click', function (ev) {
      ev.preventDefault();
      var id = t.getAttribute('data-device-tab');
      setDevice(id);
      if (history.replaceState) history.replaceState(null, '', '#guide-' + id);
    });
    t.addEventListener('keydown', function (ev) {
      var next = null;
      if (ev.key === 'ArrowRight' || ev.key === 'ArrowDown') next = tabs[(i + 1) % tabs.length];
      if (ev.key === 'ArrowLeft' || ev.key === 'ArrowUp') next = tabs[(i - 1 + tabs.length) % tabs.length];
      if (ev.key === 'Home') next = tabs[0];
      if (ev.key === 'End') next = tabs[tabs.length - 1];
      if (next) {
        ev.preventDefault();
        setDevice(next.getAttribute('data-device-tab'), true);
      }
    });
  });

  // Open the device named in the URL (#guide-android), else the first one.
  function deviceFromHash() {
    var m = /^#guide-([a-z]+)/.exec(location.hash);
    var id = m && root.querySelector('[data-device-panel="' + m[1] + '"]') ? m[1] : null;
    return id || (tabs[0] && tabs[0].getAttribute('data-device-tab'));
  }
  if (tabs.length) setDevice(deviceFromHash());
  window.addEventListener('hashchange', function () {
    if (/^#guide-/.test(location.hash)) setDevice(deviceFromHash());
  });

  // ---- App-version tabs (Android: Gmail / Samsung, Outlook: New / Classic) ---
  all('[data-device-panel]').forEach(function (panel) {
    var group = panel.querySelector('[data-variant-tabs]');
    if (!group) return;
    group.hidden = false;
    var btns = all('[data-variant-btn]', group);

    function setVariant(vid) {
      btns.forEach(function (b) { b.setAttribute('aria-pressed', String(b.getAttribute('data-variant-btn') === vid)); });
      all('[data-variant]', panel).forEach(function (el) { el.hidden = el.getAttribute('data-variant') !== vid; });
    }
    btns.forEach(function (b) {
      b.addEventListener('click', function () { setVariant(b.getAttribute('data-variant-btn')); });
    });
    setVariant(btns[0].getAttribute('data-variant-btn'));
  });

  // ---- Copy buttons ------------------------------------------------------
  if (navigator.clipboard && window.isSecureContext) {
    all('[data-copy]').forEach(function (b) {
      b.hidden = false;
      var timer;
      b.addEventListener('click', function () {
        navigator.clipboard.writeText(b.getAttribute('data-copy')).then(function () {
          b.textContent = 'Copied';
          b.classList.add('is-copied');
          clearTimeout(timer);
          timer = setTimeout(function () {
            b.textContent = 'Copy';
            b.classList.remove('is-copied');
          }, 1600);
        }).catch(function () {});
      });
    });
  }

  // ---- Printing: open every troubleshooting answer, restore afterwards ------
  var details = all('.gtrouble__item');
  var wasOpen = [];
  window.addEventListener('beforeprint', function () {
    wasOpen = details.map(function (d) { return d.open; });
    details.forEach(function (d) { d.open = true; });
  });
  window.addEventListener('afterprint', function () {
    details.forEach(function (d, i) { d.open = !!wasOpen[i]; });
  });
})();
