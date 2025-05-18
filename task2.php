<?php
// Инициализация переменных
$name = $age = $sector = $participation = "";
$agreement = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"] ?? ''));
    $age = (int) ($_POST["age"] ?? 0);
    $sector = htmlspecialchars($_POST["sector"] ?? '');
    $participation = htmlspecialchars($_POST["participation"] ?? '');
    $agreement = isset($_POST["agreement"]);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация на мероприятие в Кишинёве</title>
</head>
<body>
    <h2>Регистрация на мероприятие в Кишинёве</h2>

    <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <label>Имя участника:
            <input type="text" name="name" required>
        </label><br><br>

        <label>Возраст:
            <input type="number" name="age" min="0" required>
        </label><br><br>

        <label>Выберите сектор Кишинёва:
            <select name="sector" required>
                <option value="">-- выберите --</option>
                <option value="Центр">Центр</option>
                <option value="Ботаника">Ботаника</option>
                <option value="Рышкановка">Рышкановка</option>
                <option value="Буюканы">Буюканы</option>
                <option value="Чеканы">Чеканы</option>
            </select>
        </label><br><br>

        <p>Тип участия:</p>
        <label><input type="radio" name="participation" value="Очное" required> Очное</label>
        <label><input type="radio" name="participation" value="Онлайн"> Онлайн</label><br><br>

        <label><input type="checkbox" name="agreement" required> Я согласен с условиями участия</label><br><br>

        <input type="submit" value="Зарегистрироваться">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <h3>Данные участника:</h3>
        <p>Имя: <b><?= $name ?></b></p>
        <p>Возраст: <b><?= $age ?></b></p>
        <p>Сектор: <b><?= $sector ?></b></p>
        <p>Формат участия: <b><?= $participation ?></b></p>
        <p>Согласие с условиями: <b><?= $agreement ? 'Да' : 'Нет' ?></b></p>
    <?php endif; ?>
</body>
</html>
