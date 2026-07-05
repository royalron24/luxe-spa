<?= view('admin/layouts/header') ?>
<?= view('admin/layouts/sidebar') ?>

<div class="content">

    <div class="topbar">
        <div>
            <h3>Staff Management</h3>
            <p class="text-muted small mb-0">View and manage all spa staff members</p>
        </div>
        <div class="icon-group">
            <i class="fa-solid fa-gear"></i>
            <i class="fa-solid fa-bell"></i>
        </div>
    </div>

    <?php if ($__flash_success = session()->getFlashdata('success')): ?>
    <script>document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'success', title: 'Success', text: <?= json_encode($__flash_success) ?>, confirmButtonColor: '#b01246', timer: 3000, timerProgressBar: true }); }); </script>
    <?php endif; ?>
    <?php if ($__flash_error = session()->getFlashdata('error')): ?>
    <script>document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'error', title: 'Error', text: <?= json_encode($__flash_error) ?>, confirmButtonColor: '#b01246' }); }); </script>
    <?php endif; ?>

    <!-- Stat cards -->
    <!-- Stat cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card-box">
                <div class="small-text">Total Staff</div>
                <div class="big-number"><?= $total ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-box" style="border-left:4px solid #198754">
                <div class="small-text">Active</div>
                <div class="big-number text-success"><?= $active ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-box" style="border-left:4px solid #dc3545">
                <div class="small-text">Inactive</div>
                <div class="big-number text-danger"><?= $total - $active ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-box" style="border-left:4px solid #6f42c1">
                <div class="small-text">Positions</div>
                <div class="big-number" style="color:#6f42c1">
                    <?= count(array_unique(array_column($staff, 'position'))) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Search bar + Add button -->
    <div class="table-box mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <form method="get" action="<?= base_url('admin/staff') ?>" class="d-flex gap-2 align-items-center flex-grow-1" style="max-width:480px">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search name, email or position"
                       value="<?= esc($keyword ?? '') ?>">
                <button type="submit" class="btn btn-pink btn-sm px-3">
                    <i class="fa-solid fa-search me-1"></i>Search
                </button>
                <?php if ($keyword): ?>
                    <a href="<?= base_url('admin/staff') ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
                <?php endif; ?>
            </form>
            <a href="<?= base_url('admin/staff/create') ?>" class="btn btn-pink btn-sm px-3">
                <i class="fa-solid fa-plus me-1"></i>Add Staff
            </a>
        </div>
    </div>

    <!-- Staff table -->
    <div class="table-box">
        <div class="d-flex align-items-center mb-3 gap-2">
            <h5 class="mb-0 fw-bold">Staff List</h5>
            <span class="badge bg-secondary"><?= $total ?></span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Position</th>
                        <th>Join Date</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($staff)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-5">
                            <i class="fa-solid fa-user-slash fa-2x mb-2 d-block" style="color:#f4c5d4"></i>
                            No staff found.
                        </td></tr>
                    <?php else: ?>
                        <?php foreach ($staff as $s): ?>
                        <tr>
                            <td class="text-muted small"><?= $s['staff_id'] ?></td>
                            <td>
                                <div class="fw-semibold"><?= esc($s['full_name']) ?></div>
                                <div class="text-muted small"><?= esc($s['email']) ?></div>
                            </td>
                            <td class="text-muted small"><?= esc($s['phone'] ?? '—') ?></td>
                            <td>
                                <span class="badge rounded-pill bg-light text-dark border" style="font-size:12px;padding:5px 10px">
                                    <?= esc($s['position']) ?>
                                </span>
                            </td>
                            <td class="text-muted small"><?= $s['join_date'] ? date('d M Y', strtotime($s['join_date'])) : '—' ?></td>
                            <td>
                                <?php if ($s['status'] === 'Active'): ?>
                                    <span class="badge-active">Active</span>
                                <?php else: ?>
                                    <span class="badge-inactive">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="<?= base_url('admin/staff/edit/' . $s['staff_id']) ?>"
                                       class="btn btn-sm btn-outline-primary px-3">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger px-3"
                                        onclick="confirmDelete(<?= $s['staff_id'] ?>, '<?= esc($s['full_name']) ?>')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Delete confirmation form (hidden) -->
<form id="deleteForm" method="post" action="">
    <?= csrf_field() ?>
</form>

<?= view('admin/layouts/footer') ?>

<script>
function confirmDelete(id, name) {
    Swal.fire({
        icon: 'warning',
        title: 'Remove Staff?',
        text: 'Are you sure you want to remove ' + name + '?',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, remove',
    }).then(function(result) {
        if (result.isConfirmed) {
            document.getElementById('deleteForm').action = '<?= base_url('admin/staff/delete/') ?>' + id;
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
