<?php
/* AJAX-Interface
 */

require_once('functions.php');

// JSON-header
header("content-type: text/javascript; charset=iso-8859-1");

// get function
if(isset($_GET['f']))
    $func = $_GET['f'];
else
    $func = '';

// get xmlrpc-method-list from server
if($func == 'getMethods' && isset($_GET['srv']) && isset($_GET['path']) && isset($_GET['prt']) )
{
    // get method-array
    $result = getMethods($_GET['srv'], $_GET['path'], $_GET['prt']);

    // check for success
    if(!is_array($result))
    {
        // set err-text in JSON
        $json = '{"success" : "false", "err" : "'.$result.'" }';
    }
    else
    {
        // convert array to json-format
        $methods = '';
        foreach($result as $m)
        {
            if($methods!="") $methods .= ", ";
            $methods .= '{"name" : "'.$m['method'].'", "ret" : "'.$m['return'].'",
                "param" : "'.$m['param'].'", "help" : "'.$m['help'].'"}';
        }

        $json = '{"success" : "true", "methods" : ['.$methods.']}';
    }

    echo $json;
}

// get response from server
if($func == 'getResponse' && isset($_GET['srv']) && isset($_GET['prt']) && isset($_GET['m']) && isset($_GET['p']) )
{

}

?>
