<?

/*
  This is a simple php snipt it scrape the image directory for images that are available and their metadata (youtube videos)
  TODO: Script to put all images into a css style sheet as base64 data
*/
if ($handle = opendir('../image/round/')) {
	$jsFileNames='';
	$jsMetaNames='';
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
			if (strpos($entry,'.png')!==false){
				$jsFileNames .= '"' . $entry . '",';
			}
			if (strpos($entry,'.meta')!==false){
				$jsMetaNames .= "'" . $entry . "',";
			}			
        }
		
		
    }

  //these get put out to the html render as JS vars.
	$jsFileNames = substr($jsFileNames,0,strlen($jsFileNames)-1);
	$jsFileNames = "var fileNames = [" . $jsFileNames . "];";
	$jsMetaNames = substr($jsMetaNames,0,strlen($jsMetaNames)-1);
	$jsMetaNames = "var metaNames = [" . $jsMetaNames . "];";
	
    closedir($handle);
}




?>









<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Linked Jazz</title>

 
	



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="js/jquery.history.js"></script>
<script src="js/jquery.rdfquery.core.min-1.0.js"></script>
<script src="js/dragdealer.js"></script>
<script src="js/d3.v2.min.js"></script> 
<script src="js/vex.min.js"></script> 
<script src="js/network.js"></script> 



<script type="text/javascript"><?=$jsFileNames?><?=$jsMetaNames?></script>

<link rel="stylesheet" href="css/network.css">
<link rel="stylesheet" href="css/vex.css">
<link rel="stylesheet" href="css/vex-theme-os.css">

</head>

<body>
<a href="/"><img src="menu/logo.png"   id="logo"></a>

<div id="network" style="background-color:#fff">
    <div id="popUp">
    </div>
	
    <div style="cursor: pointer; position:absolute; right:5px; height:65px; width:65px; top:0px; opacity:0.15" id="menu_dynamic"><img alt="Dynamic mode allows you to add individuals and view their shared connections." title="Dynamic mode allows you to add individuals and view their shared connections." src="menu/menu_dynamic.png"/></div> 
    <div style="cursor: pointer; position:absolute; right:80px; height:65px; width:65px; top:0px; opacity:0.15" id="menu_similar"><img alt="Similar mode groups individuals together by their number of shared connections." title="Similar mode groups individuals together by their number of shared connections." src="menu/menu_similar.png"/></div> 
    <div style="cursor: pointer; position:absolute; right:150px; height:65px; width:65px; top:0px; opacity:0.15" id="menu_free"><img alt="Free mode groups individuals together based on their number of connections." title="Free mode groups individuals together based on their number of connections." src="menu/menu_free.png"/></div> 
	<div style="cursor: pointer; position:absolute; right:225px; height:65px; width:65px; top:0px; opacity:0.15" id="menu_fixed"><img alt="Fixed mode pins the individuals with the most connections to the outside allowing clearer presentation."  title="Fixed mode pins the individuals with the most connections to the outside allowing clearer presentation." src="menu/menu_fixed.png"/></div>     


	<div id="dynamicSearchHolder">
    	<input type="text" id="dynamicSearchInput" placeholder="Name Filter"/>
        <div id="dynamicSearchClear" title="Clear name filter text">&times;</div>
    </div>
	<div id="dynamicListHolder"></div>
    <div id="dynamicHelp">&laquo; Click names from list to add to network</div>
    <div id="dynamicClear"><img alt="Remove the nodes currently on the network"  title="Remove the nodes currently on the network." src="menu/menu_clear.png"/></div>

</div>


<div id="spinner">
	<img src="menu/ljspinner.gif">
    <span>LOADING</span>
</div>
<div id="video"></div>

<a id="gephi" href="#" title="Downalod this network as a Gephi file.">
  <img src="img/icon-gephi.png" title="Downalod this network as a Gephi file."> 
</a>


</body>
</html>
