<?php
$name = $email = $comment = "";
$agree = false;
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["mail"] ?? '');
    $comment = trim($_POST["comment"] ?? '');
    $agree = isset($_POST["agree"]);

    // Валидация "name"
    if (strlen($name) < 3 || strlen($name) > 20) {
        $errors[] = "Name must be between 3 and 20 characters.";
    }
    if (preg_match('/\d/', $name)) {
        $errors[] = "Name cannot contain digits.";
    }

    // Валидация "mail"
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Валидация "comment"
    if (empty($comment)) {
        $errors[] = "Comment cannot be empty.";
    }

    // Валидация галочки
    if (!$agree) {
        $errors[] = "You must agree with data processing.";
    }

    // Если нет ошибок
    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Write a comment</title>
    <style>
        body { font-family: monospace; }
        .form-container { max-width: 600px; margin: 30px auto; }
        label { display: block; margin: 10px 0 5px; }
        input, textarea { width: 100%; padding: 5px; }
        .error { color: red; }
        .success { color: green; }
        .checkbox-label { display: flex; align-items: center; gap: 5px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>#write-comment</h1>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success">
                <p><b>Thank you!</b> Your comment was submitted successfully.</p>
                <p>Name: <?= htmlspecialchars($name) ?></p>
                <p>Mail: <?= htmlspecialchars($email) ?></p>
                <p>Comment: <?= nl2br(htmlspecialchars($comment)) ?></p>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Name:
                <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
            </label>

            <label>Mail:
                <input type="email" name="mail" value="<?= htmlspecialchars($email) ?>">
            </label>

            <label>Comment:
                <textarea name="comment" rows="6"><?= htmlspecialchars($comment) ?></textarea>
            </label>

            <label class="checkbox-label">
                <input type="checkbox" name="agree" <?= $agree ? 'checked' : '' ?>>
                Do you agree with data processing?
            </label>

            <input type="submit" value="Send">
        </form>
    </div>
</body>
</html>
