<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Frames list of mid3v2 (Mutagen)</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta property="og:url" content="https://smolka.lima-city.de/">
    <meta name="author" content="Jürgen Smolka">
    <style type="text/css">
      body { margin-left:5%; margin-right:5%; font-size:1.1em; }
      td { padding-left:11px; padding-right:11px; vertical-align:top; }
      h4 { color:red; font-weight:bold; }
      .m { font-family:monospace; font-size:1.3em; }
      .u { white-space:nowrap; }
      </style>
  </head>
  <body>
    <h2>Frames (tags) supported by mid3v2</h2>
    <table border="1">
      <tr><td>
        <?php 
        $frame = "";
        $shellBefehl = "mid3v2 -f";
        exec($shellBefehl, $frame);
        if(!$frame)
          echo '<h4>No data fetched ...</h4><p>Try <b>mid3v2 -L</b> on konsole!</p>';
        foreach ( $frame as $strKey => $strValue ) {
          echo '<b><span class="u">';
          echo '<b><span class="m">' . substr($strValue,6,4) . '</span>&nbsp; '; 
          echo substr($strValue,14) . "</span></b><br>\n";
          if($strKey == 35 || $strKey == 71 || $strKey == 107 || $strKey == 143) 
            echo '</td><td>';
        }
        //simpel: echo '<b>' . $strValue . '</b><br>' . "\n";
        ?>
      </td></tr>
    </table>
  </body>
</html>
