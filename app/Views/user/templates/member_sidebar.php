<aside class="member-sidebar">
    <?php
        $paymentList = $payments ?? [];
        $visitCount = count($paymentList);
        $totalSpent = 0;
        foreach ($paymentList as $payment) {
            $totalSpent += (float) ($payment['amount'] ?? 0);
        }
        $loyaltyPoints = (int) ($member['loyalty_points'] ?? max($visitCount * 120, 0));
        $membershipLabel = $member['membership'] ?? 'Member';
    ?>

    <div class="member-card member-brand-card">
        <img src="<?= base_url('images/logo_spa-removebg-preview.png') ?>" alt="Luxe Spa logo">
        <div>
            <strong>Luxe Spa</strong>
            <p>Relax · Rejuvenate · Renew</p>
            <small><i class="fa-solid fa-star"></i> 5.0 - Premium Wellness</small>
        </div>
    </div>

    <div class="member-card member-profile-card">
        <div class="member-profile-cover"></div>
        <div class="member-profile-content">
            <div class="member-avatar-wrap">
                <img src="<?= base_url($member['profile_picture'] ?? 'images/logo_spa-removebg-preview.png') ?>" alt="<?= esc($member['full_name']) ?>">
            </div>
            <div class="member-profile-info">
                <h2><?= esc($member['full_name']) ?></h2>
                <p><?= esc($member['email']) ?></p>
                <span class="member-chip"><?= esc($membershipLabel) ?></span>
            </div>
            <p class="member-since">Member since <?= !empty($member['join_date']) ? date('F Y', strtotime($member['join_date'])) : 'this year' ?></p>
            <div class="member-stats member-stats-compact">
                <div class="member-stat">
                    <strong><?= $visitCount ?></strong>
                    <span>Visits</span>
                </div>
                <div class="member-stat">
                    <strong><?= number_format($loyaltyPoints / 1000, 1) ?>k</strong>
                    <span>Points</span>
                </div>
                <div class="member-stat">
                    <strong>$<?= number_format($totalSpent, 0) ?></strong>
                    <span>Saved</span>
                </div>
            </div>
        </div>
    </div>

    <div class="member-card member-nav-card">
        <nav class="member-nav">
            <a href="<?= base_url('member/dashboard') ?>" class="<?= uri_string() === 'member/dashboard' ? 'active' : '' ?>">
                <i class="fa-solid fa-house"></i>
                Overview
            </a>
            <a href="<?= base_url('member/treatment-history') ?>" class="<?= uri_string() === 'member/treatment-history' ? 'active' : '' ?>">
                <i class="fa-solid fa-calendar-days"></i>
                Bookings
            </a>
            <a href="<?= base_url('member/booking') ?>" class="<?= uri_string() === 'member/booking' ? 'active' : '' ?>">
                <i class="fa-solid fa-calendar-plus"></i>
                Book a Session
            </a>
            <a href="<?= base_url('member/profile') ?>" class="<?= uri_string() === 'member/profile' ? 'active' : '' ?>">
                <i class="fa-solid fa-user-pen"></i>
                Edit Profile
            </a>
            <a href="<?= base_url('member/subscription') ?>" class="<?= uri_string() === 'member/subscription' ? 'active' : '' ?>">
                <i class="fa-solid fa-crown"></i>
                Membership
            </a>
            <a href="<?= base_url('member/payment-history') ?>" class="<?= uri_string() === 'member/payment-history' ? 'active' : '' ?>">
                <i class="fa-solid fa-receipt"></i>
                Payment History
            </a>
            <a href="<?= base_url('logout') ?>">
                <i class="fa-solid fa-right-from-bracket"></i>
                Sign out
            </a>
        </nav>
    </div>

    <?php
        $__nextBookingModel = model('\App\Models\BookingModel');
        $nextSession        = $__nextBookingModel
            ->where('member_id', (int)$member['member_id'])
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->where('booking_date >=', date('Y-m-d'))
            ->orderBy('booking_date', 'ASC')
            ->orderBy('booking_time', 'ASC')
            ->first();
    ?>
    <div class="member-card member-session-card">
        <?php if ($nextSession): ?>
            <div class="session-label">Next session</div>
            <h3><?= esc($nextSession['service']) ?></h3>
            <p class="session-meta"><i class="fa-regular fa-calendar"></i> <?= date('M d, Y', strtotime($nextSession['booking_date'])) ?></p>
            <p class="session-meta"><i class="fa-regular fa-clock"></i> <?= date('g:i A', strtotime($nextSession['booking_time'])) ?></p>
            <?php if (!empty($nextSession['therapist']) && $nextSession['therapist'] !== 'Any Available'): ?>
                <p class="session-meta"><i class="fa-regular fa-user"></i> <?= esc($nextSession['therapist']) ?></p>
            <?php endif; ?>
            <a href="<?= base_url('member/treatment-history') ?>" class="main-btn">Manage Booking</a>
        <?php else: ?>
            <div class="session-label">Next session</div>
            <h3 class="session-empty-title">No session booked</h3>
            <p class="session-meta session-empty-note">Ready for your next ritual?</p>
            <a href="<?= base_url('member/booking') ?>" class="main-btn">Book Now</a>
        <?php endif; ?>
    </div>
</aside>
