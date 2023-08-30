<?php
    namespace Model\Entities; //chemin virtuel de stockage de la classe

    use App\Entity;  //indique le chemein virtuel de la classe utlisé

    final class User extends Entity {
        private $id;              //primary key id_user
        private $mailUser;
        private $pseudoUser;
        private $passWordUser;
        private $registrationUser;            
        private $roleUser;
        private $isBanUser;

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
         * Get the value of mailUser
         */ 
        public function getMailUser()
        {
                return $this->mailUser;
        }

               /**
         * Set the value of mailUser
         *
         * @return  self
         */ 
        public function setMailUser($mailUser)
        {
                $this->mailUser = $mailUser;

                return $this;
        }

        /**
         * Get the value of pseudoUser
         */ 
        public function getPseudoUser()
        {
                return $this->pseudoUser;
        }

               /**
         * Set the value of pseudoUser
         *
         * @return  self
         */ 
        public function setPseudoUser($pseudoUser)
        {
                $this->pseudoUser = $pseudoUser;

                return $this;
        }

         /**
         * Get the value of passWordUser
         */ 
        public function getPassWordUser()
        {
                return $this->passWordUser;
        }

               /**
         * Set the value of passWordUser
         *
         * @return  self
         */ 
        public function setPassWordUser($passWordUser)
        {
                $this->passWordUser = $passWordUser;

                return $this;
        }

        /**
         * Get the value of registrationUser
         */ 
        public function getRegistrationUser()
        {
                return $this->registrationUser;
        }

               /**
         * Set the value of registrationUser
         *
         * @return  self
         */ 
        public function setRegistrationUser($registrationUser)
        {
                $this->registrationUser = $registrationUser;

                return $this;
        }

         /**
         * Get the value of roleUser
         */ 
        public function getRoleUser()
        {
                return $this->roleUser;
        }

               /**
         * Set the value of roleUser
         *
         * @return  self
         */ 
        public function setRoleUser($roleUser)
        {
                $this->roleUser = $roleUser;

                return $this;
        }

         /**
         * Get the value of isBanUser
         */ 
        public function getIsBanUser()
        {
                return $this->isBanUser;
        }

               /**
         * Set the value of isBanUser
         *
         * @return  self
         */ 
        public function setIsBanUser($isBanUser)
        {
                $this->isBanUser = $isBanUser;

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