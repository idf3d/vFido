<?php
/*    Имя проекта: vfido
 *    Тип файла: исполняемый php-скрипт
 */  

session_start();
header("Content-type: text/html; charset=utf-8");

define('vFIDO_RUN',1);
include ('./cf.php'); //config file
include ('./lib/libxml.php');
include ('./lib/libDatabase.php');
include ('./lib/libAreas.php');
include ('./lib/libAreaFix.php');
include ('./lib/libftn.php');
include ('./lib/libauth.php');
include ('./lib/libstat.php');
include ('./lib/libhtml.php');

dbPrepare();

// main executable.
if (isset ($_GET['mode']) && (isset($_SESSION['welcome_ok'])||($_GET['mode']=='approval'))) // обязательно начинаем с welcome, исключения для премодерации
    $mode=$_GET['mode'];
else
    $mode='welcome';

if ((!auth()) && ($mode!='approval'))
{
    echo '<html><body><b>Невозможно идентифицировать пользователя.</b></body></html>';
    exit();
}

statLogVisit();

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
        case 'arealst':
            include ('./pg/areaListEditor.php');
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
        case 'approval':
            include ('./pg/approval.php');
        break;
        default :
            include ('./pg/welcome.php');
        break;
    }
?>
