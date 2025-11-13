<!-- dashboard/style.blade.php -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

<style>
/* ===== Reset & Base ===== */
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
}

a {
    text-decoration: none;
    color: inherit;
}

ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

/* ===== Header / Top Navigation ===== */
.main-navigation {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(135deg, #1a3c6e, #ff6600);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.main-navigation .sidebarBtn {
    font-size: 24px;
    cursor: pointer;
    color: #fff;
}

#clock {
    font-weight: 600;
    font-size: 16px;
}

.profile-details a {
    color: #fff;
    font-weight: 500;
    text-decoration: none !important;
}

.profile-details .dropdown-menu {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    z-index: 2000;
}

.profile-details .dropdown-item i {
    margin-right: 8px;
    color: #1a3c6e;
}

/* ===== Sidebar ===== */
/* ===== Sidebar ===== */
.sidebar {
    position: fixed;
    top: 60px; /* below the header */
    left: 0;
    width: 250px;
    height: calc(100% - 60px);
    background: linear-gradient(135deg, #1a3c6e, #ff6600);
    color: #fff;
    display: flex;
    flex-direction: column;
    overflow-y: auto; /* ✅ enables vertical scroll if content overflows */
    overflow-x: hidden;
    scroll-behavior: smooth;
    z-index: 900;
}

/* Make sure scrollbar looks clean */
.sidebar::-webkit-scrollbar {
    width: 6px;
}
.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}
.sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

.sidebar .logo-details {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

/* ✅ Ensure list starts from the top just below logo */
.sidebar .side-nav {
    flex-grow: 1;
    margin-top: 0; /* remove any spacing pushing it down */
    padding-top: 5px;
}

.sidebar .side-nav li {
    padding: 0; /* reset unnecessary padding */
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar .side-nav li a {
    color: #fff;
    display: flex;
    align-items: center;
    font-size: 15px;
    transition: all 0.2s ease;
    text-decoration: none !important;
    padding: 12px 20px;
    border-radius: 8px;
    box-sizing: border-box;
}

.sidebar .side-nav li a:hover,
.sidebar .side-nav li a.active {
    background: rgba(255, 255, 255, 0.2);
}

.sidebar .side-nav li i {
    font-size: 20px;
    margin-right: 10px;
}

.sidebar .logout-section {
    margin-top: auto;
    padding: 20px;
    background: rgba(0,0,0,0.1); /* subtle visual separation */
}

.sidebar .logout-section button {
    background: rgba(255,255,255,0.15);
    border: none;
    width: 100%;
    color: #fff;
    font-weight: 600;
    padding: 12px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.sidebar .logout-section button:hover {
    background: rgba(255,255,255,0.3);
}

/* Main content */
.home-section {
    margin-left: 250px;
    margin-top: 60px;
    padding: 20px;
    transition: all 0.3s ease;
}

/* Responsive */
@media (max-width: 991px) {
    .sidebar {
        left: -250px;
    }
    .sidebar.active {
        left: 0;
    }
    .home-section {
        margin-left: 0;
    }
}
</style>