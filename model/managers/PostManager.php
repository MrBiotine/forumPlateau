<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;


    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        public function __construct(){
            parent::connect();
        }

        /**
         * find post in a selected topic
         */
        public function findPostinTopic($id){
            $sql = "SELECT *
                    FROM " . $this->tableName . " p
                    WHERE p.topic_id = :id
                    ORDER BY p.datePost ASC";
            return $this->getMultipleResults(
                DAO::select($sql, ["id" => $id]),
                $this->className
            );
        }

        /**
         * deletes all posts in the selected topic
         */
        public function deleteAllPost($id){
            $sql = "DELETE FROM " . $this->tableName . "
                    WHERE " . $this->tableName .  ".topic_id = :id";
            return DAO::delete($sql, ["id" => $id]);
        }

        /**
         * find the oldest post in the selected topic
         */
        public function findOldestPost($id){
            $sql = "SELECT " . $this->tableName . ".id_" . $this->tableName . "
                    FROM " . $this->tableName . "
                    WHERE " . $this->tableName . ".topic_id = :id
                    AND " . $this->tableName . ".datePost = (
                        SELECT MIN(" . $this->tableName . ".datePost)
                        FROM " . $this->tableName . "
                        WHERE " . $this->tableName . ".topic_id = :id)";
            return $this->getSingleScalarResult(DAO::select($sql, ["id" => $id], false));
        }

        /**
         * find user id who write the post
         */
        public function findUserPost($id){
            $sql = "SELECT " . $this->tableName . ".user_id
                    FROM " . $this->tableName . "
                    WHERE " . $this->tableName . ".id_" . $this->tableName . " = :id";
            return $this->getSingleScalarResult(DAO::select($sql, ["id" => $id], false));
        }

        /**
         * Find the last five user posts
         */
        public function findFiveLastPost($id){
            $requete = "SELECT *
                    FROM " . $this->tableName . "
                    WHERE user_id = :id
                    ORDER BY datePost DESC
                    LIMIT 5";
            return $this->getMultipleResults(
                DAO::select($requete, ["id" => $id]),
                $this->className
            );
        }

        /**
         * deletes all topic messages in the selected category
         */
        public function deleteAllPostByCategory($id){
            $sql = "DELETE FROM " . $this->tableName . "
                        WHERE topic_id IN
                            (SELECT id_topic
                            FROM topic
                            WHERE category_id = :id)";
            return DAO::delete($sql, ["id" => $id]);
        }

        /**
         * Update a post
         */
        public function updatePost($id, $textPost){
            $sql = "UPDATE " . $this->tableName . "
                        SET textPost = :textPost, dateLastUpdate = NOW()
                        WHERE id_" . $this->tableName . " = :id";
            return DAO::update($sql, ["id" => $id, "textPost" => $textPost]);
        }

    }