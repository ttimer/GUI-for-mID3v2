<?php
/**
 *   
 *   @author Jürgen Smolka
 *   @link   https://smolka.lima-city.de/
 *   
 *
 *   BASED ON:   
 *
 *	Rekursive Verzeichnisdarstellung
 *
 *	Systemvoraussetzung:
 *	Linux / Windows 
 *	PHP 3, PHP 4, PHP 5
 *
 *	Listet alle Dateien oder wahlweise nur ausgewählte Dateitypen (z.B. *.jpg)
 *	eines Verzeichnisses rekursiv auf. Entweder kann nur das angebenene Verzeichnis 
 *	oder rekursiv alle Verzeichnisse und Unterverzeichnisse gelistet werden.
 *	Weiterhin kann ein Array mit aufzulistende Dateitypen dargestellt werden.
 *	Als Rückgabewert erhalten Sie eine Variable mit sämtlichen Verzeichnissen, Dateien,
 *	Dateigröße sowie das Aktualisierungsdatum der einzelnen Dateien.
 *	Um eine barrierefreie Darstellung zu garantieren, ist die Ausgabe valide zu HTML 4.01
 *	und CSS 2.0 
 *
 *	Aufruf der Funktion:
 *	----------------------------------------------------------------
 *	include_once("searchFiles.inc.php");
 *	$fileTyp = array("jpg","gif");
 *	$Bildergalerie = scan_dir("Bilder/",$fileTyp,TRUE,FALSE,TRUE);
 *	if($Bildergalerie == false)
 *	{
 *	//echo 'Verzeichnis existiert nicht';
 *	}
 *	else{
 *	$ausgabe = buildSites($Bildergalerie);
 *	echo $ausgabe;
 *	}
 *	----------------------------------------------------------------
 *
 * 	LICENSE: GNU General Public License (GPL)
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License version 2,
 *	as published by the Free Software Foundation.
 *
 *	@category   Verzeichnis
 *	@author     Damir Enseleit <info@selfphp.de>
 *	@copyright  2001-2006 SELFPHP
 *	@version    $Id: searchFiles.inc.php,v 0.10 2006/03/14 10:39:00 des1 Exp $
 *	@link       http://www.selfphp.de
 */
 
 
/**
 * Baut die Struktur für die Darstellung auf
 *
 * @param		array		$pictures		Enthält den Inhalt der Verzeichnisstruktur
 *
 * @return	string							Liefert das fertige HTML/CSS Layout						
 */
function buildSites($pictures)
{
    $ausgabe = "";
	reset ($pictures);
	
	$ausgabe .= '<div id="navBar">' . "\n";
	$ausgabe .= '	<div id="sectionLinks">' . "\n";
	
	ksort($pictures); // JS sortiert Verzeichnisse (CD1, CD2 ...)
	
	foreach($pictures as $key => $array) 
	{
		$ausgabe .= '		<h3>'.$pictures[$key]['name']['dir'].'</h3>' . "\n";
		$ausgabe .= '		<ul>' . "\n";
		
		ksort($array); // JS sortiert Dateien (0101.mp3, 0102.mp3... 0404.mp3 ...)
		
		foreach ($array as $key2 => $array1) 
		{
		
			if(!empty($pictures[$key][$key2]['file'])){
				$size			=	number_format($pictures[$key][$key2]['size'], 1, ',', '.');
				$date			=	date("d.m.Y, H:i:s", $pictures[$key][$key2]['time']);
				$alt			=	'Datum: ' . $date . ' / Größe: ' . $size . 'KB'; 
				$path			= $pictures[$key]['name']['path'].$pictures[$key][$key2]['file'];
				$ausgabe	.= '			<li><a href="'.$path.'" target="_blank" title="'.$alt.'">';
				$ausgabe .= $pictures[$key][$key2]['file'];
				$ausgabe .= '</a></li>' . "\n"; 
			}

		}
		$ausgabe .= '		</ul>' . "\n";
	}
	
	$ausgabe .= '	</div>' . "\n";
	$ausgabe .= '</div>' . "\n";
	
	return $ausgabe;
}

// Liste der vorhandenen Tags - Aufruf per mid3TagMp3ListTags.php
function buildSites1($batch)
{
    $ausgabe = "";     // JS
    
	reset($batch);
	ksort($batch); // JS sortiert Verzeichnisse (CD1, CD2 ...)

	if(!$batch) {
          echo '<h4 style="color:red; margin-left:11%;">No data fetched ...</h4>';
          echo '<p style="margin-left:11%;">Try <b>mid3v2 -l <i>file.mp3</i></b> on konsole!</p>';
          exit();
        }              // JS

	echo '<a name="tag"></a><br>';
	echo '<dir style="margin-left:11%;">';
	echo '<b>tags only</b> &nbsp;<a href="#file">files only</a> &nbsp;';
	echo '<a href="#kombi">combined</a> &nbsp;<a href="#top">top</a><br>';
	echo "</dir>\n";
	foreach($batch as $key => $array) 
	{
		ksort($array); // JS sortiert Dateien (0101.mp3, 0102.mp3... 0404.mp3 ...)
		
		foreach ($array as $key2 => $array1) 
		{
			if(!empty($batch[$key][$key2]['file'])){
				$size			=	number_format($batch[$key][$key2]['size'], 1, ',', '.');
				$date			=	date("d.m.Y, H:i:s", $batch[$key][$key2]['time']);
				$alt			=	'Datum: ' . $date . ' / Größe: ' . $size . 'KB'; 
				$path			= $batch[$key]['name']['path'].$batch[$key][$key2]['file'];

				$tags = "";
                                $shellBefehl = "mid3v2 -l '$path'";
                                exec($shellBefehl, $tags);

                                foreach ( $tags as $strKey => $strValue ) {
                                  if($strKey != 0)
                                    echo ' | ' . $strValue;
                                }
                                echo "<br> \n <br> \n";
			}
		}
	}

	flush();
	echo '<hr style="width:80%;"><br>';
	echo '<a name="file"></a>';
	echo '<dir style="margin-left:11%;">';
	echo '<a href="#tag">tags only</a> &nbsp;<b>files only</b> &nbsp;';
	echo '<a href="#kombi">combined</a> &nbsp;<a href="#top">top</a><br>';
	echo "</dir>\n";
	foreach($batch as $key => $array) 
	{
		ksort($array); // JS sortiert Dateien (0101.mp3, 0102.mp3... 0404.mp3 ...)
		
		foreach ($array as $key2 => $array1) 
		{
			if(!empty($batch[$key][$key2]['file'])){
				$size			=	number_format($batch[$key][$key2]['size'], 1, ',', '.');
				$date			=	date("d.m.Y, H:i:s", $batch[$key][$key2]['time']);
				$alt			=	'Datum: ' . $date . ' / Größe: ' . $size . 'KB'; 
				$path			= $batch[$key]['name']['path'].$batch[$key][$key2]['file'];

				$tags = "";
                                $shellBefehl = "mid3v2 -l '$path'";
                                exec($shellBefehl, $tags);

                                foreach ( $tags as $strKey => $strValue ) {
                                  if($strKey == 0)
                                    echo $strValue;
                                }
                                echo "<br> \n <br> \n";
			}
		}
	}

        flush();
	echo '<hr style="width:80%;"><br>';
	echo '<a name="kombi"></a><br>';
	echo '<dir style="margin-left:11%;">';
	echo '<a href="#tag">tags only</a> &nbsp;<a href="#file">files only</a> &nbsp;';
	echo '<b>combined</b> &nbsp;<a href="#top">top</a><br>';
	echo "</dir>\n";
	foreach($batch as $key => $array) 
	{
		ksort($array); // JS sortiert Dateien (0101.mp3, 0102.mp3... 0404.mp3 ...)
		
		foreach ($array as $key2 => $array1) 
		{
			if(!empty($batch[$key][$key2]['file'])){
				$size			=	number_format($batch[$key][$key2]['size'], 1, ',', '.');
				$date			=	date("d.m.Y, H:i:s", $batch[$key][$key2]['time']);
				$alt			=	'Datum: ' . $date . ' / Größe: ' . $size . 'KB'; 
				$path			= $batch[$key]['name']['path'].$batch[$key][$key2]['file'];

				$tags = "";
                                $shellBefehl = "mid3v2 -l '$path'";
                                exec($shellBefehl, $tags);

                                foreach ( $tags as $strKey => $strValue ) {
                                  if($strKey == 0)
                                    echo '<b>' . $strValue . '</b><br>' . "\n";
                                  else
                                    echo ' | ' . $strValue;
                                }
                                echo "<br> \n <br> \n";
			}
		}
	}
    return $ausgabe;
}

// Hörbücher u. ä. - Aufruf per: mid3TagMp3??????.php
function buildSites2($batch)
{
$GUI = "ID3-tags-powered-by:ID3 by GitHub.com/ttimer/GUI-for-mID3v2";
$LNK = "https://GitHub.com/ttimer/GUI-for-mID3v2/";

    $genreini = "101";         // JS
    $trackini = "001";         // JS
    $ausgabe  = "";            // JS
    $tracknr  = "";            // JS
    $lenTrack = "";            // JS
    $trackpa  = "";            // JS
    $trackpo  = "";            // JS
    
    reset($batch);
    ksort($batch);             // JS sortiert Verzeichnisse (CD1, CD2 ...)
    
    if((!empty($_POST["track"]) || $_POST["track"] == 0) && isset($_POST["Xtrack"])) {
        $tracknr = $_POST["track"];
        if(strstr($tracknr, "/")) {
          $tracknr = str_replace(" ", "", $tracknr);
          $trackpa = explode("/", $tracknr, 2);
          $tracknr = $trackpa[0];
          $trackpo = "/" . $trackpa[1];
        }
    }
    if($tracknr == "") $tracknr = $trackini; 
    $lenTrack = strlen($tracknr); 

	foreach($batch as $key => $array) 
	{
		//$ausgabe .= '		<h3>'.$batch[$key]['name']['dir'].'</h3>' . "\n";
		//$ausgabe .= '		<ul>' . "\n";
		
		ksort($array); // JS sortiert Dateien (0101.mp3, 0102.mp3... 0404.mp3 ...)
		
		foreach ($array as $key2 => $array1) 
		{
		
			if(!empty($batch[$key][$key2]['file'])){
				$size			=	number_format($batch[$key][$key2]['size'], 1, ',', '.');
				$date			=	date("d.m.Y, H:i:s", $batch[$key][$key2]['time']);
				$alt			=	'Datum: ' . $date . ' / Größe: ' . $size . 'KB'; 
				$path			= $batch[$key]['name']['path'].$batch[$key][$key2]['file'];
				//$ausgabe	.= '			<li><a href="'.$path.'" target="_blank" title="'.$alt.'">';
				//$ausgabe .= $path . $batch[$key][$key2]['file'];
				$ausgabe .= $path;
				//$ausgabe .= '</a></li>' . "\n"; 
				$ausgabe .= " $tracknr <br />\n";
				
					
	$Artist = strtok($path, "/"); // erster Abschnitt $path ( ./ );
	$Artist = strtok("/");        // zweiter Abschnitt $path
// 	$Artist = strtok("/");
// 	$Artist = strtok("/");
// 	$Artist = strtok("/");
	
	$Album  = strtok("/");        // dritter Abschnitt $path
	//$Album  = strtok("-/");
	//$Album  = strtok($Album, "-");
	
	$Titel  = str_replace(".mp3", "", $batch[$key][$key2]['file']);
	$Titel  = str_replace("-", "", $Titel);
        $Titelt = $Titel; 
	$Track  = $tracknr . $trackpo;
	$Datei  = trim($path);
	//$Datei  = "./" . $Datei; // direkt im Hauptprogramm vorgeben!!!
	
	$Artist = trim($Artist);
	$Album  = trim($Album);
	$Titel  = trim($Titel);
	$Genre  = "101";  // Speech (bspw. Hörbuch)
// 	$Coment = "";
	$Exe    = "";
	//echo $Artist . $Album . $Titel .$Track . $Datei . "<br />\n";

	if(!empty($_POST["artist"]))
	  $Artist = $_POST["artist"];
        if(!empty($_POST["album"]))
	  $Album = $_POST["album"];
	if(!empty($_POST["titel"]))
	  $Titel = $_POST["titel"];
	if(!empty($_POST["track"]) || $_POST["track"] == 0)
	  $Track = $_POST["track"];
        if($tracknr == "") 
          $tracknr = $trackini; 
	if(!empty($_POST["genre"]) || $_POST["genre"] == 0)
	  $Genre = $_POST["genre"];
        if($Genre == "") 
          $Genre = $genreini; 
// 	if(!empty($_POST["comment"]))
// 	  $Coment = $_POST["comment"];
	if(isset($_POST["execute"]))
	  $Exe = $_POST["execute"];
	
	//echo("mid3v2 -a '$_POST[artist]' -A '$_POST[album]' -t '$_POST[titel]' -T $_POST[track] -g $_POST[genre] '$Datei'<br />\n");
	//echo("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T $Track -g '$Genre' -c '$Coment' '$Datei'<br />\n");
	echo("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T '$Track' -g '$Genre' '$Datei'<br />\n");
	if($Exe == "on")
	  exec("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T '$Track' -g '$Genre' --WXXX '$GUI' '$Datei'");
	  //exec("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T $Track -g '$Genre' -c '$Coment' '$Datei'");
	//exec("mid3v2 -a '$Artist' -A 'Moerderische Cote d Azur' -t '$Titel' -T $Track -g 101 '$Datei'");
	
// 	// Genre 101 == Speech (Hörbuch)
// 	echo("id3ren -tag -edit -tagonly -noyear -nocomment -album='$Album' -artist='$Artist' -song='$Titel' -track=$Track -genre=101 '$Datei'<br />\n");
// 	exec("id3ren -tag -edit -tagonly -noyear -nocomment -album='$Album' -artist='$Artist' -song='$Titel' -track=$Track -genre=101 '$Datei'");
	
               if($lenTrack == 1 || $lenTrack > 4) {
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
               if($lenTrack == 2) {
                if($tracknr < 9)
                    $tracknr = sprintf("0%s",($tracknr + 1));
//                 elseif($tracknr >= 9 && $tracknr < 99)
//                     $tracknr = sprintf("%s",($tracknr + 1));
                else
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
               if($lenTrack == 3) {
                if($tracknr < 9)
                    $tracknr = sprintf("00%s",($tracknr + 1));
                elseif($tracknr >= 9 && $tracknr < 99)
                    $tracknr = sprintf("0%s",($tracknr + 1));
                else
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
               if($lenTrack == 4) {
                if($tracknr < 9)
                    $tracknr = sprintf("000%s",($tracknr + 1));
                elseif($tracknr >= 9 && $tracknr < 99)
                    $tracknr = sprintf("00%s",($tracknr + 1));
                elseif($tracknr >= 99 && $tracknr < 999)
                    $tracknr = sprintf("0%s",($tracknr + 1));
                else
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
            }
        }
    }
    return $ausgabe;
}

// Hörbücher u. ä. - Aufruf per: mid3TagMp3AudioBook.php
function buildSites2b($batch)
{
$GUI = "ID3-tags-powered-by:ID3 by GitHub.com/ttimer/GUI-for-mID3v2";
$LNK = "https://GitHub.com/ttimer/GUI-for-mID3v2/";

    $genreini = "101";         // JS
    $trackini = "001";         // JS
    $ausgabe  = "";            // JS
    $tracknr  = "";            // JS
    $lenTrack = "";            // JS
    $trackpa  = "";            // JS
    $trackpo  = "";            // JS
    
    reset($batch);
    ksort($batch);             // JS sortiert Verzeichnisse (CD1, CD2 ...)
    
    if((!empty($_POST["track"]) || $_POST["track"] == 0) && isset($_POST["Xtrack"])) {
        $tracknr = $_POST["track"];
        if(strstr($tracknr, "/")) {
          $tracknr = str_replace(" ", "", $tracknr);
          $trackpa = explode("/", $tracknr, 2);
          $tracknr = $trackpa[0];
          $trackpo = "/" . $trackpa[1];
        }
    }
    if($tracknr == "") $tracknr = $trackini; 
    $lenTrack = strlen($tracknr); 

    foreach($batch as $key => $array) 
    {
        ksort($array);       // JS sortiert Dateien (0101.mp3, 0102.mp3... 0404.mp3 ...)
		
        foreach ($array as $key2 => $array1) 
        {
            if(!empty($batch[$key][$key2]['file'])){
//                 $size = number_format($batch[$key][$key2]['size'], 1, ',', '.');
//                 $date = date("d.m.Y, H:i:s", $batch[$key][$key2]['time']);
//                 $alt  = 'Datum: ' . $date . ' / Größe: ' . $size . 'KB'; 
                $path = $batch[$key]['name']['path'].$batch[$key][$key2]['file'];
//                 
//                 $ausgabe .= $path;
//                 $ausgabe .= " $tracknr <br />\n";
				
                $Artist = strtok($path, "/");    // erster Abschnitt $path ( ./ )
                $Artist = strtok("/");           // zweiter Abschnitt $path
                $Album  = strtok("/");           // dritter Abschnitt $path
                $Titel  = str_replace(".mp3", "", $batch[$key][$key2]['file']);
                $Titel  = str_replace("-", "", $Titel);
                $Titelt = $Titel; 
                $Track  = $tracknr . $trackpo;
                $Datei  = trim($path);
                
                $Artist  = trim($Artist);
                $Album   = trim($Album);
                $Titel   = trim($Titel);
                $Genre   = "101";                 // Speech (bspw. Hörbuch)
                $Year    = "";
        	$Comment = "";
        	$Picture = "";
                $Exe     = "";
                $Befehl  = "mid3v2";
                
                if(!empty($_POST["artist"]) && isset($_POST["Xartist"]))
                  $Artist = $_POST["artist"];
                if(!empty($_POST["album"]) && isset($_POST["Xalbum"]))
                  $Album = $_POST["album"];
                if(!empty($_POST["titel"]) && isset($_POST["Xtitel"])) {
                  if($_POST["titel"] == "%T")
                    $Titel = "$tracknr-" . $Titel; //$Titel = "$Track-" . $Titel;
                  else
                    $Titel = $_POST["titel"];
                  $Titel = str_replace("%T", $tracknr, $Titel); //$Titel = str_replace("%T", $Track, $Titel);
                  $Titel = str_replace("%t", $Titelt, $Titel);
                }
                if((!empty($_POST["genre"]) || $_POST["genre"] == 0) && isset($_POST["Xgenre"])) 
                  $Genre = $_POST["genre"];
                if($Genre == "") 
                  $Genre = $genreini; 
                if(!empty($_POST["year"]) && isset($_POST["Xyear"]))
                  $Year = $_POST["year"];
        	if(!empty($_POST["comment"]) && isset($_POST["Xcomment"]))
        	  $Comment = $_POST["comment"];
        	if(!empty($_POST["picture"]) && isset($_POST["Xpicture"]))
        	  $Picture = $_POST["picture"];
                
                if(isset($_POST["execute"]))
                  $Exe = $_POST["execute"];
                
                if(isset($_POST["Xartist"]))
                  $Befehl .= " -a '$Artist'";
                if(isset($_POST["Xalbum"]))
                  $Befehl .= " -A '$Album'";
                if(isset($_POST["Xtitel"]))
                  $Befehl .= " -t '$Titel'";
                if(isset($_POST["Xtrack"]))
                  $Befehl .= " -T '$Track'";
                if(isset($_POST["Xgenre"]))
                  $Befehl .= " -g '$Genre'";
                if(isset($_POST["Xyear"]))
                  $Befehl .= " -y '$Year'";
        	if(isset($_POST["Xcomment"]))
        	  $Befehl .= " -c '$Comment'";
        	if(isset($_POST["Xpicture"]))
        	  $Befehl .= " -p '$Picture'";
        	  
                $Anzeige = $Befehl . " '$Datei'";
                $Befehl .= " --WXXX '$GUI'";
                $Befehl .= " '$Datei'";
                
                // Batch-Anzeige
                echo "<p style='margin-left:7%;'>" . $Anzeige . "</p>\n"; //echo("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T $Track -g '$Genre' '$Datei'<br />\n");
                
                // Änderung durchführen
                if($Exe == "on")
                  exec($Befehl); //exec("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T $Track -g '$Genre' '$Datei'");
                
               if($lenTrack == 1 || $lenTrack > 4) {
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
               if($lenTrack == 2) {
                if($tracknr < 9)
                    $tracknr = sprintf("0%s",($tracknr + 1));
//                 elseif($tracknr >= 9 && $tracknr < 99)
//                     $tracknr = sprintf("%s",($tracknr + 1));
                else
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
               if($lenTrack == 3) {
                if($tracknr < 9)
                    $tracknr = sprintf("00%s",($tracknr + 1));
                elseif($tracknr >= 9 && $tracknr < 99)
                    $tracknr = sprintf("0%s",($tracknr + 1));
                else
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
               if($lenTrack == 4) {
                if($tracknr < 9)
                    $tracknr = sprintf("000%s",($tracknr + 1));
                elseif($tracknr >= 9 && $tracknr < 99)
                    $tracknr = sprintf("00%s",($tracknr + 1));
                elseif($tracknr >= 99 && $tracknr < 999)
                    $tracknr = sprintf("0%s",($tracknr + 1));
                else
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
            }
        }
    }
    return $ausgabe;
}

// Hörbücher u. ä. - Aufruf per: mid3TagMp3AudioBookP1.php (aktuell auch ..P1L)
// -- P1(!) :: Bild nur in erster MP3-Datei speichern
function buildSites2c($batch)
{
$GUI = "ID3-tags-powered-by:ID3 by GitHub.com/ttimer/GUI-for-mID3v2";
$LNK = "https://GitHub.com/ttimer/GUI-for-mID3v2/";

    $genreini = "101";         // JS
    $trackini = "001";         // JS
    $ausgabe  = "";            // JS
    $tracknr  = "";            // JS
    $lenTrack = "";            // JS
    $trackpa  = "";            // JS
    $trackpo  = "";            // JS
    
    reset($batch);
    ksort($batch);             // JS sortiert Verzeichnisse (CD1, CD2 ...)
    
    if((!empty($_POST["track"]) || $_POST["track"] == 0) && isset($_POST["Xtrack"])) {
        $tracknr = $_POST["track"];
        if(strstr($tracknr, "/")) {
          $tracknr = str_replace(" ", "", $tracknr);
          $trackpa = explode("/", $tracknr, 2);
          $tracknr = $trackpa[0];
          $trackpo = "/" . $trackpa[1];
        }
    }
    if($tracknr == "") 
      $tracknr = $trackini; 
    $lenTrack = strlen($tracknr); 

    foreach($batch as $key => $array) 
    {
        ksort($array);       // JS sortiert Dateien (0101.mp3, 0102.mp3... 0404.mp3 ...)
		
        foreach ($array as $key2 => $array1) 
        {
            if(!empty($batch[$key][$key2]['file'])){
//                 $size = number_format($batch[$key][$key2]['size'], 1, ',', '.');
//                 $date = date("d.m.Y, H:i:s", $batch[$key][$key2]['time']);
//                 $alt  = 'Datum: ' . $date . ' / Größe: ' . $size . 'KB'; 
                $path = $batch[$key]['name']['path'].$batch[$key][$key2]['file'];
//                 
//                 $ausgabe .= $path;
//                 $ausgabe .= " $tracknr <br />\n";
			
                $Artist = strtok($path, "/");    // erster Abschnitt $path ( ./ )
                $Artist = strtok("/");           // zweiter Abschnitt $path
                $Album  = strtok("/");           // dritter Abschnitt $path
                $Titel  = str_replace(".mp3", "", $batch[$key][$key2]['file']);
                $Titel  = str_replace("-", "", $Titel);
                $Titelt = $Titel; 
                $Track  = $tracknr . $trackpo;
                $Datei  = trim($path);
                
                $Artist  = trim($Artist);
                $Album   = trim($Album);
                $Titel   = trim($Titel);
                $Genre   = "101";                 // Speech (bspw. Hörbuch)
                $Year    = "";
        	$Comment = "";
        	$Picture = "";
                $Exe     = "";
                $Befehl  = "mid3v2";
                
                if(!empty($_POST["artist"]) && isset($_POST["Xartist"]))
                  $Artist = $_POST["artist"];
                if(!empty($_POST["album"]) && isset($_POST["Xalbum"]))
                  $Album = $_POST["album"];
                if(!empty($_POST["titel"]) && isset($_POST["Xtitel"])) {
                  if($_POST["titel"] == "%T")
                    $Titel = "$tracknr-" . $Titel; //$Titel = "$Track-" . $Titel;
                  else
                    $Titel = $_POST["titel"];
                  $Titel = str_replace("%T", $tracknr, $Titel); //$Titel = str_replace("%T", $Track, $Titel);
                  $Titel = str_replace("%t", $Titelt, $Titel);
                }
                if((!empty($_POST["genre"]) || $_POST["genre"] == 0) && isset($_POST["Xgenre"])) 
                  $Genre = $_POST["genre"];
                if($Genre == "") 
                  $Genre = $genreini; 
                if(!empty($_POST["year"]) && isset($_POST["Xyear"]))
                  $Year = $_POST["year"];
        	if(!empty($_POST["comment"]) && isset($_POST["Xcomment"]))
        	  $Comment = $_POST["comment"];
        	if(!empty($_POST["picture"]) && isset($_POST["Xpicture"]))
        	  $Picture = $_POST["picture"];
                
                if(isset($_POST["execute"]))
                  $Exe = $_POST["execute"];
                
                if(isset($_POST["Xartist"]))
                  $Befehl .= " -a '$Artist'";
                if(isset($_POST["Xalbum"]))
                  $Befehl .= " -A '$Album'";
                if(isset($_POST["Xtitel"]))
                  $Befehl .= " -t '$Titel'";
                if(isset($_POST["Xtrack"]))
                  $Befehl .= " -T '$Track'";
                if(isset($_POST["Xgenre"]))
                  $Befehl .= " -g '$Genre'";
                if(isset($_POST["Xyear"]))
                  $Befehl .= " -y '$Year'";
        	if(isset($_POST["Xcomment"]))
        	  $Befehl .= " -c '$Comment'";
        	if((isset($_POST["Xpicture"]) && $Picture != "") && 
        	   ($tracknr == "001" || $tracknr == $_POST["track"])) {
//         	  $pfad = $batch[$key]['name']['path'];
//         	  $pfad .= $Picture;
//         	  $Befehl .= " -p '$pfad'";  // funktioniert, aber KEIN Bild in <form>
        	  $Befehl .= " -p '$Picture'";
        	  }
        	  
                $Anzeige = $Befehl . " '$Datei'";
                $Befehl .= " --WXXX '$GUI'";
                $Befehl .= " '$Datei'";
                
                // Batch-Anzeige
                echo "<p style='margin-left:7%;'>" . $Anzeige . "</p>\n"; //echo("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T $Track -g '$Genre' '$Datei'<br />\n");
                
                // Änderung durchführen
                if($Exe == "on")
                  exec($Befehl); //exec("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T $Track -g '$Genre' '$Datei'");
                
               if($lenTrack == 1 || $lenTrack > 4) {
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
               if($lenTrack == 2) {
                if($tracknr < 9)
                    $tracknr = sprintf("0%s",($tracknr + 1));
//                 elseif($tracknr >= 9 && $tracknr < 99)
//                     $tracknr = sprintf("%s",($tracknr + 1));
                else
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
               if($lenTrack == 3) {
                if($tracknr < 9)
                    $tracknr = sprintf("00%s",($tracknr + 1));
                elseif($tracknr >= 9 && $tracknr < 99)
                    $tracknr = sprintf("0%s",($tracknr + 1));
                else
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
               if($lenTrack == 4) {
                if($tracknr < 9)
                    $tracknr = sprintf("000%s",($tracknr + 1));
                elseif($tracknr >= 9 && $tracknr < 99)
                    $tracknr = sprintf("00%s",($tracknr + 1));
                elseif($tracknr >= 99 && $tracknr < 999)
                    $tracknr = sprintf("0%s",($tracknr + 1));
                else
                    $tracknr = sprintf("%s",($tracknr + 1));
               }
            }
        }
    }
    return $ausgabe;
}

// Musikstücke/Songs (mp3-Dateien) - Aufruf per: mid3TagMp3Music.php
function buildSites3($batch)
{
$GUI = "ID3-tags-powered-by:ID3 by GitHub.com/ttimer/GUI-for-mID3v2";
$LNK = "https://GitHub.com/ttimer/GUI-for-mID3v2/";

    $genreini = "11";        // JS
    $trackini = "1";         // JS
    $tracknr  = $trackini;   // JS
    $ausgabe  = "";          // JS
    
    reset($batch);
    ksort($batch);   // JS sortiert Verzeichnisse (CD1, CD2 ...)
	
	foreach($batch as $key => $array) 
	{
		//$ausgabe .= '		<h3>'.$batch[$key]['name']['dir'].'</h3>' . "\n";
		//$ausgabe .= '		<ul>' . "\n";
		
		ksort($array); // JS sortiert Dateien (0101.mp3, 0102.mp3... 0404.mp3 ...)
		
		foreach ($array as $key2 => $array1) 
		{
		
			if(!empty($batch[$key][$key2]['file'])){
				$size			=	number_format($batch[$key][$key2]['size'], 1, ',', '.');
				$date			=	date("d.m.Y, H:i:s", $batch[$key][$key2]['time']);
				$alt			=	'Datum: ' . $date . ' / Größe: ' . $size . 'KB'; 
				$path			= $batch[$key]['name']['path'].$batch[$key][$key2]['file'];
				//$ausgabe	.= '			<li><a href="'.$path.'" target="_blank" title="'.$alt.'">';
				//$ausgabe .= $path . $batch[$key][$key2]['file'];
				$ausgabe .= $path;
				//$ausgabe .= '</a></li>' . "\n"; 
				$ausgabe .= " $tracknr <br />\n";
				
					
	$Album  = "";
	$Artist = strtok($batch[$key][$key2]['file'], "-"); // erster Abschnitt Dateiname;
	$Titel  = strtok(".");                              // zweiter Abschnitt Dateiname;
	$Track  = $tracknr;
	$Datei  = trim($path);
	
	$Album  = trim($Album);
	$Artist = trim($Artist);
	$Titel  = trim($Titel);
	$Genre  = "11";  // Oldies
// 	$Coment = "";
	$Exe    = "";
	//echo $Artist . $Album . $Titel .$Track . $Datei . "<br />\n";


	if(!empty($_POST["artist"]))
	  $Artist = $_POST["artist"];
        if(!empty($_POST["album"]))
	  $Album = $_POST["album"];
	if(!empty($_POST["titel"]))
	  $Titel = $_POST["titel"];
// 	if(!empty($_POST["track"]) || $_POST["track"] == 0)
// 	  $Track = $_POST["track"];
//         if($tracknr == "") 
//           $tracknr = $trackini; 
        if(!empty($_POST["genre"]) || $_POST["genre"] == 0)
          $Genre = $_POST["genre"];
        if($Genre == "") 
          $Genre = $genreini; 
// 	if(!empty($_POST["comment"]))
// 	  $Coment = $_POST["comment"];
	if(isset($_POST["execute"]))
	  $Exe = $_POST["execute"];
	
	//echo("mid3v2 -a '$_POST[artist]' -A '$_POST[album]' -t '$_POST[titel]' -T $_POST[track] -g $_POST[genre] '$Datei'<br />\n");
	//echo("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T $Track -g '$Genre' -c '$Coment' '$Datei'<br />\n");
	echo("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T '$Track' -g '$Genre' '$Datei'<br />\n");
	if($Exe == "on")
	  exec("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T '$Track' -g '$Genre' --WXXX '$GUI' '$Datei'");
	  //exec("mid3v2 -a '$Artist' -A '$Album' -t '$Titel' -T $Track -g '$Genre' -c '$Coment' '$Datei'");
	//exec("mid3v2 -a '$Artist' -A 'Moerderische Cote d Azur' -t '$Titel' -T $Track -g 101 '$Datei'");
	
// 	// Genre 101 == Speech (Hörbuch)
// 	echo("id3ren -tag -edit -tagonly -noyear -nocomment -album='$Album' -artist='$Artist' -song='$Titel' -track=$Track -genre=101 '$Datei'<br />\n");
// 	exec("id3ren -tag -edit -tagonly -noyear -nocomment -album='$Album' -artist='$Artist' -song='$Titel' -track=$Track -genre=101 '$Datei'");
	

	
// 				if($tracknr < 9)
// 				  $tracknr = sprintf("00%s",($tracknr + 1));
//                                 elseif($tracknr >= 9 && $tracknr < 99)
// 				  $tracknr = sprintf("0%s",($tracknr + 1));
//                                 else
//                                   $tracknr = sprintf("%s",($tracknr + 1));
			}

		}
		//$ausgabe .= '		</ul>' . "\n";
	}
	
	//$ausgabe .= '	</div>' . "\n";
	//$ausgabe .= '</div>' . "\n";

	return $ausgabe;
}

/**
 * Füllt das Array mit den Dateiinformationen
 * (Pfad, Verzeichnisname, Dateiname, Dateigröße, letzte Aktualisierung
 *
 * @param		string	$dir 				Pfad zum Verzeichnis
 * @param		string	$file				enthält den Dateinamen
 * @param		string	$onlyDir		Enthält den Verzeichnisnamen für die Überschrift
 *															über den Bildernamen
 * @param		array		$type				aufzulistende Bildtypen
 *															genommen, ansonsten der Pfad
 * 															Default: FALSE
 * @param		bool		$allFiles		Listet alle Dateien in den Verzeichnissen auf
 *															ohne Rücksicht auf $type	
 * @param		array		$pictures		Enthält den Inhalt der Verzeichnisstruktur
 *
 * @return	array								Das Array mit allen Dateinamen						
 */
function buildArray($dir,$file,$onlyDir,$type,$allFiles,$pictures)
{
	$typeFormat = FALSE;
			
	foreach ($type as $item)
  {
  	if (strtolower($item) == substr(strtolower($file), -strlen($item)))
			$typeFormat = TRUE;
	}

	if($allFiles || $typeFormat == TRUE)
	{
		if(empty($onlyDir))
			$onlyDir = substr($dir, -strlen($dir), -1);

		$pictures[$dir]['name']['dir']	= $onlyDir;
		$pictures[$dir]['name']['path']	= $dir;
		$pictures[$dir][$file]['file']	= $file;
		$pictures[$dir][$file]['size']	= filesize($dir.$file) / 1024;
		$pictures[$dir][$file]['time']	= filemtime($dir.$file);
	}
	
	return $pictures;
}

/**
 * Durchläuft rekursiv das zu durchsuchende Verzeichnis
 *
 * @param		string	$dir 				Pfad zum Verzeichnis
 * @param		array		$type				aufzulistende Bildtypen
 * @param		bool		$only				Bei den Überschriften wird nur der Verzeichnisname
 *															genommen, ansonsten der Pfad
 * 															Default: FALSE
 * @param		bool		$allFiles		Listet alle Dateien in den Verzeichnissen auf
 *															ohne Rücksicht auf $type	
 *															Default:	FALSE
 * @param		bool		$recursive	Durchläuft rekursiv alle Verzeichnisse und Unterverzeichnisse
 *															Default:	TRUE
 * @param		string	$onlyDir		Enthält den Verzeichnisnamen für die Überschrift
 *															über den Bildernamen
 * @param		array		$pictures		Enthält als Verweis(Referenz) den Inhalt der Verzeichnisstruktur
 *
 * @return	mixed								false im Fehlerfall, ansonsten ein Array mit allen Dateinamen						
 */
 					
function scan_dir($dir, $type=array(),$only=FALSE, $allFiles=FALSE, $recursive=TRUE, $onlyDir="", &$pictures)
{
  //echo $dir; echo "<br />\n";
	$handle = @opendir($dir);
	
	if(!$handle)
		return false;

        // HIER [scandir] verwenden und dann über das sortierte(!) Array gehen 
        // - anstatt das unsortierte [readdir]
		
	while ($file = @readdir ($handle))
	{
// 		if (eregi("^\.{1,2}$",$file))      // JS
// 		{
// 			continue;
// 		}
		if ($file == "." || $file == "..") // JS
		{
			continue;
		}
		
		if(!$recursive && $dir != $dir.$file."/")
		{
			if(is_dir($dir.$file))
				continue;
		}
		
		if(is_dir($dir.$file))
		{
			scan_dir($dir.$file."/", $type, $only, $allFiles, $recursive, $file, $pictures);
		}
		else
		{
			if($only)
				$onlyDir = $dir;
			$pictures = buildArray($dir,$file,$onlyDir,$type,$allFiles,$pictures);
		}
	}

	@closedir($handle);

	return $pictures;
  
}
?>