<?php
    namespace Model\Entities; //chemin virtuel de stockage de la classe

    use App\Entity;  //indique le chemein virtuel de la classe utlisé

    final class Post extends Entity {
        private $id;              //primary key id_post
        private $datePost;
        private $textPost;
        private $topic;            //foreign key topic_id
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
        public function setUser($topic)
        {
                $this->topic = $topic;

                return $this;
        }

        /**
         * Get the value of topic
         */ 
        public function getTopic()
        {
                return $this->Topic;
        }

        /**
         * Set the value of Topic
         *
         * @return  self
         */ 
        public function setTopic($topic)
        {
                $this->topic = $topic;

                return $this;
        }

        /**
         * Get the value of topic
         */ 
        public function getTextPost()
        {
                return $this->TextPost;
        }

        /**
         * Set the value of TextPost
         *
         * @return  self
         */ 
        public function setTextPost($textPost)
        {
                $this->textPost = $textPost;

                return $this;
        }

        /* Getter and Setter of datePost */
        public function getDatePost(){
            $formattedDate = $this-datePost->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setDatePost($date){
            $this->datePost = new \DateTime($date);
            return $this;
        }

        public function __toString(){
            return $this->namePost;
    }

    }