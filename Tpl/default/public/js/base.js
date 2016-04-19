/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    $(".ajaxlink").live("click", function(){
        var url = $(this).attr("ajax-url") || $(this).attr("href");
        var msg = $(this).attr("ajax-confirm");
        var $fill = $("#"+$(this).attr("ajax-fill"));
        if(msg){
            if(!confirm(msg)){
                return false;
            }
        }
        $.get(url, {data: $(this).attr("ajax-data")}, function(request){
            if(request.status == 1){
                $fill.html(request.data).modal({
                    backdrop: true,
                    keyboard: true,
                    show: true
                });
            }else{
                alert(request.info);
            }
        }, "json");
        return false;
    });
    
    $(".allcheck").click(function(){
        if($(this).is(":checked")){
            $("input[type=checkbox][name^=childbox]").attr("checked", true);
        }else{
            $("input[type=checkbox][name^=childbox]").attr("checked", false);
        }
    });    
});



