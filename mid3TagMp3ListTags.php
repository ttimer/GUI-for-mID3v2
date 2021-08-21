<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>View existing tags</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta property="og:url" content="https://smolka.lima-city.de/">
<meta name="author" content="Jürgen Smolka">
<script type="text/javascript" src="dhtml.js"></script>
<!--  JS202106  -->
</head>

<body onload="ladenaus();">
<a name="top"></a>
<noscript><h1 style="text-align:center; background-color:yellow;">Please activate JavaScript</h1></noscript>
<?php
$relpfad  = "";
$viewonly = null;
$execute  = null;

$artist   = "";
$album    = "";
$titel    = "";
$track    = "";
$genre    = "";
$comment  = "";

//$fileTyp  = array("flac", "ogg", "wav", "cda", "mp3");
$fileTyp  = array("mp3");
$dateien  = array();
$onlyDir  = "";
$batch    = "";

include_once("mid3TagMp3.inc.php");

if (isset($_POST["relpfad"]))
  $relpfad = $_POST["relpfad"];
if(substr($relpfad, -1, 1) != "/" && strlen($relpfad) > 1)
  $relpfad = $relpfad . "/";
  
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

<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" style="margin-left:11%;" onsubmit="ladenein();">
 <fieldset style="width:900px;">
  <legend><span style="font-weight:700;">List Tags</legend>
  <p>
    (rel)path: <input type="text" name="relpfad" style="width:777px;" value="<?php echo $relpfad ?>" placeholder="./folder/ &nbsp; &nbsp; &nbsp; (./artist/album/ - ./artist/album/cd1/ - ./music/blues/ - ...)" required />
    <input type="checkbox" id="long" name="long" title="wrap - [ W ]" checked onclick="wrap()" />
  </p>
  <p style="display:none">
    viewonly: <input type="checkbox" name="viewonly" checked />
  </p>
<!--  
  <p>
    executeit: <input type="checkbox" name="execute" />
  </p>
  -->
 </fieldset>
  <p>
    <input type="submit" name="submit" value="submit" style="width:930px;" />
  </p>
</form>
<p style="margin-left:11%;"><img name="load" src="loading.gif" width="44" height="44" alt="loading"></p>

<script type="text/javascript">
  function ladenaus() { document.load.style.display = "none"; } 
  function ladenein() { document.load.style.display = "block"; } 
  function wrap() { 
    if(document.getElementById("out").style.whiteSpace == "nowrap") {
      document.getElementById("out").style.whiteSpace = "normal";
      document.getElementById("long").title = "no wrap - [ W ]";
      document.getElementById("long").checked = false;
    }
    else {
      document.getElementById("out").style.whiteSpace = "nowrap"; 
      document.getElementById("long").title = "wrap - [ W ]";
      document.getElementById("long").checked = true;
    }
  }
  document.onkeypress = function(event) {
    if(event.key == "w" || event.key == "W")
      wrap();
  }
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
 
  if(substr($relpfad, -1, 1) != "/" && strlen($relpfad) > 1) 
    $relpfad = $relpfad . "/";
  $batch = scan_dir($relpfad, $fileTyp, TRUE, FALSE, TRUE, $onlyDir, $dateien);
  
  if($batch == false) {
    echo '<dir style="margin-left:8%; font-weight:bold;">';
    echo '<p style="color:red;">No mp3 files or <u>&nbsp;folder&nbsp;</u> not existent!</p>'; 
    echo "\n <p>$relpfad</p>";
    echo '</dir>';
    exit();
  }
  
  echo '<div id="out" style="white-space:nowrap;">';
  $ausgabe = buildSites1($batch);
  echo '</div>';
}
?>
</body>
</html>
