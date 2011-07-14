<?php
/*    Имя проекта: vfido
 *    Тип файла: библиотека функций
 *    Назначение файла: Подписка/отписка на/от конференции и все функции связанные с этим
 */



// используется для получения списка эх для пользователей, которые не подписаны на эхи вобще,
// то есть для новых пользователей.
// Сейчас просто возвращает топ10 эх.
function aFixGetDefaultAreas()
{
    $ret=array();
    $sql_top10_echoes="SELECT * FROM  `areas` ORDER BY  `areas`.`statReadedMsgsCount` DESC LIMIT 0 , 10";
    $Etop=mysql_query($sql_top10_echoes);
    
    while ($t=  mysql_fetch_assoc($Etop))
        $ret[]=$t;
    
    return $ret;
}

function aFixSubscribeCurrUser($area)
{
    
    if (!areaIsExists($area))
        return;
    
    $q=mysql_query("SELECT * FROM vfido_areaSubscr WHERE uid=".(int)$_SESSION['uid']." AND area = '".addslashes($area)."'");
    if (mysql_num_rows($q)>0)
        return;
    
    mysql_query("INSERT INTO vfido_areaSubscr (uid,area) VALUES (".(int)$_SESSION['uid'].",'".addslashes($area)."')");
}

function aFixUnSubscribeAllAreasCurrUser()
{
    mysql_query("DELETE FROM vfido_areaSubscr WHERE uid=".(int)$_SESSION['uid']);
}

function aFixUnSubscribeCurrUser($area)
{
    mysql_query("DELETE FROM vfido_areaSubscr WHERE uid=".(int)$_SESSION['uid']." AND area = '".addslashes($area)."'");
}

function aFixGetCurrUserSubscribedEchoes()
{
    $q=mysql_query("SELECT a.* FROM areas AS a, vfido_areaSubscr AS asr WHERE a.messages>0
                                 AND a.area=asr.area AND asr.uid=".(int)$_SESSION['uid']." ORDER BY a.area ASC");

    $ret=array();
    
    while ($t= mysql_fetch_assoc($q))
        $ret[]=$t;
    
    return $ret;
}

function aFixGetCurrUserEchoList()
{
    $ret=aFixGetCurrUserSubscribedEchoes();
    
    if ($ret==array())
        return aFixGetDefaultAreas();
    else
        return $ret;
}

?>
