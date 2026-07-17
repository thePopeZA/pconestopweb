/* PC One Stop — main.js (no dependencies) */
(function () {
  "use strict";

  /* mobile nav */
  var toggle = document.querySelector(".nav-toggle");
  var nav = document.getElementById("nav");
  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      var open = nav.classList.toggle("open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
      toggle.textContent = open ? "CLOSE" : "MENU";
    });
  }

  /* live products from the shop */
  var live = document.getElementById("live");
  var grid = document.getElementById("prod-grid");
  if (live && grid) {
    live.hidden = false;
    fetch("/api/featured.php")
      .then(function (r) { if (!r.ok) throw 0; return r.json(); })
      .then(function (data) {
        var items = (data && data.products) || [];
        if (!items.length) { live.hidden = true; return; }
        var esc = function (s) {
          return String(s == null ? "" : s).replace(/[&<>"']/g, function (c) {
            return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
          });
        };
        grid.innerHTML = items.slice(0, 8).map(function (p) {
          var save = p.was ? '<span class="save">SALE</span>' : "";
          var was = p.was ? '<span class="was">' + esc(p.was) + "</span>" : "";
          var stock = p.stock
            ? '<span class="stock' + (/low/i.test(p.stock) ? " low" : "") + '">● ' + esc(p.stock) + "</span>"
            : "";
          var img = p.image
            ? '<img src="' + esc(p.image) + '" alt="" loading="lazy" width="220" height="220">'
            : "";
          return (
            '<a class="prod" href="' + esc(p.url) + '">' + save +
            '<span class="prod-img">' + img + "</span>" +
            '<span class="brand">' + esc(p.brand || "") + "</span>" +
            "<h3>" + esc(p.name) + "</h3>" + stock +
            '<span class="price">' + esc(p.price) + was + "</span></a>"
          );
        }).join("");
      })
      .catch(function () { live.hidden = true; });
  }

  /* contact form — AJAX with no-JS fallback */
  var form = document.getElementById("contact-form");
  if (form) {
    var ok = document.getElementById("form-ok");
    var err = document.getElementById("form-err");
    /* show state after non-JS redirect */
    var q = location.search;
    if (/[?&]sent=1/.test(q) && ok) ok.classList.add("show");
    if (/[?&]err=1/.test(q) && err) err.classList.add("show");

    form.addEventListener("submit", function (e) {
      if (!window.fetch) return; /* let the browser POST normally */
      e.preventDefault();
      var btn = form.querySelector("[type=submit]");
      btn.disabled = true; btn.textContent = "Sending…";
      ok.classList.remove("show"); err.classList.remove("show");
      fetch(form.action, { method: "POST", body: new FormData(form), headers: { "X-Requested-With": "fetch" } })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (d && d.ok) { ok.classList.add("show"); form.reset(); }
          else { err.classList.add("show"); }
        })
        .catch(function () { err.classList.add("show"); })
        .finally(function () {
          btn.disabled = false; btn.textContent = "Send message →";
          (d => d && d.scrollIntoView({ behavior: "smooth", block: "center" }))(
            ok.classList.contains("show") ? ok : err
          );
        });
    });
  }
})();
