
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GrowCRM L11</title>

    <!-- Bootstrap (Laravel 11 uses Vite or CDN — use CDN for simplicity) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f8fafc;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: #111827;
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: width 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar h3 {
            padding: 20px;
            font-size: 1.25rem;
            border-bottom: 1px solid #1f2937;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #d1d5db;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background: #1f2937;
            color: #3b82f6;
            border-left: 4px solid #3b82f6;
        }

        /* TOPBAR */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 260px;
            width: calc(100% - 260px);
            height: 60px;
            padding: 0 20px;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .topbar.collapsed {
            left: 70px;
            width: calc(100% - 70px);
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            margin-top: 60px;
            padding: 25px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .main-content.collapsed {
            margin-left: 70px;
        }

        /* TOGGLE BUTTON */
        #toggleSidebar {
            border: none;
            background: #f3f4f6;
            color: #374151;
        }

        #toggleSidebar:hover {
            background: #e5e7eb;
            color: #2563eb;
        }

        /* DROPDOWN */
        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            min-width: 180px;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
            color: #2563eb;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
            }
            .topbar {
                left: 70px;
                width: calc(100% - 70px);
            }
            .main-content {
                margin-left: 70px;
            }
        }

        @media (max-width: 576px) {
            .topbar {
                left: 0;
                width: 100%;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h3><i class="bi bi-stack"></i> <span class="ms-1 d-none d-md-inline">GrowCRM</span></h3>
        <ul>
            <li><a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> <span class="d-none d-md-inline">Dashboard</span></a></li>
            <li><a href="#"><i class="bi bi-people"></i> <span class="d-none d-md-inline">Clients</span></a></li>
            <li><a href="#"><i class="bi bi-folder"></i> <span class="d-none d-md-inline">Projects</span></a></li>
            <li><a href="#"><i class="bi bi-check2-square"></i> <span class="d-none d-md-inline">Tasks</span></a></li>
            <li><a href="#"><i class="bi bi-receipt"></i> <span class="d-none d-md-inline">Invoices</span></a></li>
        </ul>
    </div>

    <!-- Topbar -->
    <div class="topbar" id="topbar">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-light btn-sm" id="toggleSidebar" type="button">
                <i class="bi bi-list"></i>
            </button>
            <span class="fw-semibold text-dark">Dashboard</span>
        </div>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle fs-5 me-2 text-secondary"></i>
                <strong>{{ Auth::user()->name ?? 'Administrator' }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const topbar = document.getElementById('topbar');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
                topbar.classList.toggle('collapsed');
            });
        });
    </script>
</body>
</html>
