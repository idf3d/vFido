<?php
/*    Имя проекта: vfido
 *    Тип файла: библиотека функций
 *    Назначение файла: Функции областей сообщений
 */

function areasGetList()
{
    $q=mysql_query("SELECT * FROM areas WHERE messages>0 ORDER BY recieved DESC");

    $ret=array();

    while ($f=mysql_fetch_assoc($q))
    {
        $ret[]=$f;
    }

    return $ret;
}

function areasGetLastThreads($areaname,$lim)
{
    $q=mysql_query("SELECT * FROM threads WHERE area = '".addslashes($areaname)."' ORDER BY lastupdate DESC LIMIT 0,".(int)$lim);

    $ret=array();

    while ($f=mysql_fetch_assoc($q))
    {
        $ret[]=$f;
    }

    return $ret;
}

function areasGetLastMessagesFromThread($hash, $lim=100)
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

function areasGetMessage ($id)
{
    $id=(int)$id;

    $q=mysql_query("SELECT * FROM messages WHERE id=".$id);
    if ($m=mysql_fetch_assoc($q))
        return $m;
    else
        return array();
}

function areasGetMessageByMSGid ($msgid)
{
    $msgid=addslashes($msgid);

    $q=mysql_query("SELECT * FROM messages WHERE msgid='".$msgid."'");
    
    if ($m=mysql_fetch_assoc($q))
        return $m;
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
        $ret[]=$f;
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
        areasSendEmail('df@dflab.net', 'vFido:new message in '.$area, 'We have unapproved message');

     return true;
}

function areasSendEmail($_Email, $_Subject, $text){

	if(!$_Email)return 0;

	return mail($_Email, $_Subject, $text, "From: \"vFido\"<noreply@dflab.net>\nReturn-path: <df@dflab.net>");
}

?>
