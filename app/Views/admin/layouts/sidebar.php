<?php
$uri = service('uri');
$page = $uri->getSegment(1);
$subpage = $uri->getSegment(2);
$isAdminDashboard = $page === 'admin' && $subpage === 'dashboard';
?>

<div class="sidebar">

    <div class="logo">
        Luxe Spa
    </div>

    <ul>

        <li>
            <a href="<?= base_url('admin/dashboard') ?>" class="<?= $isAdminDashboard ? 'active' : '' ?>">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="<?= base_url('admin/bookings') ?>" class="<?= ($page == 'admin' && $subpage == 'bookings') ? 'active' : '' ?>">
                <i class="fa-solid fa-calendar-check"></i>
                Bookings
            </a>
        </li>

        <li>
            <a href="<?= base_url('members') ?>" class="<?= ($page == 'members') ? 'active' : '' ?>">
                <i class="fa-solid fa-users"></i>
                Members
            </a>
        </li>

        <li>
            <a href="<?= base_url('admin/staff') ?>" class="<?= ($page == 'admin' && $subpage == 'staff') ? 'active' : '' ?>">
                <i class="fa-solid fa-user-tie"></i>
                Staff
            </a>
        </li>

        <li>
            <a href="<?= base_url('revenue') ?>" class="<?= ($page == 'revenue' || ($page == 'admin' && $subpage == 'revenue')) ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-column"></i>
                Revenue Report
            </a>
        </li>

        <li>
            <a href="<?= base_url('filter') ?>" class="<?= ($page == 'filter' || ($page == 'admin' && $subpage == 'filter')) ? 'active' : '' ?>">
                <i class="fa-solid fa-filter"></i>
                Filter Members
            </a>
        </li>

        <li style="margin-top:auto;padding-top:30px;">
            <a href="<?= base_url('admin/logout') ?>">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>
        </li>

    </ul>

</div>
