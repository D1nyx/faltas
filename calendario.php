<?php
session_start();

if (!isset($_SESSION['senha']) || empty($_SESSION['senha'])) {
    header('Location: home.php');
    exit();
}

$logado = $_SESSION['senha'];
?>

<!DOCTYPE html>
<html>
<head>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar/locales/pt-br.js'></script>
  <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css' />
  <style>
    body {
      background-image: linear-gradient(to right, rgb(220, 110, 20), rgb(14, 138, 196));
      text-align: center;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .logo {
      max-width: 200px;
      height: auto;
      margin-top: 30px;
    }

    .calendar-container {
      max-width: 950px;
      margin: 0 auto;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-top: 50px;
    }
    .back-button {
        background-color: #f44336;
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .back-button:hover {
        background-color: #d32f2f;
    }
    .back-button{
        display: inline-block;
        color: white;
        font-size: 15px;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const calendarEl = document.getElementById('calendar');
      const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth'
        },
        buttonText: {
          today: 'Hoje',
          month: 'Mês'
        },
        initialView: 'dayGridMonth',
        events: 'evento.php',
        views: {
          dayGrid: {
            eventLimit: false
          }
        },
        allDaySlot: false,
        eventContent: function(arg) {
          return {
            html: `<div class="event-title">${arg.event.title}</div>`
          };
        }
      });
      calendar.render();
    });
  </script>
</head>
<body>
    <div class="logo-container">
        <a href="banco_de_dados.php" class="back-button">Voltar</a>
        <img src="tecnocon.png" class="logo" alt="Logo">
    </div>
    <div class="calendar-container">
        <div id='calendar'></div>
    </div>
</body>
</html>
