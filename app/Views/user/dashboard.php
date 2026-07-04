<?php
    $recentBookings = array_slice(
        array_filter($payments ?? [], fn($p) => ($p['payment_status'] ?? '') !== 'Membership Upgrade'),
        0, 3
    );
?>

<section class="member-shell container py-4 dashboard-shell">
    <div class="member-grid row g-4 align-items-start">
        <div class="col-lg-4 col-xl-3">
            <?= view('user/templates/member_sidebar', ['member' => $member, 'payments' => $payments ?? []]) ?>
        </div>

        <main class="member-main col-lg-8 col-xl-9 d-flex flex-column gap-3">

            <!-- Overview heading -->
            <div>
                <h2 class="page-heading mb-0">Overview</h2>
                <p class="page-subheading">Your wellness journey at a glance</p>
            </div>

            <!-- Wellness score card -->
            <div class="dashboard-panel member-card">
                <div class="dashboard-score-card">
                    <div class="score-ring-wrap">
                        <div class="score-ring"></div>
                    </div>
                    <div>
                        <h3>Wellness Score <span class="score-badge">+4 this month</span></h3>
                        <p>Consistent visits and varied treatments contribute to your holistic wellness profile.</p>
                    </div>
                </div>
            </div>

            <!-- Stat grid -->
            <div class="overview-stat-grid">
                <div class="overview-stat-card">
                    <i class="fa-regular fa-calendar-check"></i>
                    <strong><?= esc($member['sessions_this_year'] ?? '14') ?></strong>
                    <span>Sessions This Year</span>
                    <small class="stat-note">+3 vs last yr</small>
                </div>
                <div class="overview-stat-card">
                    <i class="fa-regular fa-clock"></i>
                    <strong><?= esc($member['hours_of_care'] ?? '19.5') ?></strong>
                    <span>Hours of Care</span>
                    <small class="stat-note">1,170 minutes</small>
                </div>
                <div class="overview-stat-card">
                    <i class="fa-regular fa-star"></i>
                    <strong><?= esc($member['loyalty_points'] ?? '3,240') ?></strong>
                    <span>Loyalty Points</span>
                    <small class="stat-note">Expires Dec 2026</small>
                </div>
                <div class="overview-stat-card">
                    <i class="fa-regular fa-credit-card"></i>
                    <strong>$480</strong>
                    <span>Total Savings</span>
                    <small class="stat-note">Member discounts</small>
                </div>
            </div>

            <!-- Recent treatments -->
            <div class="dashboard-panel member-card">
                <div class="recent-header">
                    <h3>Recent Treatments</h3>
                    <a href="<?= base_url('member/treatment-history') ?>">View all</a>
                </div>
                <?php if (!empty($recentBookings)): ?>
                    <div class="recent-list">
                        <?php foreach ($recentBookings as $payment): ?>
                            <article class="recent-item">
                                <div>
                                    <h4><?= esc($payment['service']) ?></h4>
                                    <p><?= esc($member['full_name']) ?> · <?= date('M d, Y', strtotime($payment['payment_date'])) ?></p>
                                </div>
                                <div class="recent-price">
                                    <strong>RM <?= number_format((float)($payment['amount'] ?? 0), 0) ?></strong>
                                    <span><?= esc($payment['payment_status'] ?? 'Completed') ?></span>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="empty-note">No treatment history yet. <a href="<?= base_url('member/booking') ?>">Book your first session.</a></p>
                <?php endif; ?>
            </div>

            <!-- Quick action cards -->
            <div class="dashboard-actions-grid">
                <a href="<?= base_url('member/profile') ?>" class="dashboard-action-card">
                    <i class="fa-regular fa-user"></i>
                    <div>
                        <strong>Edit Profile</strong>
                        <p>Update your personal info</p>
                    </div>
                    <span><i class="fa-solid fa-angle-right"></i></span>
                </a>
                <a href="<?= base_url('member/subscription') ?>" class="dashboard-action-card">
                    <i class="fa-regular fa-gem"></i>
                    <div>
                        <strong>Membership Status</strong>
                        <p>View tier and rewards</p>
                    </div>
                    <span><i class="fa-solid fa-angle-right"></i></span>
                </a>
                <a href="<?= base_url('member/booking') ?>" class="dashboard-action-card">
                    <i class="fa-regular fa-calendar-plus"></i>
                    <div>
                        <strong>Book a Session</strong>
                        <p>Reserve your next ritual</p>
                    </div>
                    <span><i class="fa-solid fa-angle-right"></i></span>
                </a>
                <a href="<?= base_url('contact') ?>" class="dashboard-action-card">
                    <i class="fa-regular fa-envelope"></i>
                    <div>
                        <strong>Contact Us</strong>
                        <p>Get help or send a message</p>
                    </div>
                    <span><i class="fa-solid fa-angle-right"></i></span>
                </a>
            </div>

        </main>
    </div>
</section>
