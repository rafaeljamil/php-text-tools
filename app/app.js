$(document).ready(function(){
    $("#formulario").submit(function(e){
        e.preventDefault()
        var form = $(this).serialize()
        $.ajax({
            type: 'POST',
            url: './app/app.php?aa=ok',
            data: form,
            dataType: 'text',
            success: function(res){
                $("#resultado").val(res)
            }
        })
    })
})