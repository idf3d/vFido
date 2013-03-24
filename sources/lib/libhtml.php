<?php
/*    Имя проекта: vfido
 *    Тип файла: библиотека функций
 *    Назначение файла: Функции вывода общих элементов html
 */

function htmlPageHeader($pg='0')
{
    
echo '<div class=head>';

if ($pg=='list')
    echo '<img src="img/messages_1.png" border=0 />';
else
    echo '<a href="'.vFIDO_URL.'?mode=list"><img src="img/messages_0.png" border=0 /></a>';

if ($pg=='fido')
    echo '<img src="img/fido_about_1.png" border=0 />';
else
    echo '<a href="'.vFIDO_URL.'?pg=fido"><img src="img/fido_about_0.png" border=0 /></a>';

if ($pg=='app')
    echo '<img src="img/vfido_about_1.png" border=0 />';
else
    echo '<a href="'.vFIDO_URL.'?pg=app"><img src="img/vfido_about_0.png" border=0 /></a>';

if ($pg=='stat')
    echo '<img src="img/statistic_1.png" border=0 />';
else
    echo '<a href="'.vFIDO_URL.'?pg=stat"><img src="img/statistic_0.png" border=0 /></a>';

echo '</div>';

}

function htmlErrorPage($message, $isDie=false)
{?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>The page is temporarily unavailable</title>
<style>
body { font-family: Tahoma, Verdana, Arial, sans-serif; }
</style>
</head>
<body bgcolor="white" text="black">
<table width="100%" height="100%">
<tr>
<td align="center" valign="middle">
Произошла ошибка: <?php echo $message; ?><br />Пожалуйста, зайдите позже.
</td>
</tr>
</table>
</body>
</html>
<?php

    if ($isDie) exit;
    
}

?>