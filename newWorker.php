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

// Получаем значения Имени, Фамилии, Должности, Зарплаты и Фото
$name = $_POST['name'];
$surname = $_POST['surname'];
$position = $_POST['position'];
$wages = $_POST['wages'];
$foto = $_POST['foto'];

// Добавляем в таблицы workers и payment новых сотрудников
function randWorkers ($conn, $name, $surname, $position, $wages, $foto) {
    // Рандомно выдаём должность новому сотруднику из таблицы professions
    $rand = $position;
    $sql = "SELECT professions FROM professions WHERE id = $rand";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
       // Выводим данные рандомной строки (профессии)
        $row = $result->fetch_assoc();
        $results =  $row["professions"];
    // } else {
    //    echo "0 результат";
    }
    // Установка данных в таблицу workers
    $sql = "INSERT INTO workers (`Имя`, `Фамилия`, `Должность`, `Зарплата`, `Фото`)
    VALUES ('$name', '$surname', '$results', '$wages', '$foto')";
    $conn->query($sql);
    // Установка данных в таблицу payment
    $sql = "INSERT INTO payment (`Имя`, `Фамилия`, `Должность`, `Январь`, `Февраль`, `Март`, `Апрель`, `Май`, `Июнь`, `Июль`, `Август`, `Сентябрь`, `Октябрь`, `Ноябрь`, `Декабрь`) 
    VALUES ('$name', '$surname', '$results', '$wages', '$wages', '$wages', '$wages', '$wages', '$wages', '$wages', '$wages', '$wages', '$wages', '$wages', '$wages')";
    $conn->query($sql);
    // if ($conn->query($sql) === TRUE) {
    //     echo "Успешно создана новая запись", "<br />";
    // } else {
    //    echo "Ошибка: " . $sql . "<br>" . $conn->error, "<br />";
    // }
}
randWorkers ($conn, $name, $surname, $position, $wages, $foto);
    


// Закрыть подключение
$conn->close();
?>
