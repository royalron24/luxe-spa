<?= view('admin/layouts/header') ?>

<?= view('admin/layouts/sidebar') ?>

<div class="content">

    <div class="topbar">

        <div>

            <h2>Revenue Report</h2>

            <small class="text-muted">

                View and monitor payment revenue

            </small>

        </div>

        <div class="icon-group">

            <i class="fa-solid fa-gear"></i>

            <i class="fa-solid fa-bell"></i>

        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="dashboard-card shadow-sm">

                <small class="text-muted">Total Revenue</small>

                <h3 class="fw-bold">
                    RM
                    <?= number_format($totalRevenue, 2) ?>
                </h3>

                <small class="text-success">
                    +12% from last year
                </small>

            </div>

        </div>

        <div class="col-md-3">

            <div class="dashboard-card shadow-sm">

                <small class="text-muted">
                    Monthly Average
                </small>

                <h3 class="fw-bold">
                    RM
                    <?= number_format($monthlyAverage, 2) ?>
                </h3>

                <small class="text-success">
                    +12% from last year
                </small>

            </div>

        </div>

        <div class="col-md-3">

            <div class="dashboard-card shadow-sm">

                <small class="text-muted">
                    Highest Month
                </small>

                <h3 class="fw-bold">
                    RM
                    <?= number_format($highestMonth['total'] ?? 0, 2) ?>
                </h3>

                <small>
                    <?= $highestMonth['month'] ?? '-' ?>
                </small>

            </div>

        </div>

        <div class="col-md-3">

            <div class="dashboard-card shadow-sm">

                <small class="text-muted">
                    Total Transactions
                </small>

                <h3 class="fw-bold">
                    <?= $totalTransaction ?>
                </h3>

                <small class="text-success">
                    +20% from last year
                </small>

            </div>

        </div>

    </div>

    <div class="table-box mb-4">

        <form method="get" action="<?= base_url('revenue') ?>">

            <div class="row align-items-end">

                <div class="col-md-4">

                    <label class="form-label">From Date</label>

                    <input type="date" name="from" class="form-control" value="<?= $_GET['from'] ?? '' ?>">

                </div>

                <div class="col-md-4">

                    <label class="form-label">To Date</label>

                    <input type="date" name="to" class="form-control" value="<?= $_GET['to'] ?? '' ?>">

                </div>

                <div class="col-md-4">

                    <button class="btn btn-pink">
                        <i class="fa-solid fa-filter"></i>
                        Apply Filter
                    </button>

                    <a href="<?= base_url('revenue') ?>" class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>

    <div class="table-box mt-4">



        <table class="table table-hover">

            <thead>

                <tr>

                    <th>Payment ID</th>

                    <th>Member ID</th>

                    <th>Service</th>

                    <th>Amount</th>

                    <th>Payment Date</th>

                    <th>Method</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody id="paymentTable">

                <?php foreach ($payments as $payment): ?>

                    <tr>

                        <td>

                            <?= $payment['payment_id'] ?>

                        </td>

                        <td>

                            M00<?= $payment['member_id'] ?>

                        </td>

                        <td>

                            <?= $payment['service'] ?>

                        </td>

                        <td>

                            RM <?= number_format($payment['amount'], 2) ?>

                        </td>

                        <td>

                            <?= date('d M Y', strtotime($payment['payment_date'])) ?>

                        </td>

                        <td>

                            <?= $payment['payment_method'] ?>

                        </td>

                        <td>

                            <?php if ($payment['payment_status'] == "Completed"): ?>

                                <span class="badge-active">

                                    Completed

                                </span>

                            <?php else: ?>

                                <span class="badge bg-warning text-dark">

                                    Pending

                                </span>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

        <div class="mt-3">

            Showing

            <strong>

                <?= count($payments) ?>

            </strong>

            payment(s)

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-md-8">

            <div class="table-box">

                <h4 class="mb-4">

                    Monthly Revenue Overview

                </h4>

                <canvas id="revenueChart" height="120"></canvas>

            </div>

        </div>

        <div class="col-md-4">

            <div class="table-box">

                <h4 class="mb-4">

                    Revenue by Membership

                </h4>

                <canvas id="membershipChart" height="250"></canvas>

            </div>

        </div>

    </div>

    <?php

    $membershipLabels = [];

    $membershipRevenue = [];

    foreach ($membership as $row) {

        $membershipLabels[] = $row['membership'];

        $membershipRevenue[] = $row['total'];

    }

    ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        // =============================
        // Line Chart
        // =============================

        const ctx = document.getElementById("revenueChart");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: <?= json_encode($months) ?>,
                datasets: [{
                    label: "Revenue",
                    data: <?= json_encode($revenues) ?>,
                    borderColor: "#d95d89",
                    backgroundColor: "rgba(217,93,137,0.15)",
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        // =============================
        // Pie Chart
        // =============================

        const pie = document.getElementById("membershipChart");

        new Chart(pie, {
            type: "pie",
            data: {
                labels: <?= json_encode($membershipLabels) ?>,
                datasets: [{
                    data: <?= json_encode($membershipRevenue) ?>,
                    backgroundColor: [
                        "#cd7f32",
                        "#c0c0c0",
                        "#f4b400"
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom"
                    }
                }
            }
        });

    </script>



    <?= view('admin/layouts/footer') ?>
