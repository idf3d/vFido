<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Показ цепочки сообщений
 */
if (!defined('vFIDO_RUN'))
{
    echo 'access violation at address FAFAFED';// sorry ;)
    exit();
}
if (!isset($_GET['id']))
{
    header('Location: '.vFIDO_URL);
    exit();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
        <link type="text/css" href="css/main.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
        <title></title>
    </head>
    <body>
        <a href="<?php echo vFIDO_URL;?>?mode=list">Назад, к списку конференций.</a>
		<h2 class="header">Список сообщений</h2>
                <?php

                    $msg=areasGetLastMessagesFromThread($_GET['id']);
                    foreach ($msg as $m)
                    {
                        if ($m['level']==0)
                        {
                        ?>
                            <a href="<?php echo vFIDO_URL;?>?mode=message&thread=<?php echo $_GET['id'];?>&id=<?php echo $m['id'];?>"><?php echo $m['subject'];?></a><br />
                        <?php
                            showThreadGetMessageReplies($msg,$m['msgid']);
                        }
                    }
                ?>
    </body>
</html>
<?php
// recursively build messages tree (NEEDS OPTIMIZATION!!!)
    function showThreadGetMessageReplies($messages,$replyTomsgid)
    {
        foreach ($messages as $m)
        {
            if ($m['reply']==$replyTomsgid)
            {
                ?>
                <a style="padding-left:<?php echo (10*$m['level']) ?>px;" href="<?php echo vFIDO_URL;?>?mode=message&thread=<?php echo $_GET['id'];?>&id=<?php echo $m['id'];?>"><?php echo $m['subject'];?></a><br />
               <?php
               showThreadGetMessageReplies($messages,$m['msgid']);
           }
        }
    }
?>