<?php
         
// IMPORT
require_once 'functions.php';

// VARS
$VERSION = "0.4.1";

// write header
$css = array('css/style.css', 'css/ui-darkness/jquery-ui-1.8.2.custom.css');
$js = array('js/jquery-1.4.2.min.js', 'js/jquery-ui-1.8.2.custom.min.js',
        'js/ajax.js', 'js/main.js');
echo writeXHTMLHeader("XMLRPC-Test", $css, $js);
echo "<h1>XMLRPC-Test</h1>";

// input for server
echo "<div class='server_adress'>";
echo "<strong>XMLRPC-Server</strong>";
echo "<input id='server' type='text' />";
echo "<strong>Path</strong>";
echo "<input id='server_path' type='text'/>";
echo "<strong>Port</strong>";
echo "<input id='port' type='text' value='80' /><br />";
echo "</div>";

// controls
echo "<div class='controls'>";
echo "<button onclick='getMethods()'>get methods from server</button>";
echo "</div>";

// error
echo "<div id='error' class='ui-state-error ui-corner-all'>";
echo "<span style='float: left; margin-right: 0.3em;' class='ui-icon ui-icon-alert'></span>";
echo "<span id='error_text'></span>";
echo "</div>";

// output
echo "<div class='output'>";
echo "<strong>output</strong><br />";
echo "<textarea id='out' name='out' rows='5'></textarea>";
echo "</div>";

getMethods("www.tu-chemnitz.de", "/verwaltung/vlvz/xmlrpc.php", 80);

// footer
echo "<div class='footer'>xmlrpc test-tool | by tom schreiber | $VERSION</div>";

// write footer
echo writeXHTMLFooter();
?>

