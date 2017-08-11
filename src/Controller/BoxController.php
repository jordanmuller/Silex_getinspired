<?php

namespace Controller;

class BoxController extends ControllerAbstract {
    public function listBoxAction()
    {
        $boxes = $this->app['box.repository']->findAll();
        
        return $this->render(
            'box_list.html.twig',
            [
                'boxes' => $boxes
            ]
        );
    }
}
