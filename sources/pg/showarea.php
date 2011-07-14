<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Показ цепочки сообщений
 */
if (!defined('vFIDO_RUN')) {
    echo 'access violation at address FAFAFED';// sorry ;)
    exit();
}
if (!isset($_GET['name'])) {
    header('Location: ' . vFIDO_URL);
    exit();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="css/ui-lightness/jqui.css" rel="stylesheet" />
<link type="text/css" href="css/tree.css" rel="stylesheet" />
<script type="text/javascript" src="js/jq.js"></script>
<script type="text/javascript" src="js/jqui.js"></script>
<script type="text/javascript" src="js/tree.js"></script>
<?php
// ↑↑ также на http://habrahabr.ru/blogs/webdev/56278/ лежит CSS дерева, которое сворачивается да разворачивается
?>
<title></title>
</head>
<body>
<?php
$threads=areasGetLastThreads($_GET['name'],20);
$msg=array();
?>
        <p><a style="float:left;" href="<?php echo vFIDO_URL;?>?mode=list">&lt;&lt; Назад, к списку конференций</a>
            <?php if ($_GET['name']!='NETMAIL')  { ?>
        <a  style="float:right;" href="<?php echo vFIDO_URL;?>?mode=newmessage&area=<?php echo $_GET['name'] ?>">[!] Написать сообщение</a>
        <?php } ?>
        <br />
        </p>
    <div id="multi-derevo">
  <h4>
      <?php if ($_GET['name']=='NETMAIL' || $_GET['name']=='')
          echo "Личные сообщения (NETMAIL)";
      else
          echo "Эхоконференция ".$_GET['name'];
       ?>
  </h4>
  <ul><!-- 1 уровень -->
<?php
            foreach ($threads as $th)
            {

                $msg=areasGetLastMessagesFromThread($th['hash']);

                    foreach ($msg as $m)
                    {
                        if ($m['level']==0)
                        {
                        ?><!-- li1 -->
                            <li><span><a href="<?php echo vFIDO_URL;?>?mode=message&id=<?php echo $m['id'];?>"><?php echo $m['subject'];?> (<?php echo $m['fromname'];?> -> <?php echo $m['toname'];?>)</a></span>
                        <?php printThreadMessageReplies($msg,$m['msgid']); ?></li><!-- li1 -->
                            <?php
                        }
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
                <li><span>
                        <a href="<?php echo vFIDO_URL;?>?mode=message&thread=<?php echo $_GET['id'];?>&id=<?php echo $m['id'];?>"><?php echo $m['fromname'];?> -> <?php echo $m['toname'];?></a>
                    </span>
               <?php  printThreadMessageReplies($messages,$m['msgid']);?></li>
<?php
           }
        }
        if ($haveUL)
            echo '</ul>';
}
?>