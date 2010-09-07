<?php
/*    Имя проекта: vfido
 *    Тип файла: библиотека функций
 *    Назначение файла: Идентификация пользователя
 */


function authCheckGETparams() //проверка параметров, переданных vkontakte
{
    if (!isset($_GET['api_id'], $_GET['viewer_id'],$_GET['auth_key'],$_GET['api_result']))
        return false;

    $truesig=md5($_GET['api_id'] . '_' . $_GET['viewer_id'] . '_'.vk_AUTHKEY);
    return ($truesig==$_GET['auth_key']);
}

function authGetUserFromBD($uid) // загрузить пользователя из базы.
{
    $uid=(int)$uid;
    $q=mysql_query('SELECT * FROM vfido_users WHERE uid='.$uid);

    if ($ret=mysql_fetch_assoc($q))
        return $ret;
    else
        return array();
}

function auth() // авторизация
{
        if (isset($_SESSION['uid'],$_SESSION['uinf']) && $_SESSION['uid']!==false) // уже есть нормальная сессия.
            return true;
            // TODO: усилить проверку сессии, сделать таймауты

        if (!authCheckGETparams())
	  {
	    echo 'ERR:PRMS';
            return false; //провал :(
	  }

       $_SESSION['uid']=$_GET['viewer_id'];
       $_SESSION['getvars']=$_GET;

       $uinf=authGetUserFromBD($_SESSION['uid']);
       if ($uinf==array())
       {
           
           $xmlInf=xml2array(str_replace('\"','"',$_GET['api_result']));
           if ((!isset($xmlInf['response']['user']['first_name'],$xmlInf['response']['user']['uid'],$xmlInf['response']['user']['last_name']))
               || $xmlInf['response']['user']['uid']!=$_SESSION['uid']
           )
           {
                echo 'Непредвиденная ошибка. Попробуйте перезапустить приложение.';
                exit();
           }

            if (!authUserToDB($_SESSION['uid'],$xmlInf['response']['user']['first_name'],$xmlInf['response']['user']['last_name']))
            {
                echo 'Непредвиденная ошибка. Повторите попытку запуска приложения позже';
                exit();
            }
            $uinf=authGetUserFromBD($_SESSION['uid']);
            if ($uinf==array())
            {
                echo 'Непредвиденная ошибка. Повторите попытку запуска приложения позже';
                exit();
            }
       }

       $_SESSION['ftnName']=nameToFTN($uinf['firstname'].' '.$uinf['lastname']);
       $_SESSION['ftnAddress']='2:5083/86.400';//all have one adress... yet ;)
       $_SESSION['uinf']=$uinf;//здесь уже все загружено и проверено, можно допускать пользователя дальше
       return true;
}

function authUserToDB($uid,$FirstName,$LastName) // добавление пользователя в базу
{
    $uid=(int)$uid;
    
     if (authIsNameExists($FirstName,$LastName))
     {
               $FirstName=$FirstName.' '.$uid;//если уже есть тёзка - добавляем к имени UID
               // в будущем планируется по именам раздавать NETMAIL, по этому имена должны быть уникальными
               if (authIsNameExists($FirstName,$LastName))
		 {
		   echo 'ERR::NAMEXSTS';
                  return false;
		 }
     }
                    
     $fn=addslashes($FirstName);
     $ln=addslashes($LastName);
     mysql_query("INSERT INTO vfido_users (uid,firstname,lastname) VALUES(".$uid.",'".$fn."','".$ln."')");
     return true; 

}

function authIsNameExists($fname,$lname)
{
    $fname=addslashes($fname);
    $lname=addslashes($lname);
    $q=mysql_query("SELECT * FROM vfido_users WHERE firstname='".$fname."' AND lastname='".$lname."'");
    return (mysql_num_rows($q)>0);
}

?>
