const form = document.getElementById('profile-form');
const dialog = document.getElementById('dialog');
const btnPwd = document.getElementById('btn-pwd');

form.addEventListener('submit', function (event) {
  if (!isModified()) {
    event.preventDefault();
    alert('Aucune modification détectée');
  }
});

btnPwd.addEventListener('click', function () {
  dialog.showModal();
});

dialog.addEventListener('close', function () {
  const inputs = dialog.querySelectorAll('.input');
  inputs.forEach((input) => {
    input.value = '';
  });
});

dialog.querySelector('form').addEventListener('submit', function (event) {
  const currentPassword = document.getElementById('currentPassword');
  const newPassword = document.getElementById('newPassword');
  const confirmPassword = document.getElementById('confirmPassword');
  if (currentPassword.value === newPassword.value) {
    event.preventDefault();
    alert("Le nouveau mot de passe doit être différent de l'ancien");
  } else if (newPassword.value !== confirmPassword.value) {
    event.preventDefault();
    alert('Les mots de passe ne correspondent pas');
  }
});

window.addEventListener('mousedown', function (event) {
  if (event.target === dialog) {
    dialog.close();
  }
});
