// get methods and info from server
function getMethods()
{
    // get server vars
    var server= $("#server").val();
    var path = $('#server_path').val();
    var port = $('#port').val();

    // get array
    $.getJSON( "ajax.php", {f: "getMethods", srv: server, path: path, prt: port},
        function(json)
        {
            if(json)
            {
                if(json.success == 'false')
                    setError(json.err);
                else
                {
                  $("#out").val(json.success);
                }
                
            }
            else
                setError("response is null");
        });
}

// show/hide error-box
function setError(err_text)
{
    if(err_text == '')
    {
        $('#error_text').html("");
        $('#error').hide();
    }
    else
    {
        $('#error_text').html("<strong>Error:</strong> " + err_text);
        $('#error').show();
    }
}


