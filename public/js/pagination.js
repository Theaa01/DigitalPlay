$(document).on('click', '.pagination-link', function(e) {
    e.preventDefault(); // Evita la recarga de página

    var url = $(this).attr('href');

    // Animar la opacidad mientras se realiza la solicitud AJAX
    $('.all-games').animate({ opacity: 0.5 }, 'slow');
    $('html, body').animate({ scrollTop: $('.all-games').offset().top }, 'slow');

    // Realizar la solicitud AJAX
    $.ajax({
        url: url,
        type: 'GET',
        success: function(data) {
            // Reemplazar el contenido de "Todos los juegos"
            $('.all-games').html($(data).find('.all-games').html());

            // Restaurar la opacidad con una animación suave
            $('.all-games').animate({ opacity: 1 }, 'slow');
        }
    });
});
