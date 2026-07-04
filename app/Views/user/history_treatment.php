<?php
    $allBookings  = $bookings ?? [];
    $statusGroups = ['Pending' => [], 'Confirmed' => [], 'Completed' => [], 'Cancelled' => []];
    foreach ($allBookings as $b) {
        $s = $b['status'] ?? 'Pending';
        if (isset($statusGroups[$s])) $statusGroups[$s][] = $b;
    }
    $upcoming  = array_merge($statusGroups['Pending'], $statusGroups['Confirmed']);
    $completed = $statusGroups['Completed'];
    $cancelled = $statusGroups['Cancelled'];
?>

<section class="member-shell container py-4 dashboard-shell">
    <div class="member-grid row g-4 align-items-start">
        <div class="col-lg-4 col-xl-3">
            <?= view('user/templates/member_sidebar', ['member' => $member, 'payments' => $allBookings]) ?>
        </div>

        <main class="member-main col-lg-8 col-xl-9">
            <h2 class="page-heading">Bookings</h2>
            <p class="page-subheading">All your past and upcoming appointments</p>

            <div class="booking-filters">
                <button class="booking-filter-btn active" onclick="filterTab('all', this)">All <span class="filter-count"><?= count($allBookings) ?></span></button>
                <button class="booking-filter-btn" onclick="filterTab('upcoming', this)">Upcoming <span class="filter-count"><?= count($upcoming) ?></span></button>
                <button class="booking-filter-btn" onclick="filterTab('completed', this)">Completed <span class="filter-count"><?= count($completed) ?></span></button>
                <button class="booking-filter-btn" onclick="filterTab('cancelled', this)">Cancelled <span class="filter-count"><?= count($cancelled) ?></span></button>
            </div>

            <?php if (!empty($allBookings)): ?>

                <?php foreach ($allBookings as $b):
                    $status      = esc($b['status'] ?? 'Pending');
                    $statusLower = strtolower($status);
                    $tabGroup    = in_array($status, ['Pending','Confirmed']) ? 'upcoming' : $statusLower;
                ?>
                <article class="dashboard-panel member-card booking-item-card" data-tab="<?= $tabGroup ?>">
                    <div class="bic-left">
                        <div class="bic-icon">
                            <i class="fa-solid fa-spa"></i>
                        </div>
                        <div>
                            <h4><?= esc($b['service']) ?></h4>
                            <div class="booking-meta">
                                <span><i class="fa-regular fa-calendar"></i> <?= date('M d, Y', strtotime($b['booking_date'])) ?></span>
                                <span><i class="fa-regular fa-clock"></i> <?= date('g:i A', strtotime($b['booking_time'])) ?></span>
                                <?php if (!empty($b['therapist'])): ?>
                                    <span><i class="fa-regular fa-user"></i> <?= esc($b['therapist']) ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($b['notes'])): ?>
                                <p class="bic-notes"><?= esc($b['notes']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="bic-right">
                        <span class="booking-status-badge <?= $statusLower ?>">
                            <i class="fa-solid fa-<?= $statusLower === 'completed' ? 'circle-check' : ($statusLower === 'cancelled' ? 'circle-xmark' : 'circle-dot') ?>"></i>
                            <?= $status ?>
                        </span>
                        <?php if (in_array($status, ['Pending', 'Confirmed'])): ?>
                            <a href="<?= base_url('member/booking/cancel/' . (int)$b['booking_id']) ?>"
                               class="booking-action-link"
                               onclick="return confirm('Cancel this booking?')">Cancel</a>
                        <?php elseif ($status === 'Completed'): ?>
                            <a href="<?= base_url('member/booking') ?>" class="booking-action-link">Rebook</a>
                        <?php endif; ?>
                    </div>
                </article>
                <?php endforeach; ?>

            <?php else: ?>
                <div class="empty-bookings-state">
                    <i class="fa-regular fa-calendar-xmark"></i>
                    <h3>No bookings yet</h3>
                    <p>Ready to experience Luxe Spa? Book your first session.</p>
                    <a href="<?= base_url('member/booking') ?>" class="main-btn">Book a Session</a>
                </div>
            <?php endif; ?>

            <div class="booking-cta-card mt-3">
                <div>
                    <strong>Ready for your next ritual?</strong>
                    <p><?= esc($member['membership'] ?? 'Premium') ?> members receive priority scheduling.</p>
                </div>
                <a href="<?= base_url('member/booking') ?>" class="main-btn">Book Now</a>
            </div>
        </main>
    </div>
</section>

<script>
function filterTab(tab, btn) {
    document.querySelectorAll('.booking-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.booking-item-card').forEach(card => {
        card.style.display = (tab === 'all' || card.dataset.tab === tab) ? '' : 'none';
    });
}
</script>

                <?php if (!empty($payments)): ?>
                    <div class="booking-list">
                        <?php foreach ($payments as $payment): ?>
                            <?php
                                $status = esc($payment['payment_status'] ?? 'Completed');
                                $statusClass = strtolower($status) === 'upcoming' ? 'upcoming' : 'completed';
                            ?>
                            <article class="booking-item" data-status="<?= $status ?>">
                                <div class="booking-item-left">
                                    <h4><?= esc($payment['service']) ?></h4>
                                    <div class="booking-meta">
                                        <span><i class="fa-regular fa-calendar"></i> <?= date('M d, Y \a\t g:i A', strtotime($payment['payment_date'])) ?></span>
                                        <span><i class="fa-regular fa-clock"></i> 60 min</span>
                                    </div>
                                    <span class="booking-with">with <?= esc($member['full_name']) ?></span>
                                </div>
                                <div class="booking-item-right">
                                    <span class="booking-status-badge <?= $statusClass ?>"><i class="fa-solid fa-circle-check"></i> <?= $status ?></span>
                                    <strong class="booking-amount">$<?= number_format((float)($payment['amount'] ?? 0), 0) ?></strong>
                                    <a href="<?= base_url('member/subscription') ?>" class="booking-action-link"><?= $statusClass === 'completed' ? 'Rebook' : 'Cancel' ?></a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="empty-note">No bookings yet. Book your first session to get started.</p>
                <?php endif; ?>
            </div>

            <div class="booking-cta-card">
                <div>
                    <strong>Ready for your next ritual?</strong>
                    <p><?= esc($member['membership'] ?? 'Premium') ?> members receive priority scheduling.</p>
                </div>
                <a href="<?= base_url('services') ?>" class="main-btn">Book Now</a>
            </div>
        </main>
    </div>
</section>

<script>
function filterBookings(status, btn) {
    document.querySelectorAll('.booking-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.booking-item').forEach(item => {
        if (status === 'all') { item.style.display = ''; }
        else { item.style.display = item.dataset.status === status ? '' : 'none'; }
    });
}
</script>
