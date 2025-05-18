<?php
$name = $email = $review = $comment = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка имени
    if (empty($_POST["name"])) {
        $errors[] = "Имя обязательно для заполнения.";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
    }

    // Проверка email
    if (empty($_POST["email"])) {
        $errors[] = "Email обязателен для заполнения.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Введите корректный Email.";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
    }

    // Проверка оценки
    $review = $_POST["review"] ?? '';

    // Проверка комментария
    if (empty($_POST["comment"])) {
        $errors[] = "Комментарий обязателен.";
    } else {
        $comment = htmlspecialchars(trim($_POST["comment"]));
    }
}
?>

<div class="form">
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <fieldset>
            <legend>Оставьте отзыв!</legend>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <label>Имя:
                    <input type="text" name="name" value="<?= $name ?>">
                </label>
                <label>Email:
                    <input type="email" name="email" value="<?= $email ?>">
                </label>
            </div>
            <div>
                <p>Оцените наш сервис!</p>
                <label><input type="radio" name="review" value="10" <?= $review == '10' ? 'checked' : '' ?>> Хорошо</label>
                <label><input type="radio" name="review" value="8" <?= $review == '8' ? 'checked' : '' ?>> Удовлетворительно</label>
                <label><input type="radio" name="review" value="5" <?= $review == '5' ? 'checked' : '' ?>> Плохо</label>
            </div>
            <div>
                <p><label for="comment">Ваш комментарий:</label></p>
                <textarea id="comment" name="comment" cols="30" rows="5"><?= $comment ?></textarea>
            </div>
            <div style="margin-top: 10px;">
                <input type="submit" value="Отправить">
                <input type="reset" value="Удалить">
            </div>
        </fieldset>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <div id="result" style="margin-top: 20px;">
            <?php if (!empty($errors)): ?>
                <div style="color: red;">
                    <p><b>Ошибки при заполнении формы:</b></p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <div style="color: green;">
                    <p><b>Форма успешно отправлена!</b></p>
                    <p>Ваше имя: <b><?= $name ?></b></p>
                    <p>Ваш e-mail: <b><?= $email ?></b></p>
                    <p>Оценка товара: <b><?= $review ?></b></p>
                    <p>Ваше сообщение: <b><?= $comment ?></b></p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
