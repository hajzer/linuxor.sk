<?php

if (isset($_GET['doc']) && is_string($_GET['doc']) && $_GET['doc']!="")
{
	$doc = $_GET['doc'];

    // everything to lower and no spaces begin or end
    $escape_filename = strtolower(trim($doc));

    // adding - for spaces and union characters
    $find = array(' ', '&', '\r\n', '\n', '+',',');
    $escape_filename = str_replace ($find, '-', $escape_filename);

    //delete and replace rest of special chars
    $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
    $repl = array('', '-', '');
    $escape_filename = preg_replace ($find, $repl, $escape_filename);

	$escape_filename = escapeshellcmd($escape_filename);
	$escape_filename = str_replace ("..", "", $escape_filename);
	$escape_filename = str_replace ("/", "", $escape_filename);

    $escape_filename = "./" . "$escape_filename" . ".md";
	$html = file_get_contents("$escape_filename");
}
else
{
    $html = file_get_contents("index.md");
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//SK" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="https://www.linuxor.sk/css/style.css" />
    <link rel="stylesheet" type="text/css" href="https://www.linuxor.sk/css/github-markdown.css">
	<title>Linuxor.sk</title>
</head>



<body id="howtoz">
<!--wrapper -->
<div id="wrapper">
    <!--header -->


<!-- header -->
<center>		
<pre>
     ooooo        ooooo ooooo      ooo ooooo     ooo ooooooo  ooooo   .oooooo.   ooooooooo.   
     `888'        `888' `888b.     `8' `888'     `8'  `8888    d8'   d8P'  `Y8b  `888   `Y88. 
      888          888   8 `88b.    8   888       8     Y888..8P    888      888  888   .d88' 
      888          888   8   `88b.  8   888       8      `8888'     888      888  888ooo88P'  
      888          888   8     `88b.8   888       8     .8PY888.    888      888  888`88b.    
      888       o  888   8       `888   `88.    .8'    d8'  `888b   `88b    d88'  888  `88b.  
     o888ooooood8 o888o o8o        `8     `YbodP'    o888o  o88888o  `Y8bood8P'  o888o  o888o 
</pre>
</center>
<!-- header -->
   
	<!-- main menu -->
	<div id="main_menu">
		<ul id="nav">
			<li class="index"><a href="https://www.linuxor.sk/" title="LINUXOR">LINUXOR</a></li>
            <li class="current active howtoz"><a href="https://www.linuxor.sk/howtoz/" title="HOWTOz">HOWTOz</a></li>
            <li class="cheatsheetz"><a href="https://www.linuxor.sk/cheatsheetz/" title="CHEATSHEETz">CHEATSHEETz</a></li>
            <li class="configz"><a href="https://www.linuxor.sk/configz/" title="CONFIGz">CONFIGz</a></li>
            <li class="linkz"><a href="https://www.linuxor.sk/linkz/" title="LINKz">LINKz</a></li>
		</ul>
	</div>

	<div id="content">
 
	<!-- sidebar 
		<div id="sidebar">
						
		</div>
    -->
		
	<!-- text -->
		<div id="text">

<?php

include('../include/Parsedown.php');


/*
echo '<link rel="stylesheet" href="github-markdown.css">';
echo '<style>';
echo '    .markdown-body {';
echo '        box-sizing: border-box;';
echo '        min-width: 200px;';
echo '        max-width: 980px;';
echo '        margin: 0 auto;';
echo '        padding: 45px;';
echo '    }';
echo '</style>';
*/



$Parsedown = new Parsedown();

echo '<article class="markdown-body">';
//echo $Parsedown->text($html);
echo Parsedown::instance()
// LH OFF
//   ->setBreaksEnabled(true) # enables automatic line breaks
   ->text($html);

echo '</article>';


?>


		</div>
		<div id="clearing"></div>
<!--end text -->
   </div>
<!--footer -->

    <div id="footer"> 
    LINUXOR.SK		
    <!--end footer -->
    </div>

	
<!--end wrapper -->
</body>
</html>