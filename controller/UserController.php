<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\PostManager;
    use Model\Managers\TopicManager;

    class MembreController extends AbstractController implements ControllerInterface{
        
        public function index(){
            $userManager = new UserManager();
            return [
                "view" => VIEW_DIR . "security/listusers.php",
                "data" => [
                    "membres" => $userManager->findAll(['dateInscription', 'DESC'])
                ]
            ];
        }

        /**
         * Allows admins to access member profiles
         */
        public function profilAdmin(){
            /* the required objects are instantiated */
            $userManager = new UserManager();
            $topicManager = new TopicManager();
            $postManager = new PostManager();

            /* filter data received from GET */
            $idUser = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /* If the filter works */
            if($idUser){
                return [
                    "view" => VIEW_DIR . "security/profilAdmin.php",
                    "data" => [
                        "User" => $UserManager->findOneById($idUser),
                        "nbTopics" => $UserManager->numberPostByUser($idUser),
                        "nbPosts" => $UserManager->numberTopicByUser($idUser),
                        "topics" => $topicManager->findTopicsUser($idUser, ["dateCreation", "DESC"]),
                        "lastPosts" => $postManager->findFiveLastPost($idUser)
                    ]
                ];
            }
            else{
                Session::addFlash("error", "Données manquantes ou invalides");
                $this->redirectTo("User");
            }
        }
    }