<?php
/*    Имя проекта: vfido
 *    Тип файла: библиотека функций
 *    Назначение файла: Функции для обработки сообщений в стиле FTN
 */

function type_style($string){
  $string=preg_replace('/(^|\s)(\*)(\w+)(\*)(\s|$)/','<b>\\0</b>',$string);
  $string=preg_replace('/(^|\s)(\_)(\w+)(\_)(\s|$)/','<u>\\0</u>',$string);
  $string=preg_replace('/(^|\s)(\\/)(\w+)(\\/)(\s|$)/','<i>\\0</i>',$string);
  return $string;
}


function message2html($text){
    $return="";
    $body_flag=false;
    foreach($text as $string){
    $string=rtrim($string);
      if (!trim($string)) {
        $string="";
      }

      if (substr($string,0,1)!="@" and  (substr($string,0,5)!="AREA:" or $body_flag)){
        $string_tmp=trim($string);
        $first_space=strpos($string_tmp," ");
        if (strtoupper(substr($string,0,10))==" * ORIGIN:"){
            $string=str_replace ("<", "&lt;",$string);
            $string=str_replace (">", "&gt;",$string);
            $return=$return."<pre class=\"origin\">".$string."</pre>\n";
            break;
        }elseif (strtoupper(substr($string,0,3))=="---"){
            $string=str_replace ("<", "&lt;",$string);
            $string=str_replace (">", "&gt;",$string);
            $return=$return."<pre class=\"tearline\">".$string."</pre>\n";
        }elseif (strtoupper(substr($string,0,3))=="..."){
            $string=str_replace ("<", "&lt;",$string);
            $string=str_replace (">", "&gt;",$string);
            $return=$return."<pre class=\"tagline\">".$string."</pre>\n";
        }elseif($string==""){
            $return=$return."<pre class=\"message\"> </pre>\n";
        }elseif(substr($string_tmp,$first_space-1,1)==">"){
            $string=str_replace ("<", "&lt;",$string);
            $string=str_replace (">", "&gt;",$string);
            if (substr_count(substr($string_tmp,0,$first_space),">")%2==0){
		$string=type_style($string);
                $return=$return."<pre class=\"quote2\">".$string."</pre>\n";
            } else {
	        $string=type_style($string);
                $return=$return."<pre class=\"quote1\">".$string."</pre>\n";
            }
        } else {
            $string=str_replace ("<", "&lt;",$string);
            $string=str_replace (">", "&gt;",$string);
	    $string=type_style($string);
            $return=$return."<pre class=\"message\">".$string."</pre>\n";
        }
      }
    $body_flag=1;
    }
    // Ссылки нарушают правила для приложений вконтакте :(
    //$return = preg_replace('#(https?|ftp)(://[-a-z0-9_\.\/]+(\.(html|php|pl|cgi))*[-a-z0-9_:@&\?=+,\.!/~*\'%$]*)#i','<a target="_blank" href="safe_open.php?\\1\\2">\\1\\2</a>',$return);
    //$return = preg_replace('#([-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,3})/#','<a href=mailto:\\1>\\1</a>',$return);

    return $return;
}

function message2textarea ($text,$quoute_string=""){
    $return="";$i=1;$skip_empty=false;
    $block="";$prefix="";$newprefix="";$quoteprefix="";
    /*foreach($text as $string){
        $i=$i+1;
        $return=$return.$i.$string."\n";
    }
    return $return;*/
    foreach($text as $string){
      if (substr($string,0,1)!="@" and  (substr($string,0,5)!="AREA:" or $body_flag)){
        if (strtoupper(substr($string,0,10))==" * ORIGIN:"){
            break;
        } 
        $string=trim($string);
        $first_space=strpos($string," ");
        if (substr($string,$first_space-1,1)==">") {
            $first_quote=strpos($string,">");
            $newprefix=substr($string,0,$first_space);
            $string=substr($string,$first_space+1);
        } else {
            $newprefix="";
        }
        if ($string=="" or $prefix!=$newprefix) {
            if ($prefix) {
                $quoteprefix=$prefix;
            } else {
                $quoteprefix=$quoute_string;
            }
            if (trim($buffer)  !="") {
                $return=$return . quote_buffer($buffer,$quoteprefix);
                $skip_empty=false;
            }
            if ($string=="") {
                if(!$skip_empty) $return=$return."\n";
                $skip_empty=true;
            } else {
                $skip_empty=false;
            }
            $prefix=$newprefix;
            $buffer="";
        }
        $buffer=$buffer . $string . " ";

      }
    }
    return htmlspecialchars($return);
}


function quote_buffer($buffer,$prefix) {
    $return="";
    $charcount=60-mb_strlen($prefix,'utf-8');
    while ($buffer!="") {
        if (mb_strlen($buffer,'utf-8') < $charcount ) {
            $result=$result." ".$prefix . "> " . $buffer."\n";
            $buffer="";
        } else {
            $chunk=mb_substr($buffer,0,$charcount,'utf-8');
            $buffer=mb_substr($buffer,$charcount,mb_strlen($buffer,'utf-8'),'utf-8');
            $last_space=mb_strrpos($chunk, " ",0,'utf-8');
            if($last_space!=0) {
               $hvost=mb_substr($chunk,$last_space+1,mb_strlen($chunk,'utf-8'),'utf-8');
               $chunk=mb_substr($chunk,0,$last_space,'utf-8');
               $buffer=$hvost.$buffer;
            }
            $result=$result." ".$prefix . "> " . $chunk."\n";
        }
    }
    return $result;
}
function nameToFTN($str){
	// Based on function from Imbolc http://php.imbolc.name

	static $tbl= array(
		'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ж'=>'zh', 'з'=>'z',
		'и'=>'i', 'й'=>'y', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p',
		'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'ы'=>'y', 'э'=>'e', 'А'=>'A',
		'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D', 'Е'=>'E', 'Ж'=>'Zh', 'З'=>'Z', 'И'=>'I',
		'Й'=>'Y', 'К'=>'K', 'Л'=>'L', 'М'=>'M', 'Н'=>'N', 'О'=>'O', 'П'=>'P', 'Р'=>'R',
		'С'=>'S', 'Т'=>'T', 'У'=>'U', 'Ф'=>'F', 'Ы'=>'Y', 'Э'=>'E', 'ё'=>"yo", 'х'=>"h",
		'ц'=>"ts", 'ч'=>"ch", 'ш'=>"sh", 'щ'=>"shch", 'ъ'=>"", 'ь'=>"", 'ю'=>"yu", 'я'=>"ya",
		'Ё'=>"Yo", 'Х'=>"H", 'Ц'=>"Ts", 'Ч'=>"Ch", 'Ш'=>"Sh", 'Щ'=>"Shch", 'Ъ'=>"", 'Ь'=>"",
		'Ю'=>"Yu", 'Я'=>"Ya",' '=>' ','~'=>'',"'"=>'','/'=>'','+'=>'','"'=>'','('=>'',')'=>''
	);

    return strtr($str, $tbl);
}

?>
