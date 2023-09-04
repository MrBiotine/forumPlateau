<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;


    class CategoryManager extends Manager{

        protected $className = "Model\Entities\Category"; //must match the entitie name
        protected $tableName = "category"; //must match the table name in the DataBase


        public function __construct(){
            parent::connect();
        }


        


    }