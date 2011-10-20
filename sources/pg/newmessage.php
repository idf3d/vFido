<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Создание сообщения
 */
if (!defined('vFIDO_RUN')) {
    echo 'access violation at address FAFAFED';// sorry ;)
    exit();
}
if (isset($_GET['replyto'])) {
    $msg=areasGetMessage($_GET['replyto']);

    if ($msg==array())
    {
        echo 'Сообщение не найдено.';
        exit();
    }

      $area=$msg['area'];
      
    if (($area=="") && ($msg['toname']!=$_SESSION['ftnName']) && ($msg['toaddr']!=$_SESSION['ftnAddress']))
    {
        echo 'Сообщение не найдено.';
        exit();
    }      
      if (isset($_GET['private'])) // ответить из эхи в нетмыл
          $area="";
      
      $msgto=$msg['fromname'];
      
      if ($area=="")
        $msgAddrTo=$msg['fromaddr'];
      else
          $msgAddrTo="";

      $initials="";
      foreach (mb_split(" ", $msgto) as $name) {
          $initials=$initials.mb_substr($name,0,1,'utf-8');
      }
      $msgsubj=$msg['subject'];
      $msgtext="Приветствую!\n".message2textarea(split("\n",$msg['text']),$initials)."\n\nС наилучшими пожеланиями,\n ".$_SESSION['uinf']['firstname'];
      $rpl=$msg['msgid'];
} else {
      $area=isset($_GET['area'])?$_GET['area']:'';
      if ($area!="" && $area!='NETMAIL')
            $msgto='All';
      else
          $msgto="";
      $msgAddrTo='';
      $msgsubj='';
      $msgtext="Приветствую!\n\n\n\nС наилучшими пожеланиями,\n ".$_SESSION['uinf']['firstname'];
      $rpl='';
}

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
                if (isset($_POST['snd']))
                {
                    $r=false;

                    $toaddr="";
                    if ($area=='NETMAIL' || $area=="")
                    {
                        $area="";
                        if (isset ($_POST['msgtoaddr']))
                            $toaddr=$_POST['msgtoaddr'];
                        else
                            $toaddr="";
                    }
                        
                        $r=areasPutMSGtoOutbox($_SESSION['ftnName'],$_POST['msgto'],$_POST['msgsubj'],$_POST['msgtxt'],$_SESSION['ftnAddress'],$area,$toaddr,'',$rpl);

                    if ($r)
                    {// sendmessage
                        ?>
                        <font color="green">Сообщение поставлено в очередь.</font><br />
                        После предварительной проверки модератором, оно будет отправлено в эхоконференцию.
                        <br /><br />
                        
                        <?php
                    }// end of sendmessage
                    else {//errormessage
                        ?>
                        <font color="red">Ошибка:</font> не удалось отправить сообщение.<br />Пожалуйста, убедитесь, что заполнены ВСЕ поля формы отправки сообщения.<br /><br />
                        <?php } //end of errormessage
                    
                } else
                {
                ?>
                <form method="POST">
                <table width="400px" border="0" style="font-size:13px;">
                <tr><td><b>Конференция:</b></td><td> <?php echo $area; ?> </td></tr>
                <tr><td><b>От:</b></td><td> <?php echo $_SESSION['ftnName']; ?> (<?php echo $_SESSION['ftnAddress']; ?>) </td></tr>
                <tr><td><b>Кому:</b></td><td> 
                        <?php if (($area=='' || $area=='NETMAIL') && $msgAddrTo!="") { ?>
                        <input type="hidden" name="msgto" value="<?php echo$msgto ?>"><?php echo$msgto ?>
                        <?php } else { ?>
                        <input type="text" name="msgto" value="<?php echo$msgto ?>">
                        <?php } ?> 
                    </td></tr>
                <?php
                if (($area=='' || $area=='NETMAIL') && $msgAddrTo=="")
                {
                ?>
                <tr><td><b>Кому (адрес):</b></td><td> <input type="text" name="msgtoaddr" value="<?php echo$msgAddrTo ?>"></td></tr>
                <?php } else if ($msgAddrTo!="") { ?>
                <tr><td><b>Кому (адрес):</b></td><td><?php echo$msgAddrTo ?> <input type="hidden" name="msgtoaddr" value="<?php echo$msgAddrTo ?>"></td></tr>
                <?php } ?>
                <tr><td><b>Тема:</b></td><td> <input type="text" name="msgsubj" value="<?php echo $msgsubj ?>"></td></tr>
                </table>
                <textarea cols="60" rows="10" name="msgtxt"><?php echo $msgtext ?></textarea>
                </div>
                <center>
                <input type="submit" value="Отправить">
                <?php
                if ($rpl==""){?>
                <input type="button" value="Отменить" onclick="document.location.href='<?php echo vFIDO_URL;?>?mode=list';">
                <?php } ?>
                <input type="hidden" name="snd" value="1"></center>
                </form><?php } ?>
                        
                        <div class="solidborder" style="font-size: 13px;text-align: left;margin: 10px;"><b><center>Уважаемый пользователь!</center></b>
                Просим не отправлять пустых сообщений, а так же сообщений не содержащих смысловой нагрузки.<br />
                Просим соблюдать правила приличия и не использовать ненормативную лексику.<br /><br />
                <div style="text-align: right;">С уважением, <br />Администрация приложения.</div>
                        
    </body>
</html>

