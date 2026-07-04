<?php
$services = [
    [
        'name'     => 'Rose Petal Massage',
        'duration' => '90 min',
        'price'    => 185,
        'icon'     => 'fa-spa',
        'img'      => 'images/spa-room.png',
        'desc'     => 'A full-body massage using warm rose-infused oils to melt tension and restore radiance.',
        'benefits' => ['Deep muscle relaxation', 'Improved circulation', 'Stress relief'],
    ],
    [
        'name'     => 'Cherry Blossom Facial',
        'duration' => '60 min',
        'price'    => 150,
        'icon'     => 'fa-face-smile',
        'img'      => 'images/facial.jpg',
        'desc'     => 'A brightening facial treatment powered by cherry blossom extracts for luminous, even skin.',
        'benefits' => ['Brightening & evening', 'Hydration boost', 'Anti-aging care'],
    ],
    [
        'name'     => 'Hydrating Body Ritual',
        'duration' => '75 min',
        'price'    => 140,
        'icon'     => 'fa-droplet',
        'img'      => 'images/treatment-room.png',
        'desc'     => 'A deep-moisture body wrap that leaves skin silky-smooth and deeply replenished.',
        'benefits' => ['Intense hydration', 'Skin softening', 'Aromatherapy'],
    ],
    [
        'name'     => 'Aromatherapy Body Wrap',
        'duration' => '60 min',
        'price'    => 120,
        'icon'     => 'fa-leaf',
        'img'      => 'images/luxegarden.png',
        'desc'     => 'Detoxifying body wrap paired with essential oil aromatherapy to purify and calm.',
        'benefits' => ['Detox & cleanse', 'Calming scent therapy', 'Pore refinement'],
    ],
    [
        'name'     => 'Velvet Hair Spa',
        'duration' => '45 min',
        'price'    => 90,
        'icon'     => 'fa-scissors',
        'img'      => 'images/hair-spa.jpg',
        'desc'     => 'Nourishing scalp massage and deep conditioning treatment for silky, revitalised hair.',
        'benefits' => ['Scalp nourishment', 'Frizz control', 'Shine restoration'],
    ],
    [
        'name'     => 'Couples Retreat Package',
        'duration' => '120 min',
        'price'    => 380,
        'icon'     => 'fa-heart',
        'img'      => 'images/waitingareaspa.png',
        'desc'     => 'A shared wellness journey for two in a private suite — the ultimate bonding ritual.',
        'benefits' => ['Private suite', 'Dual therapists', 'Champagne welcome'],
    ],
    [
        'name'     => 'Pedicure & Manicure',
        'duration' => '60 min',
        'price'    => 85,
        'icon'     => 'fa-hand-sparkles',
        'img'      => 'images/pedicure.jpg',
        'desc'     => 'Luxury nail care for hands and feet with premium polishes and a relaxing soak.',
        'benefits' => ['Nail shaping', 'Cuticle care', 'Polish & finish'],
    ],
];
$therapists = ['Nadia Voss', 'Tomás Reyes', 'Linh Nguyen', 'Anis Malik', 'Any Available'];
$timeSlots  = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
$today      = date('Y-m-d');
$maxDate    = date('Y-m-d', strtotime('+60 days'));
?>

<!-- Hero -->
<section class="book-hero">
    <div class="book-hero-inner">
        <span class="eyebrow-pill">Book a Session</span>
        <h1>Reserve Your<br><em>Wellness Ritual</em></h1>
        <p>Choose a service, pick a time, and let our therapists take care of the rest.</p>
    </div>
</section>

<!-- Services -->
<section class="book-services container" id="services">
    <div class="book-section-header">
        <h2>Our Services</h2>
        <p>From restorative massages to brightening facials — every treatment is crafted for you.</p>
    </div>

    <div class="book-services-grid">
        <?php foreach ($services as $i => $svc): ?>
        <article class="book-service-card" id="service-<?= $i ?>">
            <div class="book-service-img">
                <img src="<?= base_url($svc['img']) ?>" alt="<?= esc($svc['name']) ?>">
                <div class="book-service-overlay">
                    <span><i class="fa-regular fa-clock"></i> <?= $svc['duration'] ?></span>
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
                <button class="book-select-btn" onclick="selectService('<?= esc($svc['name']) ?>', <?= $svc['price'] ?>, '<?= $svc['duration'] ?>')">
                    Select &amp; Book
                </button>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>

<!-- Booking Form -->
<section class="book-form-section container" id="bookingForm">
    <div class="book-form-wrap">
        <div class="book-form-header">
            <h2>Complete Your Booking</h2>
            <p>Fill in your details and we'll confirm your appointment.</p>
        </div>

        <?php if (session()->get('member_logged_in')): ?>
        <!-- Logged-in: direct booking -->
        <form action="<?= base_url('member/booking/store') ?>" method="post" class="book-form">
            <div class="book-form-grid">
                <div class="spa-field">
                    <label>SERVICE</label>
                    <select name="service" id="formService" required>
                        <option value="" disabled selected>Select a service</option>
                        <?php foreach ($services as $svc): ?>
                            <option value="<?= esc($svc['name']) ?>"><?= esc($svc['name']) ?> — RM <?= $svc['price'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="spa-field">
                    <label>PREFERRED DATE</label>
                    <input type="date" name="booking_date" id="formDate" min="<?= $today ?>" max="<?= $maxDate ?>" required>
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
                <div class="spa-field" style="grid-column: span 2;">
                    <label>SPECIAL REQUESTS</label>
                    <textarea name="notes" rows="3" placeholder="Allergies, pressure preferences, focus areas…"></textarea>
                </div>
            </div>
            <div class="book-form-footer">
                <div id="formSummary" class="book-form-summary" style="visibility:hidden">
                    <strong id="formSummaryName"></strong>
                    <span id="formSummaryMeta"></span>
                </div>
                <button type="submit" class="main-btn"><i class="fa-solid fa-calendar-check"></i> Confirm Booking</button>
            </div>
        </form>
        <?php else: ?>
        <!-- Guest: enquiry that redirects to login -->
        <form action="<?= base_url('book/enquire') ?>" method="post" class="book-form">
            <div class="book-form-grid">
                <div class="spa-field">
                    <label>YOUR NAME</label>
                    <input type="text" name="name" placeholder="Full name" required>
                </div>
                <div class="spa-field">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" name="email" placeholder="you@email.com" required>
                </div>
                <div class="spa-field">
                    <label>SERVICE</label>
                    <select name="service" id="formService" required>
                        <option value="" disabled selected>Select a service</option>
                        <?php foreach ($services as $svc): ?>
                            <option value="<?= esc($svc['name']) ?>"><?= esc($svc['name']) ?> — RM <?= $svc['price'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="spa-field">
                    <label>PREFERRED DATE</label>
                    <input type="date" name="preferred_date" id="formDate" min="<?= $today ?>" max="<?= $maxDate ?>" required>
                </div>
            </div>
            <div class="book-form-footer">
                <p class="book-login-note"><i class="fa-solid fa-circle-info"></i> You'll be asked to log in or create a free account to complete your booking.</p>
                <button type="submit" class="main-btn"><i class="fa-solid fa-calendar-check"></i> Reserve My Slot</button>
            </div>
        </form>
        <?php endif; ?>
    </div>
</section>

<script>
function selectService(name, price, duration) {
    var sel = document.getElementById('formService');
    if (sel) {
        for (var i = 0; i < sel.options.length; i++) {
            if (sel.options[i].value === name) {
                sel.selectedIndex = i;
                break;
            }
        }
    }
    var summaryName = document.getElementById('formSummaryName');
    var summaryMeta = document.getElementById('formSummaryMeta');
    var summary     = document.getElementById('formSummary');
    if (summaryName && summary) {
        summaryName.textContent = name + ' — RM ' + price.toFixed(2);
        summaryMeta.textContent = duration + ' session';
        summary.style.visibility = 'visible';
    }
    document.getElementById('bookingForm').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
