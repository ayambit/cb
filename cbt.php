<?
#Прочитаем директорию содержащую файлы описаний команд
#и выведем ее в виде таблицы
function ls()
{
}

#Распарсим переданный файл и получим нумерованный список
#со следующими элементами:
    #короткий аргумент
    #длинный аргумент
    #тип элемента управления
    #список несовместимых элементов управления
    #описание аргумента
function parse($file)
{
}

#Просто прочитаем файл и выведем его н экран
function jr()
{
    echo '<h1>File start</h1>';

    $file='cmd/ls';
    #$text = file_get_contents ($file);
    #$text = readfile($file);
    $handle = fopen($file, r);
    while ($row = fscanf($handle, "%s\t%s\t%s\n")) {
        list ($arg, $field, $desk) = $row;
        echo '<table>';
        echo "<tr><td>$arg</td><td>$field</td><td>$desk</td></tr>";
        echo '</table>';
    }
    fclose($handle);
    echo $text;
    
}

function mktbl($mk,$r1,$r2,$r3)
{
        echo '<tr><td>$r1</td><td>$r2</td><td>$r3</td></tr>';
}
jr();

?>
