<?php
$intent      = $intent ?? [];
$type        = $intent['type']         ?? 'membership';
$plan        = $intent['plan']         ?? '';
$service     = $intent['service']      ?? '';
$baseAmount  = (float)($intent['base_amount']  ?? 0);
$discount    = (float)($intent['discount']     ?? 0);
$total       = (float)($intent['total']        ?? $baseAmount);
$bookingId   = $intent['booking_id']   ?? null;
$bookingDate = $intent['booking_date'] ?? '';
$bookingTime = $intent['booking_time'] ?? '';
$duration    = $intent['duration']     ?? '';
$startDate   = date('d M Y');
$endDate     = date('d M Y', strtotime('+12 months'));
?>

<div class="payment-page">

  <!-- Page hero / header -->
  <div class="payment-page-hero">
    <img src="<?= base_url('images/logospa.png') ?>" alt="Luxe Spa" class="payment-logo">
    <h1 class="payment-title">Payment</h1>
    <p class="payment-subtitle">Secure, Simple &amp; Seamless</p>
  </div>

  <div class="payment-container">
    <form action="<?= base_url('member/payment/process') ?>" method="post" id="paymentForm" novalidate>

      <div class="payment-grid">

        <!-- ── LEFT COLUMN ──────────────────────────────────────────── -->
        <div class="payment-col">

          <!-- Summary Card -->
          <div class="payment-card mb-4">
            <div class="payment-card-head">
              <span class="payment-card-icon">
                <i class="fa-solid fa-<?= $type === 'membership' ? 'crown' : 'calendar-check' ?>"></i>
              </span>
              <h3><?= $type === 'membership' ? 'Membership Summary' : 'Booking Summary' ?></h3>
            </div>

            <div class="payment-summary-list">
              <?php if ($type === 'membership'): ?>
                <div class="payment-summary-item">
                  <span>Plan Name</span>
                  <strong><?= esc($plan) ?> Membership</strong>
                </div>
                <div class="payment-summary-item">
                  <span>Duration</span>
                  <strong>12 Months</strong>
                </div>
                <div class="payment-summary-item">
                  <span>Start Date</span>
                  <strong><?= $startDate ?></strong>
                </div>
                <div class="payment-summary-item">
                  <span>End Date</span>
                  <strong><?= $endDate ?></strong>
                </div>
              <?php else: ?>
                <div class="payment-summary-item">
                  <span>Service</span>
                  <strong><?= esc($service) ?></strong>
                </div>
                <div class="payment-summary-item">
                  <span>Duration</span>
                  <strong><?= esc($duration) ?> min</strong>
                </div>
                <div class="payment-summary-item">
                  <span>Date</span>
                  <strong><?= !empty($bookingDate) ? date('d M Y', strtotime($bookingDate)) : '—' ?></strong>
                </div>
                <div class="payment-summary-item">
                  <span>Time</span>
                  <strong><?= !empty($bookingTime) ? date('g:i A', strtotime($bookingTime)) : '—' ?></strong>
                </div>
              <?php endif; ?>
            </div>
          </div><!-- /summary card -->

          <!-- Payment Details Card -->
          <div class="payment-card">
            <div class="payment-card-head">
              <span class="payment-card-icon">
                <i class="fa-regular fa-credit-card"></i>
              </span>
              <h3>Payment Details</h3>
            </div>

            <div id="cardFields">
              <div class="spa-field mb-3">
                <label>CARDHOLDER NAME</label>
                <input type="text" name="cardholder_name" placeholder="Name on card" autocomplete="cc-name">
              </div>
              <div class="spa-field mb-3">
                <label>CARD NUMBER</label>
                <input type="text" name="card_number" placeholder="1234 5678 0123 4500"
                       maxlength="19" id="cardNumberInput" autocomplete="cc-number">
              </div>
              <div class="payment-inputs-row">
                <div class="spa-field">
                  <label>EXPIRY DATE (MM/YY)</label>
                  <input type="text" name="expiry" placeholder="MM/YY" maxlength="5" autocomplete="cc-exp">
                </div>
                <div class="spa-field">
                  <label>CVV</label>
                  <input type="password" name="cvv" placeholder="•••" maxlength="3" autocomplete="cc-csc">
                </div>
                <div class="spa-field">
                  <label>COUNTRY</label>
                  <select name="country" autocomplete="country">
                    <option value="MY" selected>Malaysia</option>
                    <option value="SG">Singapore</option>
                    <option value="AU">Australia</option>
                    <option value="US">United States</option>
                    <option value="GB">United Kingdom</option>
                  </select>
                </div>
              </div>
            </div><!-- /#cardFields -->

            <div id="altMethodNote" style="display:none;" class="payment-alt-note">
              <i class="fa-solid fa-circle-info"></i>
              <p>After clicking <strong>Pay Now</strong>, you will be redirected to complete payment via your chosen method.</p>
            </div>

          </div><!-- /payment details card -->

        </div><!-- /left col -->

        <!-- ── RIGHT COLUMN ─────────────────────────────────────────── -->
        <div class="payment-col">

          <!-- Payment Method Card -->
          <div class="payment-card mb-4">
            <div class="payment-card-head">
              <span class="payment-card-icon">
                <i class="fa-solid fa-wallet"></i>
              </span>
              <h3>Payment Method</h3>
            </div>

            <div class="payment-method-group">

              <label class="payment-method-opt">
                <input type="radio" name="payment_method" value="Credit Card" checked>
                <span class="pmo-inner">
                  <span class="pmo-label">
                    <i class="fa-regular fa-credit-card"></i>
                    Credit / Debit Card
                  </span>
                  <span class="pmo-badges">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png"
                         alt="Visa" height="14">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                         alt="Mastercard" height="18">
                  </span>
                </span>
              </label>

              <label class="payment-method-opt">
                <input type="radio" name="payment_method" value="FPX Online Banking">
                <span class="pmo-inner">
                  <span class="pmo-label">
                    <i class="fa-solid fa-building-columns"></i>
                    FPX Online Banking
                  </span>
                  <span class="pmo-tag pmo-tag--fpx">FPX</span>
                </span>
              </label>

              <label class="payment-method-opt">
                <input type="radio" name="payment_method" value="E-Wallet">
                <span class="pmo-inner">
                  <span class="pmo-label">
                    <i class="fa-solid fa-mobile-screen-button"></i>
                    E-Wallet
                  </span>
                  <span class="pmo-tag pmo-tag--tng">Touch 'n Go</span>
                </span>
              </label>

              <label class="payment-method-opt">
                <input type="radio" name="payment_method" value="Bank Transfer">
                <span class="pmo-inner">
                  <span class="pmo-label">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                    Bank Transfer
                  </span>
                </span>
              </label>

            </div>
          </div><!-- /payment method card -->

          <!-- Payment Summary Card -->
          <div class="payment-card mb-4">
            <div class="payment-card-head">
              <span class="payment-card-icon">
                <i class="fa-solid fa-receipt"></i>
              </span>
              <h3>Payment Summary</h3>
            </div>
            <div class="payment-total-list">
              <div class="payment-total-item">
                <span><?= $type === 'membership' ? 'Membership Fee' : 'Service Fee' ?></span>
                <span>RM <?= number_format($baseAmount, 2) ?></span>
              </div>
              <?php if ($discount > 0): ?>
              <div class="payment-total-item payment-discount-row">
                <span>Discount <small>(Renewal benefit)</small></span>
                <span class="payment-discount-val">- RM <?= number_format($discount, 2) ?></span>
              </div>
              <?php endif; ?>
              <div class="payment-total-item payment-total-row">
                <strong>Total Amount</strong>
                <strong class="payment-total-val">RM <?= number_format($total, 2) ?></strong>
              </div>
            </div>
          </div><!-- /payment summary card -->

          <!-- Hidden POST fields -->
          <input type="hidden" name="payment_type" value="<?= esc($type) ?>">
          <input type="hidden" name="plan"         value="<?= esc($plan) ?>">
          <input type="hidden" name="service"      value="<?= esc($service) ?>">
          <input type="hidden" name="amount"       value="<?= $total ?>">
          <?php if ($bookingId): ?>
          <input type="hidden" name="booking_id" value="<?= (int)$bookingId ?>">
          <?php endif; ?>

          <!-- Pay Button -->
          <button type="submit" class="main-btn payment-pay-btn">
            <i class="fa-solid fa-lock"></i>&ensp;Pay Now
          </button>

          <p class="payment-security-text">
            <i class="fa-solid fa-shield-halved"></i>
            Your payment information is encrypted in a secure account.
            We do not store card details.
          </p>

        </div><!-- /right col -->

      </div><!-- /.payment-grid -->
    </form>
  </div><!-- /.payment-container -->
</div><!-- /.payment-page -->

<script>
(function () {
    var cardFields = document.getElementById('cardFields');
    var altNote    = document.getElementById('altMethodNote');
    var opts       = document.querySelectorAll('.payment-method-opt');
    var radios     = document.querySelectorAll('input[name="payment_method"]');

    function syncMethod() {
        var checked = document.querySelector('input[name="payment_method"]:checked');
        var isCard  = checked && checked.value === 'Credit Card';
        cardFields.style.display = isCard ? '' : 'none';
        altNote.style.display    = isCard ? 'none' : '';
        opts.forEach(function (o) { o.classList.remove('active'); });
        if (checked) { checked.closest('.payment-method-opt').classList.add('active'); }
    }

    radios.forEach(function (r) { r.addEventListener('change', syncMethod); });
    syncMethod();

    /* Format card number: groups of 4 */
    var cardInput = document.getElementById('cardNumberInput');
    if (cardInput) {
        cardInput.addEventListener('input', function () {
            var digits = this.value.replace(/\D/g, '').substring(0, 16);
            this.value = digits.replace(/(.{4})(?=.)/g, '$1 ');
        });
    }

    /* Format expiry MM/YY */
    var expiryInput = document.querySelector('input[name="expiry"]');
    if (expiryInput) {
        expiryInput.addEventListener('input', function () {
            var v = this.value.replace(/\D/g, '').substring(0, 4);
            if (v.length >= 3) { v = v.substring(0, 2) + '/' + v.substring(2); }
            this.value = v;
        });
    }
})();
</script>
