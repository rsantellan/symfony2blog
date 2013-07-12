/***************************************************
			Camera Slider
***************************************************/
jQuery.noConflict()(function($){
    $('#camera_wrap_1').camera({
        thumbnails: false,
        pagination: false,
        loader: 'bar',
        loaderPadding: 0,
        loaderStroke: 3,
        pagination: true,
        loaderColor: '#7d7d7d'
    });
});