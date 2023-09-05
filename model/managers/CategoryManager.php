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

        /*list all categorys with the number of topics*/
        public function listCategoryWithNumberTopic($order = null){
            $orderQuery = ($order) ? "ORDER BY " . $order[0] . " " . $order[1] : "";
            
            $requete = "SELECT *, (SELECT COUNT(topic.id_topic)
                                FROM topic
                                WHERE topic." . $this->tableName . "_id = id_" . $this->tableName . "
                                ) AS nombreTopic
                    FROM " . $this->tableName . " a
                    ". $orderQuery;
            return $this->getMultipleResults(
                DAO::select($requete),
                $this->className
            );
        }

        /*Custom function to update the category table*/
        public function editCategory($id, $nameCategory){
            $sql = "UPDATE " . $this->tableName . "
                        SET nameCategory = :nameCategory
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


        


    