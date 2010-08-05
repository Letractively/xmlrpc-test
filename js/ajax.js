// global vars
var MethodList;
var currentFieldID = 1;

// get methods and info from server
function getMethods()
{
    // get server vars
    var server= $("#server_adress").val();
    var path = $('#server_path').val();
    var port = $('#server_port').val();

    // show loading-picture
    $('#load_image').show();

    // get array
    $.getJSON( "ajax.php", {f: "getMethods", srv: server, path: path, prt: port},
        function(json)
        {
            // check json-return-value
            if(json)
            {
                // got we some response
                if(json.success == 'false')
                    setError(json.err);
                else
                {
                  //allright, we got the methods
                  setError('');
                  MethodList = json.methods;
                  setMethodsToListbox();
                }
                
            }
            else
                setError("response is null");

            // hide loading-picture
            $('#load_image').hide();
        });
}

// set methods to listbox
function setMethodsToListbox()
{
    //@todo: check list

    //@todo: clear list
    
    // fill
    $.each(MethodList, function(index, itemData)
        {
            var option = "<option value='" + index + "' >" +
                itemData.ret + " " + itemData.name + "(" + itemData.param + ")" +
                "</option>";
            $('#methodList').append(option);
        });

    // show info-box
    setInfo(MethodList.length + ' methods were successful received from server.');
}

// get a response for a method from server
function getResponse()
{
    // get server vars
    var server= $("#server_adress").val();
    var path = $('#server_path').val();
    var port = $('#server_port').val();
    var method = $('#method').val();

    // show loading-picture
    $('#load_image').show();

    // get array
    $.getJSON( "ajax.php", {f: "getResponse", srv: server, path: path, prt: port, m: method},
        function(json)
        {
            // check json-return-value
            if(json)
            {
                // got we some response
                if(json.success == 'false')
                    setError(json.err);
                else
                {
                  //allright, we got the methods
                  setError('');
                  $('#outbox').val(json.response);
                }

            }
            else
                setError("response is null");

            // hide loading-picture
            $('#load_image').hide();
        });
}

// add new param-field
function addParamField(param_type)
{
    //  and delete "no parameters"-text if neccessary
    if(currentFieldID == 0)
            $('#params').html('');

    // increase currentFieldID
    currentFieldID++;

    // set param_type
    if(typeof(param_type) == "string")
        param_type = " : " + param_type;
    else
        param_type = '';

    // build field html
    var field = "<div id='param" + currentFieldID + "' style='display:none;'>param " 
        + currentFieldID + param_type +"<br/><input type='text' name='param"
        + currentFieldID +"' /></div>";

    // append field und unset focus
    $('#params').append(field);
    $('#param' + currentFieldID).show(200);
    $('#button_add').blur();
}

// remove param-field
function removeParamField()
{
    //check if we have some fields
    if(currentFieldID > 0)
        // remove last field
        $('#param' + currentFieldID).hide(300,
            function()
            {
                // decrease and remove
                $('#param' + currentFieldID--).remove();
                
                // set info-text, if no parameters are set
                if(currentFieldID == 0)
                   $('#params').html("no parameter : ()");
            });

    //unset focus
    $('#button_remove').blur();
}

// clears all parameters
function clearParamList()
{
    var listlen = currentFieldID;
    for(i=0; i < listlen; i++)
        removeParamField();
}

// set list-selection
function setListSelection()
{
    // set to custom?
    if($('#methodList').val() == 'custom')
    {
        // set names to defaults
        $('#method_name').html('custom method');
        $('#output_name').html('output');

        // enable editing
        $('#method').removeAttr("disabled");
        $('#button_add').button( "option", "disabled", false );
        $('#button_remove').button( "option", "disabled", false );
    }
    // otherwise set name, ehlp and parameters
    else
    {
        // set name
        var methodname = MethodList[$('#methodList').val()].name;
        $('#method_name').html('method : ' + methodname);
        $('#method').val(methodname);

        // set parameters
        clearParamList();
        $.each( MethodList[$('#methodList').val()].param.split(','),
            function(index, itemData)
            {
                if(trim(itemData) != '')
                addParamField(trim(itemData));
            });

        // set output-name
        var out_type = MethodList[$('#methodList').val()].ret;
        $('#output_name').html('output : ' + out_type);

        // disable editing
        $('#method').attr("disabled","disabled");
        $('#button_add').button( "option", "disabled", true );
        $('#button_remove').button( "option", "disabled", true );
    }
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

// show/hide info-box
function setInfo(info_text)
{
    if(info_text == '')
    {
        $('#info_text').html("");
        $('#info').hide();
    }
    else
    {
        $('#info_text').html(info_text);
        $('#info').show();
    }
}

// trim a string
function trim (str)
{
  return str.replace (/^\s+/, '').replace (/\s+$/, '');
}



