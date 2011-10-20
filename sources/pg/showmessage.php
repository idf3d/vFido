<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Показ сообщения
 */
if (!defined('vFIDO_RUN')) {
    echo 'access violation at address FAFAFED';// sorry ;)
    exit();
}
if (!isset($_GET['id'])) {
    header('Location: '.vFIDO_URL);
    exit();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" href="css/main.css" rel="stylesheet" />
    </head>
    <body>

                <?php
                    $m=areasGetMessage($_GET['id']);

?>
                <pre class="message"><b>От:</b> <?php echo $m['fromname'].'('.$m['fromaddr'].')'; ?> (<a href="<?php echo vFIDO_URL;?>?mode=newmessage&replyto=<?php echo $m['id']; ?>">Ответить</a>)<?php if ($m['area']!="" &&$m['area']!="NETMAIL") { ?> (<a href="<?php echo vFIDO_URL;?>?mode=newmessage&private=yes&replyto=<?php echo $m['id']; ?>">Ответить лично</a>)<?php }?></pre>
                <pre class="message"><b>Кому:</b> <?php echo $m['toname']; ?></pre>
                <pre class="message"><b>Дата:</b> <?php echo $m['date']; ?></pre>
                <pre class="message"><b>Тема:</b> <?php echo $m['subject']; ?></pre>
                <hr />
<?php

echo message2html(split("\n",$m['text']));

statIncUserReadedMessages();
statIncAreaReadedMessages($m['area']);
?><hr />

    </body>
</html>
