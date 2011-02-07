<?php
/*    Имя проекта: vfido
 *    Тип файла: библиотека функций
 *    Назначение файла: Ведение статистики
 */

/*
 * Увеличивает счетчик прочитанных данным пользователем сообщений на 1
 */
function statIncUserReadedMessages()
{
    if (!auth())
        return false;

   mysql_query("UPDATE vfido_users SET statReadedMsgsCount=statReadedMsgsCount+1 WHERE uid=".$_SESSION['uid']);

   if (isset($_SESSION['stat_visitID']) && ($_SESSION['stat_visitID']>0)) // просто на случай глюка
        mysql_query("UPDATE stat_sessions SET msgs_readed_in_session=msgs_readed_in_session+1 WHERE id=".(int)$_SESSION['stat_visitID']);

   return true;
}

function statIncAreaReadedMessages($area)
{

   mysql_query("UPDATE areas SET statReadedMsgsCount=statReadedMsgsCount+1 WHERE area='".addslashes($area)."'");
   return true;
}


function statLogVisit()
{
    if (!auth())
        return false;

    $l=(isset($_SESSION['stat_loggedAt']))?$_SESSION['stat_loggedAt']:0;

    if ($l<mktime(0,0)) // если залогинились раньше чем 00:00 текущих суток...
    {
        mysql_query("INSERT INTO stat_sessions (uid) VALUES (".$_SESSION['uid'].")");
        $_SESSION['stat_visitID']=mysql_insert_id();
        $_SESSION['stat_loggedAt']=time();
    }
    return true;
}

function statGetStat() // возвращает массив с общей статистикой
{
    //SELECT * FROM `stat_sessions` WHERE DATE(datetime)=CURDATE();
    $sql_today_runs="SELECT SUM(msgs_readed_in_session) AS rds  FROM stat_sessions WHERE DATE(datetime)=CURDATE() AND msgs_readed_in_session>0";
    $sql_today_users="SELECT * FROM stat_sessions WHERE DATE( DATETIME ) = CURDATE( )  AND msgs_readed_in_session >0 GROUP BY uid";
    $sql_top10_users="SELECT * FROM `vfido_users` ORDER BY statReadedMsgsCount DESC LIMIT 0,10";
    $sql_read_total="SELECT SUM(statReadedMsgsCount) as rTotal FROM `vfido_users`";
    $sql_top10_echoes="SELECT * FROM  `areas` ORDER BY  `areas`.`statReadedMsgsCount` DESC LIMIT 0 , 10";


    $rr=mysql_query($sql_today_runs);
    $ru=mysql_query($sql_today_users);
    $Etop=mysql_query($sql_top10_echoes);
    $Utop=mysql_query($sql_top10_users);
    $RTotal=mysql_query($sql_read_total);

    $stat=array('rds'=>-1,'users'=>-1,'top10e'=>array(),'top10u'=>array(),'rTotal'=>-1); // если не получится получить статистику - заведомо неправильные числа

    if ($fr= mysql_fetch_assoc($rr))
        $stat=array_merge ($stat,$fr);

    if ($RTotalf= mysql_fetch_assoc($RTotal))
        $stat=array_merge ($stat,$RTotalf);

        $stat['users']=mysql_num_rows($ru);


    while ($t=  mysql_fetch_array($Etop))
        $stat['top10e'][]=$t;


    while ($t1=  mysql_fetch_assoc($Utop))
        $stat['top10u'][]=$t1;


    return $stat;// PROFIT111 ;)

}

function statGetMyStat() //возвращает массив с личной статистикой пользователя
{
    if (!auth())
        return false;

    $s="SELECT COUNT(id) AS runs , SUM(msgs_readed_in_session) AS rs FROM stat_sessions WHERE uid=".$_SESSION['uid'];
    $sr=mysql_query($s);

    return mysql_fetch_assoc($sr);

}

?>
