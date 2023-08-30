<?php
    namespace Model\Entities; //chemin virtuel de stockage de la classe

    use App\Entity;  //indique le chemein virtuel de la classe utlisé

    final class Topic extends Entity{ //claase finale, ne peut pas avoir d'enfant, la classe Topic hérite de entity
/*liste des propriétée de la classe topic, définies en private , accessibles directement unqument par la classe topic*/
        private $id;              //primary key id_topic
        private $nameTopic;
        private $dateTopic;
        private $isLockTopic;        
        private $user;             //foreign key user_id
        
        
/*Hydrate : instance l'objet avec les donnnées de la BDD  - */
        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

               /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of title
         */ 
        public function getNameTopic()
        {
                return $this->nameTopic;
        }

        /**
         * Set the value of nameTopic
         *
         * @return  self
         */ 
        public function setNameTopic($nameTopic)
        {
                $this->nameTopic = $nameTopic;

                return $this;
        }

        /**
         * Get the value of user
         */ 
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }

        public function getDateTopic(){
            $formattedDate = $this-dateTopic->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setDateTopic($date){
            $this->dateTopic = new \DateTime($date);
            return $this;
        }

        /**
         * Get the value of closed
         */ 
        public function getIsLockTopic()
        {
                return $this->isLockTopic;
        }

        /**
         * Set the value of IsLockTopic
         *
         * @return  self
         */ 
        public function setIsLockTopic($closed)
        {
                $this->getIsLockTopic = $closed;

                return $this;
        }

        public function __toString(){
                return $this->nameTopic;
        }
    }
