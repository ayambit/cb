<?
#Создание таблиц для хранения команд -- mktables
function mktables() {
#Для хранения данных будем использовать две таблицы. Первую
#для хранения команд с описанием, вторую для хранения
#аргументов с описаниями. 
#
#Таблицы назвовем cmd и arg соответственно. Функция 
#автоматически создает эти таблицы

#Таблица cmd
#-----------
#В этой таблице хранятся все команды с краткими описа-
#ниями. Схема представлена ниже.
# ______________________
#| ID        | int, key|
#| name      | str(64) |
#| desc      | str(255)|
# ----------------------

$sql="CREATE TABLE IF NOT EXISTS `cmd` (
`id`       int(11) NOT NULL AUTO_INCREMENT,
`name`     char(64) NOT NULL,
`desc`     char(255) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

#Создадим таблицу в базе
sqlexec($sql);

#Таблица arg
#-----------
#В этой таблице хранятся все аргументы с описаниями и
#для каждого аргумента хранится список несовместимых 
#аргументов.
# ______________________
#| id        | key     |   
#| idcmd     | key     |   
#| name      | str(64) |
#| nocompat  | str(64) |
#| desc      | str(255)|
# ----------------------
$sql="CREATE TABLE IF NOT EXISTS `arg` (
`id`       int(11)   NOT NULL AUTO_INCREMENT,
`idcmd`    int(11)   NOT NULL,
`name`     char(64)  NOT NULL,
`nocompat` char(64)  NOT NULL,
`desс`     char(255) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

#Создадим таблицу в базе
sqlexec($sql);

}

#Исполнение sql-запросов -- sqlexec
function sqlexec($sql)
{
    #Попробуем подключиться к серверу баз данных
    $con = mysql_connect("localhost","cb","e");
    if (!$con) 
        die('Could not connect: ' . mysql_error());

    #Попробуем выбрать базу cb
    if (mysql_query("USE cb;",$con))
        echo "Database selected <br />";
    else
        echo "Error selecting database: " . mysql_error() . "<br />";

    #Попробуем исполнить запрос
    if (mysql_query($sql,$con))
        echo "Query OK </br>";
    else
        echo "Qery failed: " . mysql_error() . "<br />";

    #Выведем список таблиц из нашей базы данных
    $result = mysql_query("show tables;",$con);
    while ($row = mysql_fetch_row($result)) {
            echo "Table: {$row[0]}<br />";
    }
    mysql_free_result($result);

    #Закроем подключение
    mysql_close($con);
}

#Вызовем функцию создания таблиц
mktables();

?>
