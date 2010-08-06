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
if($func == 'getMethods' && isset($_GET['srv']) )
{
    // get method-array
    $result = getMethods($_GET['srv']);

    // check for success
    if(!is_array($result))
    {
        // set err-text in JSON
        $json = '{"success" : "false", "err" : '.json_encode($result).' }';
    }
    else
    {
        // convert array to json-format
        $methods = '';
        foreach($result as $m)
        {
            if($methods!="") $methods .= ", ";
            $methods .= '{"name" : '.json_encode($m['method']).
                ', "ret" : '.json_encode($m['return']).
                ', "param" : '.json_encode($m['param']).
                ', "help" : '.json_encode($m['help']).'}';
        }

        $json = '{"success" : "true", "methods" : ['.$methods.']}';
    }

    echo $json;
}

// get response from server
if($func == 'getResponse' && isset($_GET['srv']) && isset($_GET['m']) )
{
    require_once 'lib/xmlrpc.inc';

    // prepare parameter-array
    $params = array();
    if(isset($_GET['p']) && is_array($_GET['p']))
    {
        $params_raw = $_GET['p'];
        for ($i = 0; $i < count($params_raw); $i=$i+2)
            array_push($params, array('type' => $params_raw[$i], 'value'=>$params_raw[$i+1]));
    }

    // get response-array
    $result = callServer($_GET['srv'], $_GET['m'], $params);

    // check for success
    if($result['success'] == false)
    {
        // set err-text in JSON
        $json = '{"success" : "false", "err" : '.json_encode($result['err']).' }';
    }
    else
    {
        // serialize response
        $response =  json_encode($result['xmlrpc']->value()->serialize());

        // convert array to json-format
        $json = '{"success" : "true", "response" : '.$response.'}';
    }

    echo $json;
}

?>
