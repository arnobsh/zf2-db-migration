<?php

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel, 
    Employee\Form\EmployeeForm,
    Doctrine\ORM\EntityManager,
    Employee\Entity\Employee,
    BgportalSessionToolbar\Collector\SessionCollector;

class EmployeeController extends AbstractActionController
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    } 

    public function indexAction()
    {
         $container = new \Zend\Session\Container;
        $container->a   = 'b';
        $container->foo = 'bar';
        return new ViewModel(array(
            'employees' => $this->getEntityManager()->getRepository('Employee\Entity\Employee')->findAll() 
        ));
        
       
     
    
    }

    public function addAction()
    {
        
       // $form = new EmployeeForm();
        $form = new \Employee\Form\EmployeeForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $employee = new Employee();
            $form->setInputFilter($employee->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) { 
                $employee->populate($form->getData()); 
                $this->getEntityManager()->persist($employee);
                $this->getEntityManager()->flush();

                // Redirect to list of employee
                return $this->redirect()->toRoute('employee'); 
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('$employee', array('action'=>'add'));
        } 
        $employee = $this->getEntityManager()->find('Employee\Entity\Employee', $id);

        $form = new EmployeeForm();
        $form->setBindOnValidate(false);
        $form->bind($employee);
        $form->get('submit')->setAttribute('label', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of employee
                return $this->redirect()->toRoute('employee'); 
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('employee');
        }
        $employee = $this->getEntityManager()->find('Employee\Entity\Employee', $id);
        //echo employee->title; exit;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $employee = $this->getEntityManager()->find('Employee\Entity\Employee', $id);
                if($employee) {
                    $this->getEntityManager()->remove($employee);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of employee
            return $this->redirect()->toRoute('default', array(
                'controller' => 'employee',
                'action'     => 'index',
            ));
        }

        return array(
            'id' => $id,
            'employee' => $employee
           // 'album' => $this->getEntityManager()->find('Album\Entity\Album', $id)->getArrayCopy()
        );
    }
}