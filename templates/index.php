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
                    <h1>List of companies</h1>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Employees</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($companies)) : ?>
                            <?php foreach ($companies as $company): ?>
                                <tr>
                                    <td><?php _e($company['name']) ?></td>
                                    <td><?php _e($company['address']) ?></td>
                                    <td>
                                        <a href="/employees/<?php _e($company['id']) ?>">Employees
                                            (<?php _e($company['e_count']) ?>)</a>
                                    </td>
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

                    <form method="post" action="/">
                        <div class="mb-3">
                            <label for="name" class="form-label">Company Name</label>
                            <input type="text" value="<?php _e($name) ?>" name="name" class="form-control" id="name"
                                   aria-describedby="nameHelp">
                            <div id="nameHelp" class="form-text">Enter the full name of the company.</div>
                            <?php if (hasKey($errors, 'name')) : ?>
                                <div class="error-feedback"><?php echo $errors['name'] ?></div>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Company Address</label>
                            <input type="text" value="<?php _e($address) ?>" name="address" class="form-control"
                                   id="address"
                                   aria-describedby="addressHelp">
                            <div id="addressHelp" class="form-text">Enter the full address of the company.</div>
                            <?php if (hasKey($errors, 'address')) : ?>
                                <div class="error-feedback"><?php echo $errors['address'] ?></div>
                            <?php endif ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Add new company</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
