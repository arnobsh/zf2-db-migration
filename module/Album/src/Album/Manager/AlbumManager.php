<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album\Manager;


use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 

use Album\Repository\AlbumRepository,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\EntityRepository;
    

class AlbumManager implements InputFilterAwareInterface
{
    private $album;
    private $album_repository;
    protected $inputFilter;
    
    public function __construct(\Album\Entity\Album $album)
    {
        $this->album = new $album;
    }
    
    
    public function setEntityManagerRepo()
    {
        $this->album_repository = $this->getEntityManager()->getRepository('Album\Entity\Album');
    }
    
    public function getEmplyee()
    {
        return $this->album->getEmployee();
    }

    public function getAlbum()
    {
        return $this->album;
    }
    
    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) 
    {
        return $this->$property;
    }
 
    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }
 
    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this->album);
    }
 
    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) 
    {
        $date = new \Zend\Form\Element\DateTime;
        $date->setFormat("Y-m-d H:i:s");

        $this->album->setArtist($data['artist']);
        $this->album->setTitle($data['title']);
        $this->album->setTest("test data");
        $this->album->setDetails("test details");
        $this->album->setEmpid("1");
        return $this->album;
    }
 
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
 
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
 
            $factory = new InputFactory();
 
            $inputFilter->add($factory->createInput(array(
                'name'       => 'id',
                'required'   => true,
                'filters' => array(
                    array('name'    => 'Int'),
                ),
            )));
 
            $inputFilter->add($factory->createInput(array(
                'name'     => 'artist',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
 
            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
 
            $this->inputFilter = $inputFilter;        
        }
 
        return $this->inputFilter;
    } 
}