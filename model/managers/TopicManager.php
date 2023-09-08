<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\TopicManager;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }

        /**
         * Find topics in a category
         */
        public function findTopicInCategory($id, $order){
            $orderQuery = ($order) ? "ORDER BY " . $order[0] . " " . $order[1] : "";
            
            $requete = "SELECT *, (SELECT COUNT(post.id_post)
                                FROM post
                                WHERE post." . $this->tableName . "_id = id_" . $this->tableName . "
                                ) AS numberPosts
                                
                    FROM " . $this->tableName . " t
                    WHERE t.categorie_id = :id
                    " . $orderQuery;
            return $this->getMultipleResults(
                DAO::select($requete, ["id" => $id]),
                $this->className
            );
        }

        /**
         * find user id who is the author topic
         */
        public function findIdUserTopic($id){
            $sql = "SELECT " . $this->tableName . ".user_id
                    FROM " . $this->tableName . "
                    WHERE " . $this->tableName . ".id_" . $this->tableName . " = :id";
            return $this->getSingleScalarResult(DAO::select($sql, ["id" => $id], false));
        }

        /**
         * find topics with the number posts inside
         */
        public function findTopicWithNumberPost($order = null){
            $orderQuery = ($order) ? "ORDER BY " . $order[0] . " " . $order[1] : "";
            
            $requete = "SELECT *, (SELECT COUNT(post.id_post)
                                FROM post
                                WHERE post." . $this->tableName . "_id = id_" . $this->tableName . "
                                ) AS numberPosts
                    FROM " . $this->tableName . " a
                    ". $orderQuery;
            return $this->getMultipleResults(
                DAO::select($requete),
                $this->className
            );
        }

        /**
         * To lock a topic
         */
        public function lockTopic($id){
            $requete = "UPDATE " . $this->tableName . "
                    SET isLockTopic = 1
                    WHERE " . $this->tableName . ".id_" .$this->tableName . " = :id";
            return DAO::update($requete, ["id" => $id]);
        }

        /**
         * To delock a topic
         */
        public function delockTopic($id){
            $sql = "UPDATE " . $this->tableName . "
                    SET isLockTopic = 0
                    WHERE " . $this->tableName . ".id_" .$this->tableName . " = :id";
            return DAO::update($sql, ["id" => $id]);
        }

        /**
         * find the user topics
         */
        public function findTopicsUser($id, $order = null){
            $orderQuery = ($order) ? "ORDER BY " . $order[0] . " " . $order[1] : "";
            
            $requete = "SELECT *, (SELECT COUNT(post.id_post)
                                FROM post
                                WHERE post." . $this->tableName . "_id = id_" . $this->tableName . "
                                ) AS numberPosts
                    FROM " . $this->tableName . "
                    WHERE " . $this->tableName .".user_id = :id
                    ". $orderQuery;
            return $this->getMultipleResults(
                DAO::select($requete, ["id" => $id]),
                $this->className
            );
        }

        /**
         * Delete all topics from a specified category
         */
        public function deleteAllTopicFromCategory($id){
            $sql = "DELETE FROM " . $this->tableName . "
                        WHERE categorie_id = :id";
            return DAO::delete($sql, ["id" => $id]);
        }

        /**
         * Update the topic title
         */
        public function updateTopicTitle($id, $title){
            $sql = "UPDATE " . $this->tableName . "
                        SET nameTopic = :title
                        WHERE id_" . $this->tableName . " = :id";
            return DAO::update($sql, ["id" => $id, "title" => $title]);
        }

        


    }