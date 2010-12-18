<?php
/*    Имя проекта: vfido
 *    Тип файла: исполняемый php-скрипт
 */
session_start();

header("Content-type: text/html; charset=utf-8");
//libraries and preparations
define('vFIDO_RUN',1);
include ('./cf.php'); //config file
include ('./lib/libxml.php');
include ('./lib/libDatabase.php');
include ('./lib/libAreas.php');
include ('./lib/libftn.php');
include ('./lib/libauth.php');
include ('./lib/libstat.php');
dbPrepare();

if (!auth())
{
    echo '<html><body><b>Невозможно идентифицировать пользователя.</b></body></html>';
    exit();
}

statLogVisit();

// main executable.
if (isset ($_GET['mode']))
{
    $mode=$_GET['mode'];
    if (!isset($_SESSION['welcome_ok'])) // Пользователь обязательно должен посмотреть страничку Welcome
    {
        echo 'ERROR: FAE11';
        exit();
    }
}
else
    $mode='welcome';

    switch ($mode)
    {
        case 'list':
            include ('./pg/arealist.php');
        break;
        case 'thread':
            include ('./pg/showthread.php');
        break;
        case 'message':
            include ('./pg/showmessage.php');
        break;
        case 'newmessage':
            include ('./pg/newmessage.php');
        break;
        case 'showmy':
            include ('./pg/showmy.php');
        break;
        default :
            include ('./pg/welcome.php');
        break;
    }
?>