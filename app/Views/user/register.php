<section class="auth-section">

<div class="auth-box auth-box-wide register-landscape">

    <!-- LEFT PANEL -->
    <div class="auth-left">
        <img src="<?= base_url('images/logo_spa-removebg-preview.png') ?>" alt="Luxe Spa">
        <h2>Create your account</h2>
        <p>Join Luxe Spa and reserve your membership. Complete payment later.</p>
    </div>

    <!-- RIGHT PANEL -->
    <div class="auth-right">

        <form action="<?= base_url('register/process') ?>" method="POST" class="auth-form">

            <div class="register-form-grid">
                <div class="auth-field">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>
                </div>

                <div class="auth-field">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>

<div class="auth-field">
    <label>Password</label>
    <div class="pw-wrap">
        <input type="password" name="password" id="password" required>
        <button type="button" class="pw-toggle" onclick="togglePassword('password', this)">
            <i class="fa fa-eye"></i>
        </button>
    </div>
</div>

<div class="auth-field">
    <label>Confirm Password</label>
    <div class="pw-wrap">
        <input type="password" name="confirm_password" id="confirm_password" required>
        <button type="button" class="pw-toggle" onclick="togglePassword('confirm_password', this)">
            <i class="fa fa-eye"></i>
        </button>
    </div>
</div>

                <div class="auth-field auth-field-full">
                    <label>Membership Type</label>
                    <select name="member_type">
                        <option>Individual</option>
                        <option>Corporate</option>
                        <option>Family</option>
                    </select>
                </div>
            </div>

            <p class="field-note">
                Your account remains inactive until payment is completed.
            </p>

            <button class="main-btn" type="submit">Register</button>

            <!-- MOVE SOCIAL INSIDE FORM (IMPORTANT) -->
            <div class="auth-social-divider">or continue with</div>

            <div class="auth-social-btns">
                <a href="#" class="auth-social-btn"><i class="fa-brands fa-google"></i></a>
                <a href="#" class="auth-social-btn"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="auth-social-btn"><i class="fa-brands fa-x-twitter"></i></a>
            </div>

            <p class="auth-link">
                Already have an account?
                <a href="<?= base_url('login') ?>">Login here</a>
            </p>

        </form>

    </div>

</div>

</section>     

<script>
function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon = btn.querySelector("i");

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>