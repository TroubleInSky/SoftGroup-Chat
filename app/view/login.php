<!DOCTYPE html>
<html lang="ua">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="app/source/css/style.css">
</head>
<body>
<div class="login">
    <div class="row">
        <form action="/auth" method="post">
            <div class="form-group">
                <label for="Name">Your Name</label>
                <input type="text" class="form-control"name='name' id="Name" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="password">Your Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>

            <button type="submit" class="btn btn-success">Login</button>
            <a class="btn btn-default" href="auth/register">Register</a>
        </form>
    </div>
</div>

</body>
</html>