<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Spring Systems Full Stack Challenge</title>
</head>
<body>

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
                        <tr>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
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
                    <input type="text" value="<?php _e($address) ?>" name="address" class="form-control" id="address"
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
</body>
</html>
