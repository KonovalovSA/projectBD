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

// Получаем значения месяца
$month = $_GET['month'];

// Выбираем из таблиц нужные столбцы
$sql = "SELECT workers.id, workers.Имя, workers.Фамилия, workers.Должность, payment.$month, workers.Фото FROM workers, payment WHERE workers.id = payment.id";
$result = $conn->query($sql);

// Выводим на страничку данные из таблиц
while($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
    $name = $row['Имя'];
    $surname = $row['Фамилия'];
    $position = $row['Должность'];
    $wages = $row[$month];
    $foto = $row['Фото'];

    echo "<tr>";
    echo "<td>" . $id . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $surname . "</td>";
    echo "<td>" . $position . "</td>";
    echo "<td>" . $wages . "</td>";
    echo "<td>" . "<a href='$foto' >" . "<img src='$foto'/>" . "</a>" . "</td>";
    echo "</tr>";
}


// Закрыть подключение
$conn->close();
?>