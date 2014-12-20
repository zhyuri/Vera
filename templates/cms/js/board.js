var loading =  '<div class="spinner">\
                  <div class="rect1"></div>\
                  <div class="rect2"></div>\
                  <div class="rect3"></div>\
                  <div class="rect4"></div>\
                  <div class="rect5"></div>\
                </div>';

$(document).ready(function(){

    //加载面板
    $('#models').find('button').on('click',function(){
        $('#panel').html(loading);
        var url = "http://120.24.83.112/cms/board/panel/" + $(this).attr('data-model');
        $('#panel').load(url);
    })


});
