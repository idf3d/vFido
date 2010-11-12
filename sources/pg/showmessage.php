<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Показ сообщения
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
        <title></title>
    </head>
    <body>
		<!-- <h2 class="header">Сообщение</h2> -->
                <?php
                    $m=areasGetMessage($_GET['id']);
?>
                <pre class="message"><b>От:</b> <?php echo $m['fromname'].'('.$m['fromaddr'].')'; ?> <a href="<?php echo vFIDO_URL;?>?mode=newmessage&replyto=<?php echo $m['id']; ?>">Ответить</a></pre>
                <pre class="message"><b>Кому:</b> <?php echo $m['toname']; ?></pre>
                <pre class="message"><b>Тема:</b> <?php echo $m['subject']; ?></pre>

        <?php
        //if (isset($_GET['thread']))
        //{
        //echo '<a href="'.vFIDO_URL.'?mode=thread&id='.$_GET['thread'].'">&lt;&lt; назад, к списку сообщений.</a>';
        //} elseif (isset($m['thread'])&&(trim($m['thread'])!=''))
        //{
        //    $q1=mysql_query('SELECT hash FROM threads where thread="'.addslashes($m['thread']).'"');
        //    if ($f1=mysql_fetch_assoc($q1))
        //        echo '<a href="'.vFIDO_URL.'?mode=thread&id='.$f1['hash'].'">&lt;&lt; назад, к списку сообщений.</a>';
        //}
        ?>
                <hr />
<?php

echo message2html(split("\n",$m['text']));

statIncUserReadedMessages();
statIncAreaReadedMessages($m['area']);
?><hr />
                <!-- <pre class="message"> Есть, что сказать? <a href="<?php echo vFIDO_URL;?>?mode=newmessage&replyto=<?php echo $m['id']; ?>">Напиши ответ!</a></pre> -->
                <!--<hr />
                 <div style="float:left;"> -->
                    <?php
                    
                //    $prevMsg=areasGetMessageByMSGid($m['reply']);
                //    if ($prevMsg!=array())
                 //   {
                        ?>
                       <!-- <a href="<?php echo vFIDO_URL;?>?mode=message&thread=<?php echo $_GET['thread'];?>&id=<?php echo $prevMsg['id'];?>">&lt;&lt;Предыдущее</a>-->
                    <?php
//                    }
                    ?>
  <!--              </div> -->
                <!--
                <div  style="float:right;">
                    <?php
                     $nextMsgs=areasGetNextMessagesInThread($m['msgid']);
                    if ($nextMsgs!=array())
                    {
                        foreach ($nextMsgs as $nextM)
                        {
                        ?>
                    <a href="<?php echo vFIDO_URL;?>?mode=message&thread=<?php echo $_GET['thread'];?>&id=<?php echo $nextM['id'];?>">Следующее (<?php echo $nextM['fromname']; ?>) &gt;&gt;</a><br />
                    <?php
                        }
                    }
                    ?>
                </div>-->
    </body>
</html>
