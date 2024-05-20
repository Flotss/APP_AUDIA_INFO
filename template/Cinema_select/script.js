function scrollLeft() {
  const cinemaList = document.querySelector('.cinema-list');
  cinemaList.scrollBy({ left: -cinemaList.clientWidth, behavior: 'smooth' });
}

function scrollRight() {
  const cinemaList = document.querySelector('.cinema-list');
  cinemaList.scrollBy({ left: cinemaList.clientWidth, behavior: 'smooth' });
}
