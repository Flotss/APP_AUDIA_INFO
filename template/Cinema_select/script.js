function scrollLeft() {
  const cinemaList = document.querySelector('.cinema-list');
  const scrollAmount = -cinemaList.clientWidth;
  const currentPosition = cinemaList.scrollLeft;
  const totalWidth = cinemaList.scrollWidth;

  if (currentPosition + scrollAmount <= 0) {
    cinemaList.scrollTo({ left: totalWidth, behavior: 'smooth' });
  } else {
    cinemaList.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  }
}

function scrollRight() {
  const cinemaList = document.querySelector('.cinema-list');
  const scrollAmount = cinemaList.clientWidth;
  const currentPosition = cinemaList.scrollLeft;
  const totalWidth = cinemaList.scrollWidth;

  if (currentPosition + scrollAmount >= totalWidth) {
    cinemaList.scrollTo({ left: 0, behavior: 'smooth' });
  } else {
    cinemaList.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  }
}
