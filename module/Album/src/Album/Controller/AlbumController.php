<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel, 
    Album\Form\AlbumForm,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\EntityRepository,
    Album\Entity\Album,
    Album\Manager\AlbumManager,
    BgportalSessionToolbar\Collector\SessionCollector;

class AlbumController extends AbstractActionController
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    protected $em_repo;
    protected $album_manager;
    private $album;


    public function __construct() {
        //echo 'I am the constructor';
        $this->album = new Album();
        $this->albumManager = new AlbumManager($this->album);
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
        $this->em_repo = $this->getEntityManager()->getRepository('Album\Entity\Album');
    }
 
    
    public function indexAction()
    {
         
        //set the entity repo manager
        $this->setEntityManagerRepo();
        
        
        //repository functions set up here with create custom query builder
        //$this->getEntityManager()->getRepository('Album\Entity\Album')->finderMethod();
        ////////////////////////////
        return new ViewModel(array(
            'albums' => $this->em_repo->getAlbumsAndEmployees() 
        ));
        
       
     
    
    }

    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $form->setInputFilter($this->albumManager->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) { 
                $this->albumManager->populate($form->getData()); 
                $this->getEntityManager()->persist($this->albumManager->getAlbum());
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('album'); 
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('album', array('action'=>'add'));
        } 
        $album = $this->getEntityManager()->find('Album\Entity\Album', $id);
        $this->albumManager = new AlbumManager($album);
        $form = new AlbumForm();
        $form->setBindOnValidate(false);
        $form->bind($this->albumManager);
        $form->get('submit')->setAttribute('label', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
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
            return $this->redirect()->toRoute('album');
        }
        $album = $this->getEntityManager()->find('Album\Entity\Album', $id);
        //echo $album->title; exit;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $album = $this->getEntityManager()->find('Album\Entity\Album', $id);
                if($album) {
                    $this->getEntityManager()->remove($album);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('default', array(
                'controller' => 'album',
                'action'     => 'index',
            ));
        }

        return array(
            'id' => $id,
            'album' => $album
           // 'album' => $this->getEntityManager()->find('Album\Entity\Album', $id)->getArrayCopy()
        );
    }
}