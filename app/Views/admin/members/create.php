<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Member</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            max-width: 700px;
            margin-top: 40px;
        }

        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        }

        .btn-pink {
            background: #d95d89;
            color: white;
        }

        .btn-pink:hover {
            background: #c94d79;
            color: white;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="card">

            <div class="card-body">

                <h3 class="mb-4">

                    Add New Member

                </h3>

                <form action="<?= base_url('members/store') ?>" method="post">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>Member Code</label>

                            <input type="text" name="member_code" class="form-control" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Full Name</label>

                            <input type="text" name="full_name" class="form-control" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Email</label>

                            <input type="email" name="email" class="form-control" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Phone</label>

                            <input type="text" name="phone" class="form-control" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Gender</label>

                            <select name="gender" class="form-select">

                                <option value="Male">Male</option>

                                <option value="Female">Female</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Membership</label>

                            <select name="membership" class="form-select">

                                <option>Bronze</option>

                                <option>Silver</option>

                                <option>Gold</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Status</label>

                            <select name="status" class="form-select">

                                <option>Active</option>

                                <option>Inactive</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Join Date</label>

                            <input type="date" name="join_date" class="form-control" required>

                        </div>

                    </div>

                    <div class="mt-3">

                        <button class="btn btn-pink">

                            Save Member

                        </button>

                        <a href="<?= base_url('members') ?>" class="btn btn-secondary">

                            Back

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
