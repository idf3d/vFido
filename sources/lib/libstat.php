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

   return true;
}

function statIncAreaReadedMessages($area)
{

   mysql_query("UPDATE areas SET statReadedMsgsCount=statReadedMsgsCount+1 WHERE area='".addslashes($area)."'");
   return true;
}


?>
