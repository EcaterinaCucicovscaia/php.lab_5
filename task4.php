<?php
$name = $_POST["username"] ?? '';
$errors = [];
$score = 0;
$submitted = $_SERVER["REQUEST_METHOD"] === "POST";

// Проверка
if ($submitted) {
    // Проверка имени
    if (trim($name) === '') {
        $errors[] = "Please enter your name.";
    }

    // Проверка всех ответов
    if (!isset($_POST["q1"])) $errors[] = "Please answer Question 1.";
    if (!isset($_POST["q2"])) $errors[] = "Please answer Question 2.";
    if (!isset($_POST["q3"])) $errors[] = "Please answer Question 3.";

    // Подсчет результатов
    if (empty($errors)) {
        if ($_POST["q1"] === "php") $score++;
        if ($_POST["q2"] === "html") $score++;
        // Для вопроса с множественным выбором
        $correctQ3 = ["js", "css"];
        $userQ3 = $_POST["q3"] ?? [];
        sort($correctQ3);
        sort($userQ3);
        if ($correctQ3 === $userQ3) $score++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .error { color: red; }
        .question { margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>Knowledge Test</h1>
    <form method="POST">
        <div class="question">
            <label for="username"><strong>Your Name:</strong></label><br>
            <input type="text" name="username" value="<?= htmlspecialchars($name) ?>">
        </div>

        <div class="question">
            <p><strong>1. What does PHP stand for?</strong></p>
            <label><input type="radio" name="q1" value="php" <?= (($_POST["q1"] ?? '') === "php") ? 'checked' : '' ?>> PHP: Hypertext Preprocessor</label><br>
            <label><input type="radio" name="q1" value="private" <?= (($_POST["q1"] ?? '') === "private") ? 'checked' : '' ?>> Private Home Page</label>
        </div>

        <div class="question">
            <p><strong>2. Which markup language is used to build web pages?</strong></p>
            <label><input type="radio" name="q2" value="css" <?= (($_POST["q2"] ?? '') === "css") ? 'checked' : '' ?>> CSS</label><br>
            <label><input type="radio" name="q2" value="html" <?= (($_POST["q2"] ?? '') === "html") ? 'checked' : '' ?>> HTML</label>
        </div>

        <div class="question">
            <p><strong>3. Which of these are frontend technologies?</strong></p>
            <label><input type="checkbox" name="q3[]" value="js" <?= (in_array("js", $_POST["q3"] ?? [])) ? 'checked' : '' ?>> JavaScript</label><br>
            <label><input type="checkbox" name="q3[]" value="php" <?= (in_array("php", $_POST["q3"] ?? [])) ? 'checked' : '' ?>> PHP</label><br>
            <label><input type="checkbox" name="q3[]" value="css" <?= (in_array("css", $_POST["q3"] ?? [])) ? 'checked' : '' ?>> CSS</label>
        </div>

        <input type="submit" value="Submit">
    </form>

    <?php if ($submitted): ?>
        <div>
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <p><strong>Please fix the following:</strong></p>
                    <ul>
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <h2>Results for <?= htmlspecialchars($name) ?>:</h2>
                <p>You answered correctly <strong><?= $score ?></strong> out of 3 questions.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>
