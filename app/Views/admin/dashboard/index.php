<?= view('admin/layouts/header') ?>
<?= view('admin/layouts/sidebar') ?>

<div class="content">

    <div class="topbar">
        <div>
            <h3>Welcome Back, Administrator!</h3>
            <p class="text-muted small mb-0"><?= date('l, d F Y') ?></p>
        </div>
        <div class="icon-group">
            <i class="fa-solid fa-gear"></i>
            <i class="fa-solid fa-bell"></i>
        </div>
    </div>

    <!-- Stat cards -->
    <div class="row g-3 px-2 mb-3">
        <div class="col-6 col-md-2">
            <div class="card-box">
                <div class="small-text">Total Members</div>
                <div class="big-number"><?= $totalMembers ?></div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card-box" style="border-left:4px solid #198754">
                <div class="small-text">Active Members</div>
                <div class="big-number text-success"><?= $activeMembers ?></div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card-box" style="border-left:4px solid #0dcaf0">
                <div class="small-text">New This Month</div>
                <div class="big-number text-info"><?= $newMembers ?></div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card-box" style="border-left:4px solid #d85f88">
                <div class="small-text">Revenue (Total)</div>
                <div class="big-number" style="font-size:18px">RM <?= number_format($revenue, 0) ?></div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card-box" style="border-left:4px solid #ffc107">
                <div class="small-text">Pending Bookings</div>
                <div class="big-number text-warning"><?= $pendingBookings ?></div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card-box" style="border-left:4px solid #6f42c1">
                <div class="small-text">Active Staff</div>
                <div class="big-number" style="color:#6f42c1"><?= $totalStaff ?></div>
            </div>
        </div>
    </div>

    <!-- Recent Members Table -->
    <div class="table-box mx-2 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Recent Members</h4>
            <a href="<?= base_url('members') ?>" class="btn btn-outline-danger btn-sm">View All</a>
        </div>
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Membership</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                <tr>
                    <td><?= esc($member['member_code']) ?></td>
                    <td><?= esc($member['full_name']) ?></td>
                    <td><?= esc($member['email']) ?></td>
                    <td><?= esc($member['membership'] ?? '—') ?></td>
                    <td>
                        <?php if ($member['status'] === 'Active'): ?>
                            <span class="badge-active">Active</span>
                        <?php else: ?>
                            <span class="badge-inactive">Inactive</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Charts row -->
    <div class="row mt-2 mx-0 g-3">

        <div class="col-md-8">
            <div class="table-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Revenue Overview — <?= date('Y') ?></h4>
                </div>
                <canvas id="revenueChart" height="110"></canvas>
            </div>
        </div>

        <div class="col-md-4">
            <div class="table-box">
                <h4 class="mb-4">Membership Summary</h4>
                <?php
                $tierConfig = [
                    'Gold'   => 'bg-warning',
                    'Silver' => 'bg-info',
                    'Bronze' => 'bg-danger',
                ];
                foreach ($tierConfig as $type => $bar):
                    $count = $membershipCounts[$type] ?? 0;
                    $pct   = $totalWithPlan > 0 ? round($count / $totalWithPlan * 100) : 0;
                ?>
                <div class="d-flex justify-content-between mb-1">
                    <span><?= $type ?></span>
                    <strong><?= $count ?> (<?= $pct ?>%)</strong>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar <?= $bar ?>" style="width:<?= $pct ?>%"></div>
                </div>
                <?php endforeach; ?>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="text-muted small">Total Bookings</span>
                    <a href="<?= base_url('admin/bookings') ?>" class="small fw-bold text-decoration-none"><?= $totalBookings ?> →</a>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span class="text-muted small">Active Staff</span>
                    <a href="<?= base_url('admin/staff') ?>" class="small fw-bold text-decoration-none"><?= $totalStaff ?> →</a>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($chartMonths) ?>,
        datasets: [{
            label: 'Revenue (RM)',
            data: <?= json_encode($chartRevenues) ?>,
            borderColor: '#d85f88',
            backgroundColor: 'rgba(216,95,136,.15)',
            fill: true,
            tension: .4,
            pointRadius: 4,
            pointBackgroundColor: '#d85f88'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { callback: function(v) { return 'RM ' + v.toLocaleString(); } }
            }
        }
    }
});
</script>

<?= view('admin/layouts/footer') ?>