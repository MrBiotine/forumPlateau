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
                            if($passWordUser == $passWordConfirmed && (strlen($passWordUser)>12)){
                                
                                /* password is hashed  - le hashage est un mécanisme unudirectionnel et irréversible. ON NE DEHASH PAS UN PASSWORD !!*/
                                //passbord_hash demande l'algo de hash a utilisé - ARGON2I et BCRYPT sont recommandés
                                $passWordHash = password_hash($passWordUser, PASSWORD_DEFAULT);
                                //password_default utilise BCRYPT comme algo de hash pae défault
                                //BCRYPT est en algo fort comme ARGON2I
                                //Il crée un empreinte numérique composé de l'algo utilisé, d'un COST, d'un SALT et du passWord hashé
                                //Le SALT est une chaine aleatoire hashé qui sera concaténé au passWord hashé
                                //augmente grandement la difficulté d'un pirate de trouver le mot de passe à partir du hash

                                /* user is added in db */
                                if($userManager->add([
                                    "pseudoUser" => $pseudoUser,
                                    "emailUser" => $emailUser,
                                    "passWordUser" => $passWordHash,
                                    "roleUser" => json_encode("ROLE_USER") 
                                ])){
                                    Session::addFlash("success", "Inscription réussi ! Connectez-vous !");
                                    $this->redirectTo("security", "goToSignIn");
                                }
                                else{
                                    Session::addFlash("error", "Échec de l'inscription ! insertion fail !");
                                    $this->redirectTo("security", "goToSignUp");
                                }
                            }
                            else{
                                Session::addFlash("error", "Les mots de passe ne sont pas identiques ! Veuillez les saisirs à nouveau !");
                                $this->redirectTo("security", "goToSignUp");
                            }
                        }
                        else{
                            Session::addFlash("error", "Le pseudo saisit existe déjà ! Saisissez-en un autre !");
                            $this->redirectTo("security", "goToSignUp");
                        }
                    }
                    else{
                        Session::addFlash("error", "L'email saisit existe déjà ! Saisissez-en un autre !");
                        $this->redirectTo("security", "goToSignUp");
                    }
                }
                else{
                    Session::addFlash("error", "Échec de l'inscription ! Filter fail");
                    $this->redirectTo("security", "goToSignUp");
                }
            }
            else{
                Session::addFlash("error", "Échec de l'inscription ! Form fail !");
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
                            //PASSWORD_VERIFY VA COMPARER 2 CHAINES DE CARACTERES HASHEES !!

                            //check if the user is not ban
                            if($user->getIsBanUser() == 0){
                                Session::setUser($user); // then user is stored in the current session
                                Session::addFlash("success", "Connexion réussie ! Bienvenue " . Session::getUser()->getPseudoUser()); // Display the user pseudo
                                $this->redirectTo("forum");
                            }else{
                                Session::addFlash("error", "Acces refusé - vous êtes Banni !");
                                return [
                                    "view" => VIEW_DIR."home.php"
                                ];
                            }
                            
                        }
                        else{
                            Session::addFlash("error", "L'email ou le mot de passe n'est pas bon ! Réessayez");
                            $this->redirectTo("security", "goToSignIn");
                        }
                    }
                    else{
                        Session::addFlash("error", "Échec de la connexion ! Réessayez");
                        $this->redirectTo("security", "goToSignIn");
                    }
                }
                else{
                    Session::addFlash("error", "Échec de la connexion ! Réessayez");
                    $this->redirectTo("security", "goToSignIn");
                }
            }
            else{
                Session::addFlash("error", "L'email ou le mot de passe est invalide ! Réessayez ");
                $this->redirectTo("security", "goToSignIn");
            }
        }

        /**
         * perform Logout
         */
        public function logOut(){            

            /* destroy definitely the session then logout the user */
            if(session_unset() && session_destroy()){
                Session::addFlash("success", "Déconnexion réussi !");
                $this->redirectTo("security", "goToSignIn");
            }
            else{
                Session::addFlash("error", "Échec de la déconnexion !");
                return [
                    "view" => VIEW_DIR . "home.php"
                ];
            }
        }

        /*-------------------------SECTION PASSWORD--------------------------------------------------------------------*/
        
         /**
         * Access form to update the passWord
         */
        public function updateFormPassWord(){
            return[
                "view" => VIEW_DIR . "security/updateFormPassWord.php"
            ];
        }
        /*To update a pssWord*/
        public function updatePassWord(){
            /* the required objects are instantiated */
            $userManager = new UserManager();         
            
            /* if the form fail */
            if(!isset($_POST["submitUpdatePassWord"])){
                Session::addFlash("error", "Pas de donées ! Le formulaire à échoué !");
                $this->redirectTo("security");
            }                
            /* Filtering inputs */
            $oldPassWord = filter_input(INPUT_POST, "oldPassWord", FILTER_SANITIZE_EMAIL);
            $newPassWord = filter_input(INPUT_POST, "newPassWord", FILTER_SANITIZE_SPECIAL_CHARS);
            $passWordConfirmed = filter_input(INPUT_POST, "passWordConfirmed", FILTER_SANITIZE_SPECIAL_CHARS);

            /*ckeck if the filters fail*/
            if(!$oldPassWord || !$newPassWord || !$passWordConfirmed){
                Session::addFlash("error", "Pas de donées ! Le filtrage à échoué !");
                $this->redirectTo("security");
            }
            $hashedPassWord = Session::getUser()->getPassWordUser(); // get the user hashed passWord stored in database

            /*check if get hashed passWord fail*/
            if(!$hashedPassWord){
                Session::addFlash("error", "Erreur dans la session - donnée non récupérré");
                $this->redirectTo("security");
            }
            /*check If oldPassword no matches hashed pssWord*/
            if(!password_verify( $oldPassWord, $hashedPassWord )){
                Session::addFlash("error", "Mot de passe incorrect - réessayer");
                $this->redirectTo("security", "updateFormPassWord");
            }

            /*check if  $newPassWord and $passWordConfirmed are different*/
            if($newPassWord != $passWordConfirmed){
                Session::addFlash("error", "Les mots de passe ne sont pas identiques - réessayer");
                $this->redirectTo("security", "updateFormPassWord");
            }

            /*The new passWord is hashed*/
            $newHashPassWord = password_hash($newPassWord, PASSWORD_DEFAULT) ;
            /*The new hashed passWord is inserted into db*/
            if($userManager->updatePassWord(Session::getUser()->getId(), $newHashPassWord)){
                Session::addFlash("success", "Modification du mot de passe réussi !");
                Session::getUser()->setPassWordUser($newHashPassWord);
                $this->redirectTo("security", "goProfil");
            }
            else{
                Session::addFlash("error", "Échec de la modification du mot de passe !");
                $this->redirectTo("security", "updateFormPassWord");
            }
        }

        /*----------------------------------------SECTION EMAL*/
             /**
         * Access form to update the user email
         */
        public function updateFormEmail(){
            return[
                "view" => VIEW_DIR . "security/updateFormPassWord.php"
            ];
        }

        public function updateEmail() {
            /* the required objects are instantiated */
            $userManager = new UserManager();         
            
            /* if the form fail */
            if(!isset($_POST["submitUpdateEmail"])){
                Session::addFlash("error", "Pas de donées ! Le formulaire à échoué !");
                $this->redirectTo("security");
            }                
            /* Filtering inputs */
            $oldEmail = filter_input(INPUT_POST, "oldEmail", FILTER_SANITIZE_EMAIL);
            $newEmail = filter_input(INPUT_POST, "newEmail", FILTER_SANITIZE_EMAIL);
            $confirmedEmail = filter_input(INPUT_POST, "ConfirmedEmail", FILTER_SANITIZE_EMAIL);
            $passWord = filter_input(INPUT_POST, "passWord", FILTER_SANITIZE_SPECIAL_CHARS);



            /*ckeck if the filters fail*/
            if(!$oldEmail || !$newEmail || !$emailConfirmed || !$passWord){
                Session::addFlash("error", "Données manquantes ! Le filtrage à échoué !");
                $this->redirectTo("security");
            }

            /* check if the oldEmail matche the current user email */
            if($oldEmail != Session::getUser()->getEmailUser()){
                Session::addFlash("error", "Eamil incorrect - réessayer");
                $this->redirectTo("security", "updateFormEmail");
            }

             /* check if the nex email matche the confirmed email */
             if($newEmail != $confirmedEmail){
                Session::addFlash("error", "Eamil incorrect - réessayer");
                $this->redirectTo("security", "updateFormEmail");
            }

            
            $hashedPassWord = Session::getUser()->getPassWordUser(); // get the user hashed passWord stored in database

            /*check if get hashed passWord fail*/
            if(!$hashedPassWord){
                Session::addFlash("error", "Erreur dans la session - donnée non récupérré");
                $this->redirectTo("security");
            }
            /*check If Password no matches hashed pssWord*/
            if(!password_verify($passWord, $hashedPassWord)){
                Session::addFlash("error", "Mot de passe incorrect - réessayer");
                $this->redirectTo("security", "updateFormEmail");
            }

            /*The new user email is inserted into db and added to the current session*/
            if($userManager->updateMail(Session::getUser()->getId(), $newEmail)){
                Session::addFlash("success", "Modification du mel réussi !");
                Session::getUser()->setEmailUser($newEmail);
                $this->redirectTo("security", "goProfil");
            }
            else{
                Session::addFlash("error", "Échec de la modification du mel !");
                $this->redirectTo("security", "updateFormPassWord");
            }


        }

    }

?>