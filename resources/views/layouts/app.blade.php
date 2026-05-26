<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Data Cargo - Dashboard untuk mengelola data pengiriman cargo">
    <title>@yield('title', 'Data Management Cargo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 270px;
            --sidebar-bg: linear-gradient(180deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --card-bg: #ffffff;
            --body-bg: #f1f5f9;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1000;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
        }

        .sidebar-brand {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand h2 {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand .brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
        }

        .sidebar-brand small {
            display: block;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.7rem;
            font-weight: 400;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .sidebar-nav {
            padding: 20px 16px;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-nav .nav-label {
            color: rgba(255, 255, 255, 0.35);
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0 12px;
            margin-bottom: 10px;
            margin-top: 20px;
        }

        .sidebar-nav .nav-label:first-child {
            margin-top: 0;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 4px;
            position: relative;
        }

        .nav-link-custom:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-link-custom.active {
            color: #fff;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.4) 0%, rgba(6, 182, 212, 0.2) 100%);
            box-shadow: 0 2px 12px rgba(99, 102, 241, 0.2);
        }

        .nav-link-custom.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: var(--accent);
            border-radius: 0 4px 4px 0;
        }

        .nav-link-custom i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.02em;
        }

        .topbar-left p {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-toggle-sidebar {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            cursor: pointer;
            padding: 4px;
        }

        .topbar-date {
            background: linear-gradient(135deg, #f0f0ff 0%, #e0f2fe 100%);
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ===== CONTENT AREA ===== */
        .content-area {
            padding: 28px 32px;
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 16px 16px 0 0;
        }

        .stat-card.total::before { background: linear-gradient(90deg, var(--primary), var(--accent)); }
        .stat-card.proses::before { background: linear-gradient(90deg, var(--warning), #fbbf24); }
        .stat-card.complete::before { background: linear-gradient(90deg, var(--success), #34d399); }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        }

        .stat-card .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 16px;
        }

        .stat-card.total .stat-icon { background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(6, 182, 212, 0.1)); color: var(--primary); }
        .stat-card.proses .stat-icon { background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(251, 191, 36, 0.1)); color: var(--warning); }
        .stat-card.complete .stat-icon { background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.1)); color: var(--success); }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-card.total .stat-value { color: var(--primary); }
        .stat-card.proses .stat-value { color: var(--warning); }
        .stat-card.complete .stat-value { color: var(--success); }

        .stat-card .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ===== CARD PANEL ===== */
        .card-panel {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .card-panel-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-panel-header h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-panel-body {
            padding: 24px;
        }

        /* ===== TABLE ===== */
        .table-modern {
            margin: 0;
        }

        .table-modern thead th {
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 14px 16px;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
        }

        .table-modern tbody td {
            padding: 14px 16px;
            font-size: 0.87rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-dark);
        }

        .table-modern tbody tr {
            transition: background-color 0.15s ease;
        }

        .table-modern tbody tr:hover {
            background: #f8fafc;
        }

        /* ===== BADGES ===== */
        .badge-status {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .badge-proses {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(245, 158, 11, 0.06));
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .badge-complete {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(16, 185, 129, 0.06));
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        /* ===== BUTTONS ===== */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 0.87rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.35);
            color: #fff;
        }

        .btn-success-custom {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 0.87rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
            color: #fff;
        }

        .btn-danger-custom {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-danger-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
            color: #fff;
        }

        .btn-outline-custom {
            background: transparent;
            border: 1.5px solid var(--border-color);
            color: var(--text-muted);
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-outline-custom:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(99, 102, 241, 0.04);
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-warning-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
            color: #fff;
        }

        /* ===== FORM CONTROLS ===== */
        .form-control-custom {
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.87rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            background: #fff;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .form-label-custom {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .form-select-custom {
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.87rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            background: #fff;
        }

        .form-select-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* ===== SEARCH BAR ===== */
        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .search-wrapper input {
            padding-left: 42px;
        }

        /* ===== PAGINATION ===== */
        .pagination .page-link {
            border: none;
            color: var(--text-muted);
            font-size: 0.82rem;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 8px;
            margin: 0 2px;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background: rgba(99, 102, 241, 0.08);
            color: var(--primary);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
        }

        /* ===== PHOTO THUMBNAIL ===== */
        .photo-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid var(--border-color);
            transition: transform 0.2s ease;
            cursor: pointer;
        }

        .photo-thumb:hover {
            transform: scale(1.8);
            z-index: 10;
            position: relative;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        /* ===== ALERTS ===== */
        .alert-custom {
            border: none;
            border-radius: 12px;
            padding: 14px 20px;
            font-size: 0.87rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }

        .alert-success-custom {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
            color: #059669;
            border-left: 4px solid var(--success);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== FILE INPUT ===== */
        .file-upload-area {
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            transition: all 0.2s ease;
            cursor: pointer;
            background: #fafbfc;
        }

        .file-upload-area:hover {
            border-color: var(--primary);
            background: rgba(99, 102, 241, 0.02);
        }

        .file-upload-area i {
            font-size: 2.5rem;
            color: var(--primary-light);
            margin-bottom: 10px;
        }

        .file-upload-area p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin: 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .btn-toggle-sidebar {
                display: block;
            }

            .content-area {
                padding: 20px 16px;
            }

            .topbar {
                padding: 14px 16px;
            }
        }

        /* ===== SIDEBAR OVERLAY ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ===== ANIMATION ===== */
        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h2>
                <span class="brand-icon"><i class="bi bi-box-seam-fill"></i></span>
                <span>
                    PT. Tata Bandar Samudera
                    <small>Data Management System</small>
                </span>
            </h2>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
            <a href="{{ route('cargo.index') }}" class="nav-link-custom {{ request()->routeIs('cargo.*') ? 'active' : '' }}">
                <i class="bi bi-database-fill"></i>
                Data Cargo
            </a>

            <div class="nav-label">Aksi</div>
            <a href="{{ route('cargo.create') }}" class="nav-link-custom">
                <i class="bi bi-plus-circle-fill"></i>
                Tambah Data
            </a>
            <a href="{{ route('cargo.export.pdf') }}" class="nav-link-custom">
                <i class="bi bi-file-earmark-pdf-fill"></i>
                Export PDF
            </a>
            <a href="{{ route('cargo.export.excel') }}" class="nav-link-custom">
                <i class="bi bi-file-earmark-excel-fill"></i>
                Export Excel
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left d-flex align-items-center gap-3">
                <button class="btn-toggle-sidebar" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <p>@yield('page-subtitle', 'Selamat datang di sistem manajemen cargo')</p>
                </div>
            </div>
            <div class="topbar-right">
                <div class="topbar-date">
                    <i class="bi bi-calendar3"></i>
                    <span id="currentDate"></span>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="content-area">
            @if(session('success'))
                <div class="alert alert-custom alert-success-custom mb-4">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('toggleSidebar');

        if (toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

        // Display current date
        const dateEl = document.getElementById('currentDate');
        if (dateEl) {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            dateEl.textContent = now.toLocaleDateString('id-ID', options);
        }
    </script>
    @stack('scripts')
</body>
</html>
