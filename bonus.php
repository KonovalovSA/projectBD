<?php
// Подключение к MySQL
$servername = "localhost"; // локалхост
$username = "Admin"; // имя пользователя
$password = ""; // пароль если существует
$dbname = "myBase"; // база данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);
// Проверка соединения
if ($conn->connect_error) {
   die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем значения месяца, должности и премии
$month = $_POST['month'];
$position = $_POST['positionBonus'];
$bonus = $_POST['bonus'];

// Полученное значение должности переводим в наименование
if ($position == 1) {
    $position = "Бухгалтер";
} else if ($position == 2) {
    $position = "Курьер";
} else if ($position == 3) {
    $position = "Менеджер";
}

// Узнаём общее количество сотрудников
$sql = "SELECT COUNT(*) FROM workers";
$positionTotal = $conn->query($sql);
$row = $positionTotal->fetch_row();
$total = $row[0];

// Изменяем зарплату за месяц с учётом премии
function changeWages ($conn, $total, $month, $resPosition, $bonus) {
    for ($x = 1; $x <= $total; $x++) {
        $sql = "SELECT $month FROM payment WHERE Должность='$resPosition' AND id = '$x'";
        if ($conn->query($sql)) {
            $sql = "SELECT $month FROM payment WHERE Должность='$resPosition' AND id = '$x'";
            $wages = $conn->query($sql);
            if ($wages->num_rows > 0) {
            // Выводим данные рандомной строки (профессии)
                $row = $wages->fetch_assoc();
                $resWages =  $row["$month"];
                $resWages = $bonus * $resWages + $resWages;
                $sql = "UPDATE payment SET $month='$resWages' WHERE Должность='$resPosition' AND id = '$x'";
                $conn->query($sql);
            }
        }
    }
}

changeWages ($conn, $total, $month, $position, $bonus);


// Закрыть подключение
$conn->close();
?>