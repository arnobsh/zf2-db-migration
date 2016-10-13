<?php

namespace Track\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel, 
    Track\Form\TrackForm,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\EntityRepository,
    Track\Entity\Track,
    Track\Manager\TrackManager,
    BgportalSessionToolbar\Collector\SessionCollector;

class TrackController extends AbstractActionController
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    protected $em_repo;
    protected $trackManager;
    private $track;


    public function __construct() {
        //echo 'I am the constructor';
        $this->track = new Track();
        $this->trackManager = new TrackManager($this->track);
    }

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

    public function setEntityManagerRepo()
    {
        $this->em_repo = $this->getEntityManager()->getRepository('Track\Entity\Track');
    }
 
    
    public function indexAction()
    {
         
        //set the entity repo manager
        $this->setEntityManagerRepo();
        
        $albumsAndTracks  = $this->em_repo->getAlbumsAndTracks();
        //repository functions set up here with create custom query builder
        //$this->getEntityManager()->getRepository('Track\Entity\Track')->finderMethod();
        ////////////////////////////
        return new ViewModel(array(
            'tracks' =>  $albumsAndTracks
        ));
        
       
     
    
    }

    public function addAction()
    {
        $form = new TrackForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $form->setInputFilter($this->trackManager->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) { 
                $this->trackManager->populate($form->getData()); 
                $this->getEntityManager()->persist($this->trackManager->getTrack());
                $this->getEntityManager()->flush();

                // Redirect to list of tracks
                return $this->redirect()->toRoute('track'); 
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('track', array('action'=>'add'));
        } 
        $track = $this->getEntityManager()->find('Track\Entity\Track', $id);
        //$this->trackManager = new TrackManager($track);
        $form = new TrackForm();
        $form->setBindOnValidate(false);
        $form->bind($track);
        $form->get('submit')->setAttribute('label', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of tracks
                return $this->redirect()->toRoute('track');
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
            return $this->redirect()->toRoute('track');
        }
        $track = $this->getEntityManager()->find('Track\Entity\Track', $id);
        //echo $track->title; exit;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $track = $this->getEntityManager()->find('Track\Entity\Track', $id);
                if($track) {
                    $this->getEntityManager()->remove($track);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of tracks
            return $this->redirect()->toRoute('default', array(
                'controller' => 'track',
                'action'     => 'index',
            ));
        }

        return array(
            'id' => $id,
            'track' => $track
           // 'track' => $this->getEntityManager()->find('Track\Entity\Track', $id)->getArrayCopy()
        );
    }
}