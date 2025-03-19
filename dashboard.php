<?php
session_start();
// Basic authentication check
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo - COTEMAG</title>
    <link rel="shortcut icon" href="/icon/logo5.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2196f3;
            color: white;
            padding: 20px;
        }

        .sidebar-header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header img {
            width: 100px;
            margin-bottom: 10px;
        }

        .sidebar-menu {
            margin-top: 20px;
        }

        .sidebar-menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            margin: 5px 0;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.1);
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="/icon/logo5.png" alt="COTEMAG Logo">
                <h3>Panel Administrativo</h3>
            </div>
            <div class="sidebar-menu">
                <a href="#"><i class="fas fa-home"></i> Inicio</a>
                <a href="#"><i class="fas fa-users"></i> Estudiantes</a>
                <a href="#"><i class="fas fa-chalkboard-teacher"></i> Profesores</a>
                <a href="#"><i class="fas fa-book"></i> Cursos</a>
                <a href="#"><i class="fas fa-calendar"></i> Horarios</a>
                <a href="#"><i class="fas fa-cog"></i> Configuración</a>
            </div>
        </div>

        <div class="main-content">
            <div class="top-bar">
                <h2>Bienvenido, Administrador</h2>
                <button class="logout-btn" onclick="logout()">Cerrar Sesión</button>
            </div>

            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Estudiantes</h3>
                    <p>500</p>
                </div>
                <div class="card">
                    <h3>Total Profesores</h3>
                    <p>50</p>
                </div>
                <div class="card">
                    <h3>Cursos Activos</h3>
                    <p>25</p>
                </div>
                <div class="card">
                    <h3>Eventos Próximos</h3>
                    <p>3</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function logout() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas cerrar la sesión?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            })
        }
    </script>
</body>
</html>