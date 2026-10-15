(function(){
  // ---- menu mobile ----
  var menuToggle = document.getElementById('menuToggle');
  var mobileMenu = document.getElementById('mobileMenu');
  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', function(){
      var open = mobileMenu.classList.toggle('open');
      menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // ---- toast helper ----
  var toastEl = document.getElementById('toast');
  var toastTimer;
  function showToast(msg){
    if (!toastEl) return;
    toastEl.textContent = msg;
    toastEl.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function(){ toastEl.classList.remove('show'); }, 3200);
  }

  // Botões cujo link ainda não foi configurado (app/config.php → links):
  // mantêm o aviso do protótipo até a URL real ser informada.
  document.querySelectorAll('[data-link-pendente]').forEach(function(el){
    el.addEventListener('click', function(e){
      e.preventDefault();
      showToast(el.getAttribute('data-link-pendente'));
    });
  });

  // ---- modal do certificado CAL 0807 ----
  var certModal = document.getElementById('certModal');
  var lastFocus = null;
  function focusables(){
    return Array.prototype.slice.call(certModal.querySelectorAll('a[href], button:not([disabled])'));
  }
  function openCertModal(){
    lastFocus = document.activeElement;
    certModal.classList.add('open');
    document.body.style.overflow = 'hidden';
    var f = focusables();
    if (f.length) f[0].focus();
  }
  function closeCertModal(){
    certModal.classList.remove('open');
    document.body.style.overflow = '';
    if (lastFocus) lastFocus.focus();
  }
  if (certModal) {
    document.querySelectorAll('[data-open-cert]').forEach(function(el){
      el.addEventListener('click', openCertModal);
    });
    certModal.querySelectorAll('[data-close-cert]').forEach(function(el){
      el.addEventListener('click', closeCertModal);
    });
    certModal.addEventListener('click', function(e){
      if (e.target === certModal) closeCertModal();
    });
    document.addEventListener('keydown', function(e){
      if (!certModal.classList.contains('open')) return;
      if (e.key === 'Escape') { closeCertModal(); return; }
      if (e.key === 'Tab') {
        var f = focusables(), first = f[0], last = f[f.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
      }
    });
  }

  // ---- envio dos formulários (fetch; sem JS o POST normal também funciona) ----
  document.querySelectorAll('form.pform[data-ajax]').forEach(function(f){
    var errorBox = f.querySelector('.form-error');
    var successBox = f.querySelector('.form-success');
    var submitBtn = f.querySelector('button[type="submit"]');

    f.addEventListener('submit', function(e){
      e.preventDefault();
      if (f.classList.contains('is-sending')) return;
      f.classList.remove('has-error');
      f.classList.add('is-sending');
      submitBtn.disabled = true;

      fetch(f.action, {
        method: 'POST',
        body: new FormData(f),
        headers: { 'Accept': 'application/json' }
      })
        .then(function(r){
          return r.json().catch(function(){ return { ok: false }; });
        })
        .then(function(data){
          if (data.ok) {
            f.classList.add('submitted');
            successBox.focus();
          } else {
            showError(data.message);
          }
        })
        .catch(function(){ showError(); })
        .then(function(){
          f.classList.remove('is-sending');
          submitBtn.disabled = false;
          if (window.turnstile && f.querySelector('.cf-turnstile')) {
            window.turnstile.reset(f.querySelector('.cf-turnstile'));
          }
        });
    });

    function showError(msg){
      if (msg) errorBox.textContent = msg;
      f.classList.add('has-error');
      errorBox.focus();
    }
  });

  // ---- busca no catálogo de equipamentos ----
  var equipSearch = document.getElementById('equipSearch');
  if (equipSearch) {
    var equipGrid = document.getElementById('equipGrid');
    var equipEmpty = document.getElementById('equipEmpty');
    var equipCount = document.getElementById('equipCount');
    var allChips = Array.prototype.slice.call(equipGrid.querySelectorAll('.pchip'));
    var totalEquip = allChips.length;
    equipSearch.addEventListener('input', function(){
      var q = equipSearch.value.trim().toLowerCase();
      var visible = 0;
      allChips.forEach(function(chip){
        var match = chip.getAttribute('data-name').indexOf(q) !== -1;
        chip.classList.toggle('hidden', !match);
        if (match) visible++;
      });
      equipEmpty.classList.toggle('show', visible === 0);
      equipCount.textContent = q ? (visible + ' de ' + totalEquip) : (totalEquip + ' itens');
    });
  }
})();
