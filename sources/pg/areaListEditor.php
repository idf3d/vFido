<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Редактирования списка эхоконференций
 */
if (!defined('vFIDO_RUN'))
{
    echo 'access violation at address FAFAFED';// sorry ;)
    exit();
}

if (isset($_POST['subscribe']))
{
    unset ($_POST['subscribe']);
    aFixUnSubscribeAllAreasCurrUser();
    foreach ($_POST as $area) {
        aFixSubscribeCurrUser($area);
    }
    header("Location: ".vFIDO_URL."?mode=list");
    exit();
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
htmlPageHeader();
$c=areasGetList();
$subsA=aFixGetCurrUserSubscribedEchoes();

$subs=array();
foreach ($subsA as $a)
{
    $subs[]=$a['area'];
}

?>
    <h2>Мои эхоконференции</h2>
    <p> Выберите эхоконференции, которые будут отображаться в списке "Мои эхоконференции".</p>

    <div style="font-size: 14px;height: 340px;overflow: auto;">
        
    <form method="POST">
        <input type="hidden" name="subscribe" value="ok"/>
        
        <?php
        $i=0;
        foreach ($c as $ar) {
        ?>
        <label for="<?php echo $ar['area']; ?>">
        <input type="checkbox" name="<?php echo $i++; ?>" value="<?php echo $ar['area']; ?>" id="<?php echo $ar['area']; ?>"
               <?php echo (in_array($ar['area'],$subs))?'checked':''; ?> 
               /><?php echo $ar['area']; ?></label><br />
        <?php
        }
        ?>
               </div><br /><center>
        <input type="submit" value="Сохранить изменения" /></center>
    </form>
</body>
</html>