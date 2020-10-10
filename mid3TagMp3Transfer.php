<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Copy &amp; Edit of ID3 tags</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta property="og:url" content="https://smolka.lima-city.de/">
<meta name="author" content="Jürgen Smolka">
<script type="text/javascript" src="dhtml.js"></script>
</head>

<?php
// Um ein Bild-Dummy zu erstellen, kann von einer 
// MP3-Datei eine ID3-Tags-Kopie gezogen werden. 
// (abc01.mp3 ==> dummy:X01-00.mp3 ==> abc00.mp3)
$quelle   = "";
$ziel     = "";
$noquelle = "";
$noziel   = "";
$viewonly = "";
$apicture = "";
$Xpicture = "";
$Xkopie   = "";
$execute  = "";
$befehl   = "";

$var   = "";
$tag   = "";
$tags  = "";
$para  = "";
$paras = "";
$pflag = "";
$array = null;
$shellBefehl = "";

if(isset($_POST["quelle"]))
  $quelle = $_POST["quelle"];
if(isset($_POST["ziel"]))
  $ziel = $_POST["ziel"];
if(isset($_POST["viewonly"]))
  $viewonly = $_POST["viewonly"];
if(isset($_POST["apicture"]))
  $Xpicture = "checked";
if(isset($_POST["execute"]))
  $execute = $_POST["execute"];
if(isset($_POST["kopie"]) && $quelle != $ziel)
  $Xkopie = $_POST["kopie"];
if(isset($_POST["befehl"]))
  $befehl = $_POST["befehl"];
?>

<?php
if (isset($_POST["submit"])) {
  // Daten der Quelldatei lesen und anzeigen
  if($viewonly && !$execute) {
    $shellBefehl = "mid3v2 -l '$quelle'";
    exec($shellBefehl, $var);
    $tags = $var;
    //print_r($var);
    //var_dump($var);
    if(!is_file($quelle) || !file_exists($quelle)) $noquelle = 'true';
    $shellBefehl = "";
    $var = "";

    $shellBefehl = "mid3v2 -l '$ziel'";
    exec($shellBefehl, $var);
    // print_r($var);
    if(!is_file($ziel) || !file_exists($ziel)) $noziel = 'true';
    $shellBefehl = "";
    $var = "";

    $paras = "";
    if(isset($_POST["apicture"]))
      $paras = " --APIC 'pic.jpg'";

    foreach($tags as $tag) {
     if(strstr($tag, "=")) { 
      if(strstr($tag, "APIC=")) $pflag = "P";
      if(strstr($tag, "APIC=") || strstr($tag, "TLEN=") || strstr($tag, "unrepresentable data"))
       continue;
  
      $tag  = str_replace("'", "’", $tag); // abc'd fff => abc’d fff (Rückwandlung am Schrittende)
      $para = " --$tag'";
      
      if(strstr($para, "--COMM") || strstr($para, "--W")) { // --LINK, --Wxxx ???
       $para = str_replace("iTunNORM", "iTunNORM:", $para);
       $para = str_replace("iTunPGAP", "iTunPGAP:", $para);
       $para = str_replace("iTunSMPB", "iTunSMPB:", $para);
       $para = str_replace("Comment=eng=", "Comment:", $para);
       $para = str_replace("=eng=", "", $para);       
       
       // COMM==XXX=?  =>  --COMM ':?:XXX'
       if(strstr($para, "==")) {
        $array = explode("=", $para, 4);
        $array[3] = str_replace("'", "", $array[3]);
        $para = "$array[0] '$array[1]:$array[3]:$array[2]'";
       }

       // --COMM ':https://ar...  =>  -e --COMM ':https\://ar...
       if(stristr($para, "http:") || stristr($para, "https:")) {
        $para = str_replace(" --", " -e --", $para);
        $para = str_replace("http:", "http\:", $para);
        $para = str_replace("HTTP:", "HTTP\:", $para);
        $para = str_replace("https:", "https\:", $para);
        $para = str_replace("HTTPS:", "HTTPS\:", $para);
       }
      }
      
      if(strstr($para, "--TXXX")) {
       $array = explode("=", $para, 3);
       $para = "$array[0] '$array[1]:$array[2]";
//        $para = "$array[0] '$array[1]¦$array[2]"; // Rückwandlung am Schrittende :: DELETE ???
      }
      
      $para = str_replace("=", " '", $para);
      if(strstr($para, "’")) {               // Ggf. Rückwandlung (siehe oben)
       $para = str_replace("'", '"', $para); // 'ab’d ff' => "ab’d ff" (' -> ")
       $para = str_replace("’", "'", $para); // "ab’d ff" => "ab'd ff" (’ -> ')
      }
//       if(strstr($para, "¦")) {
//        $para = str_replace("¦", "=", $para); // 'abc¦xyz' => 'abc=xyz' (¦ -> =) :: DELETE ???
//       }
      $paras = $paras.$para;
     }
    }
    $paras = trim($paras);
    $paras = str_replace(" '' ", " ' ' ", $paras); // TPE1=' ' anstatt =''

    //if($paras != "" || $paras != 0)
    $shellBefehl = "mid3v2 $paras '$ziel'";
    $befehl = $shellBefehl;
  }
  //print ("\n<br>mid3cp '$quelle' '$ziel'");
  //print $shellBefehl;
  //$shellBefehl = "";
  
  // Daten auf die Zieldatei übertragen
  // (ggf. vorab im Textfeld anpassen/erweitern -- bspw. Tracknummer minus 1)
  if($execute) {
    if($Xkopie) { 
      exec("mid3cp '$quelle' '$ziel'");
    }
    exec($befehl, $var);
    $shellBefehl = "";
    $var = "";
  }
}
?>

<body>
<noscript style="text-align:center;"><h1>Please activate JavaScript</h1></noscript>
<form name="id3" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" style="margin-left:11%;">
 <fieldset style="width:900px;">
  <legend><span style="font-weight:700;">Files</span></legend>
  <p>
    source: <input type="text" name="quelle" style="width:777px;" value="<?php echo $quelle; ?>" placeholder="./artist/album/title.mp3" required />
  </p>
  <p>
    target: &nbsp;<input type="text" name="ziel" style="width:777px;" value="<?php echo $ziel; ?>" placeholder="./artist/album/title.mp3 &nbsp;(x01-00.mp3 may be used here)" required />
  </p>
  <p style="display:none">
    viewonly: <input type="checkbox" name="viewonly" checked />
  </p>
  <p>
    add Pic.: &nbsp; <input type="checkbox" name="apicture" <?php echo $Xpicture; ?> />
    <?php if($pflag == "P") echo '&nbsp; <img src="pic.jpg" width="22" height="22" alt="pic present!" title="dummy pic"> Picture present!'; ?>
  </p>
  <p>
    copy first: <input type="checkbox" name="kopie" checked /> &nbsp; [edit after full copy (esp. w/ APIC, LINK ...)]
  </p>
  <p>
    executeit: &nbsp;<input type="checkbox" name="execute" /> &nbsp; [edit textarea beforehand] (list of <a href="./mid3TagMp3Frames.php" target="frame">tags/frames</a>)
  </p>
 </fieldset>
 
 <textarea name="befehl" style="width:925px; font-size:12pt; line-height:24pt;" rows="4"><?php echo $befehl; ?></textarea>
 
  <p>
    <input type="submit" name="submit" value="submit" style="width:930px;" />
  </p>
</form>
<?php
  if($noquelle || $noziel) {
    echo '<dir style="margin-left:8%; font-weight:bold;">';
    if($noquelle) 
      echo '<p style="color:red;">No source file found!</p>'; 
    if($noziel)
      echo '<p style="color:red;">No target file found!</p>'; 
    echo '</dir>';
    exit();
  }

  if(isset($_POST["submit"])) {
    echo('<dir style="margin-left:8%;">');
    if($Xkopie) { echo("\n<br>'copy first' was $Xkopie <br>\n"); }
    else { echo("\n<br>'copy first' was off <br>\n"); }
    echo('</dir>');
    echo("<br>\n");
    echo('<script type="text/javascript">');
    echo('if(document.id3.quelle.value == document.id3.ziel.value)');
    echo('  clearCheck("name", "kopie", 0);');
    echo('</script>');
    echo("<br>\n");
  }
?>
</body>
</html>
