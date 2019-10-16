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

if( isset( $_POST['my_file_upload'] ) ){  
	// ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

	$uploaddir = './images/'; // . - текущая папка где находится submit.php

	// cоздадим папку если её нет
	if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

	$files      = $_FILES; // полученные файлы
	$done_files = array();

	// переместим файлы из временной директории в указанную
	foreach( $files as $file ){
		$file_name = $file['name'];
		$target_file = $uploaddir . $file_name;
		if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
			$done_files[] = realpath( "$uploaddir/$file_name" );
			// переименовываем загруженый файл
			for ($x = 0; $x < 10000; $x++){
				if (!file_exists($uploaddir . $x . '.jpg')) {
					// Переименовываем загруженный только что файл
					rename($target_file, $uploaddir . $x . '.jpg');
					// Получаем значение id сотрудника которому нужно добавить фото 
					$id = $_POST['id'];
					// Добавляем фото конкретному сотруднику
					$sql = "UPDATE workers SET Фото = 'images/$x.jpg' WHERE id = $id";
					$conn->query($sql);


					$conn->close();
					
				}   
			}
	
		}
	}

	$data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');
	die( json_encode( $data ) );
}
?>