$(document).ready(function(){
    area2=new nicEditor({fullPanel : true}).panelInstance('contenidoMail'); 
    $(document).on("submit", "form", function(event){event.preventDefault(); 
        var url=$(this).attr("action"); 
        $.ajax({
            url: url, 
            type: 'POST', 
            data: new FormData(this), 
            processData: false, 
            contentType: false, 
            beforeSend: function(){
                $('#cargando').show();
            }, 
            success: function (data, status){
                $('#cargando').hide(); 
                console.log(data); 
                alert('Mails enviados con exito');
            }, 
            error: function (xhr, desc, err){
                $('#cargando').hide(); 
                console.log("xD");
            }
        });
    });
});