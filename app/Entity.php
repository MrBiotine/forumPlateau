<?php
    namespace App;

    abstract class Entity{

        protected function hydrate($data){

            foreach($data as $field => $value){
                //field = nom d'une colonne
                //value = valeur d'une cellule

                //field = marque_id
                //fieldarray = ['marque','id']
                $fieldArray = explode("_", $field);

                //if des FK : si le fieldArray à un 2e elèment et que c un id
                if(isset($fieldArray[1]) && $fieldArray[1] == "id"){
                    // def du nom du manager
                    $manName = ucfirst($fieldArray[0])."Manager";
                    //FQN : Fully Qualified Name
                    $FQCName = "Model\Managers".DS.$manName;
                    
                    //instance du manager
                    $man = new $FQCName();
                    //appel de la méthode findOneById du bon manager en fournissant l'id de l'entité référenciée (de l'enregistrement de la table 'truc' qui a pour id $value)
                    //value qui contenait un id contient maintenant un objet =>  instance d'une entité venant du modèle model/entities
                    $value = $man->findOneById($value);
                }
                //fabrication du nom du setter à appeler (ex: setMarque)
                //3 cas : (pour l'entité "truc")
                //-PK : "id" => "setId"
                //-FK : "truc" => "setTtruc"
                //-Autre : "title" => "setTitle"
                //si ce setter existe 
                $method = "set".ucfirst($fieldArray[0]);
                //alors on l'appelle en lui passant $value comme argument
                // 2 cas possible:
                // -FK : $value contient un objet
                // -Pk ou autre : $value contient une valeur
               
                if(method_exists($this, $method)){
                    $this->$method($value);
                }

            }
        }

        public function getClass(){
            return get_class($this);
        }
    }