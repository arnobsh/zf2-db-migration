<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fixture\Employee;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Employee\Entity\Employee;
class EmployeeFixtureLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cdate = new \DateTime('now');
        //$cd = $cdate->format('Y-m-d H:i:s');
        $employee = new Employee();
        $employee->setName("Test Employee");
        $employee->setAddress("Test Address");
        $employee->setCreated($cdate);

        $manager->persist($employee);
        $manager->flush();
    }
}