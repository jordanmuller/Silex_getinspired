<?php

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Liste;

class ListeAdminController extends ControllerAbstract
{
    public function listListeAction()
    {
        $listes = $this->app['liste.repository']->findAll();
        
        return $this->render(
            'admin/list/list_list_admin.html.twig',
            [
                'listes' => $listes
            ]
        );
    }
    
    public function deleteAction($id) {
        $liste = $this->app['liste.repository']->find($id);
        //echo '<pre>'; var_dump($liste); echo '</pre>';
        if(!$liste instanceof Liste){
            $this->app->abort(404);
        }
        
        
        $this->app['liste.repository']->delete($liste);
                
        $this->addFlashMessage('La liste a été supprimée');            
        return $this->redirectRoute('admin_listes');
        
    }
}
