<?
#Прочитаем директорию содержащую файлы описаний команд
#и выведем ее в виде таблицы
function ls()
{
}

#Распарсим переданный файлu с двоеточиями в качестве разделителя
#и получим нумерованный список со следующими элементами:
    #короткий аргумент
    #длинный аргумент
    #тип элемента управления
    #список несовместимых элементов управления
    #описание аргумента
function parse($file)
{
    echo '<h1>File parse start</h1>';

    $file='cmd/foo';
    #$text = file_get_contents ($file);
    #$text = readfile($file);
    $handle = fopen($file, r);
    #Начнем строить таблицу
        #Чтобы можно было получить доступ к ней из джаваскрипта, сделаем ей ID
    echo '<table id="cmdtbl">';
    #Добавим заголовочную строку
    echo "<tr><td>Short</td><td>Long</td>
              <td>Value</td><td>Description</td></tr>";
    #Сделаем итератор для нумерации полей
    $i = 0;
    #Выведм все строки из файла, разбивая их по полям
    while ($row = fgets($handle)) {
        list ($arg, $argl, $field, $desk) = explode(":",$row);
        
        #обрежем все пробелы слева и справа
        $arg=trim($arg);
        $argl=trim($argl);
        $field=trim($field);

        #выведем короткий аргумент
        echo "<tr><td>$arg</td>";
        #выведем длинный аргумент 
        echo "<td>$argl</td>";
        #выведем нужный элемент управления
            echo "<td>";
            #увеличим итератор
            $i++;
            #вставим поле нужного типа
            #имена полям будем назначать по принципу добавления порядкового
            #номера к букве e
            switch ($field) {
                case "cbox":
                    echo "<input type='checkbox' id=e$i
                           onclick='alertme($i)'/>";
                    break;
                case "field":
                    echo "<input type='field' id=e$i
                           onclick='alertme($i)'/>";
                    break;
            }
            echo "</td>";
        #выведем описание
        echo "<td>$desk</td></tr>";
    }
        echo '</table>';
    #Закроем хэндл файла с описаниями команд
    fclose($handle);
    
#Сделаем итоговое поле и кнопку "рассчитать"
echo <<<EOT
    <input type='field' name='result' /> 
    <input type='button' id='build' value='Build' onclick='edbg()' /> 

    <div id='dbg'></div>
EOT;
}

function mktbl($mk,$r1,$r2,$r3)
{
        echo '<tr><td>$r1</td><td>$r2</td><td>$r3</td></tr>';
}

#Выведеме страницу до body
    #Подключим нужные джаваскрипты
function head()
{
echo <<<EOT
<html>
    <head>  
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <style type='text/css'>
            table,th,td
            {
                border:1px solid black;
            }
        </style>
        <script type="text/javascript" src="cbt.js">
        </script>
    </head>
    <body onload="edbg()">
EOT;
}


#Выведем страницу после body
function foot()
{
    echo "
    </body>
</html>";
}
head();
parse(1);
foot();

?>
