<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\CategoryManager;
    use Model\Managers\PostManager;
    use Model\Managers\TopicManager;
    use Model\Managers\UserManager;
    
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          

           return listCategorys();
        
        }

        public function listCategorys(){               // Fonction pour afficher la liste de toute les catégories
            
            $categoryManager = new CategoryManager();   // Instancier cette variable pour accéder aux méthodes de la classe

            return [                                    // Fonction native du FrameWork findAll() (se trouve dans Manager.php) on demande à la variable d'utiliser cette fonction
                
                "view" => VIEW_DIR."forum/listCategorys.php",

                "data" => ["categorys" => $categoryManager->findAll(["nameCategory","ASC"])]                               
            ];                                          // Permet d'afficher toutes les catégories
        }

        public function listTopics($id) {

            $topicManager = new TopicManager();         // Instancier cette variable pour accéder aux méthodes de la classe 
            $categoryManager = new CategoryManager();   // Instancier cette variable pour accéder aux méthodes de la classe et permettre l'ajout de topic dans une catégorie vide
            $userManager = new UserManager();           // Instancier cette variable pour accéder aux méthodes de la classe et permettre l'ajout de topic dans une catégorie vide

            return [

                "view" => VIEW_DIR."forum/listTopics.php",

                "data" => [                             // Les fonctions natives du FrameWork findAll() et findOneById($id) (se trouvent dans Manager.php) on demande à la variable d'utiliser cette fonction

                    "topics" => (
                        isset($id)
                        ? $topicManager->findListByIdDep($id, "category", ["dateTopic", "DESC"])
                        : $topicManager->findAll(["dateTopic", "DESC"])// Permet d'afficher toutes les informations d'un topic
                    ),
                    "category" => $categoryManager->findOneById($id),// Pour retrouver un élément selon un id
                    
                    //"user" => $userManager->findOneById($id)// Pour retrouver un élément selon un id 
                ]                                  
            ];
        }


        

    }
