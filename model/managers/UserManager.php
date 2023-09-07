<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;


    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }

        /**
         * find a user by email
         */
        public function findEmail($emailUser){
            $sql = "SELECT *
                        FROM " . $this->tableName . " m
                        WHERE m.emailUser = :emailUser";
            return $this->getOneOrNullResult(
                DAO::select($sql, ["emailUser" => $emailUser], false),
                $this->className
            );
        }

        /**
         * find a user by pseudo
         */
        public function findPseudo($pseudoUser){
            $sql = "SELECT *
                        FROM " . $this->tableName . " m
                        WHERE m.pseudoUser = :pseudoUser";
            return $this->getOneOrNullResult(
                DAO::select($sql, ["pseudoUser" => $pseudoUser], false),
                $this->className
            );
        }

        /**
         *  find the password associated with the email
         */
        public function findPassWord($emailUser){
            $sql = "SELECT passwordUser
                        FROM " . $this->tableName . " m
                        WHERE m.emailUser = :emailUser";
            return $this->getOneOrNullResult(
                DAO::select($sql, ["emailUser" => $emailUser], false),
                $this->className
            );
        }

        /**
         * count the number of topics written by a user
         */
        public function numberTopicByUser($id){
            $sql = "SELECT COUNT(t.id_topic) AS nbTopics
                        FROM " . $this->tableName . " m, topic t
                        WHERE m.id_user = t.user_id
                        AND m.id_user = :id";
            return $this->getSingleScalarResult(
                DAO::select($sql, ["id" => $id], false)
            );
        }

        /**
         * count posts number written by a user
         */
        public function numberPostByUser($id){
            $sql = "SELECT COUNT(p.id_post) AS nbPosts
                        FROM " . $this->tableName . " m, post p
                        WHERE m.id_user = p.user_id
                        AND m.id_user = :id";
            return $this->getSingleScalarResult(
                DAO::select($sql, ["id" => $id], false)
            );
        }

        /**
         * Update the user passWord
         */
        public function updatePassWord($id, $mdp){
            $requete = "UPDATE " . $this->tableName . "
                        SET passwordUser = :mdp
                        WHERE id_" . $this->tableName ." = :id";
            return DAO::update($requete, ["id" => $id, "mdp" => $mdp]);
        }

        /**
         * update a user email
         */
        public function updateMail($id, $email){
            $requete = "UPDATE " . $this->tableName . "
                        SET emailUser = :email
                        WHERE id_" . $this->tableName ." = :id";
            return DAO::update($requete, ["id" => $id, "email" => $email]);
        }

        /**
         * update a user pseudo
         */
        public function updatePseudo($id, $pseudo){
            $requete = "UPDATE " . $this->tableName . "
                        SET pseudoUser = :pseudo
                        WHERE id_" . $this->tableName . " = :id";
            return DAO::update($requete, ["id" => $id, "pseudo" => $pseudo]);
        }

        /**
         * update a user role
         */
        public function modificationRole($id, $role){
            $requete = "UPDATE " . $this->tableName . "
                        SET role = :role
                        WHERE id_" . $this->tableName . " = :id";
            return DAO::update($requete, ["id" => $id, "role" => $role]);
        }


    }