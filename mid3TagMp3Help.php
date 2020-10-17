<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Help for mid3v2 (Mutagen)</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta property="og:url" content="https://smolka.lima-city.de/">
    <meta name="author" content="Jürgen Smolka">
    <style type="text/css">
      body { margin-left:5%; margin-right:5%; font-size:1.3em; }
      td { padding-left:11px; padding-right:11px; vertical-align:top; }
      h4 { color:red; font-weight:bold; }
      .m { font-family:monospace; font-size:1.3em; }
      .u { white-space:nowrap; }
      </style>
  </head>
  <body onload="ladenaus();">
    <a name="top"></a>
    <noscript style="text-align:center;"><h1>Please activate JavaScript</h1></noscript>
    <?php
      $command = "mid3v2 --help";
      if(!empty($_POST["command"]))
        $command = $_POST["command"];
    ?>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" style="margin-left:11%;" onsubmit="ladenein();">
      <p>
       command: <input type="text" name="command" style="width:777px;" value="<?php echo $command ?>" required />
      </p>
      <p>
        <input type="submit" name="submit" value="submit" style="width:911px;" />
      </p>
    </form>
    <p style="margin-left:11%;"><img name="load" src="loading.gif" width="44" height="44" alt="loading"></p>
    <script type="text/javascript">
      function ladenaus() { document.load.style.display = "none"; } 
      function ladenein() { document.load.style.display = "block"; } 
    </script>

    <table border="0">
      <tr><td>
        <?php 
        if (isset($_POST["submit"])) {
          $data = "";
          $shellBefehl = $command;
          exec($shellBefehl, $data);
          if(!$data)
            echo '<h4>No data fetched ...</h4><p>Try <b>' . $command . '</b> on konsole!</p>';
          echo '<pre>';
          foreach ( $data as $strKey => $strValue ) {
            echo '<b>' . $strValue . '</b><br>' . "\n";
          }
        }
        ?>
        </pre>
      </td></tr>
    </table>
  </body>
</html>