<?php
$servername = "localhost"; // локалхост
$username = "Admin"; // имя пользователя
$password = ""; // пароль если существует

// Создание соединения
$conn = new mysqli($servername, $username, $password);
// Проверка соединения
if ($conn->connect_error) {
   die("Ошибка подключения: " . $conn->connect_error);
}

// Созданние базы данных
$sql = "CREATE DATABASE myBase";
$conn->query($sql);
// if ($conn->query($sql) === TRUE) {
//    echo "База данных создана успешно", "<br />";
// } else {
//    echo "Ошибка создания базы данных: " . $conn->error, "<br />";
// }


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

// Создание таблицы professions
$sql = "CREATE TABLE professions (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
professions VARCHAR(30) NOT NULL
)";
$conn->query($sql);
// if ($conn->query($sql) === TRUE) {
//    echo "Таблица professions создана успешно", "<br />";
// } else {
//    echo "Ошибка создания таблицы: " . $conn->error, "<br />";
// }

// Установка данных в таблицу professions
$sql = "INSERT INTO professions (professions)
VALUES ('Бухгалтер'), ('Курьер'), ('Менеджер')";
$conn->query($sql);
// if ($conn->query($sql) === TRUE) {
//    echo "Успешно создана новая запись", "<br />";
// } else {
//    echo "Ошибка: " . $sql . "<br>" . $conn->error, "<br />";
// }

// Создание таблицы workers
$sql = "CREATE TABLE workers (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Имя VARCHAR(30) NOT NULL,
    Фамилия VARCHAR(30) NOT NULL,
    Должность VARCHAR(30) NOT NULL,
    Зарплата INT(30) NOT NULL,
    Фото VARCHAR(30) NOT NULL
    )";
$conn->query($sql);
// if ($conn->query($sql) === TRUE) {
//    echo "Таблица workers создана успешно", "<br />";
// } else {
//    echo "Ошибка создания таблицы: " . $conn->error, "<br />";
// }


// Записываем сотрудника с рандомной профессией
function randWorkers ($conn, $name, $surname, $wages, $foto) {
    $rand = rand(0, 2);
    $sql = "SELECT professions FROM professions LIMIT $rand,1";
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
    // if ($conn->query($sql) === TRUE) {
    //     echo "Успешно создана новая запись", "<br />";
    // } else {
    //    echo "Ошибка: " . $sql . "<br>" . $conn->error, "<br />";
    // }
}
randWorkers ($conn, 'Сергей', 'Коновалов', rand (50000, 100000), 'images/0.jpg');
randWorkers ($conn, 'Владислав', 'Коновалов', rand (50000, 100000), 'images/1.jpg');
randWorkers ($conn, 'Маргарита', 'Багрец', rand (50000, 100000), 'images/2.jpg');
randWorkers ($conn, 'Малхази', 'Зантарая', rand (50000,100000), 'images/3.jpg');
randWorkers ($conn, 'Александр', 'Савицкий', rand (50000,100000), 'images/4.jpg');
randWorkers ($conn, 'Виолетта', 'Мальцева', rand (50000,100000), 'images/5.jpg');
randWorkers ($conn, 'Кармелита', 'Коновалова', rand (50000,100000), 'images/6.jpg');
randWorkers ($conn, 'Вероника', 'Багрец', rand (50000,100000), 'images/7.jpg');
randWorkers ($conn, 'Вячеслав', 'Багрец', rand (50000,100000), 'images/8.jpg');
randWorkers ($conn, 'Виталий', 'Чиканков', rand (50000,100000), 'images/9.jpg');
randWorkers ($conn, 'Валерий', 'Дорофеев', rand (50000,100000), 'images/10.jpg');
randWorkers ($conn, 'Виктор', 'Панфилов', rand (50000,100000), 'images/11.jpg');
randWorkers ($conn, 'Максим', 'Николаев', rand (50000,100000), 'images/12.jpg');
randWorkers ($conn, 'Артём', 'Лукъяненько', rand (50000,100000), 'images/13.jpg');
randWorkers ($conn, 'Владимир', 'Тихонов', rand (50000,100000), 'images/14.jpg');

// Создание таблицы payment
$sql = "CREATE TABLE payment (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Имя VARCHAR(30),
    Фамилия VARCHAR(30),
    Должность VARCHAR(30),
    Январь DOUBLE(10,2),
    Февраль DOUBLE(10,2),
    Март DOUBLE(10,2),
    Апрель DOUBLE(10,2),
    Май DOUBLE(10,2),
    Июнь DOUBLE(10,2),
    Июль DOUBLE(10,2),
    Август DOUBLE(10,2),
    Сентябрь DOUBLE(10,2),
    Октябрь DOUBLE(10,2),
    Ноябрь DOUBLE(10,2),
    Декабрь DOUBLE(10,2)
    )";
$conn->query($sql);
// if ($conn->query($sql) === TRUE) {
//    echo "Таблица payment создана успешно", "<br />";
// } else {
//    echo "Ошибка создания таблицы: " . $conn->error, "<br />";
// }

// Узнаём общее количество сотрудников
$sql = "SELECT COUNT(*) FROM workers";
$ter = $conn->query($sql);
$row = $ter->fetch_row();
$total = $row[0];

for ($x = 0; $x < $total; $x++) {
    // Записываем Имя сотрудника
    $sql = "SELECT Имя FROM workers LIMIT $x,1";
    $name = $conn->query($sql);
    if ($name->num_rows > 0) {
       // Выводим Имя сотрудника
        $row = $name->fetch_assoc();
        $resName =  $row["Имя"];
    // } else {
    //    echo "0 результат";
    }
    
    // Записываем Фамилию сотрудника
    $sql = "SELECT Фамилия FROM workers LIMIT $x,1";
    $surname = $conn->query($sql);
    if ($surname->num_rows > 0) {
       // Выводим Фамилию сотрудника
        $row = $surname->fetch_assoc();
        $resSurname =  $row["Фамилия"];
    // } else {
    //    echo "0 результат";
    }
    
    // Записываем Должность сотрудника
    $sql = "SELECT Должность FROM workers LIMIT $x,1";
    $position = $conn->query($sql);
    if ($position->num_rows > 0) {
       // Выводим Должность сотрудника
        $row = $position->fetch_assoc();
        $resPosition =  $row["Должность"];
    // } else {
    //    echo "0 результат";
    }
    
    // Выводим Зарплату сотрудника
    $sql = "SELECT Зарплата FROM workers LIMIT $x,1";
    $wages = $conn->query($sql);
    $row = $wages->fetch_assoc();
    $wagesBonus =  $row["Зарплата"];
    
    
    
    
    // Установка данных в таблицу payment
    $sql = "INSERT INTO payment (`Имя`, `Фамилия`, `Должность`, `Январь`, `Февраль`, `Март`, `Апрель`, `Май`, `Июнь`, `Июль`, `Август`, `Сентябрь`, `Октябрь`, `Ноябрь`, `Декабрь`) 
    VALUES ('$resName', '$resSurname', '$resPosition', '$wagesBonus', '$wagesBonus', '$wagesBonus', '$wagesBonus', '$wagesBonus', '$wagesBonus', '$wagesBonus', '$wagesBonus', '$wagesBonus', '$wagesBonus', '$wagesBonus', '$wagesBonus')";
    $conn->query($sql);
    // if ($conn->query($sql) === TRUE) {
    //     echo "Успешно создана новая запись", "<br />";
    // } else {
    //    echo "Ошибка: " . $sql . "<br>" . $conn->error, "<br />";
    // }
}

// Переводим числовое значение месяца в название
$month = date('m');
if ($month == '01') {
    $month = 'Январь';
  } else if ($month == '02') {
    $month = 'Февраль';
  } else if ($month == '03') {
    $month = 'Март';
  } else if ($month == '04') {
    $month = 'Апрель';
  } else if ($month == '05') {
    $month = 'Май';
  } else if ($month == '06') {
    $month = 'Июнь';
  } else if ($month == '07') {
    $month = 'Июль';
  } else if ($month == '08') {
    $month = 'Август';
  } else if ($month == '09') {
    $month = 'Сентябрь';
  } else if ($month == '10') {
    $month = 'Октябрь';
  } else if ($month == '11') {
    $month = 'Ноябрь';
  } else if ($month == '12') {
    $month = 'Декабрь';
  }

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