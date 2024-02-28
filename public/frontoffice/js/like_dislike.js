$(document).ready(function() {
    $('.like-button').click(function(e) {
        e.preventDefault();
        var publicationId = $(this).data('publication');
        $.ajax({
            type: 'POST',
            url: '/publication/' + publicationId + '/like',
            success: function(response) {
                // Mettre à jour l'affichage après le like
            }
        });
    });

    $('.dislike-button').click(function(e) {
        e.preventDefault();
        var publicationId = $(this).data('publication');
        $.ajax({
            type: 'POST',
            url: '/publication/' + publicationId + '/dislike',
            success: function(response) {
                // Mettre à jour l'affichage après le dislike
            }
        });
    });
});
