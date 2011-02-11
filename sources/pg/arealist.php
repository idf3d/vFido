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
<link type="text/css" href="css/ui-lightness/jqui.css" rel="stylesheet" />
<link type="text/css" href="css/main.css" rel="stylesheet" />
<script type="text/javascript" src="js/jq.js"></script>
<script type="text/javascript" src="js/jqui.js"></script>
<style type="text/css">
   #accordion {
         height:400px;
         overflow: auto;
   }

</style>
<title></title>
</head>
    <body>
        <?php
            $t=areasGetList();
        ?>
        <h2 class="header">Эхоконференции</h2>
		<div id="accordion">
                    <div id="my">
				<h3><a href="<?php echo vFIDO_URL;?>?mode=showmy">Адресованные мне письма</a></h3>
                    </div>
                    <div>
                        <h3><a href="#">Мои эхоконференции</a></h3>
                        <div>
                            <?php
                             foreach ($t as $v)
                                        {
                                            ?>
                                                <a href="<?php echo vFIDO_URL;?>?mode=area&name=<?php echo $v['area']; ?>"><?php echo $v['area']; ?></a><br />
                                            <?php
                                        }
                                        ?>
                        </div>
                    </div>
		</div>
        <script type="text/javascript">
	$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3",active: false});
                               $("#my").click(function() {  document.location="<?php echo vFIDO_URL;?>?mode=showmy";});


        });
        </script>
    </body>
</html>
