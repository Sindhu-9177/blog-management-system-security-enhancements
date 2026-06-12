<?php

include 'db.php';

if(isset($_POST['register']))
{
    $username=$_POST['username'];

    $password=password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );
     // Validation
    if(strlen($username) < 3)
    {
        die("Username too short.");
    }

    if(strlen($password) < 6)
    {
        die("Password must be at least 6 characters.");
    }


$stmt = mysqli_prepare(
$conn,
"INSERT INTO users(username,password)
VALUES(?,?)"
);

mysqli_stmt_bind_param(
$stmt,
"ss",
$username,
$password
);

mysqli_stmt_execute($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow-lg login-card">

<div class="card-body">

<h2 class="text-center mb-4">
Create Account
</h2>

<form method="POST">

<input
type="text"
name="username"
class="form-control mb-3"
placeholder="Username"
required>

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button
name="register"
class="btn btn-success w-100">

Register

</button>

</form>

<p class="text-center mt-3">

Already have an account?

<a href="login.php">
Login
</a>

</p>

</div>

</div>

</div>

</div>

</div>

</body>
</html>