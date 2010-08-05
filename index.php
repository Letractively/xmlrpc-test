<?php
         
// IMPORT
require_once 'functions.php';

// VARS
$VERSION = "0.5.0";

// write html-header
$css = array('css/style.css', 'css/ui-darkness/jquery-ui-1.8.2.custom.css');
$js = array('js/jquery-1.4.2.min.js', 'js/jquery-ui-1.8.2.custom.min.js',
        'js/ajax.js', 'js/main.js');
echo writeXHTMLHeader("xmlrpc-test-tool", $css, $js);

// title / begin of container
echo "<div id='container'>";
echo "<img id='load_image' src='./css/img/ajax_loader.gif' alt='Loading...' />";
echo "<h1 id='head'>xmlrpc-test-tool</h1>";

// input for server
echo "<div id='server'>";
echo "<div class='info'>";
echo "<label id='label_adress' for='server_adress'>XMLRPC-Server</label>";
echo "<label id='label_path' for='server_path'>Path</label>";
echo "<label id='label_port' for='server_port'>Port</label></div>";
echo "<div class='field'>";
echo "<input id='server_adress' type='text' />";
echo "<input id='server_path' type='text'/>";
echo "<input id='server_port' type='text' value='80' /></div>";
echo "</div>";

// controls
echo "<div id='controls'>";
echo "<select name='method' id='methodList'>";
echo "<option value='custom'>Custom Method...</option>";
echo "</select>";
echo "<button id='button_methods'>get methods from server</button>";
echo "</div>";

// input
echo "<table id='input'><tr>";
echo "<td width='210px'><strong id='method_name'>custom method</strong><br/><input type='text' id='method' /></td>";
echo "<td id='params' width='270px'><div id='param1'>param 1<br/><input type='text' name='param1' /></div></td>";
echo "<td class='add_rm'><button id='button_add'></button><br />";
echo "<button id='button_remove'></button></td>";
echo "<td width='110px' class='send'><button id='button_send'>send</button></td>";
echo "</tr></table>";

// error
echo "<div id='error' class='ui-state-error ui-corner-all'>";
echo "<span style='float: left; margin-right: 0.3em;' class='ui-icon ui-icon-alert'></span>";
echo "<span id='error_text'></span>";
echo "</div>";

// info
echo "<div id='info' class='ui-state-highlight ui-corner-all'>";
echo "<span style='float: left; margin-right: 0.3em;' class='ui-icon ui-icon-info'></span>";
echo "<span id='info_text'></span>";
echo "</div>";

// output
echo "<div id='output'>";
echo "<strong id='output_name'>output</strong><br />";
echo "<textarea id='outbox' name='out' rows='8' cols='auto'></textarea>";
echo "</div>";

// footer
echo "<div id='footer'><a href='http://code.google.com/p/xmlrpc-test/'>xmlrpc-test-tool</a> | ";
echo "by <a href='mailto:Tom Schreiber <development@tomhost.de>?Subject=xmlrpc-test-tool (v$VERSION)'>tom schreiber</a> ";
echo "| <a href='history.txt'>v$VERSION</a></div>";

// end of container
echo "</div>";

// write footer
echo writeXHTMLFooter();
?>

