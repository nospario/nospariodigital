/* Nospario Digital — live system status
   Fetches the Heart Internet status feed, maps statuses to labels/colours
   exactly as the prototype did, renders the banner + per-service rows, and
   refreshes every 120s. Fails silently to the static server-rendered fallback.
*/
(function () {
  'use strict';

  var FEED = 'https://www.heartstatus.uk/index.json';
  var REFRESH_MS = 120000;

  function statusMeta(s) {
    switch (s) {
      case 'operational': return { label: 'Operational', color: '#2E9E6B' };
      case 'degraded':
      case 'degraded_performance': return { label: 'Degraded', color: '#D99A2B' };
      case 'maintenance':
      case 'under_maintenance': return { label: 'Maintenance', color: '#D99A2B' };
      case 'partial_outage': return { label: 'Partial outage', color: '#E07B39' };
      case 'major_outage':
      case 'outage':
      case 'down': return { label: 'Outage', color: '#D9534F' };
      default: return {
        label: s ? (s.charAt(0).toUpperCase() + s.slice(1).replace(/_/g, ' ')) : 'Unknown',
        color: '#9A9CA1'
      };
    }
  }

  function aggMeta(a) {
    if (a === 'operational') return { text: 'All systems operational', color: '#1F7A53', bg: '#EAF6F0', border: '#CBEBDB', dot: '#2E9E6B' };
    if (a === 'major_outage' || a === 'outage' || a === 'down') return { text: 'Major service outage', color: '#A03A37', bg: '#FBECEB', border: '#F2CFCD', dot: '#D9534F' };
    if (a === 'maintenance' || a === 'under_maintenance') return { text: 'Scheduled maintenance in progress', color: '#8A5E12', bg: '#FBF3E1', border: '#F0E2BE', dot: '#D99A2B' };
    if (a === 'partial_outage') return { text: 'Partial service disruption', color: '#8A5E12', bg: '#FBF3E1', border: '#F0E2BE', dot: '#D99A2B' };
    return { text: 'Some systems degraded', color: '#8A5E12', bg: '#FBF3E1', border: '#F0E2BE', dot: '#D99A2B' };
  }

  function parseFeed(j) {
    var inc = j.included || [];
    var secs = inc.filter(function (x) { return x.type === 'status_page_section'; });
    var overallSec = secs.find(function (s) { return /overall/i.test(s.attributes.name); }) ||
      secs.slice().sort(function (a, b) { return (a.attributes.position || 0) - (b.attributes.position || 0); })[0];
    var sid = overallSec ? String(overallSec.id) : null;
    var items = inc
      .filter(function (x) {
        return x.type === 'status_page_resource' &&
          (sid === null || String(x.attributes.status_page_section_id) === sid);
      })
      .sort(function (a, b) { return (a.attributes.position || 0) - (b.attributes.position || 0); })
      .map(function (x) {
        return {
          name: String(x.attributes.public_name || '')
            .replace(/\s+/g, ' ')
            .replace(/^heart internet\s*-\s*/i, '')
            .trim() || 'Service',
          status: x.attributes.status,
          availability: typeof x.attributes.availability === 'number' ? x.attributes.availability : null
        };
      });
    return {
      aggregate: j.data && j.data.attributes ? j.data.attributes.aggregate_state : null,
      updatedAt: j.data && j.data.attributes ? j.data.attributes.updated_at : null,
      items: items
    };
  }

  function render(live) {
    if (!live || !live.items || !live.items.length) return;

    var b = aggMeta(live.aggregate);

    // Banner
    var banner = document.querySelector('[data-status-banner]');
    if (banner) {
      banner.style.background = b.bg;
      banner.style.borderColor = b.border;
      var bTitle = banner.querySelector('[data-status-text]');
      if (bTitle) { bTitle.textContent = b.text; bTitle.style.color = b.color; }
      var bSub = banner.querySelector('[data-status-sub]');
      if (bSub) {
        var sub = 'Live status';
        if (live.updatedAt) {
          try {
            sub = 'Updated ' + new Date(live.updatedAt).toLocaleString('en-GB',
              { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });
          } catch (e) {}
        }
        bSub.textContent = sub;
      }
      var bDot = banner.querySelector('[data-status-dot]');
      if (bDot) bDot.style.background = b.dot;
    }

    // Per-service rows
    var list = document.querySelector('[data-status-list]');
    if (list) {
      list.innerHTML = live.items.map(function (it) {
        var m = statusMeta(it.status);
        var uptime = it.availability != null ? (it.availability * 100).toFixed(2) + '%' : '—';
        return '<div class="status-row">' +
          '<div class="status-row__main">' +
            '<span class="status-dot" style="background:' + m.color + '"></span>' +
            '<div><div class="status-row__name"></div>' +
            '<div class="status-row__meta"></div></div>' +
          '</div>' +
          '<span class="status-row__label" style="color:' + m.color + '"></span>' +
        '</div>';
      }).join('');
      // Fill text nodes safely (avoid injecting feed strings as HTML).
      var rows = list.querySelectorAll('.status-row');
      live.items.forEach(function (it, i) {
        var m = statusMeta(it.status);
        var uptime = it.availability != null ? (it.availability * 100).toFixed(2) + '%' : '—';
        var row = rows[i];
        if (!row) return;
        row.querySelector('.status-row__name').textContent = it.name;
        row.querySelector('.status-row__meta').textContent = uptime + ' uptime · 90 days';
        row.querySelector('.status-row__label').textContent = m.label;
      });
    }

    // Hero chip + footer dot/text
    document.querySelectorAll('[data-status-chip], [data-status-footer]').forEach(function (el) {
      var dot = el.querySelector('[data-status-dot]');
      var txt = el.querySelector('[data-status-text]');
      if (dot) dot.style.background = b.dot;
      if (txt) txt.textContent = b.text;
    });
  }

  function fetchStatus() {
    if (!window.fetch) return;
    fetch(FEED, { cache: 'no-store' })
      .then(function (r) { return r.json(); })
      .then(function (j) { render(parseFeed(j)); })
      .catch(function () { /* keep the static fallback */ });
  }

  fetchStatus();
  setInterval(fetchStatus, REFRESH_MS);
})();
