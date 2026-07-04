<?= view('admin/layouts/header') ?>
<?= view('admin/layouts/sidebar') ?>

<div class="content">

    <div class="topbar">
        <div>
            <h3>Bookings Management</h3>
            <p class="text-muted small mb-0">View and manage all member session bookings</p>
        </div>
        <div class="icon-group">
            <i class="fa-solid fa-gear"></i>
            <i class="fa-solid fa-bell"></i>
        </div>
    </div>

    <?php if ($__flash_success = session()->getFlashdata('success')): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({ icon: 'success', title: 'Success', text: <?= json_encode($__flash_success) ?>, confirmButtonColor: '#b01246', timer: 3000, timerProgressBar: true });
    });
    </script>
    <?php endif; ?>
    <?php if ($__flash_error = session()->getFlashdata('error')): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({ icon: 'error', title: 'Error', text: <?= json_encode($__flash_error) ?>, confirmButtonColor: '#b01246' });
    });
    </script>
    <?php endif; ?>

    <!-- Stat cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card-box">
                <div class="small-text">Total Bookings</div>
                <div class="big-number"><?= $totalBookings ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-box" style="border-left:4px solid #ffc107">
                <div class="small-text">Pending</div>
                <div class="big-number text-warning"><?= $pending ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-box" style="border-left:4px solid #198754">
                <div class="small-text">Confirmed</div>
                <div class="big-number text-success"><?= $confirmed ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-box" style="border-left:4px solid #6c757d">
                <div class="small-text">Completed</div>
                <div class="big-number text-secondary"><?= $completed ?></div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="table-box mb-4">
        <form method="get" action="<?= base_url('admin/bookings') ?>" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold mb-1">Search Member / Service</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Name or service…" value="<?= esc($filters['search'] ?? '') ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All</option>
                    <?php foreach (['Pending','Confirmed','Completed','Cancelled'] as $s): ?>
                        <option value="<?= $s ?>" <?= ($filters['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold mb-1">Date From</label>
                <input type="date" name="date_from" class="form-control form-control-sm" value="<?= esc($filters['date_from'] ?? '') ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold mb-1">Date To</label>
                <input type="date" name="date_to" class="form-control form-control-sm" value="<?= esc($filters['date_to'] ?? '') ?>">
            </div>
            <div class="col-md-3 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-danger btn-sm px-4">
                    <i class="fa-solid fa-filter me-1"></i>Filter
                </button>
                <a href="<?= base_url('admin/bookings') ?>" class="btn btn-outline-secondary btn-sm px-3">Reset</a>
            </div>
        </form>
    </div>

    <!-- Bookings table -->
    <div class="table-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">All Bookings <span class="badge bg-secondary"><?= count($bookings) ?></span></h5>
        </div>

        <?php if (!empty($bookings)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Therapist</th>
                        <th>Status</th>
                        <th>Booked On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $b): ?>
                    <?php
                        $statusColors = [
                            'Pending'   => 'warning',
                            'Confirmed' => 'info',
                            'Completed' => 'success',
                            'Cancelled' => 'secondary',
                        ];
                        $color = $statusColors[$b['status']] ?? 'secondary';
                    ?>
                    <tr>
                        <td class="text-muted small">#<?= $b['booking_id'] ?></td>
                        <td>
                            <div class="fw-semibold"><?= esc($b['full_name'] ?? 'N/A') ?></div>
                            <div class="text-muted small"><?= esc($b['email'] ?? '') ?></div>
                            <?php if (!empty($b['membership'])): ?>
                                <span class="badge bg-pink-subtle text-danger" style="background:#fdeaf1;color:#b01246;font-size:10px"><?= esc($b['membership']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($b['service']) ?></td>
                        <td><?= date('d M Y', strtotime($b['booking_date'])) ?></td>
                        <td><?= date('g:i A', strtotime($b['booking_time'])) ?></td>
                        <td><?= esc($b['therapist'] ?? '—') ?></td>
                        <td><span class="badge bg-<?= $color ?>"><?= esc($b['status']) ?></span></td>
                        <td class="text-muted small"><?= date('d M Y', strtotime($b['created_at'])) ?></td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <!-- Quick status update -->
                                <form method="post" action="<?= base_url('admin/bookings/status/' . $b['booking_id']) ?>" class="d-inline">
                                    <select name="status" class="form-select form-select-sm d-inline-block" style="width:120px" onchange="this.form.submit()">
                                        <?php foreach (['Pending','Confirmed','Completed','Cancelled'] as $s): ?>
                                            <option value="<?= $s ?>" <?= $b['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                                <a href="<?= base_url('admin/bookings/delete/' . $b['booking_id']) ?>"
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Delete this booking?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="fa-regular fa-calendar-xmark fa-3x mb-3 d-block" style="color:#f4c5d4"></i>
                <p>No bookings found<?= !empty($filters['status']) ? ' for status "' . esc($filters['status']) . '"' : '' ?>.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<?= view('admin/layouts/footer') ?>
