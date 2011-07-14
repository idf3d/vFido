<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Приветствие
 */
if (!defined('vFIDO_RUN')) {
    echo 'access violation at address FAFAFED';// sorry ;)
    exit();
}
$_SESSION['welcome_ok'] = 1;

$wl=isset($_GET['wl'])?$_GET['wl']:'n';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="css/main.css" rel="stylesheet" />
<title></title>
</head>
<body>
<?php

    $pg=isset($_GET['pg'])?$_GET['pg']:''; // получаем идентификатор страницы.

    htmlPageHeader($pg); // показываем красивую шапку
   
   switch ($pg) {
      case 'fido': 
         printAboutFido();
      break;
      case 'app':
         printAboutApp();
      break;
      case 'stat':
         printStat();
      break;
      default:
         printMainWelcome();
      break;
   }
?>
</body>
</html>
<?php

function printMainWelcome(){
?><center><h2>Добро пожаловать! (vFido v.0.3.0)</h2>
С помощью этого приложения ты сможешь читать и писать письма во всемирную Сеть Фидонет.
<p>
Рекомендуем установить это приложение к себе на страницу, чтобы не потерять его. <br />Ссылка установки
располагается над окошком приложения.
</center>
<?php
}

function printAboutFido(){
?><h2>FidoNet</h2>
Фидонет является любительской сетью, это хобби для любого её участника.
Фидошники тратят время и используют свои возможности для того, чтобы Сеть
работала на благо всех её пользователей. Сеть обеспечивает пользователям
удобное и эффективное средство для общения, для обмена информацией.
<p>
Все пользователи Фидонета общаются под собственными именами и имеют уникальные
адреса в Сети. Тематические конференции и личная переписка — основное наполнение Сети.
В отличие от Интернета, в Фидо не бывает рекламы, спама и многократно дублирующейся
бесполезной информации.
<?php
}

function printAboutApp(){
?><h2>О программе vFido</h2>
Программа vFido является так называемым гейтом или WebBBS: она обеспечивает пользователям
сайта «ВКонтакте», принадлежащего к Сети Интернет, отправлять и получать почту в другой
сети (в Фидонете), не являясь её непосредственными зарегистрированными пользователями.
<p>
Подобно самому Фидонету, приложение vFido развивается на некоммерческой основе,
в свободное от основной работы время его авторов.
<p>
<b>Над приложением работают:</b>
<p>
→ Yuriy Lukyanets (2:5086/83)<br />
→ Sergei Shutov (3:712/550) <br />
→ Mithgol the Webmaster (2:5063/88)
<p>
    <b>Выражается благодарность</b> Максу Лушникову за perl-скрипты для экспорта и импорта писем в БД MySQL и Дмитрию Игнатову (2:5028/66) за создание иконки "ФидоНет" и графического оформление приложения.
    <p>
Если вы хотите присоединиться к нам и работать над развитием и улучшением приложения, напишите об этом на e-mail df@dflab.net. Для участия в проекте требуется знание языка PHP, совместная разработка производится с использованием SVN.
<?php
}

function printStat(){
    $sGlob=statGetStat();
?>
    <div style="margin-left: 25px;">
    <h2 style="margin-left:50px;">Статистика приложения</h2>
    
    <table class="solidborder" style="margin-left:50px;">
        <tr><td class="solidborder">&nbsp;</td><td class="solidborder">Сегодня</td><td class="solidborder">Вчера</td></tr>
        <tr><td class="solidborder">Количество пользователей</td><td class="solidborder"><?php echo $sGlob['users']; ?></td><td class="solidborder"><?php echo $sGlob['users_yest']; ?></td></tr>
        <tr><td class="solidborder">Прочитано сообщений</td><td class="solidborder"><?php echo $sGlob['rds']; ?></td><td class="solidborder"><?php echo $sGlob['rds_yest']; ?></td></tr>
        <tr><td class="solidborder">Прочитано сообщений за все время</td><td class="solidborder" colspan="2"><?php echo $sGlob['rTotal']; ?></td></tr>
    </table>
    <br />
    
<p>    
<table>

    <tr><td align="center">Top10 пользователей</td><td align="center">Top10 конференций</td></tr>
    <tr><td>
<table class="solidborder">
    <tr>
        <th class="solidborder">&nbsp;</th>
        <th class="solidborder"> Имя </th>
        <th class="solidborder"> Сообщений <br/> прочитано </th>
    </tr>
    <?php $c=1; foreach ($sGlob['top10u'] as $u) {  ?>
    <tr><td class="solidborder"><?php echo $c++; ?></td><td class="solidborder"><?php echo $u['firstname']." ".$u['lastname'];  ?></td><td class="solidborder"><?php echo $u['statReadedMsgsCount']; ?></td></tr>
    <?php } ?>
</table>
    </td><td>
<table class="solidborder">
    <tr>
        <th class="solidborder">&nbsp;</th>
        <th class="solidborder"> Название </th>
        <th class="solidborder"> Сообщений <br /> прочитано </th>
    </tr>
        <?php $c=1; foreach ($sGlob['top10e'] as $e) {  ?>
    <tr><td class="solidborder"><?php echo $c++; ?></td><td class="solidborder"><?php echo $e['area'];  ?></td><td class="solidborder"><?php echo $e['statReadedMsgsCount']; ?></td></tr>
    <?php } ?>
</table>

</table>
</p></div>
<?php
}
?>