document.body.onload = function () {
  console.log('Chart.js loaded');
  // input name idCinema
  const idCinema = document.getElementById('idCinema').value;

  const data = [
    { date: 2010, value: 10 },
    { date: 2010, value: 10 },
    { date: 2010, value: 10 },
    { date: 2010, value: 10 },
    { date: 2011, value: 20 },
    { date: 2012, value: 15 },
    { date: 2013, value: 25 },
    { date: 2014, value: 22 },
    { date: 2015, value: 30 },
    { date: 2016, value: 28 },
  ];

  (async () => {
    const response = await fetch(
      'http://localhost/api/monitoring?id=' + idCinema
    );
    console.log(response.body);
    const data = await response.json();

    const dataTemp = data.dataTemperature;
    const dataSound = data.dataSound;
    const dataCO2 = data.dataCO2;

    const chart = new Chart(document.getElementById('temperature-chart'), {
      type: 'line',
      data: {
        labels: dataTemp.map((row) => row.date),
        datasets: [
          {
            label: 'Temperature (°C)',
            data: dataTemp.map((row) => row.value),
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
        labels: dataSound.map((row) => row.value),
        datasets: [
          {
            label: 'Niveau Sonore (dB)',
            data: dataSound.map((row) => row.value),
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
        labels: dataCO2.map((row) => row.date),
        datasets: [
          {
            label: 'Niveau de CO2 (ppm)',
            data: dataCO2.map((row) => row.value),
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1,
          },
        ],
      },
    });
  })();
  // AJAX
};
