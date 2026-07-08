<?= view('admin/layouts/header') ?>
<?= view('admin/layouts/sidebar') ?>

<div class="content">

    <div class="topbar">

        <div>

            <h2>Filter Members</h2>

            <small class="text-muted">
                Filter members by name, subscription plan and payment status
            </small>

        </div>

        <div class="icon-group">

            <i class="fa-solid fa-gear"></i>

            <i class="fa-solid fa-bell"></i>

        </div>

    </div>

    <div class="table-box">
        <form method="get" action="<?= base_url('filter') ?>">

            <div class="row">

                <div class="col-md-4">

                    <label class="form-label">Member Name</label>

                    <input type="text" name="name" class="form-control" placeholder="Search member..."
                        value="<?= service('request')->getGet('name') ?>">

                </div>

                <div class="col-md-3">

                    <label class="form-label">Subscription Plan</label>

                    <select name="membership" class="form-select">

                        <option value="">All Plans</option>

                        <option value="Bronze" <?= service('request')->getGet('membership') == 'Bronze' ? 'selected' : '' ?>>
                            Bronze
                        </option>

                        <option value="Silver" <?= service('request')->getGet('membership') == 'Silver' ? 'selected' : '' ?>>
                            Silver
                        </option>

                        <option value="Gold" <?= service('request')->getGet('membership') == 'Gold' ? 'selected' : '' ?>>
                            Gold
                        </option>

                    </select>

                </div>

                <div class="col-md-3">

                    <label class="form-label">Payment Status</label>

                    <select name="payment_status" class="form-select">

                        <option value="">All Status</option>

                        <option value="Completed" <?= service('request')->getGet('payment_status') == 'Completed' ? 'selected' : '' ?>>
                            Completed
                        </option>

                        <option value="Pending" <?= service('request')->getGet('payment_status') == 'Pending' ? 'selected' : '' ?>>
                            Pending
                        </option>

                    </select>

                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">

                    <button type="submit" class="btn btn-pink">

                        <i class="fa-solid fa-filter"></i>

                        Apply

                    </button>

                    <a href="<?= base_url('filter') ?>" class="btn btn-secondary">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

    <div class="table-box mt-4">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Member Code</th>

                    <th>Full Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Subscription</th>

                    <th>Payment Status</th>

                </tr>

            </thead>

            <tbody>

                <?php if (!empty($members)): ?>

                    <?php foreach ($members as $member): ?>

                        <tr>

                            <td><?= $member['member_code'] ?></td>

                            <td><?= $member['full_name'] ?></td>

                            <td><?= $member['email'] ?></td>

                            <td><?= $member['phone'] ?></td>

                            <td><?= $member['membership'] ?></td>

                            <td>

                                <?php if ($member['payment_status'] == "Completed"): ?>

                                    <span class="badge-active">

                                        Completed

                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-warning text-dark">

                                        Pending

                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="6" class="text-center text-muted">

                            No member found.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

        <div class="mt-3">

            Showing

            <strong><?= count($members) ?></strong>

            member(s)

        </div>

    </div>

</div>

<?= view('admin/layouts/footer') ?>
