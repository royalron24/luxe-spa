<?php
$services = [
    ['name' => 'Rose Petal Massage',      'duration' => 90,  'price' => 185, 'icon' => 'fa-spa',           'img' => 'images/spa-room.png',       'desc' => 'A full-body massage using warm rose-infused oils to melt tension and restore radiance.',      'benefits' => ['Deep muscle relaxation', 'Improved circulation', 'Stress relief']],
    ['name' => 'Cherry Blossom Facial',   'duration' => 60,  'price' => 150, 'icon' => 'fa-face-smile',    'img' => 'images/facial.jpg',         'desc' => 'A brightening facial powered by cherry blossom extracts for luminous, even skin.',            'benefits' => ['Brightening & evening', 'Hydration boost', 'Anti-aging care']],
    ['name' => 'Hydrating Body Ritual',   'duration' => 75,  'price' => 140, 'icon' => 'fa-droplet',       'img' => 'images/treatment-room.png', 'desc' => 'A deep-moisture body wrap that leaves skin silky-smooth and deeply replenished.',             'benefits' => ['Intense hydration', 'Skin softening', 'Aromatherapy']],
    ['name' => 'Aromatherapy Body Wrap',  'duration' => 60,  'price' => 120, 'icon' => 'fa-leaf',          'img' => 'images/luxegarden.png',     'desc' => 'Detoxifying body wrap paired with essential oil aromatherapy to purify and calm.',             'benefits' => ['Detox & cleanse', 'Calming scent therapy', 'Pore refinement']],
    ['name' => 'Velvet Hair Spa',         'duration' => 45,  'price' => 90,  'icon' => 'fa-scissors',      'img' => 'images/hair-spa.jpg',       'desc' => 'Nourishing scalp massage and deep conditioning treatment for silky, revitalised hair.',        'benefits' => ['Scalp nourishment', 'Frizz control', 'Shine restoration']],
    ['name' => 'Couples Retreat Package', 'duration' => 120, 'price' => 380, 'icon' => 'fa-heart',         'img' => 'images/waitingareaspa.png', 'desc' => 'A shared wellness journey for two in a private suite — the ultimate bonding ritual.',          'benefits' => ['Private suite', 'Dual therapists', 'Champagne welcome']],
    ['name' => 'Pedicure & Manicure',     'duration' => 60,  'price' => 85,  'icon' => 'fa-hand-sparkles', 'img' => 'images/pedicure.jpg',       'desc' => 'Luxury nail care for hands and feet with premium polishes and a relaxing soak.',               'benefits' => ['Nail shaping', 'Cuticle care', 'Polish & finish']],
];
$therapists = ['Nadia Voss', 'Tomás Reyes', 'Linh Nguyen', 'Anis Malik', 'Any Available'];
$timeSlots  = ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
$today      = date('Y-m-d');
$maxDate    = date('Y-m-d', strtotime('+60 days'));
?>

<section class="member-shell container py-4 dashboard-shell">
    <div class="member-grid row g-4 align-items-start">
        <div class="col-lg-4 col-xl-3">
            <?= view('user/templates/member_sidebar', ['member' => $member, 'payments' => $bookings ?? []]) ?>
        </div>

        <main class="member-main col-lg-8 col-xl-9">
            <h2 class="page-heading">Book a Session</h2>
            <p class="page-subheading">Reserve your next wellness ritual</p>

            <!-- Service Cards (same as public book page) -->
            <div class="profile-section-card mb-3">
                <h3 class="profile-section-title">Choose a Service</h3>
                <div class="book-services-grid member-book-grid">
                    <?php foreach ($services as $svc): ?>
                    <article class="book-service-card member-service-pick"
                             data-service="<?= esc($svc['name']) ?>"
                             data-price="<?= $svc['price'] ?>"
                             data-duration="<?= $svc['duration'] ?>"
                             onclick="pickService(this)">
                        <div class="book-service-img">
                            <img src="<?= base_url($svc['img']) ?>" alt="<?= esc($svc['name']) ?>">
                            <div class="book-service-overlay">
                                <span><i class="fa-regular fa-clock"></i> <?= $svc['duration'] ?> min</span>
                                <span>RM <?= number_format($svc['price'], 2) ?></span>
                            </div>
                        </div>
                        <div class="book-service-body">
                            <div class="book-service-icon"><i class="fa-solid <?= $svc['icon'] ?>"></i></div>
                            <h3><?= esc($svc['name']) ?></h3>
                            <p><?= esc($svc['desc']) ?></p>
                            <ul class="book-service-benefits">
                                <?php foreach ($svc['benefits'] as $b): ?>
                                    <li><i class="fa-solid fa-check"></i> <?= esc($b) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="member-service-pick-check"><i class="fa-solid fa-circle-check"></i> Selected</div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="profile-section-card mb-3" id="memberBookForm">
                <h3 class="profile-section-title">Date, Time &amp; Preferences</h3>
                <form action="<?= base_url('member/booking/store') ?>" method="post">
                    <input type="hidden" name="service" id="hiddenService">

                    <div class="book-form-grid mb-3">
                        <div class="spa-field">
                            <label>DATE</label>
                            <input type="date" name="booking_date" min="<?= $today ?>" max="<?= $maxDate ?>" required>
                        </div>
                        <div class="spa-field">
                            <label>TIME SLOT</label>
                            <select name="booking_time" required>
                                <option value="" disabled selected>Select a time</option>
                                <?php foreach ($timeSlots as $slot): ?>
                                    <option value="<?= $slot ?>"><?= date('g:i A', strtotime($slot)) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="spa-field">
                            <label>PREFERRED THERAPIST</label>
                            <select name="therapist">
                                <?php foreach ($therapists as $t): ?>
                                    <option value="<?= esc($t) ?>"><?= esc($t) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="spa-field">
                            <label>SPECIAL REQUESTS</label>
                            <textarea name="notes" rows="2" placeholder="Allergies, pressure preferences…" style="width:100%;padding:12px 16px;border-radius:12px;border:1px solid rgba(232,18,70,.16);background:#fff5f8;color:#3a1f2a;font-size:14px;font-family:inherit;resize:vertical"></textarea>
                        </div>
                    </div>

                    <div class="booking-summary-bar">
                        <div class="booking-summary-info">
                            <span id="summaryService" class="summary-service-name">Select a service above to continue</span>
                            <span id="summaryMeta" class="summary-meta"></span>
                        </div>
                        <button type="submit" id="submitBtn" class="main-btn booking-submit-btn" disabled style="opacity:.5;cursor:not-allowed">
                            <i class="fa-solid fa-calendar-check"></i> Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</section>

<script>
function pickService(card) {
    document.querySelectorAll('.member-service-pick').forEach(c => c.classList.remove('picked'));
    card.classList.add('picked');
    document.getElementById('hiddenService').value        = card.dataset.service;
    document.getElementById('summaryService').textContent = card.dataset.service + ' — RM ' + parseFloat(card.dataset.price).toFixed(2);
    document.getElementById('summaryMeta').textContent    = card.dataset.duration + ' min session';
    var btn = document.getElementById('submitBtn');
    btn.disabled = false; btn.style.opacity = '1'; btn.style.cursor = 'pointer';
    document.getElementById('memberBookForm').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>

<section class="member-shell container py-4 dashboard-shell">
    <div class="member-grid row g-4 align-items-start">
        <div class="col-lg-4 col-xl-3">
            <?= view('user/templates/member_sidebar', ['member' => $member, 'payments' => $bookings ?? []]) ?>
        </div>

        <main class="member-main col-lg-8 col-xl-9">
            <h2 class="page-heading">Book a Session</h2>
            <p class="page-subheading">Reserve your next wellness ritual</p>

            <form action="<?= base_url('member/booking/store') ?>" method="post" id="bookingForm">

                <!-- Step 1: Choose Service -->
                <div class="profile-section-card mb-3">
                    <h3 class="profile-section-title">1. Choose a Service</h3>
                    <div class="service-select-grid">
                        <?php foreach ($services as $svc): ?>
                            <label class="service-select-card">
                                <input type="radio" name="service" value="<?= esc($svc['name']) ?>" data-price="<?= $svc['price'] ?>" data-duration="<?= $svc['duration'] ?>" required>
                                <div class="service-card-inner">
                                    <div class="service-card-icon"><i class="fa-solid <?= $svc['icon'] ?>"></i></div>
                                    <div>
                                        <strong><?= esc($svc['name']) ?></strong>
                                        <p><?= esc($svc['desc']) ?></p>
                                        <div class="service-meta">
                                            <span><i class="fa-regular fa-clock"></i> <?= $svc['duration'] ?> min</span>
                                            <span>RM <?= number_format($svc['price'], 2) ?></span>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-circle-check service-check"></i>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Step 2: Date & Time -->
                <div class="profile-section-card mb-3">
                    <h3 class="profile-section-title">2. Pick a Date &amp; Time</h3>
                    <div class="booking-datetime-grid">
                        <div class="spa-field">
                            <label>DATE</label>
                            <input type="date" name="booking_date" min="<?= $today ?>" max="<?= $maxDate ?>" required>
                        </div>
                        <div class="spa-field">
                            <label>TIME SLOT</label>
                            <select name="booking_time" required>
                                <option value="" disabled selected>Select a time</option>
                                <?php foreach ($timeSlots as $slot): ?>
                                    <option value="<?= $slot ?>"><?= date('g:i A', strtotime($slot)) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Therapist & Notes -->
                <div class="profile-section-card mb-3">
                    <h3 class="profile-section-title">3. Therapist &amp; Preferences</h3>
                    <div class="booking-datetime-grid mb-3">
                        <div class="spa-field">
                            <label>PREFERRED THERAPIST</label>
                            <select name="therapist">
                                <?php foreach ($therapists as $t): ?>
                                    <option value="<?= esc($t) ?>"><?= esc($t) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="spa-field">
                            <label>SPECIAL REQUESTS / NOTES</label>
                            <textarea name="notes" rows="3" placeholder="Allergies, pressure preferences, focus areas…" style="width:100%;padding:12px 16px;border-radius:12px;border:1px solid rgba(232,18,70,.16);background:#fff5f8;color:#3a1f2a;font-size:14px;font-family:inherit;resize:vertical"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Summary & Submit -->
                <div class="booking-summary-bar">
                    <div class="booking-summary-info">
                        <span id="summaryService" class="summary-service-name">Select a service to continue</span>
                        <span id="summaryMeta" class="summary-meta"></span>
                    </div>
                    <button type="submit" class="main-btn booking-submit-btn">
                        <i class="fa-solid fa-calendar-check"></i> Confirm Booking
                    </button>
                </div>

            </form>

            <!-- Upcoming Bookings -->
            <?php if (!empty($bookings)): ?>
            <div class="dashboard-panel member-card mt-4">
                <div class="recent-header">
                    <h3>Your Upcoming Bookings</h3>
                    <a href="<?= base_url('member/treatment-history') ?>">View all</a>
                </div>
                <div class="booking-list">
                    <?php foreach (array_slice($bookings, 0, 5) as $b): ?>
                        <?php $statusClass = strtolower($b['status'] ?? 'pending'); ?>
                        <article class="booking-item" data-status="<?= esc($b['status']) ?>">
                            <div class="booking-item-left">
                                <h4><?= esc($b['service']) ?></h4>
                                <div class="booking-meta">
                                    <span><i class="fa-regular fa-calendar"></i> <?= date('M d, Y', strtotime($b['booking_date'])) ?></span>
                                    <span><i class="fa-regular fa-clock"></i> <?= date('g:i A', strtotime($b['booking_time'])) ?></span>
                                    <?php if (!empty($b['therapist'])): ?>
                                        <span><i class="fa-regular fa-user"></i> <?= esc($b['therapist']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="booking-item-right">
                                <span class="booking-status-badge <?= $statusClass ?>"><?= esc($b['status']) ?></span>
                                <?php if ($statusClass === 'pending' || $statusClass === 'confirmed'): ?>
                                    <a href="<?= base_url('member/booking/cancel/' . $b['booking_id']) ?>"
                                       class="booking-action-link"
                                       onclick="return confirm('Cancel this booking?')">Cancel</a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</section>

<script>
document.querySelectorAll('input[name="service"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var card = this.closest('.service-select-card');
        document.querySelectorAll('.service-select-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        document.getElementById('summaryService').textContent = this.value + ' — RM ' + parseFloat(this.dataset.price).toFixed(2);
        document.getElementById('summaryMeta').textContent = this.dataset.duration + ' min session';
    });
});
</script>
