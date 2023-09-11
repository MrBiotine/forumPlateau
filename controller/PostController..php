<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\PostManager;
    use Model\Managers\TopicManager;

    class PostController extends AbstractController implements ControllerInterface{
        public function index(){}

        /**
         * Lists the posts in a topic
         */
        public function listPosts(){
            /* the required objects are instantiated */
            $topicManager = new TopicManager();
            $postManager = new PostManager();

            /* Filter  external data*/
            $idTopic = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            /* Check if the filter fail */
            if(!$idTopic){
                Session::addFlash("error","Données invalides")              
                $this->redirectTo("forum","listTopics");
            }
            return [
                    "view" => VIEW_DIR . "forum/Post/listPosts.php",
                    "data" => [
                        "posts" => $postManager->findListByIdDep($idTopic, "topic", ["datePost", "DESC"]),
                        "old" => $postManager->findOldestPost($idTopic),
                        "topic" => $topicManager->findOneById($idTopic)
                    ]
                ];
        }

    }