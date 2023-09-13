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
                Session::addFlash("error","Données invalides");              
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

        //access form to add a post
        public function addFormPost(){
            return [
                "view" => VIEW_DIR . "forum/post/addFormPost.php"
            ];
        }

        //perform add a post
        public function addPost(){
            /* the required objects are instantiated */
                $topicManager = new TopicManager();
                $postManager = new PostManager();

            /* ckeck if the form fail */
            if(!isset($_POST["addPost"])){
                Session::addFlash("error", "Le formulaire a échoué !");
                $this->redirectTo("post","addFormPost");
            }

            /* Filter  external data*/
            $textPost = filter_input(INPUT_POST, "contenu", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idTopic = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /*check if the filter fail*/
            if(!$textPost || !$idTopic){
                Session::addFlash("error", "Les données sont invalides !");
                $this->redirectTo("post","addFormPost");
            }

            /*check if the topic is lock*/
            if($topicManager->findOneById($idTopic)->getIsLockTopic()){
                Session::addFlash("error", "Ajout impossible - le sujet est verouillé !");
                $this->redirectTo("forum");
            }

             /* Finally the post is added */
             if($postManager->add([
                "textPost" => $textPost,
                "user_id" => Session::getUser()->getId(),
                "topic_id" => $idTopic
            ])){
                Session::addFlash("success", "Ajout du post dans le topic '" . $topicManager->findOneById($idTopic)->getNameTopic() . "' réussi !");
                $this->redirectTo("post", "listPosts", "$idTopic");
            }
            else{
                Session::addFlash("error", "Échec de l'ajout du post !");
                $this->redirectTo("post", "addFormPost");
            }
        }

        public function deletePost(){
            /* the required objects are instantiated */
            $topicManager = new TopicManager();
            $postManager = new PostManager();

            //check if the user is ban
            if(Session::getUser->getIsBanUser() == 1){
                Session::addFlash("error", "Action refusé - vous êtes banni !");
                $this->redirectTo("security");
            }

            /* Filter  external data*/
            $idPost = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            /*Get the topic id*/
            $idTopic = $postManager->findOneById($idPost)->getTopic()->getId();

            /*check if the filter fail or if we thr idtopic is null or no available*/
            if(!$idPost || !$idTopic){
                Session::addFlash("error", "Les données sont invalides !");
                $this->redirectTo("post","addFormPost");
            }

            /*ckeck if the topic is lock*/
            if($topicManager->findOneById($idTopic)->getIsLockTopic() == 1){
                Session::addFlash("error", "Ajout impossible - le sujet est verouillé !");
                $this->redirectTo("forum");
            }
            /*check if the user is not the post author nor a admin*/
            if(!(Session::getUser()->getId() == $postManager->findUserPost($idPost)) && !Session::isAdmin()){
                Session::addFlash("error", "Vous n'êtes pas autoriser à supprimer le post !");
                $this->redirectTo("post", "listPosts", "$idTopic");
            }

             /* Finally the post is deleted */
             if($postManager->delete($idPost)){
                Session::addFlash("success", "Suppression du post dans le topic '" . $topicManager->findOneById($idTopic)->getNameTopic() . "' réussi !");
                $this->redirectTo("post", "listPosts", "$idTopic");
            }
            else{
                Session::addFlash("error", "Échec de la suppression du post !");
                $this->redirectTo("post", "addFormPost");
            }
        }

        public function updateFormPost(){
            /* the required objects are instantiated */
            $postManager = new PostManager();
            
            /* Inputs are filtering */
            $idPost = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /* if the filter work */
            if($idPost){
                return [
                    "view" => VIEW_DIR . "forum/post/updatePost.php",
                    "data" => [
                        "post" => $postManager->findOneById($idPost)
                    ]
                ];
            }
            else{
                $this->redirectTo("home");
            }
        }

        /*Perform a post update*/
        public function updatePost(){
            /* the required objects are instantiated */
                $topicManager = new TopicManager();
                $postManager = new PostManager();

            /* ckeck if the form fail */
            if(!isset($_POST["updatePost"])){
                Session::addFlash("error", "Le formulaire a échoué !");
                $this->redirectTo("post","updateFormPost");
            }

            /* Filter  external data*/
            $newPost = filter_input(INPUT_POST, "newPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idPost = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            /*check if the filter fail*/
            if(!$newPost || !$idPost){
                Session::addFlash("error", "Les données sont invalides !");
                $this->redirectTo("post","updateFormPost");
            }

            /*check if the topic is lock*/
            if($topicManager->findOneById($idPost)->getIsLockTopic() == 1){
                Session::addFlash("error", "Modification impossible - le sujet est verouillé !");
                $this->redirectTo("forum");
            }

             /* Finally the post is added */
             if($postManager->add([
                "textPost" => $textPost,
                "user_id" => Session::getUser()->getId(),
                "topic_id" => $idTopic
            ])){
                Session::addFlash("success", "Ajout du post dans le topic '" . $topicManager->findOneById($idTopic)->getNameTopic() . "' réussi !");
                $this->redirectTo("post", "listPosts", "$idTopic");
            }
            else{
                Session::addFlash("error", "Échec de l'ajout du post !");
                $this->redirectTo("post", "addFormPost");
            }
        }

                

        

    }