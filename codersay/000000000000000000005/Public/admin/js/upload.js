$(document).ready(function(){
    $("#addupload").click(function(){
        $("#other").clone().insertAfter("#upload");
        $("#other").show();
    });
});

