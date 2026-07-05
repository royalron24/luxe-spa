<?php
    $tierOrder  = ['Bronze' => 0, 'Silver' => 1, 'Gold' => 2];
    $tierColors = ['Bronze' => '#cd7f32', 'Silver' => '#9e9e9e', 'Gold' => '#d4a017'];
    $currentTier = $member['membership'] ?? '';
    $currentPts  = (int) ($member['loyalty_points'] ?? 0);
    $nextPts     = 5000;
    $pct         = min(100, round($currentPts / $nextPts * 100));
?>

<section class="member-shell container py-4 dashboard-shell">
    <div class="member-grid row g-4 align-items-start">
        <div class="col-lg-4 col-xl-3">
            <?= view('user/templates/member_sidebar', ['member' => $member, 'payments' => $payments ?? []]) ?>
        </div>

        <main class="member-main col-lg-8 col-xl-9">
            <h2 class="page-heading">Membership</h2>
            <p class="page-subheading">Your tier benefits and loyalty rewards</p>

            <?php if (!empty($currentTier)): ?>
            <div class="member-tier-hero tier-hero-<?= strtolower($currentTier) ?> mb-3">
                <div class="tier-hero-top">
                    <div>
                        <small>CURRENT TIER</small>
                        <h2><?= esc($currentTier) ?></h2>
                        <p>Member since <?= !empty($member['join_date']) ? date('F Y', strtotime($member['join_date'])) : 'this year' ?> · Renews Jan 1, 2027</p>
                    </div>
                    <i class="fa-solid fa-<?= $currentTier === 'Gold' ? 'crown' : ($currentTier === 'Silver' ? 'medal' : 'star') ?> tier-hero-icon"></i>
                </div>
                <div class="tier-progress-wrap">
                    <div class="tier-progress-labels">
                        <span><?= number_format($currentPts) ?> pts</span>
                        <span><?= number_format($nextPts) ?> pts</span>
                    </div>
                    <div class="tier-progress-bar"><div style="width: <?= $pct ?>%"></div></div>
                    <p class="tier-progress-note"><?= number_format($nextPts - $currentPts) ?> points until next tier · Est. 3 more visits</p>
                </div>
                <div class="tier-stats-row">
                    <div><strong><?= number_format($currentPts) ?></strong><span>Total Points</span></div>
                    <div><strong><?= count($payments ?? []) ?></strong><span>Appointments</span></div>
                    <div><strong>Dec 2026</strong><span>Expiry</span></div>
                </div>
            </div>

            <div class="profile-section-card mb-3">
                <h3 class="profile-section-title">Tier Overview</h3>
                <div class="tier-overview-grid">
                    <?php foreach ($plans as $plan): ?>
                        <?php $isActive = $plan['name'] === $currentTier; ?>
                        <div class="tier-overview-card tier-<?= strtolower($plan['name']) ?> <?= $isActive ? 'active' : '' ?>">
                            <div class="tier-icon-badge">
                                <i class="fa-solid fa-<?= $plan['name'] === 'Gold' ? 'crown' : ($plan['name'] === 'Silver' ? 'medal' : 'star') ?>"></i>
                            </div>
                            <span><?= esc($plan['name']) ?></span>
                            <?php if ($isActive): ?><small>You're here</small><?php endif; ?>
                            <strong>RM <?= number_format($plan['price'], 0) ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="profile-section-card mb-3">
                <h3 class="profile-section-title">Choose or Renew a Plan</h3>
                <div class="plan-cards-grid">
                    <?php foreach ($plans as $plan): ?>
                        <?php $isCurrent = ($currentTier === $plan['name']); ?>
                        <div class="plan-select-card tier-<?= strtolower($plan['name']) ?> <?= $isCurrent ? 'current' : '' ?>">
                            <div class="plan-select-top">
                                <div>
                                    <h4><span class="tier-plan-icon"><i class="fa-solid fa-<?= $plan['name'] === 'Gold' ? 'crown' : ($plan['name'] === 'Silver' ? 'medal' : 'star') ?>"></i></span><?= esc($plan['name']) ?></h4>
                                    <?php if ($isCurrent): ?><span class="plan-current-badge">Current</span><?php endif; ?>
                                </div>
                                <strong>RM <?= number_format($plan['price'], 2) ?></strong>
                            </div>
                            <p><?= esc($plan['benefits']) ?></p>
                            <form action="<?= base_url('member/payment/prepare') ?>" method="post">
                                <input type="hidden" name="type" value="membership">
                                <input type="hidden" name="plan" value="<?= esc($plan['name']) ?>">
                                <input type="hidden" name="amount" value="<?= esc($plan['price']) ?>">
                                <button type="submit" class="main-btn" style="width:100%">
                                    <?= $isCurrent ? 'Renew Plan' : 'Subscribe Now' ?>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="booking-cta-card">
                <div>
                    <strong>Need help choosing a plan?</strong>
                    <p>Our concierge team is happy to guide you to the right tier.</p>
                </div>
                <a href="<?= base_url('member/dashboard') ?>" class="main-btn">Book Session</a>
            </div>
        </main>
    </div>
</section>
