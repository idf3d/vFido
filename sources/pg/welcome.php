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
   switch ($pg) {
      case 'fido': 
         printAboutFido();
      break;
      case 'app':
         printAboutApp();
      break;
      default:
         printMainWelcome();
      break;
   }
   printNavigation();
?>
</body>
</html>
<?php

function printMainWelcome(){
?><h2 class="header">Добро пожаловать! (vFido v.0.2.91)</h2>
<div style="font: 13px;">
В настоящее время программа находится в тестовом режиме и подвергается беспрестанным улучшениям.
<p>
Все пожелания, предложения, а также сообщения об ошибках можно направлять её автору.
<p>
С помощью этого приложения ты сможешь читать и писать письма во всемирную Сеть Фидонет.
<p>
<b>При отправке сообщений, пожалуйста, помни, что они проходят проверку модератором;
сообщения, не несущие смысловой нагрузки (например, «Всем привет!», «Проверка!»), не будут
допущены в Фидонет.</b>
<p>
Рекомендуем установить это приложение к себе на страницу, чтобы не потерять его. Ссылка установки
располагается над окошком приложения.
</div>
<?php
}

function printNavigation(){
?><div style="font: 13px; ">
Для продолжения работы перейди к <a href="<?php echo vFIDO_URL;?>?mode=list">списку конференций</a>.
<p>
<b>Дополнительная информация:</b><br />
→ <a href="<?php echo vFIDO_URL;?>?pg=fido">Что такое Фидо?</a><br />
→ <a href="<?php echo vFIDO_URL;?>?pg=app">О программе vFido</a><br />
</div>
<?php
}

function printAboutFido(){
?><h2 class="header">FidoNet</h2>
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
?><h2 class="header">О программе vFido</h2>
Программа vFido является так называемым гейтом или WebBBS: она обеспечивает пользователям
сайта «ВКонтакте», принадлежащего к Сети Интернет, отправлять и получать почту в другой
сети (в Фидонете), не являясь её непосредственными зарегистрированными пользователями.
<p>
Подобно самому Фидонету, приложение vFido развивается на некоммерческой основе,
в свободное от основной работы время его авторов.
<p>
<b>В данное время над приложением работают:</b>
<p>
→ Yuriy Lukyanets (2:5086/83)<br />
→ Sergei Shutov (3:712/550)
<p>
Если вы хотите присоединиться к нам и работать над развитием и улучшением приложения, напишите об этом на e-mail df@dflab.net. Для участия в проекте требуется знание языка PHP, совместная разработка производится с использованием SVN.
<?php
}
?>