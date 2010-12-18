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

    $diff=time()-((isset($_SESSION['stat_loggedAt']))?$_SESSION['stat_loggedAt']:0);
    if ($diff>86340)//23 часа 59 минут
    {
        mysql_query("INSERT INTO stat_sessions (uid) VALUES (".$_SESSION['uid'].")");
        $_SESSION['stat_visitID']=mysql_insert_id();
        $_SESSION['stat_loggedAt']=time();
    }
}

?>
