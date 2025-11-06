<!-- dashboard/sidebar.blade.php -->
<div class="sidebar">
    <div class="logo-details">
        <i class="bx bx-cab"></i>
        @php
            $user = Auth::user();
            $associate = $user->association ?? null;
        @endphp
        <span class="logo_name">{{ $associate ? $associate->name : 'Association' }}</span>
    </div>

    <ul class="side-nav">
        <!-- Dashboard -->
        <li>
            <a href="{{ route('dashboard') }}" class="active">
                <i class="bx bx-home"></i> Dashboard
            </a>
        </li>

        @auth
            @if(auth()->user()->role === 'system_admin')
                <!-- Associations -->
                <li>
                    <a href="{{ route('associations.index') }}">
                        <i class="bx bx-buildings"></i> Associations
                    </a>
                </li>

                <!-- Users -->
                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="bx bx-group"></i> Users
                    </a>
                </li>

                <!-- Orders Report -->
                <li>
                    <a href="{{ route('order_report.index') }}">
                        <i class="bx bx-file"></i> Orders Report
                    </a>
                </li>

                <!-- Usage Revenue -->
                <li>
                    <a href="{{ route('order_report.revenue') }}">
                        <i class="bx bx-coin-stack"></i> Usage Revenue
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('driver-performance.dashboard') }}">
                        <i class="bx bx-user"></i> Drivers
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('passengers.dashboard') }}">
                        <i class="bx bx-user"></i> Passengers
                    </a>
                </li>
            @endif
        @endauth

        <!-- Driver Performance -->
        <li>
            <a href="{{ route('driver-performance.index') }}">
                <i class="bx bx-line-chart"></i> Driver Performance
            </a>
        </li>
    </ul>

    <!-- Logout -->
    <div class="logout-section">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
                <i class="bx bx-log-out"></i> Log Out
            </button>
        </form>
    </div>
</div>