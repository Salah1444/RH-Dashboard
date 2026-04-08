import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// ── Chart: Effectifs
  const ctx1 = document.getElementById('chartEffectifs').getContext('2d');
  new Chart(ctx1, {
    type: 'line',
    data: {
      labels: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
      datasets: [{
        label: 'Effectifs',
        data: [1180, 1195, 1200, 1208, 1210, 1215, 1215, 1220, 1225, 1230, 1240, 1248],
        borderColor: '#4e73df',
        backgroundColor: 'rgba(78,115,223,.08)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#4e73df',
        pointRadius: 4,
        borderWidth: 2
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { grid: { color: '#f0f0f7' }, ticks: { font: { family: 'Nunito', size: 11 } } },
        x: { grid: { display: false }, ticks: { font: { family: 'Nunito', size: 11 } } }
      }
    }
  });

  // ── Chart: Sexe
  const ctx2 = document.getElementById('chartSexe').getContext('2d');
  new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: ['Hommes', 'Femmes'],
      datasets: [{
        data: [712, 536],
        backgroundColor: ['#4e73df', '#e74a3b'],
        borderWidth: 2, borderColor: '#fff'
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` } }
      },
      cutout: '70%'
    }
  });

  // ── Chart: Région
  const ctx3 = document.getElementById('chartRegion').getContext('2d');
  new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: ['Souss-Massa', 'Marrakech-Safi', 'Casablanca-Settat', 'Rabat-Salé', 'Fès-Meknès', 'Autres'],
      datasets: [{
        label: 'Employés',
        data: [320, 245, 210, 180, 150, 143],
        backgroundColor: ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b','#858796'],
        borderRadius: 6,
        borderSkipped: false
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { grid: { color: '#f0f0f7' }, ticks: { font: { family: 'Nunito', size: 10 } } },
        x: { grid: { display: false }, ticks: { font: { family: 'Nunito', size: 10 } } }
      }
    }
  });
