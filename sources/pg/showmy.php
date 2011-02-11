<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Показ карбонки
 */
if (!defined('vFIDO_RUN')) {
    echo 'access violation at address FAFAFED';// sorry ;)
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
<?php  $msg=areasGetMyMessages(); ?>
        <p><a href="<?php echo vFIDO_URL;?>?mode=list">&lt;&lt; Назад, к списку конференций.</a></p>
    <div id="multi-derevo">
   <h4>Сообщения адресованные на имя <b><?php echo $_SESSION['ftnName']; ?></b></h4>
  <ul><!-- 1 уровень -->
    <?php if ($msg==array()) echo "<li><span>Сообщений нет</span></li>"; ?>
      <!-- ----------- -->
                 <?php
                    foreach ($msg as $m)
                    {

                        ?>
                            <li><span><a href="<?php echo vFIDO_URL;?>?mode=message&thread=<?php echo $_GET['id'];?>&id=<?php echo $m['id'];?>"> <?php echo $m['recieved'];?> <?php echo $m['subject'];?> (<?php echo $m['fromname'];?> в <?php echo $m['area'];?>)</a></span>
                        </li>
                            <?php
                        
                    }
                ?>
  </ul>
    </div><!-- /multi-derevo -->
    <iframe id="msgframe" width="100%" height="50%"></iframe>
  </body>
</html>