<?php
/*    Имя проекта: vfido
 *    Тип файла: отображаемый
 *    Назначение файла: Список эхоконференций
 */
if (!defined('vFIDO_RUN'))
{
    echo 'access violation at address FAFAFED';// sorry ;)
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
<style type="text/css">
   #accordion {
         height:400px;
         overflow: auto;
   }
</style>
<title></title>
</head>
    <body>
        <h2 class="header">Эхоконференции</h2>
		<div id="accordion">
                    <div id="my">
				<h3><a href="<?php echo vFIDO_URL;?>?mode=showmy">Адресованные мне письма</a></h3>
                    </div>
                    <?php
                    $t=areasGetList();
                    $activeArea='false';
                    foreach ($t as $k=>$v)
                    {
                    ?>
			<div>
				<h3><a href="#"><?php echo $v['area']; ?> </a></h3>
				<div>
                                    <div  style="float:right;">
                                        <a href="<?php echo vFIDO_URL;?>?mode=newmessage&area=<?php echo $v['area'];?>">Написать сообщение</a>
                                    </div>
                                    <div>
                                    <?php
                                        $thr=areasGetLastThreads($v['area'],10);
                                        foreach ($thr as $thrI => $thV)
                                        {
                                            if (isset($_GET['area']) && $_GET['area']==$v['area'])
                                                $activeArea=$k+1; //Индекс активной эхи, при возврате из списка сообщений трэда, смещаем на 1 тк первая - карбонка
                                            ?>
                                                <a href="<?php echo vFIDO_URL;?>?mode=thread&id=<?php echo $thV['hash'];?>"><?php echo $thV['subject'];?></a><br />
                                            <?php
                                        }
                                    ?>
                                    </div>
                                </div>
			</div>
                        <?php } ?>
		</div>
        <script type="text/javascript">
	$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3",active: <?php echo $activeArea; ?>});
                               $("#my").click(function() {  document.location="<?php echo vFIDO_URL;?>?mode=showmy";});


        });
        </script>
    </body>
</html>
