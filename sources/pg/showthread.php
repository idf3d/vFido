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
<link type="text/css" href="css/tree.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="js/tree.js"></script>
<?php
// ↑↑ также на http://habrahabr.ru/blogs/webdev/56278/ лежит CSS дерева, которое сворачивается да разворачивается
?>
<title></title>
</head>
<body>
<?php  $msg=areasGetLastMessagesFromThread($_GET['id'],1000); ?>
        <p><a href="<?php echo vFIDO_URL;?>?mode=list&area=<?php echo $msg[0]['area']; ?>">&lt;&lt; Назад, к списку конференций.</a></p>
    <div id="multi-derevo">
  <h4>Эхоконференция <?php echo $msg[0]['area'].', обсуждение на тему '.$msg[0]['subject']; ?></h4>
  <ul><!-- 1 уровень -->

      <!-- ----------- -->
                 <?php
                    foreach ($msg as $m)
                    {
                        if ($m['level']==0)
                        {
                        ?><!-- li1 -->
                            <li><span><a href="<?php echo vFIDO_URL;?>?mode=message&thread=<?php echo $_GET['id'];?>&id=<?php echo $m['id'];?>"><?php echo $m['subject'];?> (<?php echo $m['fromname'];?> -> <?php echo $m['toname'];?>)</a></span>
                        <?php printThreadMessageReplies($msg,$m['msgid']); ?></li><!-- li1 -->
                            <?php
                        }
                    }
                ?>
  </ul>
    </div><!-- /multi-derevo -->
    <iframe id="msgframe" width="100%" height="50%"></iframe>
  </body>
</html>

<?php
function printThreadMessageReplies($messages,$replyTomsgid)
{
        $haveUL=false;
        foreach ($messages as $m)
        {
            if ($m['reply']==$replyTomsgid)
            {
                if (!$haveUL)
                {
                    echo '<ul>';
                    $haveUL=true;
                }
                ?>
                <li><span><a href="<?php echo vFIDO_URL;?>?mode=message&thread=<?php echo $_GET['id'];?>&id=<?php echo $m['id'];?>"><?php echo $m['fromname'];?> -> <?php echo $m['toname'];?></a></span>
               <?php  printThreadMessageReplies($messages,$m['msgid']);?></li>
<?php
           }
        }
        if ($haveUL)
            echo '</ul>';
}
?>