<section class="auth-section">
    <div class="auth-box">

        <h2>Member Registration</h2>
        <p>Create your Luxe Spa membership account.</p>

        <form action="<?= base_url('register/process') ?>" method="POST">

            <input type="text"
                   name="full_name"
                   placeholder="Full Name"
                   required>

            <input type="email"
                   name="email"
                   placeholder="Email Address"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Password"
                   required>

            <input type="password"
                   name="confirm_password"
                   placeholder="Confirm Password"
                   required>

            <button type="submit">Register</button>

        </form>

        <p class="auth-link">
            Already have an account?
            <a href="<?= base_url('login') ?>">Login here</a>
        </p>

    </div>
</section>