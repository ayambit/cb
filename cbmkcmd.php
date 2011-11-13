<?
#Сделаем страницу для добавления команды в таблицу
    #вначале будем проверять, не доабавляем ли мы новую команду
    #затем буем выводить форму добавления
    #под формой будем выводить все введенные команды

#Действие, которое нужно совершить, закодировано в переменной do
    #Варианты: mk, rm, ed
function addcmd()
{
    
    #присвоим значение do локальным переменным для удобства
    $do=$_GET["do"];
    
    switch ($do) {

    #в случае добавления команды
    case "mk":
        #присвоим значения локальным переменным для удобства
        $cmd =$_GET["cmd"];
        $desc=$_GET["desc"];
        
        #если переменные не пусты, запишем их в бд
        if ($cmd != "" && $desc != "") {
            #соберем запрос на добавление команды
            $sql = "INSERT INTO `cb`.`cmd` (`id`, `name`, `desc`)
                VALUES (NULL, '$cmd', '$desc');";
            #исполним его
            sqlexec($sql); 
        }

        break;
        
    #в случае удаления команды
    case "rm":
        #присвоим значение локальной переменной для удобства
        $id=$_GET["id"];
        
        #и если идентификатор не пустой
        if ($id != "") {
            #соберем запрос на удаление команды
            $sql = "DELETE FROM `cb`.`cmd` WHERE `id`=$id";
            #исполним его
            sqlexec($sql); 
        }
        break;

    #в случае редактирования команды
    case "ed":
        #присвоим значение локальной переменной для удобства
        $id=$_GET["id"];

        #и если идентификатор не пустой
        if ($id != "") {
            #соберем запрос на редактирование команды
            $sql = "SELECT * FROM `cb`.`cmd` WHERE `id`=$id";
            #исполним его, записав результат
            $result = sqlexec($sql); 
        }
        #получим нужную нам строку
        $row = mysql_fetch_row($result);

        echo "<tr> 
                 <td>$row[0]</td>
                 <td>$row[1]</td>
                 <td>$row[2]</td>
             </tr>";

        break;
    }
}

#Сделаем форму, которая позволит править введенные команды
#
function edform() 
{
    echo "<h1>Исправьте команду или ее описание</h1>";
    $form='
    <FORM action="cbmkcmd.php" method="get">
        <input type="hidden" name="do" value="mk">
        <LABEL for="cmd">Название команды: </LABEL>
            <INPUT type="text" name="cmd"><br />
        <LABEL for="desc">Описание команды: </LABEL>
            <INPUT type="text" name="desc"><br />
        <INPUT type="submit" value="Послать">
    </FORM>';

    echo $form;
}

#Сделаем форму, которая позволит добавить в базу
#команду и ее описание
function mkform() 
{
    echo "<h1>Введите команду</h1>";
    $form='
    <FORM action="cbmkcmd.php" method="get">
        <input type="hidden" name="do" value="mk">
        <LABEL for="cmd">Название команды: </LABEL>
            <INPUT type="text" name="cmd"><br />
        <LABEL for="desc">Описание команды: </LABEL>
            <INPUT type="text" name="desc"><br />
        <INPUT type="submit" value="Послать">
    </FORM>';

    echo $form;
}

#Выведем список уже имеющихся команд
    #для каждой команды разрешим набор следующих дествий
        #редактирование, удаление
    #cписок будем выводить в табличной форме в следующем виде:
        #id, команда, описание команды, редактирование, удаление
function mkcmd() 
{
    #Попробуем выбрать все команды
    $result = sqlexec("select * from cmd;");

    #Напшем, что мы выводим список команд
    echo "<h1>Список имеющихся команд</h1>";

    #Выведем все команды таблицей
    #В каждой строке будем выводить
        #id, команду и описание
        #сформированную ссылку на изменение
        #сформированную ссылку на удаление
    echo "<table>";
    while ($row = mysql_fetch_row($result)) {
       echo "<tr> 
                 <td>$row[0]</td>
                 <td>$row[1]</td>
                 <td>$row[2]</td>
                 <td><a href='?do=ed&id=$row[0]'>edit</a></td>
                 <td><a href='?do=rm&id=$row[0]'>rm</a></td>
             </tr>";
    }
    echo "</table>";
    echo "<hr>";

    #Освободим память, занятую запросом (?)
    mysql_free_result($result);   
};

#Выполним sql-запрос
function sqlexec($sql)
{
    echo "<h1>Выполняю следующий запрос:</h1>";
    #Попробуем подключиться к серверу баз данных
    $con = mysql_connect("localhost","cb","e");
    if (!$con)
        die('Could not connect: ' . mysql_error());

    #Попробуем выбрать базу cb
    if (mysql_query("USE cb;",$con))
        echo "Database selected <br />";
    else
        echo "Error selecting database: " . mysql_error() . "<br />";
    
    echo $sql . "</br>";

    #Попробуем исполнить запрос
    if ($result = mysql_query($sql,$con))
        echo "Query OK </br>";
    else
        echo "Qery failed: " . mysql_error() . "<br />";
    
    #Закроем подключение
    mysql_close($con);

    echo "<hr>";

    #Вернем результат
    return($result);

    #Освободим память, занятую запросом (?)
    mysql_free_result($result);   
}

#Если нам передали команду, добавим ее в базу
if(!empty($_GET)) 
    addcmd();

mkform();
mkcmd();

?>
