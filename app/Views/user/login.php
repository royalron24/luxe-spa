<section class="auth-section">
    <div class="auth-box">
        <div class="auth-header">
            <img src="<?= base_url('images/logo_spa-removebg-preview.png') ?>" alt="Luxe Spa logo">
            <div>
                <h2>Member Login</h2>
                <p>Sign in with your member email.</p>
            </div>
        </div>

        <form action="<?= base_url('login/process') ?>" method="POST" class="auth-form">
            <div class="auth-field">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" placeholder="Email Address" required>
            </div>
<div class="auth-field">
    <label for="password">Password</label>

    <div class="pw-wrap">
        <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Password"
            required
        >

        <button type="button" class="pw-toggle" onclick="togglePassword()">
            <i id="eyeIcon" class="fa-solid fa-eye"></i>
        </button>
    </div>

    <button type="submit" class="main-btn">
        Login
    </button>
    
</div>
        <p class="auth-link">
            Don't have an account?
            <a href="<?= base_url('register') ?>">Register here</a>
        </p>
    </div>
    </form>
</section>

<script>
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
</script>