const forms = document.querySelectorAll('.wpcf7-form');
forms.forEach(form => {
  const brs = form.querySelectorAll('br');
  brs.forEach(br => br.remove());
});