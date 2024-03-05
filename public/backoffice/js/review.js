$(document).ready(function() {
    // On va chercher toutes les étoiles
    const stars = $(".la-star");
    
    // On boucle sur les étoiles pour ajouter des écouteurs d'événements
    stars.each(function() {
        const star = $(this);
        
        // On écoute le survol
        star.on("mouseover", function() {
            resetStars();
            star.css("color", "red");
            star.addClass("las").removeClass("lar");
            
            // Élément précédent dans le DOM (de même niveau, balise sœur)
            let previousStar = star.prev();
            while (previousStar.length > 0) {
                // On passe l'étoile qui précède en rouge
                previousStar.css("color", "red");
                previousStar.addClass("las").removeClass("lar");
                // On récupère l'étoile qui la précède
                previousStar = previousStar.prev();
            }
        });
        
        // On écoute le clic
        star.on("click", function() {
            const note = star.data("value");
            $("#note").val(note);
        });
        
        // On écoute la sortie du survol
        star.on("mouseout", function() {
            resetStars();
            const note = $("#note").val();
            setStars(note);
        });
    });
    
    // Fonction pour réinitialiser l'affichage des étoiles
    function resetStars() {
        stars.css("color", "black");
        stars.addClass("lar").removeClass("las");
    }
    
    // Fonction pour afficher les étoiles jusqu'à la valeur donnée
    function setStars(value) {
        stars.each(function() {
            const star = $(this);
            const starValue = star.data("value");
            
            if (starValue <= value) {
                star.css("color", "red");
                star.addClass("las").removeClass("lar");
            }
        });
    }
    
    // Récupérer la note initiale et afficher les étoiles correspondantes
    const initialNote = parseInt($("#note").val());
    setStars(initialNote);
});