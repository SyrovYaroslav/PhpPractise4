<?php
session_start();

$aConfig = require_once 'config.php';
$db = mysqli_connect(
    $aConfig['host'],
    $aConfig['user'],
    $aConfig['pass'],
    $aConfig['name']
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $text = mysqli_real_escape_string($db, $_POST['text']);
    $date = date('Y-m-d H:i:s');

    $query = "INSERT INTO comments (email, name, text, date) VALUES (
        '$email',
        '$name',
        '$text',
        '$date'
    )";
    mysqli_query($db, $query);
}

$query = 'SELECT * FROM comments';
$dbResponse = mysqli_query($db, $query);
$comments = mysqli_fetch_all($dbResponse, MYSQLI_ASSOC);
mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="">

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">

    <?php require_once 'sectionNavbar.php' ?>
    <br>

    <div class="card card-primary">
        <div class="card-header bg-primary text-light">
            GuestBook form
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6">

                    <form action="guestbook.php" method="post">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="text">Comment:</label>
                            <textarea class="form-control" id="text" name="text" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <br>

    <div class="card card-primary">
        <div class="card-header bg-body-secondary text-dark">
            Сomments
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">

                    <?php foreach ($comments as $comment): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($comment['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($comment['text']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>