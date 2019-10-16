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

// Получаем значения месяца, текущего курса и счётчик переключения Р/$
$month = $_POST['month'];
$curs = $_POST['curs'];
$count = $_POST['count'];

if (($count%2) !== 0) {
    $sql = "UPDATE `payment` SET `Январь` = `Январь` / $curs, `Февраль` = `Февраль` / $curs, `Март` = `Март` / $curs, `Апрель` = `Апрель` / $curs,
    `Май` = `Май` / $curs, `Июнь` = `Июнь` / $curs, `Июль` = `Июль` / $curs, `Август` = `Август` / $curs, `Сентябрь` = `Сентябрь` / $curs,
    `Октябрь` = `Октябрь` / $curs, `Ноябрь` = `Ноябрь` / $curs, `Декабрь` = `Декабрь` / $curs";
} else {
    $sql = "UPDATE `payment` SET `Январь` = `Январь` * $curs, `Февраль` = `Февраль` * $curs, `Март` = `Март` * $curs, `Апрель` = `Апрель` * $curs,
    `Май` = `Май` * $curs, `Июнь` = `Июнь` * $curs, `Июль` = `Июль` * $curs, `Август` = `Август` * $curs, `Сентябрь` = `Сентябрь` * $curs,
    `Октябрь` = `Октябрь` * $curs, `Ноябрь` = `Ноябрь` * $curs, `Декабрь` = `Декабрь` * $curs";
}
$result = $conn->query($sql);

// Закрыть подключение
$conn->close();
?>