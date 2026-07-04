<?= view('admin/layouts/header') ?>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h3 class="mb-4">

                Edit Member

            </h3>

            <form action="<?= base_url('members/update/' . $member['member_id']) ?>" method="post">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Member Code</label>

                        <input type="text" name="member_code" class="form-control"
                            value="<?= $member['member_code'] ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Full Name</label>

                        <input type="text" name="full_name" class="form-control" value="<?= $member['full_name'] ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Email</label>

                        <input type="email" name="email" class="form-control" value="<?= $member['email'] ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Phone</label>

                        <input type="text" name="phone" class="form-control" value="<?= $member['phone'] ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Gender</label>

                        <select name="gender" class="form-select">

                            <option value="Male" <?= ($member['gender'] == 'Male') ? 'selected' : '' ?>>

                                Male

                            </option>

                            <option value="Female" <?= ($member['gender'] == 'Female') ? 'selected' : '' ?>>

                                Female

                            </option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Membership</label>

                        <select name="membership" class="form-select">

                            <option value="Bronze" <?= ($member['membership'] == 'Bronze') ? 'selected' : '' ?>>

                                Bronze

                            </option>

                            <option value="Silver" <?= ($member['membership'] == 'Silver') ? 'selected' : '' ?>>

                                Silver

                            </option>

                            <option value="Gold" <?= ($member['membership'] == 'Gold') ? 'selected' : '' ?>>

                                Gold

                            </option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Status</label>

                        <select name="status" class="form-select">

                            <option value="Active" <?= ($member['status'] == 'Active') ? 'selected' : '' ?>>

                                Active

                            </option>

                            <option value="Inactive" <?= ($member['status'] == 'Inactive') ? 'selected' : '' ?>>

                                Inactive

                            </option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Join Date</label>

                        <input type="date" name="join_date" class="form-control" value="<?= $member['join_date'] ?>">

                    </div>

                </div>

                <div class="mt-4">

                    <button type="submit" class="btn btn-primary">

                        Update Member

                    </button>

                    <a href="<?= base_url('members') ?>" class="btn btn-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<?= view('admin/layouts/footer') ?>
