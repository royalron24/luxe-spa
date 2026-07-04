<!-- Contact Hero -->
<section class="contact-hero">
    <div class="contact-hero-inner">
        <span class="eyebrow-pill">Get in Touch</span>
        <h1>Contact <em>Luxe Spa</em></h1>
        <p>Have a question, want to make an enquiry, or simply want to say hello? We'd love to hear from you.</p>
    </div>
</section>

<!-- Info + Form -->
<section class="contact-main container">

    <div class="contact-grid">

        <!-- Left: info cards -->
        <div class="contact-info-col">
            <div class="contact-info-card">
                <div class="contact-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div>
                    <strong>Our Address</strong>
                    <p>No. 18, Jalan Indah 3, Taman Indah,<br>81200 Johor Bahru, Johor, Malaysia</p>
                </div>
            </div>
            <div class="contact-info-card">
                <div class="contact-info-icon"><i class="fa-solid fa-phone"></i></div>
                <div>
                    <strong>Phone</strong>
                    <p>+60 12-345 6789</p>
                </div>
            </div>
            <div class="contact-info-card">
                <div class="contact-info-icon"><i class="fa-solid fa-envelope"></i></div>
                <div>
                    <strong>Email</strong>
                    <p>info@luxespa.com</p>
                </div>
            </div>
            <div class="contact-info-card">
                <div class="contact-info-icon"><i class="fa-regular fa-clock"></i></div>
                <div>
                    <strong>Opening Hours</strong>
                    <p>Mon – Fri: 10:00 AM – 9:00 PM<br>Sat – Sun: 9:00 AM – 10:00 PM</p>
                </div>
            </div>

            <div class="contact-social-row">
                <a href="#" class="contact-social-btn"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="contact-social-btn"><i class="fab fa-instagram"></i></a>
                <a href="#" class="contact-social-btn"><i class="fab fa-tiktok"></i></a>
                <a href="#" class="contact-social-btn"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>

        <!-- Right: form -->
        <div class="contact-form-col">
            <div class="contact-form-card">
                <h2>Send Us a Message</h2>
                <p>Fill in the form and our team will respond within 24 hours.</p>

                <form action="<?= base_url('contact/send') ?>" method="post" class="contact-form">
                    <div class="contact-form-grid">
                        <div class="spa-field">
                            <label>FULL NAME</label>
                            <input type="text" name="name" placeholder="Your full name" required>
                        </div>
                        <div class="spa-field">
                            <label>EMAIL ADDRESS</label>
                            <input type="email" name="email" placeholder="you@email.com" required>
                        </div>
                        <div class="spa-field">
                            <label>PHONE NUMBER</label>
                            <input type="text" name="phone" placeholder="+60 12-345 6789">
                        </div>
                        <div class="spa-field">
                            <label>SUBJECT</label>
                            <select name="subject">
                                <option value="" disabled selected>Select a topic</option>
                                <option value="Booking Enquiry">Booking Enquiry</option>
                                <option value="Membership">Membership</option>
                                <option value="Feedback">Feedback</option>
                                <option value="General">General Enquiry</option>
                            </select>
                        </div>
                        <div class="spa-field contact-full-col">
                            <label>MESSAGE</label>
                            <textarea name="message" rows="5" placeholder="How can we help you?…" required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="main-btn contact-submit-btn">
                        <i class="fa-solid fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Map placeholder -->
    <div class="contact-map-wrap">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.0!2d103.7!3d1.5!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMzAnMDAuMCJOIDEwM8KwNDInMDAuMCJF!5e0!3m2!1sen!2smy!4v1688000000000!5m2!1sen!2smy"
            width="100%" height="320" style="border:0;border-radius:16px;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" title="Luxe Spa Location">
        </iframe>
    </div>
</section>
