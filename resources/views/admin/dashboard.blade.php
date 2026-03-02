@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
   <style>
    :root {
        /* Colores principales */
        --color-primary: #5a2a83;
        --color-primary-light: #B399D4;
        --color-primary-lighter: #E6E0F0;
        --color-primary-dark: #6A3D9A;

        --color-secondary: #3ba2f0;
        --color-accent: #f0933b;

        /* Variantes de morado para gráficas */
        --chart-purple-1: #8A4FFF; /* Morado vibrante */
        --chart-purple-2: #6A3D9A; /* Morado medio */
        --chart-purple-3: #9B72CF; /* Morado lavanda */
        --chart-purple-4: #B399D4; /* Morado pastel */
        --chart-purple-5: #4A2C80; /* Morado oscuro */
        --chart-purple-6: #C9B6E8; /* Morado claro */
        --chart-purple-7: #7B5ACB; /* Morado azulado */
        --chart-purple-8: #A885D8; /* Morado suave */
        --chart-purple-9: #5E3F8E; /* Morado intenso */
        --chart-purple-10: #D4C5F4; /* Morado muy claro */
    }

    /* Aplicar colores morados a las gráficas */
    .chart-colors {
        --chart-color-1: var(--chart-purple-1);
        --chart-color-2: var(--chart-purple-2);
        --chart-color-3: var(--chart-purple-3);
        --chart-color-4: var(--chart-purple-4);
        --chart-color-5: var(--chart-purple-5);
        --chart-color-6: var(--chart-purple-6);
        --chart-color-7: var(--chart-purple-7);
        --chart-color-8: var(--chart-purple-8);
        --chart-color-9: var(--chart-purple-9);
        --chart-color-10: var(--chart-purple-10);
    }

      :root {
          --color-success: #28a745;
          --color-info: #17a2b8;
          --color-text: #4A4A4A;
          --color-text-light: #7A7A7A;
          --color-bg: #F9F6FC;
          --color-warning: #ffc107;
          --color-danger: #dc3545;
          --color-white: #FFFFFF;
          --color-border: #E1D8EB;
          --shadow-card: 0 4px 12px rgba(139, 95, 191, 0.1);
          --shadow-hover: 0 8px 24px rgba(139, 95, 191, 0.15);
        }

        /* Estilos generales */
        .text-purple {
          color: var(--color-primary);
        }
        
        .bg-purple-gradient {
          background-color: var(--color-primary);
        }

        /* Tarjetas de resumen compactas */
        .card-admin {
          background: var(--color-white);
          border-radius: 16px;
          padding: 1.75rem 1.25rem;
          text-align: center;
          box-shadow: var(--shadow-card);
          transition: all 0.3s ease;
          border: none;
          position: relative;
          overflow: hidden;
          height: 100%;
          display: flex;
          flex-direction: column;
          border: 1px solid var(--color-border);
        }
        
        .card-admin::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 5px;
          background-color: var(--color-primary);
        }
        
        .card-admin:hover {
          transform: translateY(-5px);
          box-shadow: var(--shadow-hover);
          border-color: var(--color-primary-light);
        }
        
        .icon-wrapper {
          background-color: var(--color-primary);
          color: var(--color-white);
          width: 60px;
          height: 60px;
          display: flex;
          align-items: center;
          justify-content: center;
          border-radius: 18px;
          font-size: 24px;
          margin: 0 auto 1.25rem;
          box-shadow: 0 6px 15px rgba(139, 95, 191, 0.25);
          transition: all 0.3s ease;
        }
        
        .card-admin:hover .icon-wrapper {
          transform: scale(1.05);
          box-shadow: 0 8px 20px rgba(139, 95, 191, 0.35);
        }
        
        .card-admin h5 {
          font-weight: 600;
          color: var(--color-primary-dark);
          margin-bottom: 0.75rem;
          font-size: 1rem;
        }
        
        .card-admin .count {
          font-size: 2.25rem;
          font-weight: 800;
          color: var(--color-primary);
          margin: 0.5rem 0;
          line-height: 1.2;
          font-family: 'Montserrat', sans-serif;
        }
        
        .card-admin .btn-sm {
          margin-top: auto;
          font-size: 0.85rem;
          padding: 0.5rem 1rem;
          border-radius: 10px;
          background: var(--color-primary);
          color: var(--color-white);
          border: none;
          font-weight: 500;
          transition: all 0.3s ease;
        }

        .card-admin .btn-sm:hover {
          background: var(--color-primary-dark);
          transform: translateY(-2px);
          box-shadow: 0 4px 12px rgba(139, 95, 191, 0.3);
        }

        /* Botones */
        .btn-purple {
          background: var(--color-primary);
          color: var(--color-white);
          font-weight: 500;
          border: none;
          transition: all 0.3s ease;
          border-radius: 10px;
          padding: 0.5rem 1.25rem;
        }
        
        .btn-purple:hover {
          background: var(--color-primary-dark);
          transform: translateY(-2px);
          box-shadow: 0 4px 12px rgba(139, 95, 191, 0.25);
          color: var(--color-white);
        }

        /* Sección de gráficos */
        .chart-section {
          margin-bottom: 2rem;
          background: var(--color-white);
          border-radius: 16px;
          padding: 1.75rem;
          box-shadow: var(--shadow-card);
          border: 1px solid var(--color-border);
          transition: all 0.3s ease;
        }
        
        .chart-section:hover {
          box-shadow: var(--shadow-hover);
        }
        
        .chart-wrapper {
          height: 320px;
          padding: 1rem;
          background: var(--color-white);
          border-radius: 12px;
          margin-bottom: 1rem;
          border: 1px solid var(--color-border);
        }
        
        .section-title {
          margin: 0 0 1.75rem 0;
          font-weight: 700;
          font-size: 1.35rem;
          color: var(--color-primary-dark);
          position: relative;
          padding-left: 16px;
          display: flex;
          align-items: center;
        }
        
        .section-title::before {
          content: '';
          position: absolute;
          left: 0;
          top: 5px;
          height: 70%;
          width: 4px;
          background: var(--color-primary);
          border-radius: 3px;
        }

        /* Controles de filtro compactos */
        .filter-container {
          background: var(--color-white);
          border-radius: 16px;
          padding: 1.5rem;
          margin: 2rem 0;
          box-shadow: var(--shadow-card);
          border: 1px solid var(--color-border);
        }
        
        .filter-container label {
          font-weight: 600;
          color: var(--color-primary-dark);
          font-size: 0.9rem;
          margin-bottom: 0.5rem;
        }
        
        .filter-container .form-control,
        .filter-container select {
          border-radius: 10px;
          border: 1px solid var(--color-border);
          padding: 0.5rem 0.75rem;
          font-size: 0.9rem;
          background: var(--color-white);
          transition: all 0.3s ease;
        }
        
        .filter-container .form-control:focus,
        .filter-container select:focus {
          border-color: var(--color-primary);
          box-shadow: 0 0 0 0.25rem rgba(139, 95, 191, 0.15);
        }
        
        .filter-container .btn-dark {
          background: var(--color-primary-dark);
          border-radius: 10px;
          padding: 0.5rem 1rem;
          font-weight: 500;
          font-size: 0.9rem;
          border: none;
          transition: all 0.3s ease;
        }

        .filter-container .btn-dark:hover {
          background: var(--color-primary);
          transform: translateY(-2px);
          box-shadow: 0 4px 12px rgba(139, 95, 191, 0.25);
        }

        /* Estilo para el contenedor principal */
        .admin-container {
          padding: 2rem;
          background: var(--color-bg);
          min-height: 100vh;
        }

        /* PDF Button */
        .pdf-btn {
          background: var(--color-white);
          color: var(--color-primary);
          border: 1px solid var(--color-primary);
          border-radius: 10px;
          padding: 0.4rem 0.9rem;
          font-size: 0.85rem;
          transition: all 0.3s ease;
          font-weight: 500;
        }
        
        .pdf-btn:hover {
          background: var(--color-primary);
          color: var(--color-white);
          transform: translateY(-2px);
          box-shadow: 0 4px 12px rgba(139, 95, 191, 0.2);
        }

        /* Dropdown de notificaciones - Diseño mejorado */
        .notification-dropdown {
          width: 380px;
          border: none;
          border-radius: 16px;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
          overflow: hidden;
          border: 1px solid var(--color-border);
          padding: 0;
        }
        
        .notification-header {
          background-color: var(--color-primary);
          color: var(--color-white);
          padding: 1.25rem 1.5rem;
          border-bottom: 1px solid var(--color-border);
        }
        
        .notification-header h5 {
          font-weight: 600;
          margin: 0;
          display: flex;
          align-items: center;
          font-size: 1.1rem;
        }
        
        .notification-header h5 i {
          margin-right: 0.75rem;
          font-size: 1.25rem;
        }
        
        .notification-body {
          padding: 0;
          max-height: 400px;
          overflow-y: auto;
          background: var(--color-bg);
        }
        
        .notification-item {
          padding: 1rem 1.5rem;
          border-bottom: 1px solid var(--color-border);
          transition: all 0.2s ease;
          display: flex;
          align-items: center;
          justify-content: space-between;
        }
        
        .notification-item:last-child {
          border-bottom: none;
        }
        
        .notification-item:hover {
          background-color: rgba(139, 95, 191, 0.05);
        }
        
        .notification-type {
          font-weight: 600;
          color: var(--color-primary-dark);
          display: flex;
          align-items: center;
          gap: 0.5rem;
        }
        
        .notification-count {
          font-size: 1.1rem;
          font-weight: 700;
        }
        
        .notification-empty {
          padding: 2.5rem 1.5rem;
          text-align: center;
          color: var(--color-text-light);
        }
        
        .notification-empty i {
          font-size: 2.5rem;
          color: var(--color-primary-light);
          margin-bottom: 1rem;
          display: block;
          opacity: 0.7;
        }
        
        .notification-empty p {
          margin: 0;
          font-size: 1rem;
        }

        /* Botón de notificaciones */
        .notification-btn {
          background: var(--color-white);
          border: 1px solid var(--color-border);
          border-radius: 12px;
          padding: 0.6rem;
          color: var(--color-primary);
          transition: all 0.3s ease;
          position: relative;
          display: flex;
          align-items: center;
          justify-content: center;
          width: 46px;
          height: 46px;
        }
        
        .notification-btn:hover {
          background: var(--color-primary-lighter);
          color: var(--color-primary-dark);
          transform: translateY(-2px);
          box-shadow: var(--shadow-card);
        }
        
        .notification-btn i {
          font-size: 1.25rem;
        }
        
        .notification-badge {
          position: absolute;
          top: -5px;
          right: -5px;
          background: var(--color-danger);
          color: white;
          border-radius: 50%;
          width: 22px;
          height: 22px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 0.75rem;
          font-weight: 700;
          border: 2px solid var(--color-white);
          box-shadow: 0 2px 5px rgba(220, 53, 69, 0.3);
          transition: all 0.3s ease;
        }

        .notification-badge.pulse {
          animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
          0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
          }
          70% {
            transform: scale(1.05);
            box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
          }
          100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
          }
        }

        /* Indicador de nuevas notificaciones */
        .new-notification-indicator {
          position: absolute;
          top: 8px;
          right: 8px;
          width: 8px;
          height: 8px;
          background: var(--color-danger);
          border-radius: 50%;
        }

        /* Efecto de sonido visual */
        .sound-wave {
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 3px;
          height: 20px;
        }

        .bar {
          width: 3px;
          height: 100%;
          background-color: var(--color-primary);
          border-radius: 3px;
          animation: soundWave 1.5s ease infinite;
        }

        .bar:nth-child(2) { animation-delay: 0.2s; }
        .bar:nth-child(3) { animation-delay: 0.4s; }
        .bar:nth-child(4) { animation-delay: 0.6s; }
        .bar:nth-child(5) { animation-delay: 0.8s; }

        @keyframes soundWave {
          0%, 100% { height: 5px; }
          50% { height: 20px; }
        }

        /* Header del dashboard */
        .dashboard-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 2.5rem;
          padding: 1.5rem 0;
          border-bottom: 1px solid var(--color-border);
        }
        
        .dashboard-title {
          font-weight: 800;
          color: var(--color-primary-dark);
          font-size: 2rem;
          margin: 0;
        }

        /* Responsividad mejorada */
        @media (max-width: 992px) {
          .admin-container {
            padding: 1.5rem;
          }
          
          .dashboard-title {
            font-size: 1.75rem;
          }
          
          .card-admin {
            padding: 1.5rem 1rem;
          }
          
          .icon-wrapper {
            width: 50px;
            height: 50px;
            font-size: 22px;
          }
          
          .card-admin .count {
            font-size: 2rem;
          }

          .chart-wrapper {
            height: 280px;
          }
          
          .notification-dropdown {
            width: 320px;
          }
        }

        @media (max-width: 768px) {
          .admin-container {
            padding: 1.25rem;
          }
          
          .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
          }
          
          .card-admin {
            padding: 1.25rem 0.75rem;
          }
          
          .icon-wrapper {
            width: 45px;
            height: 45px;
            font-size: 20px;
            border-radius: 14px;
          }
          
          .card-admin .count {
            font-size: 1.75rem;
          }

          .chart-wrapper {
            height: 250px;
          }
          
          .section-title {
            font-size: 1.2rem;
          }
          
          .filter-container {
            padding: 1.25rem;
          }
          
          .notification-dropdown {
            width: 300px;
            right: -50px !important;
          }
        }

        @media (max-width: 576px) {
          .admin-container {
            padding: 1rem;
          }
          
          .dashboard-title {
            font-size: 1.5rem;
          }
          
          .card-admin {
            padding: 1.25rem 0.5rem;
          }
          
          .card-admin .count {
            font-size: 1.6rem;
          }
          
          .notification-dropdown {
            width: 280px;
            right: -80px !important;
          }
        }
    </style>

<!-- Elemento de audio para la notificación (oculto) -->
<audio id="notification-sound" preload="auto">
  <source src="{{ asset('sounds/notification.mp3') }}" type="audio/mpeg">
</audio>

<div class="admin-container">
  <div class="dashboard-header">
    <h1 class="dashboard-title">Dashboard de Administración</h1>
    
    {{-- Dropdown de notificaciones --}}
    <div class="dropdown">
      <button class="notification-btn" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>
        <span class="notification-badge" id="notification-badge" style="display: none;">0</span>
      </button>
      <div class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationsDropdown">
        <div class="notification-header">
          <h5><i class="bi bi-bell me-2"></i> Solicitudes Pendientes</h5>
        </div>
        <div class="notification-body" id="notification-content">
          <div class="notification-empty">
            <div class="sound-wave mb-3">
              <div class="bar"></div>
              <div class="bar"></div>
              <div class="bar"></div>
              <div class="bar"></div>
              <div class="bar"></div>
            </div>
            <p>Cargando notificaciones...</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tarjetas de resumen compactas -->
  <div class="row g-4">
    @php
      $cards = [
        ['Total Usuarios', $userCount, 'admin.usuarios.index', 'bi-people-fill', 'primary'],
        ['Total Eventos', $eventCount, 'admin.eventos.index', 'bi-calendar-event', 'accent'],
        ['Total Emprendimientos', $emprendimientoCount, 'admin.emprendimientos.index', 'bi-lightbulb', 'success'],
        ['Total Cursos/Talleres', $cursoCount, 'admin.cursos.index', 'bi-journal-bookmark-fill', 'info']
      ];
    @endphp
    
    @foreach($cards as [$title, $count, $route, $icon, $color])
      <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card-admin">
          <div class="icon-wrapper">
            <i class="bi {{ $icon }}"></i>
          </div>
          <h5>{{ $title }}</h5>
          <div class="count">{{ $count }}</div>
          <a href="{{ route($route) }}" class="btn btn-purple btn-sm">
            <i class="bi bi-arrow-right me-1"></i> Ver detalles
          </a>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Filtros por fecha compactos -->
  <div class="filter-container">
    <div class="row g-3 align-items-end">
      <div class="col-md-3">
        <label class="form-label">Desde</label>
        <input type="month" id="from-global" class="form-control" value="{{ request('from-global') }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">Hasta</label>
        <input type="month" id="to-global" class="form-control" value="{{ request('to-global') }}">
      </div>
      <div class="col-md-3">
        <button class="btn btn-dark w-100" onclick="filtrarRangoGlobal()">
          <i class="bi bi-funnel me-1"></i> Filtrar
        </button>
      </div>
    </div>
  </div>

  <!-- Gráficos compactos -->
  @php
    $charts = [
      ['Usuarios', 'usersChart', $newUsers, 'var(--color-secondary)', 'usuarios', 'bi-people'],
      ['Eventos', 'eventsChart', $newEvents, 'var(--color-accent)', 'eventos', 'bi-calendar'],
      ['Emprendimientos', 'emprChart', $newEmprendimientos, 'var(--color-success)', 'emprendimientos', 'bi-lightbulb'],
      ['Cursos/Talleres', 'cursosChart', $newCursos, 'var(--color-primary)', 'cursos', 'bi-journal']
    ];
  @endphp
  
  <div class="row">
    @foreach($charts as [$title, $id, $data, $color, $slug, $icon])
      <div class="col-lg-6 mb-4">
        <div class="chart-section">
          <h5 class="section-title">
            <i class="bi {{ $icon }} me-2"></i> Nuevos {{ $title }}
          </h5>
          
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
              <label for="type-{{ $id }}" class="me-2 small fw-medium">Tipo de gráfico:</label>
              <select id="type-{{ $id }}" class="form-select form-select-sm" onchange="updateChartType('{{ $id }}', this.value)" style="width: auto;">
                <option value="line">Línea</option>
                <option value="bar">Barras</option>
                <option value="pie">Pastel</option>
              </select>
            </div>
            <a href="{{ route('admin.dashboard.pdf', [
              'type' => $slug,
              'from' => request('from-global'),
              'to' => request('to-global')
            ]) }}" class="btn btn-sm pdf-btn">
              <i class="bi bi-file-earmark-pdf me-1"></i> PDF
            </a>
          </div>
          
          <div class="chart-wrapper">
            <canvas id="{{ $id }}"></canvas>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Mapeo de colores para los gráficos
const chartColors = {
  usersChart: '#3ba2f0',
  eventsChart: '#f0933b',
  emprChart: '#28a745',
  cursosChart: '#6f42c1'
};

// Variables globales para el control de notificaciones
let lastNotificationCount = 0;
let notificationSound = document.getElementById('notification-sound');

// Función para reproducir sonido de notificación
function playNotificationSound() {
  if (notificationSound) {
    // Reiniciar el audio si ya estaba reproduciéndose
    notificationSound.currentTime = 0;
    
    // Intentar reproducir el sonido
    notificationSound.play().catch(error => {
      console.log('La reproducción automática fue prevenida:', error);
      // En algunos navegadores, la reproducción automática debe ser iniciada por el usuario
    });
  }
}

// Inicializar gráficos
const chartRefs = {};
function initCharts() {
  const labels = @json($months);
  
  chartRefs['usersChart'] = createChart(
    'usersChart', 
    labels, 
    @json($newUsers), 
    'Usuarios', 
    '#8A4FFF'   // morado vibrante
  );
  
  chartRefs['eventsChart'] = createChart(
    'eventsChart', 
    labels, 
    @json($newEvents), 
    'Eventos', 
    '#6A3D9A'   // morado medio
  );
  
  chartRefs['emprChart'] = createChart(
    'emprChart', 
    labels, 
    @json($newEmprendimientos), 
    'Emprendimientos', 
    '#9B72CF'   // morado lavanda
  );
  
  chartRefs['cursosChart'] = createChart(
    'cursosChart', 
    labels, 
    @json($newCursos), 
    'Cursos/Talleres', 
    '#4A2C80'   // morado oscuro
  );
}

// Crear gráfico
function createChart(id, labels, data, label, color, type = 'line') {
  const ctx = document.getElementById(id).getContext('2d');
  
  // Paleta de colores morados para gráficas circulares
  const purplePalette = [
    '#8A4FFF', '#6A3D9A', '#9B72CF', '#B399D4', '#4A2C80',
    '#C9B6E8', '#7B5ACB', '#A885D8', '#5E3F8E', '#D4C5F4'
  ];
  
  // Asignar colores según el tipo de gráfico
  let backgroundColor, borderColor;
  
  if (type === 'pie' || type === 'doughnut' || type === 'polarArea') {
    // Gráficos circulares → múltiples colores
    backgroundColor = purplePalette.slice(0, Math.min(data.length, purplePalette.length));
    borderColor = backgroundColor.map(color => darkenColor(color, 20));
  } else {
    // Gráficos de líneas y barras → un morado principal
    backgroundColor = lightenColor(color, 40);
    borderColor = color;
  }
  
  return new Chart(ctx, {
    type: type,
    data: {
      labels: labels,
      datasets: [{
        label: label,
        data: data,
        borderColor: borderColor,
        backgroundColor: backgroundColor,
        borderWidth: 2,
        fill: type !== 'pie' && type !== 'doughnut' && type !== 'polarArea',
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'top',
          labels: {
            boxWidth: 12,
            padding: 20,
            font: {
              size: 12
            }
          }
        },
        tooltip: {
          mode: 'index',
          intersect: false,
          bodyFont: {
            size: 12
          },
          titleFont: {
            size: 12
          }
        }
      },
      scales: (type === 'pie' || type === 'doughnut' || type === 'polarArea') ? {} : {
        x: { 
          grid: {
            display: false
          },
          ticks: {
            font: {
              size: 11
            }
          }
        },
        y: { 
          beginAtZero: true,
          grid: {
            color: '#f5f5f5'
          },
          ticks: {
            font: {
              size: 11
            }
          }
        }
      }
    }
  });
}

// Cambiar tipo de gráfico
function updateChartType(id, newType) {
  if (chartRefs[id]) {
    chartRefs[id].destroy();
  }
  
  // Mapeo de colores morados para cada gráfico
  const purpleColors = {
    'usersChart': '#8A4FFF',
    'eventsChart': '#6A3D9A',
    'emprChart': '#9B72CF',
    'cursosChart': '#4A2C80'
  };
  
  chartRefs[id] = createChart(
    id,
    @json($months),
    id === 'usersChart' ? @json($newUsers) :
    id === 'eventsChart' ? @json($newEvents) :
    id === 'emprChart' ? @json($newEmprendimientos) :
    @json($newCursos),
    id.replace('Chart',''),
    purpleColors[id] || '#8A4FFF', // color morado por defecto
    newType
  );
}

// Oscurecer color
function darkenColor(color, percent) {
  const num = parseInt(color.replace('#', ''), 16);
  const amt = Math.round(2.55 * percent);
  const R = (num >> 16) - amt;
  const G = (num >> 8 & 0x00FF) - amt;
  const B = (num & 0x0000FF) - amt;
  
  return '#' + (
    0x1000000 +
    (R < 0 ? 0 : R > 255 ? 255 : R) * 0x10000 +
    (G < 0 ? 0 : G > 255 ? 255 : G) * 0x100 +
    (B < 0 ? 0 : B > 255 ? 255 : B)
  ).toString(16).slice(1);
}

// Aclarar color
function lightenColor(color, percent) {
  const num = parseInt(color.replace('#', ''), 16);
  const amt = Math.round(2.55 * percent);
  const R = (num >> 16) + amt;
  const G = (num >> 8 & 0x00FF) + amt;
  const B = (num & 0x0000FF) + amt;
  
  return '#' + (
    0x1000000 +
    (R < 255 ? R < 1 ? 0 : R : 255) * 0x10000 +
    (G < 255 ? G < 1 ? 0 : G : 255) * 0x100 +
    (B < 255 ? B < 1 ? 0 : B : 255)
  ).toString(16).slice(1);
}

// Función para actualizar notificaciones
async function actualizarNotificaciones() {
    const badge = document.getElementById("notification-badge");
    const content = document.getElementById("notification-content");
    
    if (!badge || !content) return;

    try {
        const res = await fetch("/notificaciones/pendientes");
        if (!res.ok) throw new Error("Error al contar pendientes");

        const data = await res.json();
        const total = data.usuarios + data.emprendimientos + data.productos;

        // Verificar si hay nuevas notificaciones
        if (total > lastNotificationCount && lastNotificationCount > 0) {
            playNotificationSound();
            
            // Efecto visual para nuevas notificaciones
            if (badge) {
                badge.classList.add('pulse');
                setTimeout(() => badge.classList.remove('pulse'), 1500);
            }
        }
        
        // Actualizar el contador anterior
        lastNotificationCount = total;

        // Actualizar badge
        if (total > 0) {
            badge.textContent = total;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }

        // Actualizar contenido del dropdown
        if (total > 0) {
            content.innerHTML = `
                <div class="p-3">
                    <div class="notification-item">
                        <div class="notification-type">
                            <i class="bi bi-people text-primary"></i>
                            <span>Usuarios pendientes</span>
                        </div>
                        <span class="notification-count text-primary">${data.usuarios}</span>
                    </div>
                    <div class="notification-item">
                        <div class="notification-type">
                            <i class="bi bi-building text-success"></i>
                            <span>Emprendimientos pendientes</span>
                        </div>
                        <span class="notification-count text-success">${data.emprendimientos}</span>
                    </div>
                    <div class="notification-item">
                        <div class="notification-type">
                            <i class="bi bi-box-seam text-info"></i>
                            <span>Productos pendientes</span>
                        </div>
                        <span class="notification-count text-info">${data.productos}</span>
                    </div>
                </div>
            `;
        } else {
            content.innerHTML = `
                <div class="notification-empty">
                    <i class="bi bi-check-circle"></i>
                    <p>¡Todo al día! No hay solicitudes pendientes</p>
                </div>
            `;
        }
    } catch(err) {
        console.error(err);
        content.innerHTML = `
            <div class="notification-empty">
                <i class="bi bi-exclamation-triangle text-warning"></i>
                <p>Error al cargar notificaciones</p>
            </div>
        `;
    }
}

// Inicializar al cargar
document.addEventListener('DOMContentLoaded', function() {
    initCharts();
    
    // Cargar notificaciones al inicio y cada 30 segundos
    actualizarNotificaciones();
    setInterval(actualizarNotificaciones, 30000);
    
    // Permitir la reproducción de sonido después de la interacción del usuario
    document.addEventListener('click', function() {
        if (notificationSound) {
            notificationSound.play().then(() => {
                notificationSound.pause();
                notificationSound.currentTime = 0;
            }).catch(() => {
                // Silenciar error de reproducción automática
            });
        }
    }, { once: true });
});
</script>
@endsection