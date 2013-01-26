<?php
/*    Имя проекта: vfido
 *    Тип файла: библиотека функций
 *    Назначение файла: Функции областей сообщений
 */

function areasGetList()
{
    $q=mysql_query("SELECT * FROM areas WHERE messages>0 ORDER BY area ASC");

    $ret=array();

    while ($f=mysql_fetch_assoc($q))
    {
        $ret[]=$f;
    }

    return $ret;
}

function areasGetLastThreads($areaname,$lim)
{
   
    if ($areaname=="" || $areaname=='NETMAIL')
        $q=mysql_query("SELECT threads.* FROM threads,messages WHERE threads.area = '' AND messages.thread=threads.thread
                                    AND (messages.fromaddr = '".$_SESSION['ftnAddress']."' OR messages.toaddr='".$_SESSION['ftnAddress']."')
                                    AND (messages.fromname='".$_SESSION['ftnName']."' OR messages.toname='".$_SESSION['ftnName']."')
                                    AND (messages.fromname!='AreaFix' AND messages.toname!='AreaFix')
                                    GROUP BY threads.thread
                                    ORDER BY lastupdate DESC LIMIT 0,".(int)$lim);   
    else
        $q=mysql_query("SELECT * FROM threads WHERE area = '".addslashes($areaname)."' ORDER BY lastupdate DESC LIMIT 0,".(int)$lim);

    $ret=array();

    while ($f=mysql_fetch_assoc($q))
    {
        $ret[]=$f;
    }

    return $ret;
}

function areasGetLastMessagesFromThread($hash, $lim=100,$showOnlyUnread=false)
{
    $hash=addslashes($hash);
    $lim=(int)$lim;
    $ret=array();

    $q=mysql_query ("SELECT * FROM threads Where hash = '".$hash."'");
    if ($t=mysql_fetch_assoc($q))
    {
        // к сожалению надо проверять и thread и area, как показала практика, threadId может быть одинаковым для нескольких арий и тогда
        // сообщения попадают не в ту эху, в которую надо
        $msgQ=mysql_query("SELECT * FROM messages WHERE thread='".$t['thread']."' AND area ='".$t['area']."' ORDER BY recieved DESC LIMIT 0,".$lim);

        while ($msg=mysql_fetch_assoc($msgQ))
        {
            $ret[]=$msg;
        }
    }
    return $ret;
}

function areasGetMyMessages()
{

    $ret=array();

        $msgQ=mysql_query("SELECT * FROM messages WHERE toname='".$_SESSION['ftnName']."' AND NOT area='' ORDER BY recieved DESC LIMIT 0,1000");
       
        while ($msg=mysql_fetch_assoc($msgQ))
        {
            $ret[]=$msg;
        }

        return $ret;
}

function __areasCheckMsgSecure($msg)
{
    if ($msg['area']!='')
        return $msg; // Not NETMAIL, ok.
    
    if ($msg['fromaddr']!=$_SESSION['ftnAddress'] && $msg['toaddr']!=$_SESSION['ftnAddress'])
        return array();
    
    if ($msg['fromname']!=$_SESSION['ftnName'] && $msg['toname']!=$_SESSION['ftnName'])
        return array();
    
    if ($msg['fromname']=='AreaFix' || $msg['toname']=='AreaFix')
        return array();
    
    return $msg;
}

function areasGetMessage ($id)
{
    $id=(int)$id;

    $q=mysql_query("SELECT * FROM messages WHERE id=".$id);
    if ($m=mysql_fetch_assoc($q))
        return __areasCheckMsgSecure($m);
    else
        return array();
}

function areasGetMessageByMSGid ($msgid)
{
    $msgid=addslashes($msgid);

    $q=mysql_query("SELECT * FROM messages WHERE msgid='".$msgid."'");
    
    if ($m=mysql_fetch_assoc($q))
        return __areasCheckMsgSecure($m);
    else
        return array();
}

function areasGetNextMessagesInThread ($msgid)
{
    $msgid=addslashes($msgid);
    $q=mysql_query("SELECT * FROM messages WHERE reply='".$msgid."'");
    $ret=array();
    while ($f=mysql_fetch_assoc($q))
    {
        $ret[]=__areasCheckMsgSecure($f);
    }
    return $ret;
}

function areasPutMSGtoOutbox($fromname,$toname,$subject,$text,$fromaddr,$area='',$toaddr='',$origin='',$reply='',$approve=0)
{
    $fromname=addslashes($fromname);
    $toname=addslashes($toname);
    
    if ((trim($toname)=='') || (trim($toname)=='')|| (trim($subject)=='')|| (trim($text)==''))
        return false;
    
    $subject=addslashes($subject);
    $text=addslashes($text);
    $fromaddr=addslashes($fromaddr);
    $area=addslashes($area);
    
    if ($area=='') $area='NETMAIL';

    $toaddr=addslashes($toaddr);

    if ($area=='NETMAIL' && trim($toaddr)=='')
        return false;

    $origin=addslashes($origin);

    if (trim($origin)=='')
        $origin='Dark station [reb0rn]';

    $reply=addslashes($reply);

    if ($approve!=1)
        $approve=0;

    $hash=md5($fromname.$toname.rand().$subject.$text.time());

    mysql_query("INSERT INTO outbox (fromname,toname,subject,text,fromaddr,toaddr,origin,area,reply,date,hash,sent,approve)
                            VALUES ('".$fromname."','".$toname."','".$subject."','".$text."','".$fromaddr."','".$toaddr."','".$origin."','".
                            $area."','".$reply."',NOW(),'".$hash."',0,".$approve.")");
                            
    if ($approve==0)
        areasSendApprovalEmail($area, $fromname.' '.$fromaddr, $toname.' '.$toaddr, $text, $hash);

     return true;
}

function areasApproveMessage($hash,$isApprove=false)
{
    $hash = addslashes($hash);
    
    if ($isApprove)
    {
        mysql_query("UPDATE outbox SET approve=1 WHERE hash='".$hash."'");
    } else {
        mysql_query("DELETE FROM outbox WHERE hash='".$hash."'");
    }
    
    $s = mysql_query("SELECT approve FROM outbox WHERE hash='".$hash."'");
    
    if (!$isApprove)
    {
        return (mysql_num_rows($s)==0);            
    } else {
        $f = mysql_fetch_assoc($s);
        
        if ($f===FALSE)
            return false;
        
        return ($f['approve']=='1');            
    }
        
}

function areasSendApprovalEmail($mArea,$mFrom,$mTo,$mText,$mHash)
{ 
    $baseurl = 'https://'.$_SERVER['SERVER_NAME'].vFIDO_URL.'?mode=approval';    
    
    $headers  = 'From: "vFido"<noreply@dflab.net>' . "\r\n";
    $headers .= 'Return-path: <df@dflab.net>' . "\r\n";
    $headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
    
    $text  = 'Please approve message: ' . "\r\n" . "\r\n";
    
    $text .= '===================================== '. "\r\n";
    $text .= 'Area: ' . $mArea . "\r\n";
    $text .= 'From: ' . $mFrom . "\r\n";
    $text .= 'To: '   . $mTo . "\r\n";
    $text .= '===================================== '. "\r\n";
    
    $text .= $mText . "\r\n";
    
    $text .= '===================================== '. "\r\n";
    
    $text .= $baseurl . '&approve='.$mHash. "\r\n";
    $text .= $baseurl . '&decline='.$mHash. "\r\n";
    
    return mail('df@dflab.net','vFido:new message in '.$mArea,$text,$headers);
}

function areasSendEmail($_Email, $_Subject, $text){

	if(!$_Email)return 0;

	return mail($_Email, $_Subject, $text, "From: \"vFido\"<noreply@dflab.net>\nReturn-path: <df@dflab.net>");
}

function areaIsExists($area)
{
   $q=mysql_query("SELECT * FROM areas WHERE area = '".addslashes($area)."'");
   
    return  (mysql_num_rows($q)>0);
}

?>
