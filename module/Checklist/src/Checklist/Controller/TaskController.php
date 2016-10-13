<?php

namespace Checklist\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class TaskController extends AbstractActionController {

    public function indexAction() {
        $mapper = $this->getTaskMapper();
        return new ViewModel(array('tasks' => $mapper->fetchAll()));
    }

    public function getTaskMapper() {
        $sm = $this->getServiceLocator();
        return $sm->get('TaskMapper');
    }

}
