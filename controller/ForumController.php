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

           return $this->listCategorys();
        
        }
/*--------------------------------------SECTION CATEGORY -----------------------------------------------------------------------------*/
        public function listCategorys(){               // Display category list
            
            $categoryManager = new CategoryManager();   // Instantiate a new object to access the class's methods

            return [                                    // findAll() is a native function from framework
                
                "view" => VIEW_DIR."forum/listCategorys.php",

                "data" => ["categorys" => $categoryManager->findAll(["nameCategory","ASC"])]                               
            ];                                          // select all records from 'category' table, sort of by ascending name 
        }

        //access form to add category

        public function addFormCategory(){           

            return [                                    // The function name must match the target file in order to access it.
                
                "view" => VIEW_DIR."forum/addFormCategory.php",                           
            ];
        }

        public function addCategory(){                  // Function to add a category 
            $session = new Session();                //instantiate a new session to use notification  

            $categoryManager = new CategoryManager();   // Instantiate a new object to access the class's methods
            
            $name = filter_input(INPUT_POST, 'nameCategory', FILTER_SANITIZE_FULL_SPECIAL_CHARS); //filter the datas from addFormCategory.php

            $data = [
                'nameCategory' => $name
            ];
            $categoryManager->add($data);   // Perform insert a new record in table 'category' 

            return [                                    // The function name must match the target file in order to access it.
                                           
                "view" => VIEW_DIR."forum/listCategorys.php",
                $session->addFlash('success',"Ajouté avec succès"),                   // Display the notification
                "data" => ["categorys" => $categoryManager->findAll()]                               
            ];
        }

         //access form to edit category

         public function editFormCategory($id){           

            return [                                    // The function name must match the target file in order to access it.
                
                "view" => VIEW_DIR."forum/editFormCategory.php",
                "data" => ["category" => $categoryManager->findOneById($id)]                           
            ];
        }

        public function delCategory($id){               // Function to delete a category

            $categoryManager = new CategoryManager();
            $session = new Session();                   //instantiate a new session to use notification 

            return [                                    // The function name must match the target file in order to access it.

                "view" => VIEW_DIR."forum/listCategorys.php",  // redirect to the page displaying the categorys
                $session->addFlash('success',"Supprimé avec succès"),// Display the notification
                
                "data" => [$categoryManager->delete($id), "categorys" => $categoryManager->findAll(["name", "ASC"])]           
            ];
        }

        
/*-------------------------------------SECTION TOPICS ----------------------------------------------------------------------------------*/

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
