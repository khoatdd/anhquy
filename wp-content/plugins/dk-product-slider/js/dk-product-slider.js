$(function(){
    $('.overlay').each(function(){
        var link = $(this).attr("data");
        console.log(link);
        $(this).click(function(){
            $(location).attr("href",link);
        });
    });
});