<!-- dashboard/header.blade.php -->
<nav class="main-navigation">
    <div class="sidebarBtn">
        <i class="bx bx-menu"></i>
    </div>

    <div id="clock"></div>

    <div class="dropdown profile-details">
        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bx bx-user"></i> {{ Auth::user()->name }}
</a>
    </div>
</nav>
