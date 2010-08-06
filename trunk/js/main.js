// initializing after loading the page
$(document).ready(function()
{
    // set jquery-ui-design
    $("#button_send").button();
    $("#button_methods").button();
    $("#button_add").button({ text: false ,  icons: {primary:'ui-icon-plus'}});
    $("#button_remove").button({ text: false ,  icons: {primary:'ui-icon-minus'}});
    $("#outbox").resizable();

    // set functions to buttons
    $('#button_add').click(addParamField);
    $('#button_remove').click(removeParamField);
    $('#button_methods').click(getMethods);
    $('#button_send').click(getResponse);

    // set function to drop-down-list
    $('#methodList').change(setListSelection);

    // reset form (necessary after reload)
    resetForm();
});


