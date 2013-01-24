<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Премодерация
 */
if (!defined('vFIDO_RUN')) {
    echo 'access violation at address FAFAFED';// sorry ;)
    exit();
}

$hash='';
$result='';
if (isset($_GET['approve']))
{
    $hash=$_GET['approve'];
    
    if (areasApproveMessage($hash,true))
            $result = 'Подтверждение: успешно.';
    else
            $result = 'Подтверждение: не удалось.';
    
} else if (isset($_GET['decline']))
{
    $hash=$_GET['decline'];

    if (areasApproveMessage($hash,false))
            $result = 'Удаление: успешно.';
    else
            $result = 'Удаление: не удалось.';

    
} else {
    $result='Неизвестная операция.';
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="css/main.css" rel="stylesheet" />
<title></title>
</head>
<body>
    <br /><br /><center><h2><?php echo $result; ?></h2></center>
</body>
</html>