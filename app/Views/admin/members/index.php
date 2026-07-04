<?= view('admin/layouts/header') ?>
<?= view('admin/layouts/sidebar') ?>

<div class="content">

    <div class="topbar">

        <div>

            <h2>Manage Members</h2>

            <small class="text-muted">
                Manage and update member information
            </small>

        </div>

        <div class="icon-group">

            <i class="fa-solid fa-gear"></i>

            <i class="fa-solid fa-bell"></i>

        </div>

    </div>

    <div class="table-box">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <input type="text" id="search" class="form-control search-box"
                placeholder="Search member name, email or phone">

            <a href="<?= base_url('members/create') ?>" class="btn btn-pink">

                <i class="fa-solid fa-plus"></i>

                Add New Member

            </a>

        </div>

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Member ID</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Membership</th>

                    <th>Status</th>

                    <th width="150">Action</th>

                </tr>

            </thead>

            <tbody id="memberTable">

                <?php foreach ($members as $member): ?>

                    <tr>

                        <td><?= $member['member_code'] ?></td>

                        <td><?= $member['full_name'] ?></td>

                        <td><?= $member['email'] ?></td>

                        <td><?= $member['phone'] ?></td>

                        <td><?= $member['membership'] ?></td>

                        <td>

                            <?php if ($member['status'] == "Active"): ?>

                                <span class="badge-active">

                                    Active

                                </span>

                            <?php else: ?>

                                <span class="badge-inactive">

                                    Inactive

                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <button type="button" class="btn btn-warning btn-sm" onclick="editMember(

            '<?= $member['member_id'] ?>',

            '<?= esc($member['member_code']) ?>',

            '<?= esc($member['full_name']) ?>',

            '<?= esc($member['email']) ?>',

            '<?= esc($member['phone']) ?>',

            '<?= esc($member['gender']) ?>',

            '<?= esc($member['membership']) ?>',

            '<?= esc($member['status']) ?>',

            '<?= esc($member['join_date']) ?>'

            )">

                                <i class="fa-solid fa-pen"></i>

                            </button>

                            <a href="<?= base_url('members/delete/' . $member['member_id']) ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this member?')">

                                <i class="fa-solid fa-trash"></i>

                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

        <div class="d-flex justify-content-between align-items-center mt-4">

            <div>

                Showing

                <strong><?= count($members) ?></strong>

                members

            </div>

            <nav>

                <ul class="pagination mb-0">

                    <li class="page-item disabled">

                        <span class="page-link">Previous</span>

                    </li>

                    <li class="page-item active">

                        <span class="page-link">1</span>

                    </li>

                    <li class="page-item disabled">

                        <span class="page-link">Next</span>

                    </li>

                </ul>

            </nav>

        </div>

    </div>

    <div class="table-box mt-4" id="editSection" style="display:none;">

        <h4 class="mb-4">

            Edit Member

        </h4>

        <form id="editForm" method="post">

            <input type="hidden" id="edit_member_id" name="member_id">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Member Code</label>

                    <input type="text" class="form-control" id="edit_member_code" name="member_code" required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Full Name</label>

                    <input type="text" class="form-control" id="edit_full_name" name="full_name" required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Email</label>

                    <input type="email" class="form-control" id="edit_email" name="email" required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Phone</label>

                    <input type="text" class="form-control" id="edit_phone" name="phone" required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Gender</label>

                    <select class="form-select" id="edit_gender" name="gender">

                        <option value="Male">Male</option>

                        <option value="Female">Female</option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Membership</label>

                    <select class="form-select" id="edit_membership" name="membership">

                        <option value="Bronze">Bronze</option>

                        <option value="Silver">Silver</option>

                        <option value="Gold">Gold</option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Status</label>

                    <select class="form-select" id="edit_status" name="status">

                        <option value="Active">Active</option>

                        <option value="Inactive">Inactive</option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Join Date</label>

                    <input type="date" class="form-control" id="edit_join_date" name="join_date">

                </div>

            </div>

            <div class="mt-3">

                <button type="submit" class="btn btn-pink">

                    Save Changes

                </button>

                <button type="button" class="btn btn-secondary" onclick="hideEdit()">

                    Cancel

                </button>

            </div>

        </form>

    </div>

    <script>

        document.getElementById("search").addEventListener("keyup", function () {

            let keyword = this.value;

            fetch("<?= base_url('members/search') ?>?keyword=" + encodeURIComponent(keyword))

                .then(response => response.json())

                .then(data => {

                    let html = "";

                    data.forEach(member => {

                        let badge = "";

                        if (member.status == "Active") {

                            badge = '<span class="badge-active">Active</span>';

                        } else {

                            badge = '<span class="badge-inactive">Inactive</span>';

                        }

                        html += `

            <tr>

                <td>${member.member_code}</td>

                <td>${member.full_name}</td>

                <td>${member.email}</td>

                <td>${member.phone}</td>

                <td>${member.membership}</td>

                <td>${badge}</td>

                <td>

                    <button

                        type="button"

                        class="btn btn-warning btn-sm"

                        onclick="editMember(

                        '${member.member_id}',

                        '${member.member_code}',

                        '${member.full_name}',

                        '${member.email}',

                        '${member.phone}',

                        '${member.gender}',

                        '${member.membership}',

                        '${member.status}',

                        '${member.join_date}'

                        )">

                        <i class="fa-solid fa-pen"></i>

                    </button>

                    <a

                        href="<?= base_url('members/delete') ?>/${member.member_id}"

                        class="btn btn-danger btn-sm"

                        onclick="return confirm('Delete this member?')">

                        <i class="fa-solid fa-trash"></i>

                    </a>

                </td>

            </tr>

            `;

                    });

                    document.getElementById("memberTable").innerHTML = html;

                });

        });

    </script>

    <script>

        function editMember(
            id,
            member_code,
            full_name,
            email,
            phone,
            gender,
            membership,
            status,
            join_date
        ) {

            document.getElementById("editSection").style.display = "block";

            document.getElementById("edit_member_id").value = id;

            document.getElementById("edit_member_code").value = member_code;

            document.getElementById("edit_full_name").value = full_name;

            document.getElementById("edit_email").value = email;

            document.getElementById("edit_phone").value = phone;

            document.getElementById("edit_gender").value = gender;

            document.getElementById("edit_membership").value = membership;

            document.getElementById("edit_status").value = status;

            document.getElementById("edit_join_date").value = join_date;

            document.getElementById("editForm").action = "<?= base_url('members/update') ?>/" + id;

            document.getElementById("editSection").scrollIntoView({

                behavior: "smooth"

            });

        }

        function hideEdit() {

            document.getElementById("editSection").style.display = "none";

            document.getElementById("editForm").reset();

        }

    </script>

    <?= view('admin/layouts/footer') ?>
