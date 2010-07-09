<?php

/**
 *  writeXHTMLHeader($title, $css_array, $script_array)
 *
 * @param      $title        title of page
 * @param      $css_array    array of css-file-paths
 * @param      $script_array array of js-file-paths
 *
 *@return     (string) xhtml-valid header
*/
function writeXHTMLHeader($title, $css_array='', $script_array='')
{
    $xhtml = '<?xml version="1.0" ?>';
    $xhtml .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"';
    $xhtml .= '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    $xhtml .= '<html xmlns="http://www.w3.org/1999/xhtml"><head>';
    $xhtml .= "<title>$title</title>";

    //CSS einbinden
    if(is_array($css_array))
        foreach($css_array as $css)
           $xhtml .= '<link rel="stylesheet" type="text/css" href="'.$css.'" media="screen,print" title="screen" />';

    //Skripte einbinden
    if(is_array($script_array))
        foreach($script_array as $script)
           $xhtml .= '<script src="'.$script.'" type="text/javascript"></script>';

    $xhtml .= '</head><body>';

    return $xhtml;
}

/**
 *  writeXHTMLFooter: write
 *
 * @return     (string) xhtml-valid footer
*/
function writeXHTMLFooter()
{
    return '</body></html>';
}

/**
 *  callServer($server, $port, $method, $params)
 *
 * @param      $server  server
 * @param      $path    server-path
 * @param      $port    server-port
 * @param      $method  method-name
 * @param      $params  method-params
 *
 * @return     (string) response-array ('success', ['xmlrpcval' |'err'])
 *              if 'success'==true -> xmlrpcval is given as 'xmlrpcval'
 *              otherwise you got an error-text as 'err'
*/
function callServer($server, $path, $port, $method, $params='')
{
    require_once 'lib/xmlrpc.inc';

    // init client with server-parameters
    $client = new xmlrpc_client($path, $server, $port);

    // prepare parameters (if needed)
    $parameter_valid = array();
    if(is_array($params))
    {
        foreach($params as $value)
            array_push($parameter_valid, new xmlrpcval($value['value'], $value['key']));
    }
    
    // prepare message for server (w/ ord w/o parameters)
    if(count($parameter_valid) > 0)
        $message = new xmlrpcmsg($method, $parameter_valid);
    else
        $message = new xmlrpcmsg($method);

    // send message to server
    $result = $client->send($message);

    // check response and create response-array
    if (!$result)
       $ret_array = array('success'=>false, 
           "err" => "Could not connect to server.");
    elseif ($result->faultCode())
       $ret_array = array('success'=>false,
               "err" => "XML-RPC Fault #".$result->faultCode().": ".$result->faultString());
    else
       $ret_array = array('success'=>true, "xmlrpcval" => $result->value()->scalarVal());

    // resturn response-array
    return $ret_array;
}

/**
 *  getMethods($server, $port)
 *
 * @param      $server  server-adress
 * @param      $path    server-path
 * @param      $port    server-port
 *
 * @return     (string) methodarray
*/
function getMethods($server, $path, $port)
{
    require_once 'lib/xmlrpc.inc';

    // get response from server
    $func = "system.listMethods";
    $response = callServer($server, $path, $port, $func);

    // put response in array
    if($response['success'])
    {
        $result=array();
        foreach ($response['xmlrpcval'] as $xmlrpcval)
        {
            $method = $xmlrpcval->scalarVal();

             // get signature of method
            $func = "system.methodSignature";
            $res_sig = callServer($server, $path, $port, $func, array(array("type" => "string", "value" => $method)));
            $sig = "";
            $ret = "";

            // format signature
            if ($res_sig['success'] && is_array($res_sig['xmlrpcval']))
            {
                $param_array = $res_sig['xmlrpcval'][0]->scalarVal();

                //Erster Parameter ist Rückgabetyp
                $ret = $param_array[0]->scalarVal();

                // Restliche Parameter sind Aufrufparameter
                
                for($i=1; $i < count($param_array); $i++)
                {
                    if($i > 1) $sig .= ", ";
                    $sig .= $param_array[1]->scalarVal();
                }
            }

            //get description of method
            $func = "system.methodHelp";
            $res_doc = callServer($server, $path, $port, $func, array(array("type" => "string", "value" => $method)));
            $doc = "";

            // check success of response and get documentation
            if($res_doc['success']) $doc = $res_doc['xmlrpcval'];

            // push results in array
            array_push($result, array('method' => $method, 'return' => $ret, 'param' => $sig, 'help' => $doc ));
        }
    }
    else
    {
        $result = $response['err'];
    }

    // return response
    return $result;
}

?>
