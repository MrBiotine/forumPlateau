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

        public function editCategory($id, $nameCategory){
            $sql = "UPDATE " . $this->tableName . "
                        SET nameCategory = :nameCategory, dateDerniereModification = NOW()
                        WHERE id_" . $this->tableName . " = :id";
            $params = [
                "id" => $id,
                "nameCategory" => $nameCategory
            ];
            
            try{
                return DAO::update($sql, $params);
            }
            catch(\PDOException $e){
                echo $e->getMessage();
                die();
            }
        }
    }


        


    }