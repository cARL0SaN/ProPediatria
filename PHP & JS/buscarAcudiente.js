$(document).ready(function() {
    $('#ide').blur(function() {
        var valor = $(this).val();
        if (valor !== '') {
            $.ajax({
                url: 'PHP & JS/buscarAcudiente.php',
                type: 'POST',
                data: {ident: valor}, // Usar 'ident' en lugar de 'valor'
                success: function(response) {
                    var datos = JSON.parse(response);
                    $('#nom').val(datos.nom_persona);
                    $('#ape').val(datos.ape_persona);
                    $('#cor').val(datos.correo_persona);
                    $('#tele').val(datos.telefono_persona);
                    $('#fec_nac').val(datos.fechaNaci_persona);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
});
