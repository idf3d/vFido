<?php
/*    Имя проекта: vfido
 *    Тип файла: библиотека функций
 *    Назначение файла: функции базы данных
 */


function dbPrepare()
{
    @mysql_connect(vFIDO_MYSQ_HOST, vFIDO_MYSQL_USER, vFIDO_MYSQL_PWD) or htmlErrorPage('невозможно подключиться к базе данных',true);
    @mysql_select_db(vFIDO_MYSQL_DBNAME) or htmlErrorPage('невозможно выбрать базу данных',true);
    
    $cs='utf8';

    mysql_query("SET character_set_client = '".$cs."'");
    mysql_query("SET character_set_results = '".$cs."'");
    mysql_query("SET character_set_connection = '".$cs."'");
    mysql_query("SET CHARACTER SET ".$cs);
    mysql_query("charset ".$cs);
    mysql_query("set character_set='".$cs."'");

}



?>
