<section class="auth-section">
    <div class="auth-box">
        <div class="auth-header">
            <img src="<?= base_url('images/logo_spa-removebg-preview.png') ?>" alt="Luxe Spa logo">
            <div>
                <h2>Create your Luxe Spa account</h2>
                <p>Register now to reserve your account. Complete payment later to activate membership.</p>
            </div>
        </div>

        <form action="<?= base_url('register/process') ?>" method="POST" class="auth-form">
            <div class="auth-field">
                <label for="full_name">Full Name</label>
                <input id="full_name" type="text" name="full_name" placeholder="Full Name" required>
            </div>
            <div class="auth-field">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="auth-field">
                <label for="password">Password</label>
                <div style="position:relative">
                    <input id="password" type="password" name="password" placeholder="Password" style="padding-right:40px" required>
                    <button type="button" tabindex="-1" onclick="togglePw('password',this)"
                        style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;outline:none;cursor:pointer;padding:0;color:#a17186;font-size:13px;line-height:1">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="auth-field">
                <label for="confirm_password">Confirm Password</label>
                <div style="position:relative">
                    <input id="confirm_password" type="password" name="confirm_password" placeholder="Confirm Password" style="padding-right:40px" required>
                    <button type="button" tabindex="-1" onclick="togglePw('confirm_password',this)"
                        style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;outline:none;cursor:pointer;padding:0;color:#a17186;font-size:13px;line-height:1">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="auth-field">
                <label for="member_type">Membership Type</label>
                <select id="member_type" name="member_type" required>
                    <option value="Individual">Individual</option>
                    <option value="Corporate">Corporate</option>
                    <option value="Family">Family</option>
                </select>
            </div>
            <p class="field-note">Your account remains inactive until you choose a plan and complete payment.</p>
            <button type="submit" class="main-btn">Register</button>
        </form>

        <p class="auth-link">
            Already have an account?
            <a href="<?= base_url('login') ?>">Login here</a>
        </p>
    </div>
</section>
<script>
function togglePw(id, btn) {
    var inp = document.getElementById(id);
    var icon = btn.querySelector('i');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        inp.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
