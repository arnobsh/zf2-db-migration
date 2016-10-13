<?php

namespace Employee\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class EmployeeTable extends AbstractTableGateway
{
    protected $table = 'employee';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new \Employee());

        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getEmployee($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveEmployee(Employee $employee)
    {
        $data = array(
            'name' => $employee->name,
            'address'  => $employee->address,
            'created'  => now(),
        );

        $id = (int)$employee->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getEmployee($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteEmployee($id)
    {
        $this->delete(array('id' => $id));
    }

}
