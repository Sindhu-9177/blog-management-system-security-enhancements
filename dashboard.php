<?php

session_start();

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

include 'db.php';

$search = "";

if(isset($_GET['search']))
{
    $search = $_GET['search'];
}

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$start = ($page - 1) * $limit;

$query = "
SELECT * FROM posts
WHERE title LIKE '%$search%'
OR content LIKE '%$search%'
ORDER BY id DESC
LIMIT $start, $limit
";

$result = mysqli_query($conn, $query);

$count_query = mysqli_query(
$conn,
"SELECT COUNT(*) AS total
FROM posts
WHERE title LIKE '%$search%'
OR content LIKE '%$search%'"
);

$count_row = mysqli_fetch_assoc($count_query);

$total_posts = $count_row['total'];

$total_pages = ceil($total_posts / $limit);

?>

<!DOCTYPE html>
<html>

<head>

    <title>📚 Blog Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">

    <div class="container-fluid">

        <h3 class="text-white mb-0">
            Blog Management System
        </h3>

        <div>

            <span class="text-white me-3">
                👋 Welcome Back, <?= $_SESSION['user']; ?>
            </span>

            <a
            href="logout.php"
            class="btn btn-danger">
                Logout
            </a>

        </div>

    </div>

</nav>

<div class="container mt-4">

    <!-- Hero Section -->

    <div class="card shadow border-0 mb-4">

        <div class="card-body text-center p-4">

            <h1 class="display-5">
                Blog Management Dashboard
            </h1>

            <p class="text-muted">
                Manage posts, search content and track blog activity.
            </p>

        </div>

    </div>

    <!-- Search Box -->

    <form method="GET" class="mb-4">

        <div class="input-group">

            <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search posts by title or content..."
            value="<?= $search; ?>">

            <button
            class="btn btn-primary"
            type="submit">
                Search
            </button>

        </div>

    </form>
    <p class="text-muted">
    Total Results: <?= $total_posts; ?>
</p>

    <!-- Statistics Card -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow border-0 bg-primary text-white">

                <div class="card-body">

                    <h5>Total Posts</h5>

                    <h2>
                        <?= $total_posts; ?>
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Add Post Button -->

    <a
    href="add_post.php"
    class="btn btn-success mb-3">

        ➕ Create New Blog Post

    </a>

    <!-- Posts Table -->
     <div class="table-responsive">

    <table class="table table-bordered table-hover shadow bg-white">

        <thead class="table-dark">

            <tr>

                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created Date</th>
                <th>Actions</th>


            </tr>

        </thead>

        <tbody>

        <?php while($row = mysqli_fetch_assoc($result)){ ?>

            <tr>

                <td><?= $row['id']; ?></td>

                <td><?= $row['title']; ?></td>

                <td>
<?= strlen($row['content']) > 50 ? substr($row['content'], 0, 50).'...' : $row['content']; ?>
</td>
<td>
<?= date('d M Y', strtotime($row['created_at'])); ?>
</td>

                <td>

                    <a
                    href="edit_post.php?id=<?= $row['id']; ?>"
                    class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <a
                    href="delete_post.php?id=<?= $row['id']; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this post?')">

                        Delete

                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>
    </div>

    <!-- Pagination -->

    <?php if($total_pages > 1){ ?>

    <nav>

        <ul class="pagination justify-content-center">

            <?php
            for($i = 1; $i <= $total_pages; $i++)
            {
            ?>

            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">

                <a
                class="page-link"
                href="?page=<?= $i; ?>&search=<?= $search; ?>">

                    <?= $i; ?>

                </a>

            </li>

            <?php } ?>

        </ul>

    </nav>

    <?php } ?>

</div>

<footer class="bg-dark text-white text-center p-3 mt-5">

    Blog Management System © 2026

</footer>

</body>
</html>