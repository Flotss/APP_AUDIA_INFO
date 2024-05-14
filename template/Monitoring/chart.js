document.body.onload = function () {
  console.log('Chart.js loaded');
  const data = [
    { year: 2010, count: 10 },
    { year: 2011, count: 20 },
    { year: 2012, count: 15 },
    { year: 2013, count: 25 },
    { year: 2014, count: 22 },
    { year: 2015, count: 30 },
    { year: 2016, count: 28 },
  ];
  fetch('src/ApiController/MonitoringApiController.php');
  // AJAX
  //Promise 
  const chart = new Chart(document.getElementById('temperature-chart'), {
    type: 'line',
    data: {
      labels: data.map((row) => row.year),
      datasets: [
        {
          label: 'Temperature (°C)',
          data: data.map((row) => row.count),
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1,
        },
      ],
    },
  });

  const chart1 = new Chart(document.getElementById('sound-level-chart'), {
    type: 'line',
    data: {
      labels: data.map((row) => row.year),
      datasets: [
        {
          label: 'Niveau Sonore (dB)',
          data: data.map((row) => row.count),
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1,
        },
      ],
    },
  });

  const chart2 = new Chart(document.getElementById('co2-level-chart'), {
    type: 'line',
    data: {
      labels: data.map((row) => row.year),
      datasets: [
        {
          label: 'Niveau de CO2 (ppm)',
          data: data.map((row) => row.count),
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1,
        },
      ],
    },
  });
};
