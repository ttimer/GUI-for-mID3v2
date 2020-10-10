<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MP3 files in this directory (incl. subfolders)</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta property="og:url" content="https://smolka.lima-city.de/">
<meta name="author" content="Jürgen Smolka">
<script type="text/javascript" src="dhtml.js"></script>
<script type="text/javascript">
function setAll() {
 setLine1();
 setLine2();
}

function setLine1() {
 setCheck("name", "Xartist", 0);
 setCheck("name", "Xalbum", 0);
 setCheck("name", "Xtitel", 0);
 setCheck("name", "Xtrack", 0);
}

function setLine2() {
 setCheck("name", "Xgenre", 0);
 setCheck("name", "Xyear", 0);
 setCheck("name", "Xcomment", 0);
 setCheck("name", "Xpicture", 0);
}

function setStandard() {
 setCheck("name", "Xartist", 0);
 setCheck("name", "Xalbum", 0);
 setCheck("name", "Xtitel", 0);
 setCheck("name", "Xtrack", 0);
 setCheck("name", "Xgenre", 0);
 setCheck("name", "Xpicture", 0);
}

function clearAll() {
 clearCheck("name", "Xartist", 0);
 clearCheck("name", "Xalbum", 0);
 clearCheck("name", "Xtitel", 0);
 clearCheck("name", "Xtrack", 0);
 clearCheck("name", "Xgenre", 0);
 clearCheck("name", "Xyear", 0);
 clearCheck("name", "Xcomment", 0);
 clearCheck("name", "Xpicture", 0);
}

function setPic() {
 var pic = "pic.jpg";
 if(document.id3.relpfad.value != '')
   pic = document.id3.relpfad.value + "cover.jpg";
 document.id3.picture.value = pic;
}

function ladenaus() { document.load.style.display = "none"; } 
function ladenein() { document.load.style.display = "block"; } 
</script>
</head>

<body onload="ladenaus();">
<a name="top"></a>
<noscript style="text-align:center;"><h1>Please activate JavaScript</h1></noscript>
<?php
$relpfad  = "";    //"./";  //"./test/";
$viewonly = null;
$execute  = null;

$Xartist  = "";
$Xalbum   = "";
$Xtitel   = "";
$Xtrack   = "";
$Xgenre   = "";
$Xyear    = "";
$Xcomment = "";
$Xpicture = "";

$artist   = "";
$album    = "";
$titel    = "";
$track    = "";
$genre    = "";
$year     = "";
$comment  = "";
$picture  = "";
$array    = "";

$fileTyp  = array("mp3");
$dateien  = array();
$onlyDir  = "";
$batch    = "";

include_once("mid3TagMp3.inc.php");

if (isset($_POST["relpfad"]))
  $relpfad = $_POST["relpfad"];
  
if(isset($_POST["Xartist"]))
  $Xartist = "checked";
if(isset($_POST["Xalbum"]))
  $Xalbum = "checked";
if(isset($_POST["Xtitel"]))
  $Xtitel = "checked";
if(isset($_POST["Xtrack"]))
  $Xtrack = "checked";
if(isset($_POST["Xgenre"]))
  $Xgenre = "checked";
if(isset($_POST["Xyear"]))
  $Xyear = "checked";
if(isset($_POST["Xcomment"]))
  $Xcomment = "checked";
if(isset($_POST["Xpicture"]))
  $Xpicture = "checked";

if(!empty($_POST["artist"]))
  $artist = $_POST["artist"];
if(!empty($_POST["album"]))
  $album = $_POST["album"];
if(!empty($_POST["titel"]))
  $titel = $_POST["titel"];
if(!empty($_POST["track"]))
  $track = $_POST["track"];
if(!empty($_POST["genre"]))
  $genre = $_POST["genre"];
if(!empty($_POST["year"]))
  $year = $_POST["year"];
if(!empty($_POST["comment"]))
  $comment = $_POST["comment"];
if(!empty($_POST["picture"]))
  $picture = $_POST["picture"];

?>

<form name="id3" method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" style="margin-left:11%;" onsubmit="ladenein();">
 <fieldset style="width:900px;">
  <legend><span style="font-weight:700;">Audio Book</span> P1L (control)</legend>
  <p>
    (rel)path: <input type="text" name="relpfad" style="width:777px;" value="<?php echo $relpfad ?>" placeholder="./artist/album/" required />
  </p>
  <p style="display:none">
    viewonly: <input type="checkbox" name="viewonly" checked />
  </p>
  <p>
    executeit: <input type="checkbox" name="execute" />
  </p>
 </fieldset>
 
 <fieldset style="width:900px;">
  <legend><span style="font-weight:700;">ID3 Tags</span> (tag control)</legend>
  <table cellpadding="4" cellspacing="11">
   <tr>
    <td>-a (Artist):</td><td><input type="checkbox" name="Xartist" <?php echo $Xartist ?> /></td><td> | </td>
    <td>-A (Album):</td> <td><input type="checkbox" name="Xalbum" <?php echo $Xalbum ?> /></td><td> | </td>
    <td>-t (Title):</td> <td><input type="checkbox" name="Xtitel" <?php echo $Xtitel ?> /></td><td> | </td>
    <td>-T (Track):</td> <td><input type="checkbox" name="Xtrack" <?php echo $Xtrack ?> /></td><td> | </td>
    <td><a href="javascript:setLine1()">line1</a> | <a href="javascript:setStandard()">std.</a> | <a href="javascript:setAll()">all</a> | <a href="javascript:clearAll()">clear</a></td>
   </tr>
   <tr>
    <td>-g (Genre):</td> <td><input type="checkbox" name="Xgenre" <?php echo $Xgenre ?> /></td><td> | </td>
    <td>-y (Year):</td>  <td><input type="checkbox" name="Xyear" <?php echo $Xyear ?> /></td><td> | </td>
    <td>-c (Com.):</td>  <td><input type="checkbox" name="Xcomment" <?php echo $Xcomment ?> /></td><td> | </td>
    <td>-p (Picture):</td>  <td><input type="checkbox" name="Xpicture" <?php echo $Xpicture ?> /></td><td> | </td>
    <td><a href="javascript:setLine2()">line2</a> | <a href="javascript:setStandard()">std.</a> | <a href="javascript:setAll()">all</a> | <a href="javascript:clearAll()">clear</a></td>
   </tr>
  </table>
 </fieldset>
 
 <fieldset style="width:900px;">
  <legend style="font-weight:700; line-height:133%;">Manual adaption</legend>
  <table>
  <tr><td>
    artist: </td><td><input type="text" name="artist" style="width:767px;" value="<?php echo $artist ?>" />
  </td></tr>
  <tr><td>
    album:  </td><td><input type="text" name="album" style="width:767px;" value="<?php echo $album ?>" />
  </td></tr>
  <tr><td>
    title:  </td><td><input type="text" name="titel" style="width:767px;" value="<?php echo $titel ?>" placeholder="(%T :: track as prefix: 001-... | or in text: xxx 001 xxx)" />
  </td></tr>
  <tr><td>
    track:  </td><td><input type="text" name="track" style="width:767px;" value="<?php echo $track ?>" placeholder="001  (initial value)" />
  </td></tr>
  <tr><td>
    <a href="./mid3TagMp3Genre.php" target="genre">genre</a>:  </td><td><input type="text" name="genre" style="width:767px;" value="<?php echo $genre ?>" placeholder="101  (speech)" />
  </td></tr>
  <tr><td>
    year:  </td><td><input type="text" name="year" style="width:767px;" value="<?php echo $year ?>" />
  </td></tr>
  <tr><td>
    comment:  </td><td><input type="text" name="comment" style="width:767px;" value="<?php echo $comment ?>" />
  </td></tr>
  <tr><td>
    picture1:  </td><td><input type="text" name="picture" style="width:717px;" value="<?php echo $picture ?>" placeholder="(first mp3 file only!)" />
    <a href="javascript:setPic()">
    <img src="<?php if(strstr($picture,':')) { $array = explode(':',$picture); echo $array[0]; } else echo $picture; ?>" width="40" height="38" border="2" align="top" />
    </a>
    <!--<img src="<?php //echo $picture ?>" width="40" height="38" border="2" align="top" />-->
  </td></tr>
  <tr><td>
    pic-link:  </td><td><input type="text" name="apiclink" style="width:767px;" placeholder="[ UNDER CONSTRUCTION ] ../01-00.mp3  (! experimental !)" />
  </td></tr>
  </table>
 </fieldset>
  <p>
    <input type="submit" name="submit" value="submit" style="width:930px;" />
  </p>
</form>
<p style="margin-left:11%;"><img name="load" src="loading.gif" width="44" height="44" alt="loading"></p>

<?php
// App-Steuerung
if (isset($_POST["submit"])) {
  if(isset($_POST["relpfad"]))
    $relpfad = $_POST["relpfad"];
  if(isset($_POST["viewonly"]))
    $viewonly = $_POST["viewonly"];
  if(isset($_POST["execute"]))
    $execute = $_POST["execute"];

  if(isset($_POST["Xartist"]))
    $Xartist = $_POST["Xartist"];
  if(isset($_POST["Xalbum"]))
    $Xalbum = $_POST["Xalbum"];
 
  $batch = scan_dir($relpfad, $fileTyp, TRUE, FALSE, TRUE, $onlyDir, $dateien);
  
  if($batch == false) {
    echo '<dir style="margin-left:8%; font-weight:bold;">';
    echo '<p style="color:red;">No mp3 files or <u>&nbsp;folder&nbsp;</u> not existent!</p>'; 
    echo "\n <p>$relpfad</p>";
    echo '</dir>';
    exit();
  }
  
  if($viewonly)
    $ausgabe = buildSites2c($batch);
  echo '<dir style="text-align:center;"><p><a href="#top">top</a><br><br></p></dir>';
}
?>

</body>
</html>