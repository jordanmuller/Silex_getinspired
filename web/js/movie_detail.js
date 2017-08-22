$(function(){
    $('.btn-signale-comment').click(function(){
        $this = $(this);        
       
        // On récupère l'attribut_data id qui est l'id de la review
        var id_review = $this.data('id');
       
        // On fait une requête ajax en mode post qui pointe sur l'url en question, l'url est la route qui ponte vers le controller
        $.post('/silex/Silex_getinspired/web/index_dev.php/reviews/addSignale', {
            // En PHP, on récupère $_POST['id_review'] => var id_review
             id_review : id_review
        }, function(resultat){
            // Réponse du serveur renvoyant l'ajax en console.log
            // console.log(resultat);
            $this.parent().prev().addClass('signale');
        });
    });
    
    $('.btn-designale-comment').click(function(){
        $this = $(this);        
       
        // On récupère l'attribut_data id qui est l'id de la review
        var id_review = $this.data('id');
       
        // On fait une requête ajax en mode post qui pointe sur l'url en question, l'url est la route qui ponte vers le controller
        $.post('/silex/Silex_getinspired/web/index_dev.php/reviews/removeSignale', {
            // En PHP, on récupère $_POST['id_review'] => var id_review
             id_review : id_review
        }, function(resultat){
            // Réponse du serveur renvoyant l'ajax en console.log
            // console.log(resultat);
            $this.parent().prev().removeClass('signale');
        });       
    });
    
    $('.btn-delete-comment').click(function(){    
       $this = $(this);        
       
        // On récupère l'attribut_data id qui est l'id de la review
        var id_review = $this.data('id');
       
        // On fait une requête ajax en mode post qui pointe sur l'url en question, l'url est la route qui ponte vers le controller
        $.post('/silex/Silex_getinspired/web/index_dev.php/reviews/deleteComment', {
            // En PHP, on récupère $_POST['id_review'] => var id_review
             id_review : id_review
        }, function(resultat){
            // Réponse du serveur renvoyant l'ajax en console.log
            // console.log(resultat);
            $this.parent().prev().addClass('delete-by-admin');
        });
    });
});