<?php
    namespace Model\Entities; //chemin virtuel de stockage de la classe

    use App\Entity;  //indique le chemein virtuel de la classe utlisé

    final class User extends Entity {
        private $id;                  //primary key id_user
        private $pseudoUser;              
        private $emailUser;        
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
         * Get the value of emailUser
         */ 
        public function getEmailUser()
        {
                return $this->emailUser;
        }

               /**
         * Set the value of emailUser
         *
         * @return  self
         */ 
        public function setEmailUser($emailUser)
        {
                $this->emailUser = $emailUser;

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
        // public function setRoleUser($role)
        // {
        //         //we get a JSON
        //         $this->roleUser = json_decode($role);
        //        
        //         //if there is no assigned role, a default role will be assigned
        //         if(empty($this->$role)){
        //                 $this->roleUser[] = "ROLE_USER";
        //         }
        //
        //         return $this;
        // }

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

         /**
         * Perform checking role user
         */
        //public function hasRole($roleUser){
        //        return $this->roleUser == $roleUser;
        //}

        public function hasRole($role){
                //si dans le tableau JSON on trouve un role qui corresponde au role en paramètre, on retourne le role
                //return in_array($role, $this->getRoleUser());
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

        
    
            /**
             * Méthode toString de la classe
             */
            public function __toString(){
                return $this->pseudoUser . "";
            }

        
    }
?>