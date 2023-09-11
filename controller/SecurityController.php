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
                $pseudoUser = filter_input(INPUT_POST, 'pseudoUser', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $emailUser = filter_input(INPUT_POST, 'emailUser', FILTER_SANITIZE_EMAIL);
                $passWordUser = filter_input(INPUT_POST, 'passWordUser', FILTER_SANITIZE_SPECIAL_CHARS);
                $passWordConfirmed = filter_input(INPUT_POST, 'passWordConfirmed', FILTER_SANITIZE_SPECIAL_CHARS);
                
                /* if filter is successful */
                if($pseudoUser && $emailUser && $passWordUser && $passWordConfirmed){

                    /* if emailUser doesen't exist  */
                    if(!$userManager->findEmail($emailUser)){
                        
                        /* if pseudoUser doesen't exist */
                        if(!$userManager->findPseudo($pseudoUser)){
                            
                            /* if $passWordUser and $passWordconfirmed are identical */
                            if($passWordUser == $passWordConfirmed){
                                
                                /* password is hashed */
                                $passWordHash = password_hash($passWordUser, PASSWORD_DEFAULT);

                                /* user is added in db */
                                if($userManager->add([
                                    "pseudoUser" => $pseudoUser,
                                    "emailUser" => $emailUser,
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
                }
                else{
                    $session->addFlash("error", "Échec de l'inscription ! Filter fail");
                    $this->redirectTo("security", "goToSignUp");
                }
            }
            else{
                $session->addFlash("error", "Échec de l'inscription ! Form fail !");
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
            if(isset($_POST["submitSignIn"])){
                
                /* Filter datas send by the form 'signin.php' with post method */
                $emailUser = filter_input(INPUT_POST, "emailUser", FILTER_SANITIZE_EMAIL);
                $passWordUser = filter_input(INPUT_POST, "passWordUser", FILTER_SANITIZE_SPECIAL_CHARS);

                /* if filter is a success */
                if($emailUser && $passWordUser){
                    $passWordBdd = $userManager->findPassWord($emailUser); // Find the password associated with the emailUser address
                    
                    /* if password exist */
                    if($passWordBdd){
                        $hash = $passWordBdd->getPassWordUser(); // get the hash stored in the database
                        $user = $userManager->findEmail($emailUser); // get the user with his email                       
                        
                                                   
                        /* if $passWordUser and $hash are identical */
                        if(password_verify($passWordUser, $hash)){
                            Session::setUser($user); // user is stored in the current session
                            Session::addFlash("success", "Connexion réussie ! Bienvenue " . Session::getUser()->getPseudoUser()); // Display the user pseudo
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
                $session->addFlash("error", "L'email ou le mot de passe est invalide ! Réessayez ");
                $this->redirectTo("security", "goToSignIn");
            }
        }

        /**
         * perform Logout
         */
        public function logOut(){
            /* the required objects are instantiated */
            $session = new Session();

            /* destroy definitely the session then logout the user */
            if(session_unset() && session_destroy()){
                $session->addFlash("success", "Déconnexion réussi !");
                return [
                    "view" => VIEW_DIR . "home.php"
                ];
            }
            else{
                $session->addFlash("error", "Échec de la déconnexion !");
                return [
                    "view" => VIEW_DIR . "home.php"
                ];
            }
        }
    }

?>