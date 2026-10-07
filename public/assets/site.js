(function () {
  var c = document.querySelector('.count');
  if (c) {
    var t = new Date(c.dataset.date).getTime();
    var tick = function () {
      var d = t - Date.now();
      if (d <= 0) { c.textContent = 'Today is the day'; return; }
      var n = function (x, l) { return '<div><b>' + x + '</b>' + l + '</div>'; };
      c.innerHTML = n(Math.floor(d / 864e5), 'days') + n(Math.floor(d % 864e5 / 36e5), 'hours') + n(Math.floor(d % 36e5 / 6e4), 'min');
    };
    tick(); setInterval(tick, 30000);
  }
  var lb = document.getElementById('lb');
  document.querySelectorAll('.gallery img').forEach(function (i) {
    i.addEventListener('click', function () {
      lb.querySelector('img').src = i.dataset.full;
      lb.querySelector('p').textContent = i.alt;
      lb.showModal();
    });
  });
  if (lb) lb.addEventListener('click', function () { lb.close(); });
})();
