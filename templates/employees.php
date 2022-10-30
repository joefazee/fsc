<?php require_once 'header.php' ?>
<body>

<div class="container">
    <div class="col-md-12 pt-2">
        <a href="/" class="btn btn-lg btn-outline-primary">List of companies</a>
    </div>
</div>

<div class="container pt-5">
    <div class="row">
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">
                    <h1>Employees for <?php _e($companyInfo['name']); ?></h1>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($employees)) : ?>
                            <?php foreach ($employees as $employee): ?>
                                <tr>
                                    <td><?php _e($employee['name']) ?></td>
                                    <td><?php _e($employee['phone']) ?></td>
                                    <td><?php _e($employee['email']) ?></td>

                                </tr>

                            <?php endforeach; endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h1>Add a new company</h1>

                    <form method="post" action="/employees/<?php _e($companyInfo['id']); ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Employee Name</label>
                            <input type="text" value="<?php _e($name) ?>" name="name" class="form-control" id="name">
                            <?php if (hasKey($errors, 'name')) : ?>
                                <div class="error-feedback"><?php echo $errors['name'] ?></div>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Employee Phone Number</label>
                            <input type="text" value="<?php _e($phone) ?>" name="phone" class="form-control" id="phone">

                            <?php if (hasKey($errors, 'phone')) : ?>
                                <div class="error-feedback"><?php echo $errors['phone'] ?></div>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Employee Email</label>
                            <input type="email" value="<?php _e($email) ?>" name="email" class="form-control"
                                   id="email">
                            <?php if (hasKey($errors, 'email')) : ?>
                                <div class="error-feedback"><?php echo $errors['email'] ?></div>
                            <?php endif ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Add New Employee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
