<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;

    class SecurityController extends AbstractController implements ControllerInterface{
        
        public function index(){
            return [
                "view" => VIEW_DIR."home.php"
            ];
        }

        /**
         * redirect to page signUp
         */
        public function goToSignUp(){
            return [
                "view" => VIEW_DIR . "security/signUp.php"
            ];
        }

         /**
         * Allow to signup
         */
        public function signUp(){
            /* the required objects are instantiated */
            $userManager = new UserManager();
            $session = new Session();

            /* if the form send datas */
            if(isset($_POST["submitInscription"])){

                /* Filter datas send by the form 'signup.php' with post method */
                $pseudo = filter_input(INPUT_POST, 'pseudoUser', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, 'emailUser', FILTER_SANITIZE_EMAIL);
                $passWord = filter_input(INPUT_POST, 'passWorUser', FILTER_SANITIZE_SPECIAL_CHARS);
                $passWordBis = filter_input(INPUT_POST, 'passWordConfirmed', FILTER_SANITIZE_SPECIAL_CHARS);
                
                /* if filter is successful */
               // if($pseudo && $email && $passWord && $passWordBis){

                    /* if email doesen't exist  */
                    if(!$userManager->findEmail($email)){
                        
                        /* if pseudo doesen't exist */
                        if(!$userManager->findPseudo($pseudo)){
                            
                            /* if $passWord and $passWordconfirmed are identical */
                            if($passWord == $passWordBis){
                                
                                /* password is hashed */
                                $passWordHash = password_hash($passWord, PASSWORD_DEFAULT);

                                /* user is added in db */
                                if($userManager->add([
                                    "pseudoUser" => $pseudo,
                                    "emailUser" => $email,
                                    "passWordUser" => $passWordHash,
                                    "roleUser" => "ROLE_USER"
                                ])){
                                    $session->addFlash("success", "Inscription réussi ! Connectez-vous !");
                                    $this->redirectTo("security", "goToSignIn");
                                }
                                else{
                                    $session->addFlash("error", "Échec de l'inscription ! insertion fail !");
                                    $this->redirectTo("security", "goToSignUp");
                                }
                            }
                            else{
                                $session->addFlash("error", "Les mots de passe ne sont pas identiques ! Veuillez les saisirs à nouveau !");
                                $this->redirectTo("security", "goToSignUp");
                            }
                        }
                        else{
                            $session->addFlash("error", "Le pseudo saisit existe déjà ! Saisissez-en un autre !");
                            $this->redirectTo("security", "goToSignUp");
                        }
                    }
                    else{
                        $session->addFlash("error", "L'email saisit existe déjà ! Saisissez-en un autre !");
                        $this->redirectTo("security", "goToSignUp");
                    }
               // }
               // else{
               //     $session->addFlash("error", "Échec de l'inscription ! Filter fail");
               //     $this->redirectTo("security", "goToSignUp");
               // }
            }
            else{
                $session->addFlash("error", "Échec de l'inscription ! form fail !");
                $this->redirectTo("security", "goToSignUp");
            }
        }

        /**
         * redirect to page signIn.php
         */
        public function goToSignIn(){
            return [
                "view" => VIEW_DIR . "security/signIn.php"
            ];
        }

        /**
         * Allow to signIn
         */
        public function signIn(){
            /* the required objects are instantiated */
            $userManager = new userManager();
            $session = new Session();

            /* if the form send datas */
            if(isset($_POST["submitsignIn"])){
                
                /* Filter datas send by the form 'signin.php' with post method */
                $email = filter_input(INPUT_POST, "emailUser", FILTER_SANITIZE_EMAIL);
                $passWord = filter_input(INPUT_POST, "passWordUser", FILTER_SANITIZE_SPECIAL_CHARS);

                /* if filter is a success */
                if($email && $passWord){
                    $passWordBdd = $userManager->findPassWord($email); // Find the password associated with the email address
                    
                    /* if password exist */
                    if($passWordBdd){
                        $hash = $passWordBdd->getpassWord(); // get the hash stored in the database
                        $user = $userManager->findEmail($email); // get the user with his email
                        
                        /* if $passWord and $hash are identical */
                        if(password_verify($passWord, $hash)){
                            Session::setUser($user); // user is stored in the current session
                            $session->addFlash("success", "Connexion réussie ! Bienvenue " . Session::getUser()->getPseudoUser()); // Display the user pseudo
                            return [
                                "view" => VIEW_DIR . "home.php"
                            ];
                        }
                        else{
                            $session->addFlash("error", "L'email ou le mot de passe n'est pas bon ! Réessayez");
                            $this->redirectTo("security", "goToSignIn");
                        }
                    }
                    else{
                        $session->addFlash("error", "Échec de la connexion ! Réessayez");
                        $this->redirectTo("security", "goToSignIn");
                    }
                }
                else{
                    $session->addFlash("error", "Échec de la connexion ! Réessayez");
                    $this->redirectTo("security", "goToSignIn");
                }
            }
            else{
                $session->addFlash("error", "L'email ou le mot de passe n'est pas bon ! Réessayez");
                $this->redirectTo("security", "goToSignIn");
            }
        }
    }

?>