$(document).ready(function(){
   
    var href = 'index.php/' + $("meta[name='menuUrl']").attr("content"); ;
    var aElement = $('a[href$="'+href+'/"]:first');
    var liElement = $(aElement).closest("li.sub-menu");
    $(liElement).find("a :first").click();
    $(aElement).addClass("active");
    
});