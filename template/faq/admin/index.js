// Get the modal
var modalModify = document.getElementById('modalModify');
var modalDelete = document.getElementById('modalDelete');
var modalAdd = document.getElementById('modalAdd');

// Get the button that opens the modal
var buttonsModify = document.getElementsByClassName('modify');
var buttonsDelete = document.getElementsByClassName('delete');
var buttonAdd = document.getElementById('add');

// Get the <span> and <button> element that closes the modal
var spanModify = document.getElementById('closeModify');
var spanDelete = document.getElementById('closeDelete');
var spanAdd = document.getElementById('closeAdd');
var buttonsClose = document.getElementsByClassName('cancel');

// When the user clicks the button, open the modal
buttonAdd.onclick = function () {
  modalAdd.showModal();
};

for (var i = 0; i < buttonsModify.length; i++) {
  buttonsModify[i].onclick = function () {
    modalModify.showModal();
    var id = this.getAttribute('data-id');
    var question = this.getAttribute('data-question');
    var answer = this.getAttribute('data-answer');

    var questionInput = document.getElementById('question');
    var answerInput = document.getElementById('answer');
    var idInput = document.getElementById('id');

    idInput.value = id;
    questionInput.value = question;
    answerInput.value = answer;
  };
}

for (var i = 0; i < buttonsDelete.length; i++) {
  buttonsDelete[i].onclick = function () {
    modalDelete.showModal();
    var id = this.getAttribute('data-id');
    var idInput = document.getElementById('idDelete');
    idInput.value = id;
  };
}

// When the user clicks on <span> (x), close the modal
spanModify.onclick = function () {
  modalModify.close();
};

spanDelete.onclick = function () {
  modalDelete.close();
};

spanAdd.onclick = function () {
  modalAdd.close();
};

for (var i = 0; i < buttonsClose.length; i++) {
  buttonsClose[i].onclick = function () {
    modalModify.close();
    modalDelete.close();
    modalAdd.close();
  };
}

// When the user clicks anywhere outside of the modal, close it
window.onmousedown = function (event) {
  if (event.target == modalModify) {
    modalModify.close();
  }
  if (event.target == modalDelete) {
    modalDelete.close();
  }

  if (event.target == modalAdd) {
    modalAdd.close();
  }
};
