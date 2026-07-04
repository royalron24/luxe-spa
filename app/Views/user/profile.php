<section class="member-shell container py-4 dashboard-shell">
    <div class="member-grid row g-4 align-items-start">
        <div class="col-lg-4 col-xl-3">
            <?= view('user/templates/member_sidebar', ['member' => $member, 'payments' => $payments ?? []]) ?>
        </div>

        <main class="member-main col-lg-8 col-xl-9">
            <h2 class="page-heading">Edit Profile</h2>
            <p class="page-subheading">Update your personal information</p>

            <form action="<?= base_url('member/profile/update') ?>" method="post" enctype="multipart/form-data">
                <div class="profile-section-card mb-3">
                    <h3 class="profile-section-title">Profile Photo</h3>
                    <div class="profile-photo-row">
                        <div class="profile-photo-preview-wrap">
                            <img src="<?= base_url($member['profile_picture'] ?? 'images/logo_spa-removebg-preview.png') ?>" alt="<?= esc($member['full_name']) ?>" class="profile-photo-img">
                            <label for="profile_picture" class="profile-photo-edit"><i class="fa-solid fa-camera"></i></label>
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display:none">
                        </div>
                        <div>
                            <strong><?= esc($member['full_name']) ?></strong>
                            <p>JPG or PNG, max 5 MB</p>
                            <div class="profile-photo-actions">
                                <label for="profile_picture" class="spa-btn-outline">Upload new</label>
                                <button type="button" class="spa-btn-ghost">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-section-card mb-3">
                    <h3 class="profile-section-title">Personal Information</h3>
                    <div class="profile-form-grid">
                        <div class="spa-field">
                            <label>FULL NAME</label>
                            <input type="text" name="full_name" value="<?= esc($member['full_name']) ?>" required>
                        </div>
                        <div class="spa-field">
                            <label>EMAIL ADDRESS</label>
                            <input type="email" value="<?= esc($member['email']) ?>" disabled>
                        </div>
                        <div class="spa-field">
                            <label>PHONE NUMBER</label>
                            <input type="text" name="phone" value="<?= esc($member['phone'] ?? '') ?>">
                        </div>
                        <div class="spa-field">
                            <label>GENDER</label>
                            <select name="gender">
                                <option value="Male" <?= ($member['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= ($member['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                        <div class="spa-field">
                            <label>MEMBER TYPE</label>
                            <select name="member_type">
                                <option value="Individual" <?= ($member['member_type'] ?? '') === 'Individual' ? 'selected' : '' ?>>Individual</option>
                                <option value="Corporate" <?= ($member['member_type'] ?? '') === 'Corporate' ? 'selected' : '' ?>>Corporate</option>
                                <option value="Family" <?= ($member['member_type'] ?? '') === 'Family' ? 'selected' : '' ?>>Family</option>
                            </select>
                        </div>
                        <div class="spa-field">
                            <label>MEMBERSHIP PLAN</label>
                            <input type="text" value="<?= esc($member['membership'] ?? 'None') ?>" disabled>
                        </div>
                    </div>
                </div>

                <div class="profile-save-bar">
                    <span>Changes will be applied to your profile immediately.</span>
                    <div>
                        <a href="<?= base_url('member/dashboard') ?>" class="spa-btn-ghost">Discard</a>
                        <button type="submit" class="main-btn">Save Changes</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</section>
