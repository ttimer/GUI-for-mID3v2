<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MP3 music files in this directory (incl. subfolders)</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta property="og:url" content="https://smolka.lima-city.de/">
<meta name="author" content="Jürgen Smolka">
<script type="text/javascript" src="dhtml.js"></script>
</head>

<body onload="ladenaus();">
<a name="top"></a>
<noscript style="text-align:center;"><h1>Please activate JavaScript</h1></noscript>
<?php
$relpfad  = "";    //"./";  //"./test/";
$viewonly = null;
$execute  = null;

$artist   = "";
$album    = "";
$titel    = "";
$track    = "";
$genre    = "";
$comment  = "";

$fileTyp  = array("mp3");
$dateien  = array();
$onlyDir  = "";
$batch    = "";

include_once("mid3TagMp3.inc.php");

if (isset($_POST["relpfad"]))
  $relpfad = $_POST["relpfad"];
  
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
  
?>

<form name="id3" method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" style="margin-left:11%;" onsubmit="ladenein();">
 <fieldset style="width:900px;">
  <legend><span style="font-weight:700;">Songs</span> (control)</legend>
  <p>
    (rel)path: <input type="text" name="relpfad" style="width:777px;" value="<?php echo $relpfad ?>" placeholder="./music/" required />
  </p>
  <p style="display:none">
    viewonly: <input type="checkbox" name="viewonly" checked />
  </p>
  <p>
    executeit: <input type="checkbox" name="execute" />
  </p>
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
    title:  </td><td><input type="text" name="titel" style="width:767px;" value="<?php echo $titel ?>" />
  </td></tr>
<!--  <tr><td>
    track:  </td><td><input type="text" name="track" style="width:767px;" value="<?php echo $track ?>" />
  </td></tr>-->
  <tr><td>
    <a href="./mid3TagMp3Genre.php" target="genre">genre</a>:  </td><td><input type="text" name="genre" style="width:767px;" value="<?php echo $genre ?>" />
  </td></tr>
<!--  <tr><td>
    comment:  </td><td><input type="text" name="comment" style="width:767px;" value="<?php echo $comment ?>" />
  </td></tr>-->
  </table>
 </fieldset>
  <p>
    <input type="submit" name="submit" value="submit" style="width:930px;" />
  </p>
</form>
<p style="margin-left:11%;"><img name="load" src="loading.gif" width="44" height="44" alt="loading"></p>
<script type="text/javascript">
  function ladenaus() { document.load.style.display = "none"; } 
  function ladenein() { document.load.style.display = "block"; } 
</script>

<?php
// App-Steuerung
if (isset($_POST["submit"])) {
  if(isset($_POST["relpfad"]))
    $relpfad = $_POST["relpfad"];
  if(isset($_POST["viewonly"]))
    $viewonly = $_POST["viewonly"];
  if(isset($_POST["execute"]))
    $execute = $_POST["execute"];
 
  $batch = scan_dir($relpfad, $fileTyp, TRUE, FALSE, TRUE, $onlyDir, $dateien);
  
  if($batch == false) {
    echo '<dir style="margin-left:8%; font-weight:bold;">';
    echo '<p style="color:red;">No mp3 files or <u>&nbsp;folder&nbsp;</u> not existent!</p>'; 
    echo "\n <p>$relpfad</p>";
    echo '</dir>';
    exit();
  }

  if($viewonly)
    $ausgabe = buildSites3($batch);
  echo '<dir style="text-align:center;"><p><a href="#top">top</a><br><br></p></dir>';
}
?>

</body>
</html>