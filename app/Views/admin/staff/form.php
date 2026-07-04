<?= view('admin/layouts/header') ?>
<?= view('admin/layouts/sidebar') ?>

<div class="content">

    <div class="topbar">
        <div>
            <h3><?= $staff ? 'Edit Staff Member' : 'Add New Staff' ?></h3>
            <p class="text-muted small mb-0"><?= $staff ? 'Update staff information' : 'Add a new staff member to the team' ?></p>
        </div>
        <div class="icon-group">
            <i class="fa-solid fa-gear"></i>
            <i class="fa-solid fa-bell"></i>
        </div>
    </div>

    <?php if ($__flash_error = session()->getFlashdata('error')): ?>
    <script>document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'error', title: 'Validation Error', text: <?= json_encode($__flash_error) ?>, confirmButtonColor: '#b01246' }); }); </script>
    <?php endif; ?>

    <div class="table-box mx-3" style="max-width:600px">
        <form action="<?= $action ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="full_name" class="form-control"
                       value="<?= esc(old('full_name', $staff['full_name'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control"
                       value="<?= esc(old('email', $staff['email'] ?? '')) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Phone</label>
                <input type="text" name="phone" class="form-control"
                       value="<?= esc(old('phone', $staff['phone'] ?? '')) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Position <span class="text-danger">*</span></label>
                <select name="position" class="form-select" required>
                    <?php $positions = ['Therapist', 'Senior Therapist', 'Receptionist', 'Manager', 'Supervisor', 'Beautician']; ?>
                    <?php $selected = old('position', $staff['position'] ?? 'Therapist'); ?>
                    <?php foreach ($positions as $pos): ?>
                        <option value="<?= $pos ?>" <?= $selected === $pos ? 'selected' : '' ?>><?= $pos ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Join Date</label>
                <input type="date" name="join_date" class="form-control"
                       value="<?= esc(old('join_date', $staff['join_date'] ?? '')) ?>">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <?php $sel = old('status', $staff['status'] ?? 'Active'); ?>
                    <option value="Active" <?= $sel === 'Active' ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= $sel === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-pink">
                    <i class="fa-solid fa-floppy-disk"></i> <?= $staff ? 'Update' : 'Save' ?>
                </button>
                <a href="<?= base_url('admin/staff') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

</div>

<?= view('admin/layouts/footer') ?>
