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
        $.ajax({
          url: $(form).attr('action'),
          data: $(form).serialize(),
          type: $(form).attr('method'),
          dataType: 'json',
          success: function(json){
              
          }
              
        });
        return false;
    }
}
