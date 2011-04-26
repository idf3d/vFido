<?php
/*    Имя проекта: vfido
 *    Тип файла: исполняемый php-скрипт
 */  

session_start();
header("Content-type: text/html; charset=utf-8");
header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');

define('vFIDO_RUN',1);
include ('./cf.php'); //config file
include ('./lib/libxml.php');
include ('./lib/libDatabase.php');
include ('./lib/libAreas.php');
include ('./lib/libftn.php');
include ('./lib/libauth.php');
include ('./lib/libstat.php');
include ('./lib/libhtml.php');

dbPrepare();

if (!auth())
{
    echo '<html><body><b>Невозможно идентифицировать пользователя.</b></body></html>';
    exit();
}

statLogVisit();

// main executable.
if (isset ($_GET['mode'],$_SESSION['welcome_ok'])) // обязательно начинаем с welcome
    $mode=$_GET['mode'];
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
        case 'area':
            include ('./pg/showarea.php');
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
