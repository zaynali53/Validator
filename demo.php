<?php

require_once 'class.validator.php';

$v = new Validator;

$rules = [
    'email'         =>  'required|email:zayn.com',
    'password'      =>  'required|min_length:8|max_length:30',
    'environment'   =>  'required|white_list:admin,user,guest',
    'file'          =>  'f_required|f_types:jpg,bmp,png'
];

$v->validate($_POST, $rules);

$v->is_valid ?: $v->show_errors(['id' => 'errors', 'class' => 'errors'], TRUE);

echo "<pre>", print_r($_POST), "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Validator Demo</title>
    </head>
    <body>
        <form action="demo.php" method="POST" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="environment" value="admin"> <br>
            Email: <input type="email" name="email"> <br>
            Password: <input type="password" name="password"> <br>
            <input type="file" name="file"> <br>
            <input type="submit" value="submit">
        </form>
    </body>
</html>
