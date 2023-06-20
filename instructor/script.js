const darkModeButton = document.querySelector('.dark-mode-button');
const body = document.querySelector('body');

darkModeButton.addEventListener('click', () => {
  body.classList.toggle('dark-mode');
});
