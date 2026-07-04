<?php
    $totalPaid   = 0;
    $totalTx     = count($payments ?? []);
    foreach ($payments ?? [] as $p) { $totalPaid += (float)($p['amount'] ?? 0); }
?>

<section class="member-shell container py-4 dashboard-shell">
    <div class="member-grid row g-4 align-items-start">
        <div class="col-lg-4 col-xl-3">
            <?= view('user/templates/member_sidebar', ['member' => $member, 'payments' => $payments ?? []]) ?>
        </div>

        <main class="member-main col-lg-8 col-xl-9">
            <h2 class="page-heading">Payment History</h2>
            <p class="page-subheading">All your transactions and billing records</p>

            <div class="pay-summary-row mb-3">
                <div class="pay-summary-card">
                    <i class="fa-solid fa-receipt"></i>
                    <div>
                        <strong><?= $totalTx ?></strong>
                        <span>Total Transactions</span>
                    </div>
                </div>
                <div class="pay-summary-card">
                    <i class="fa-solid fa-circle-dollar-to-slot"></i>
                    <div>
                        <strong>RM <?= number_format($totalPaid, 2) ?></strong>
                        <span>Total Paid</span>
                    </div>
                </div>
                <div class="pay-summary-card">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>
                        <strong><?= $totalTx ?></strong>
                        <span>Completed</span>
                    </div>
                </div>
            </div>

            <div class="dashboard-panel member-card">
                <div class="recent-header">
                    <h3>Transactions</h3>
                </div>

                <?php if (!empty($payments)): ?>
                    <div class="pay-list">
                        <?php foreach ($payments as $payment): ?>
                            <article class="pay-item">
                                <div class="pay-item-icon">
                                    <i class="fa-regular fa-credit-card"></i>
                                </div>
                                <div class="pay-item-info">
                                    <h4><?= esc($payment['service']) ?></h4>
                                    <p><?= date('M d, Y', strtotime($payment['payment_date'])) ?> · <?= esc($payment['payment_method'] ?? 'N/A') ?></p>
                                </div>
                                <div class="pay-item-right">
                                    <strong>RM <?= number_format((float)($payment['amount'] ?? 0), 2) ?></strong>
                                    <span class="pay-status-badge"><?= esc($payment['payment_status'] ?? 'Completed') ?></span>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="empty-note">No payment records found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</section>
