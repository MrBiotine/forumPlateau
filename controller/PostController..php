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
        public function listerPostsDansTopic(){
            /* the required objects are instantiated */
            $topicManager = new TopicManager();
            $postManager = new PostManager();

            /* Filter  external data
  */
            $idTopic = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            /* Si le filtrage fonctionne */
            if(!$idTopic){


                return [
                    "view" => VIEW_DIR . "forum/Post/listerPostsDansTopic.php",
                    "data" => [
                        "posts" => $postManager->findPostinTopic($idTopic),
                        "ancien" => $postManager->findOldestPost($idTopic),
                        "topic" => $topicManager->findOneById($idTopic)
                    ]
                ];
            }
            else{
                $this->redirectTo("topic");
            }
        }

    }