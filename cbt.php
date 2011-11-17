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

    $file='cmd/ls';
    #$text = file_get_contents ($file);
    #$text = readfile($file);
    $handle = fopen($file, r);
        echo '<table>';
    while ($row = fgets($handle)) {
        list ($arg, $argl, $field, $desk) = explode(":",$row);
        #выведем короткий аргумент
        echo "<tr><td>$arg</td>";
        #выведем длинный аргумент 
        echo "<td>$argl</td>";
        #выведем нужный элемент управления
        echo "<td>";
        switch (trim($field)) {
            case "cbox":
                echo "<input type='checkbox' name='cbox' 
                       value='cbox' />";
                break;
            case "field":
                echo "<input type='field' name='cbox' 
                       value='cbox' />";
                break;
        }
        echo "</td>";


        #выведем описание
        echo "<td>$desk</td></tr>";
    }
        echo '</table>';
    fclose($handle);
    echo $text;
    
}

function mktbl($mk,$r1,$r2,$r3)
{
        echo '<tr><td>$r1</td><td>$r2</td><td>$r3</td></tr>';
}

function head()
{
    echo "
    <html>
    <head>
        <style type='text/css'>
            table,th,td
            {
                border:1px solid black;
            }
        </style>
    </head>
    <body>";
}

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
