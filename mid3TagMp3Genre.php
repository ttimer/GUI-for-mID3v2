<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Genres list of mid3v2 (Mutagen)</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta property="og:url" content="https://smolka.lima-city.de/">
    <meta name="author" content="Jürgen Smolka">
    <style type="text/css">
      body { margin-left:5%; margin-right:5%; font-size:1.1em; }
      td { padding-left:11px; padding-right:11px; vertical-align:top; }
      h4 { color:red; font-weight:bold; }
      .u { white-space:nowrap; font-weight:bold; }
    </style>
  </head>
  <body>
    <p><h2 style="display:inline;">Genres list of mid3v2</h2>
    &nbsp; (Standard 2020-10-10: <b>TCON&nbsp;0</b> ... <b>TCON&nbsp;125</b> - see 
    <a href="https://id3.org/id3v2.3.0#Appendix_A_-_Genre_List_from_ID3v1" target="id3org">ID3.org</a>
     / <a href="https://en.wikipedia.org/wiki/List_of_ID3v1_Genres" target="wiki">wikipedia</a>)</p>
    <table border="1">
      <tr><td>
        <?php 
        $genre = "";
        $block = 39;
        $bstep = $block + 1;
        $shellBefehl = "mid3v2 -L";
        exec($shellBefehl, $genre);
        if(!$genre)
          echo '<h4>No data fetched ...</h4><p>Try <b>mid3v2 -L</b> on konsole!</p>';
        foreach ( $genre as $strKey => $strValue ) {
          echo '<span class="u">' . $strValue . '</span><br>' . "\n";
          if($strKey == $block) {
            echo '</td><td>';
            $block = $block + $bstep;
          }
        }
        ?>
      </td></tr>
    </table>
  </body>
</html>