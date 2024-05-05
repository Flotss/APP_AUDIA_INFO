const questionsElements = document.querySelectorAll('.question');

// for each add click event
questionsElements.forEach((questionElement) => {
  questionElement.addEventListener('click', () => {
    // toggle the class of the parent element
    questionElement.classList.toggle('active');
  });
});
