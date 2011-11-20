function alertme(e)                                            
{                                                              
        alert(document.getElementById("e1").checked);
}

function edbg()
{
    //очистим поле dbg
    document.getElementById("dbg").innerHTML = '';
    //прогоним в цикле элементы с 1 по 10
    //и выведем их состояние в dbg
    for(i=1;i<=document.getElementById('cmdtbl').rows.length;i++) {
        //соберем ID элемента управления
        eid = "e"+i;

        var el = document.getElementById(eid);

        //попробуем коротки прочитать аргумент из таблицы
            //если его там нет, будем считать вместо него пустая строка
        try {
            arg = document.getElementById('cmdtbl')
                          .rows[i].cells[0].childNodes[0].data;
        }
        catch(err) {
            arg = "";
        }
            
        //попробуем прочитать длинный аргумент из таблицы
            //если его там нет, будем считать вместо него пустая строка
        try {
            argl = document.getElementById('cmdtbl')
                          .rows[i].cells[1].childNodes[0].data;
        }
        catch(err) {
            argl = "";
        }

        //проверим, есть ли короткий аргумент
        //если есть, используе его, если нет, то длинный
        if (arg != "") {
            arguse = arg;
        } else if (argl != "") {
            arguse = argl;
        } else {
            arguse = "ERROR!";
        }
        
        dbg(arguse + "\t" + arguse.length);

    }
}

//window.onload=edbg()

//запишем принятые строки в div dbg
function dbg(s)
{
    document.getElementById("dbg").innerHTML +=(s + "<br />");
}

//построим итоговую команду
    //в итоговом поле выведем итоговую команду и все отмеченные ключи и поля
    //проверять на несовместимость ключей не пока не будет
    //если есть короткий аргумент, используем его, если нету --длинный
function build()
{
}
