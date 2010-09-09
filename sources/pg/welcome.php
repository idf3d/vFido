<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Приветствие
 */
if (!defined('vFIDO_RUN'))
{
    echo 'access violation at address FAFAFED';// sorry ;)
    exit();
}
$_SESSION['welcome_ok']=1;

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
		<h2 class="header">Добро пожаловать! (vFido v.0.2.0)</h2>
                <div style="font: 13px;">
                В данное время программа находится в тестовом режиме и постоянно улучшается.<br />
                Все пожелания, предложения, а также сообщения об ошибках можешь направлять её автору.<br /><br />
                 Для продолжения работы перейди к <a href="<?php echo vFIDO_URL;?>?mode=list">списку конференций</a>.
                 <br /><br />
                 С помощью этого приложения ты сможешь читать и писать письма во всемирную сеть FidoNet.
                 <br /><br />
                 <b>При отправке сообщений, пожалуйста, помни, что они проходят проверку модератором, и сообщения, не несущие смысловой
                 нагрузки (например "Всем привет!", "Проверка!"), в сеть не отправляются.</b>
                 <br /><br />
                 <b><font color="red">ВНИМАНИЕ:</font> обновлен интерфейс просмотра писем. Теперь используется красивое дерево на JQuery. Если возникнут ошибки - сообщайте автору приложения!</b>
                 <br /><br />
                 Рекомендуем установить это приложение к себе на страницу, чтобы его не потерять. (ссылка над окошком приложения)
                </div>
    </body>
</html>
