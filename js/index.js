// Запуск всплывающего календаря
$( function() {
    $( "#datepicker" ).datepicker();
});

var count = 0;
// Устанавливаем текущий месяц
var dataPickNow = function () {
    if(!$("#datepicker").val()) {
        var dataPicker = new Date();
        dataPicker = dataPicker.getMonth()+ 1;
        $("#datepicker").val(dataPicker);
    }
}

// Переводим числовое значение месяца в название
dataPickNow();
var monthNow = function (month) {
    if (month == 01) {
        month = 'Январь';
    } else if (month == 02) {
        month = 'Февраль';
    } else if (month == 03) {
        month = 'Март';
    } else if (month == 04) {
        month = 'Апрель';
    } else if (month == 05) {
        month = 'Май';
    } else if (month == 06) {
        month = 'Июнь';
    } else if (month == 07) {
        month = 'Июль';
    } else if (month == 08) {
        month = 'Август';
    } else if (month == 09) {
        month = 'Сентябрь';
    } else if (month == 10) {
        month = 'Октябрь';
    } else if (month == 11) {
        month = 'Ноябрь';
    } else if (month == 12) {
        month = 'Декабрь';
    }
    return month;
}

// Отображаем данные за определённый месяц
var monthFunc = function () {
    month = $("#datepicker").val().slice(0,2);
    month = monthNow(month);
    if (window.XMLHttpRequest) {
        // код для IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // код для IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("result").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","month.php?month="+month,true);
    xmlhttp.send();
}

$(document).ready(function() {
    // Загружаем запрос по созданию БД
    $("#result").load("../index.php");
    // Загрузка таблицы сотрудников с зарплатой за определённый месяц
    $("#btn").bind("click", function () {
      monthFunc();
    });
    // Добавление сотрудников
    $("#btnAdd").on("click", function () {
        var name = $('#name').val();
        var surname = $('#surname').val();
        var position = $('#position').val();
        var wages = $('#wages').val();
        var foto = $('#foto').val();
        $.ajax ({
            url: "newWorker.php",
            type: "POST",
            data: ({name: name, surname: surname, position: position, wages: wages, foto: foto}),
            dataType: "HTML",
            success: function () {
                dataPickNow();
                monthFunc();
            }
        });
    });
    // Добавление премии сотрудникам одной должности за определённый месяц
    $("#btnBonus").on("click", function () {
        dataPickNow();
        var bonus = $('#bonus').val();
        var month = $('#datepicker').val().slice(0,2);
        var positionBonus = $('#positionBonus').val();
        month = monthNow(month);
        $.ajax ({
            url: "bonus.php",
            type: "POST",
            data: ({bonus: bonus, positionBonus: positionBonus, month: month}),
            dataType: "HTML",
            success: function () {
                dataPickNow();
                monthFunc();
            }
        });
    });
    // Загрузка фото по id конкретному сотруднику
    var files; // переменная. будет содержать данные файлов
    // заполняем переменную данными, при изменении значения поля file 
    $('input[type=file]').on('change', function(){
        files = this.files;
    });
    $('.upload_files').on( 'click', function( event ){
        event.stopPropagation(); // остановка всех текущих JS событий
        event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега
        // ничего не делаем если files пустой
        if( typeof files == 'undefined' ) return;
    
        // создадим объект данных формы
        var data = new FormData();
        var id = $('#id').val();
        // заполняем объект данных файлами в подходящем для отправки формате
        $.each( files, function( key, value ){
            data.append( key, value );
            
        });
    
        // добавим переменную для идентификации запроса
        data.append( 'my_file_upload', 1);
        data.append( 'id', id);
        // AJAX запрос
        $.ajax({
            url         : 'submit.php',
            type        : 'POST',
            data        : data,
            cache       : false,
            
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData : false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType : false, 
            dataType    : 'json',
            // функция успешного ответа сервера
            success     : function( html, respond, status, jqXHR ){
                dataPickNow();
                monthFunc();
            }
        });
    });
    // Переключение Зарплаты Рубли/Доллары
    $.getJSON("https://www.cbr-xml-daily.ru/daily_json.js", function(data) {
        curs = data.Valute.USD.Value.toFixed(2);
    });
    var count = 0;
    $("#curs").on("click", function () {
        count++;
        if (count%2 == 0) {
            $("#curs").val('Зарплата за месяц в Рублях');
            
        } else {
            $("#curs").val('Зарплата за месяц в Долларах');
        }
        month = $('#datepicker').val().slice(0,2);
        month = monthNow(month);
        $.ajax ({
            url: "curs.php",
            type: "POST",
            data: ({month: month, curs: curs, count: count}),
            dataType: "HTML",
            success: function () {
                dataPickNow();
                monthFunc();
            }
        });
    });
});
        
