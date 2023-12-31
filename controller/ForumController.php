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
            //var for meta tag
            $title = "Les Catégories";
            $description = "liste positive des catégoties disponibleq";

            return [                                    // findAll() is a native function from framework
                
                "view" => VIEW_DIR."forum/listCategorys.php",

                "data" => ["categorys" => $categoryManager->listCategoryWithNumberTopic(["nameCategory","ASC"]),
                "title" => $title,
                "description" => $description]                               
            ]; //Custom function which  select all records from 'category' table, sort of by ascending name and count the number topics inside
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
            
            $categoryManager = new CategoryManager();   // Instantiate a new object to access the class's methods

            return [                                    // The function name must match the target file in order to access it.
                
                "view" => VIEW_DIR."forum/editFormCategory.php",
                "data" => ["category" => $categoryManager->findOneById($id)]                           
            ];
        }

        public function editCategory($id){                  // Function to add a category 
            $session = new Session();                //instantiate a new session to use notification  

            $categoryManager = new CategoryManager();   // Instantiate a new object to access the class's methods
            
            $name = filter_input(INPUT_POST, 'nameCategory', FILTER_SANITIZE_FULL_SPECIAL_CHARS); //filter the datas from editFormCategory.php
           
            $categoryManager->editCategory($id, $name);   // Perform udate in table 'category' 

            return [                                    // The function name must match the target file in order to access it.
                                           
                "view" => VIEW_DIR."forum/listCategorys.php",
                $session->addFlash('success',"Edité avec succès"),                   // Display the notification
                "data" => ["categorys" => $categoryManager->findAll()]                //Display the categorys list               
            ];
        }

        public function deleteCategory(){               // Function to delete a category

            $categoryManager = new CategoryManager();
            $topicManager = new TopicManager();
            $postManager = new PostManager();
            // filter data received from GET
            $idCategory = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //check if filter fail
            if(!$idCategory){
                Session::addFlash('error',"Données invalide - le filtrage a échouée !");
                $this->redirectTo("forum");
            }

            //if user is not the admin, the action is canceled
            if(!Session::isAdmin()){
                Session::addFlash('error',"Action refusé - vous n'avez pas le niveau requis de privilège");
                $this->redirectTo("forum");
            }
            
            $nameCategory = $categorieManager->findOneById($idCategory)->getNameCategory();

            /* Delete on cascade : delete all the posts linked with the category, then delete all the topics linked with the category, and finally the category itself */
            if($postManager->deleteAllPostByCategory($idCategory) && $topicManager->deleteAllTopicFromCategory($idCategory) && $categoryManager->delete($idCategory)){
                Session::addFlash("success", "Suppression de la catégorie '$nameCategory' réussi !");
                $this->redirectTo("forum");
            }
            else{
                Session::addFlash("error", "Échec de la suppression !");
                $this->redirectTo("forum");
                }
        }

        
/*-------------------------------------SECTION TOPICS ----------------------------------------------------------------------------------*/

        public function listTopics($id) {

            $topicManager = new TopicManager();         // Instancier cette variable pour accéder aux méthodes de la classe 
            $categoryManager = new CategoryManager();   // Instancier cette variable pour accéder aux méthodes de la classe et permettre l'ajout de topic dans une catégorie vide
            
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

         /**
         * Redirect to page addformTopic.php
         */
        public function addFormTopic(){
            /* the required objects are instantiated */
            $categoryManager = new CategoryManager();

            /* check if the user is ban */
            if(Session::isBan()){
                Session::addFlash("error", "Acces refusé. Raison: ".Session::getUser()->getPseudoUser()." est banni");
                $this->redirectTo("forum");
            }

            //filter the data from url via the metthod GET
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if(!$id){
                Session::addFlash("error", "Données invalide");
                $this->redirectTo("forum");
            }

            return [
                "view" => VIEW_DIR . "forum/topic/addFormTopic.php",
                "data" => ["category" => $categoryManager->findOneById($id)] 
            ];
        }

        /*To add a topic inside a category*/
        public function addTopic() {
            /* the required objects are instantiated */
            $topicManager = new TopicManager();
            $postManager = new PostManager();
            

            /* If the form has a faillure*/
            if(!isset($_POST["submitTopicInCategory"])){
                Session::addFlash("error", "Echec du formulaire !");
                $this->redirectTo("security", "goToSignUp");
            }

            /*Filter the datas send by the form*/
            $nameTopic = filter_input(INPUT_POST, "nameTopic", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $textPost = filter_input(INPUT_POST, "textPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idCategory = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /*check if the filter fail*/
            if(!$nameCategory || !$textPost || !$idCategory){
                Session::addFlash("error", "Données non valides !");
                $this->redirectTo("home");
            }
             /* Add a topic and get his id */
             $idTopic = $topicManager->add([
                "nameTopic" => $nameTopic,
                "user_id" => Session::getUser()->getId(),
                "category_id" => $idCategory
            ]);

            /* Add the first post in the new topic */
            if($idTopic && $postManager->add([
                "textPost" => $textPost,
                "user_id" => Session::getUser()->getId(),
                "topic_id" => $idTopic
            ])){
                $session->addFlash("success", "Ajout du topic '$nameTopic' réussi !");
                $this->redirectTo("post", "listPosts", "$idTopic");
            }
            else{
                $session->addFlash("error", "Échec de l'ajout du topic !");
                $this->redirectTo("forum", "addFormTopic", "$idCategorie");
            }         


        }

        /*shares reserved for admin : delete a topic*/
            public function deleteTopic() {
                /* the required objects are instantiated */
            $topicManager = new TopicManager();
            $postManager = new PostManager();
            
            // filter data received from GET
            $idTopic = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //check if filter fail
            if(!$idTopic){
                Session::addFlash('error',"Données invalide - le filtrage a échouée !");
                $this->redirectTo("forum");
            }

            //if user is not the admin, the action is canceled
            if(!Session::isAdmin()){
                Session::addFlash('error',"Action refusé - vous n'avez pas le niveau requis de privilège");
                $this->redirectTo("forum");
            }
            
            $nameTopic = $topicManager->findOneById($idTopic)->getNameTopic();

            /* Delete on cascade : delete all the posts linked with the Topic and finally the Topic itself */
            if($postManager->deleteAllPostByTopic($idTopic) && $TopicManager->delete($idTopic)){
                Session::addFlash("success", "Suppression du sujet : '$nameTopic' réussi !");
                $this->redirectTo("forum");
            }
            else{
                Session::addFlash("error", "Échec de la suppression !");
                $this->redirectTo("forum");
                }

            }


        

    }
