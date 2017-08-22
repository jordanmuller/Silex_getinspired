<?php

namespace Controller;

use Entity\Review;
// Namespace pour la classe Request
use Symfony\Component\HttpFoundation\Request;

class ReviewController extends ControllerAbstract
{
    // Request est une classe fournie par Symphony, il fait lui même l'injection de dépendance (pas d'Entity)
    public function addSignaleAjax(Request $request) {
        // Propriété request de l'objet $request
        $id_review = $request->request->get('id_review'); // Equivaut à $_POST['id_review'];
        
        $this->app['review.repository']->setSignaleReview($id_review, true);
        // On crée un tableau $data
        $data = ['status' => 'success'];        
        
        // On retourne le tableau via la méthode json() de silex
        // json(), 1er argument un tableau de réponse, en second le code statut, en 3eme le header HTTP
        return $this->app->json($data, 200);        
    }
    
    public function removeSignaleAjax(Request $request) {
        // Propriété request de l'objet $request
        $id_review = $request->request->get('id_review'); // Equivaut à $_POST['id_review'];
        
        $this->app['review.repository']->setSignaleReview($id_review, false);
        // On crée un tableau $data
        $data = ['status' => 'success'];        
        
        // On retourne le tableau via la méthode json() de silex
        // json(), 1er argument un tableau de réponse, en second le code statut, en 3eme le header HTTP
        return $this->app->json($data, 200);        
    } 
    
    public function deleteCommentAjax(Request $request) {
        // Propriété request de l'objet $request
        $id_review = $request->request->get('id_review'); // Equivaut à $_POST['id_review'];
        
        $this->app['review.repository']->setSignaleReview($id_review, false, 'Le commentaire à été supprimé par l\'administrateur du site');
        // On crée un tableau $data
        $data = ['status' => 'success'];        
        
        // On retourne le tableau via la méthode json() de silex
        // json(), 1er argument un tableau de réponse, en second le code statut, en 3eme le header HTTP
        return $this->app->json($data, 200);        
    }    
}
