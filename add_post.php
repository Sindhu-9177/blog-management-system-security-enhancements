```php
<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

include 'db.php';

if(isset($_POST['save']))
{
    $title = $_POST['title'];
    $content = $_POST['content'];

    mysqli_query(
        $conn,
        "INSERT INTO posts(title,content)
         VALUES('$title','$content')"
    );

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add New Post</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/style.css">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <h3 class="text-white">Blog Management System</h3>

        <a href="dashboard.php" class="btn btn-primary">
            Back to Dashboard
        </a>
    </div>
</nav>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow-lg">

<div class="card-body">

<h2 class="mb-4 text-center">
Create New Blog Post
</h2>

<form method="POST">

<div class="mb-3">
<label class="form-label">
Post Title
</label>

<input
type="text"
name="title"
class="form-control"
placeholder="Enter post title"
required>
</div>

<div class="mb-3">
<label class="form-label">
Post Content
</label>

<textarea
name="content"
class="form-control"
rows="8"
placeholder="Write your content here..."
required></textarea>
</div>

<button
type="submit"
name="save"
class="btn btn-success">

Publish Post

</button>

<a
href="dashboard.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
```
