<section class="auth-section">
    <div class="auth-box">
        <div class="auth-center-header">
            <img src="<?= base_url('images/logo_spa-removebg-preview.png') ?>" alt="Luxe Spa logo">
            <h2>Welcome Back</h2>
            <p>Sign in with your member email.</p>
        </div>

        <form action="<?= base_url('login/process') ?>" method="POST" class="auth-form">
            <div class="auth-field">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="auth-field">
                <label for="password">PASSWORD</label>
                <div class="pw-wrap">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <button type="button" class="pw-toggle" onclick="togglePassword()">
                        <i id="eyeIcon" class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="main-btn">Login</button>
        </form>

        <div class="auth-social-divider">or continue with</div>
        <div class="auth-social-btns">
            <a href="#" class="auth-social-btn" title="Google"><i class="fa-brands fa-google"></i></a>
            <a href="#" class="auth-social-btn" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="auth-social-btn" title="X / Twitter"><i class="fa-brands fa-x-twitter"></i></a>
        </div>

        <p class="auth-link">
            Don't have an account?
            <a href="<?= base_url('register') ?>">Register here</a>
        </p>
    </div>
</section>
<script>
function togglePassword() {
    var inp = document.getElementById('password');
    var icon = document.getElementById('eyeIcon');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        inp.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</script>