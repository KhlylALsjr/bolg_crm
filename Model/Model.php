<?php
abstract class Model{
    protected $id;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
         $this->id=$id;
    }
    abstract public function save($conn);
    abstract public function delete($conn);
}