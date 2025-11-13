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
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bx bx-home-alt"></i> Dashboard
            </a>
        </li>

        @auth
            {{-- ===================== SYSTEM ADMIN SECTION ===================== --}}
            @if(auth()->user()->role === 'system_admin')
                <li class="nav-section-title">Administration</li>

                <li>
                    <a href="{{ route('associations.index') }}">
                        <i class="bx bx-network-chart"></i> Associations
                    </a>
                </li>

                <li>
                    <a href="{{ route('corporate_accounts.index') }}">
                        <i class="bx bx-building-house"></i> Corporate Accounts
                    </a>
                </li>

                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="bx bx-user-circle"></i> Users
                    </a>
                </li>

                <li>
                    <a href="{{ route('driver-performance.dashboard') }}">
                        <i class="bx bx-id-card"></i> Drivers
                    </a>
                </li>

                <li>
                    <a href="{{ route('passengers.dashboard') }}">
                        <i class="bx bx-user-pin"></i> Passengers
                    </a>
                </li>

                <li>
                    <a href="{{ route('corporate.wallets.index') }}">
                        <i class="bx bx-wallet"></i> Prepaid Top Up
                    </a>
                </li>

                <li class="nav-section-title">Reports</li>

                <li>
                    <a href="{{ route('order_report.index') }}">
                        <i class="bx bx-receipt"></i> Orders Report
                    </a>
                </li>

                <li>
                    <a href="{{ route('order_report.revenue') }}">
                        <i class="bx bx-coin-stack"></i> Usage Revenue
                    </a>
                </li>
            @endif

            {{-- ===================== CORPORATE SECTION ===================== --}}
            @if(auth()->user()->role === 'system_admin' || auth()->user()->role === 'corporate')
                <li class="nav-section-title">Corporate</li>

                <li>
                    <a href="{{ route('employees.index') }}">
                        <i class="bx bx-group"></i> Employees
                    </a>
                </li>

                <li>
                    <a href="{{ route('corporate.orders.index') }}">
                        <i class="bx bx-bar-chart-alt-2"></i> Corporate Reports
                    </a>
                </li>

                <li>
                    <a href="{{ route('corporate.invoices.index') }}">
                        <i class="bx bx-file"></i> Invoices
                    </a>
                </li>
            @endif

            {{-- ===================== DRIVER PERFORMANCE ===================== --}}
            @if(auth()->user()->role === 'system_admin' || auth()->user()->role === 'user' || auth()->user()->role === 'association_admin')
                <li class="nav-section-title">Performance</li>

                <li>
                    <a href="{{ route('driver-performance.index') }}">
                        <i class="bx bx-line-chart"></i> Driver Performance
                    </a>
                </li>
            @endif
        @endauth
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
