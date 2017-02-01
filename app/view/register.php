<!DOCTYPE html>
<html lang="ua">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/app/source/css/style.css">
</head>
<body>
<div class="register">
    <div class="row">
        <?php

            if($result['status']):

        ?>
                <a class="btn btn-success" href="/auth">Successful</a>
        <?php
        endif;
        if($_POST == array()){
            $result['status'] = true;
        }
        ?>
        <form method="post" action="/auth/register">
            <div class="form-group <?php  if(!$result['status'] && !$result['name']['status']){echo 'has-error';}?>" >
                <label for="Name">Your Name</label>
                <input type="text"  class="form-control" name="name" id="Name" placeholder="Name">
                <h6><?php  if(!$result['name']['status']){echo $result['name']['text'];}?></h6>
            </div>
            <div class="form-group <?php  if(!$result['status'] && !$result['password']['status']){echo 'has-error';}?>" >
                <label for="password">Your Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                <h6><?php  if(!$result['password']['status']){echo $result['password']['text'];}?></h6>
            </div>

            <button type="submit" class="btn btn-success">Register</button>
            <a class="btn btn-default" href="/auth">GoTo Login</a>
        </form>
    </div>
</div>

</body>
</html>