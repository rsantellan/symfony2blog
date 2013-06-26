translatorManager = function(options){
	this._initialize();

}

translatorManager.instance = null;

translatorManager.getInstance = function (){
	if(translatorManager.instance == null)
		translatorManager.instance = new translatorManager();
	return translatorManager.instance;
}

translatorManager.prototype = {
    _initialize: function(){
        
    },
    
    sendGetTranslations: function(form)
    {
        var my_waiting_noty = callNoty("Procesando", "information");
        $.ajax({
          url: $(form).attr('action'),
          data: $(form).serialize(),
          type: $(form).attr('method'),
          dataType: 'json',
          success: function(json){
              if(json.status == "OK")
              {
                $("#bundles_container_error").html("");
                $("#bundles_texts_container").html(json.options.html);
              }
              else
              {
                $("#bundles_container_error").html(json.options.message);
                $("#bundles_texts_container").html("");
              }
          }, 
          complete: function()
          {
            my_waiting_noty.close();
          }
        });
        return false;
    },
    
    sendPutTranslations: function(form)
    {
        var my_waiting_noty = callNoty("Procesando", "information");
        $.ajax({
          url: $(form).attr('action'),
          data: $(form).serialize(),
          type: $(form).attr('method'),
          dataType: 'json',
          success: function(json){
              if(json.status == "OK")
              {
                callNoty("Cambios guardados correctamente", 'success');
              }
              else
              {
                callNoty("Errores al guardar", 'alert');
              }
          }, 
          complete: function()
          {
            my_waiting_noty.close();
          }
              
        });
        return false;
    },
    
    doChanges: function(myUrl)
    {
        var my_waiting_noty = callNoty("Procesando", "information");
        $.ajax({
          url: myUrl,
          type: 'get',
          dataType: 'json',
          success: function(json){
              if(json.status == "OK")
              {
                callNoty("Cambios aplicados correctamente", 'success');
              }
          }, 
          complete: function()
          {
            my_waiting_noty.close();
          }
              
        });
        return false;
    }
}


function callNoty(message, status)
{
  var timeout = 1000;
  var noty_id = noty({
    text: message,
    layout: 'center',
    timeout: timeout,
    type: status
  });
  return noty_id;
}