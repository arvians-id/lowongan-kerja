<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Arvians</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">AR</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li <?= activeDashboard() ?>><a class="nav-link" href="/"><i class="fas fa-fire"></i> <span>General Dashboard</span></a></li>
            <li class="menu-header">Manage Admin</li>
            <li class="nav-item dropdown <?= activeSidebar(['users', 'blacklist']) ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users-cog"></i> <span>Manage Users</span></a>
                <ul class="dropdown-menu">
                    <li <?= activeSidebar('users') ?>><a class="nav-link" href="/admin/users">Users</a></li>
                    <li <?= activeSidebar('blacklist') ?>><a class="nav-link" href="/admin/blacklist">Users Blacklist</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown <?= activeSidebar(['profile', 'password', 'email']) ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-id-card-alt"></i> <span>Manage Profile</span></a>
                <ul class="dropdown-menu">
                    <li <?= activeSidebar('profile') ?>><a class="nav-link" href="/admin/profile">Profile</a></li>
                    <li <?= activeSidebar('password') ?>><a class="nav-link" href="/admin/password">Changes Password</a></li>
                    <li <?= activeSidebar('email') ?>><a class="nav-link" href="/admin/email">Changes Email</a></li>
                </ul>
            </li>
            <li class="menu-header">Manage Job</li>
            <li <?= activeSidebar('job') ?>><a class="nav-link" href="/admin/job"><i class="fas fa-briefcase"></i> <span>Manage Job</span></a></li>
            <li <?= activeSidebar('applicant') ?>><a class="nav-link" href="/admin/applicant"><i class="fas fa-archive"></i> <span>Manage Applicant</span></a></li>
            <li <?= activeSidebar('schedule') ?>><a class="nav-link" href="/admin/schedule"><i class="fas fa-calendar-alt"></i> <span>Manage Schedule</span></a></li>
            <li class="menu-header">Configuration</li>
            <li <?= activeSidebar('setting') ?>><a class="nav-link" href="/admin/setting"><i class="fas fa-cogs"></i> <span>Setting</span></a></li>
            <li><a class="nav-link logout" href="/auth/logout"><i class="fas fa-power-off"></i> <span>Logout</span></a></li>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> <?= createMyDate(date('Y-m-d')) ?>
            </a>
        </div>
    </aside>
</div>