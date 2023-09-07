<?php
    namespace Model\Entities; //chemin virtuel de stockage de la classe

    use App\Entity;  //indique le chemein virtuel de la classe utlisé

    final class Category extends Entity {
        private $id; 
        private $nameCategory; 
        private $numberTopic;

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
     * Get the value of nameCategory
     */ 
    public function getNameCategory()
    {
            return $this->nameCategory;
    }

    /**
     * Set the value of nameCategory
     *
     * @return  self
     */ 
    public function setNameCategory($nameCategory)
    {
            $this->nameCategory = $nameCategory;

            return $this;
    }

    /**
     * Get the value of numberTopic
     */ 
    public function getNumberTopic()
    {
            return $this->numberTopic;
    }

    /**
     * Set the value of numberTopic
     *
     * @return  self
     */ 
    public function setNumberTopic($numberTopic)
    {
            $this->numberTopic = $numberTopic;

            return $this;
    }
        
    }