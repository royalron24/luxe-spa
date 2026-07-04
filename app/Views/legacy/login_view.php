<section class="auth-section">
    <div class="auth-box">

        <h2>Member Login</h2>
        <p>Login to access your Luxe Spa account.</p>

        <form action="<?= base_url('login/process') ?>" method="POST">

            <input type="email"
                   name="email"
                   placeholder="Email Address"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Password"
                   required>

            <button type="submit">Login</button>

        </form>

        <p class="auth-link">
            Don't have an account?
            <a href="<?= base_url('register') ?>">Register here</a>
        </p>

    </div>
</section>