$(function(){
    $('.btn-signale-comment').click(function(){
        $this = $(this);        
       
        // On récupère l'attribut_data id qui est l'id de la review
        var id_review = $this.data('id');
       
        // On fait une requête ajax en mode post qui pointe sur l'url en question, l'url est la route qui ponte vers le controller
        $.post(addSignaleUrl, {
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
        $.post(removeSignaleUrl, {
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
        $.post(deleteCommentUrl, {
            // En PHP, on récupère $_POST['id_review'] => var id_review
             id_review : id_review
        }, function(resultat){
            // Réponse du serveur renvoyant l'ajax en console.log
            // console.log(resultat);
            $this.parent().prev().replaceWith('<div class="comment-content delete-by-admin">Le commentaire à été supprimé par l\'administrateur du site</div>');
        });
    });
});
