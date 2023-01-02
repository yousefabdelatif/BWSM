<?php
require "model/AppModel.php"; 
require "view/AppView.php"; 
require("controller\Utils\UplodedFile.php");
require("model\FriendSuggestionSystemModel.php");
require("view\FriendSuggestionSystemView.php");
include_once("ErrorHandler\ErrorHandler.php");
include_once("controller\AppRoutes\AppRoutes.php");
include_once("view\PosterView.php");
include_once("model\PosterModel.php");



function set_url( $url )
{
    echo("<script>history.replaceState({},'','$url');</script>");
}


class AppController
{

    private ERR_MSG_Handler  $m_ERR_MSG_Handler;
    private view $m_View;
    private Model $m_Model;
    private User $m_CurrentUser;
    private FriendSuggestionSystemModel $m_FriendSuggestionSystemModel;
    private FriendSuggestionSystemView $m_FriendSuggestionSystemView;
    private PosterModel $m_PosterModel;
    private PosterView $m_PosterView;
    private array $Routes;
    public function __construct(string $hostName ="localhost:3307",string $username='root',string $password='yousef123')
    {   
        
        $this->m_CurrentUser =new User();
        $this->m_ERR_MSG_Handler = new ERR_MSG_Handler;     
        $this->m_PosterView =new PosterView;
        $this->m_FriendSuggestionSystemView =new FriendSuggestionSystemView();
        $this->m_Model=new Model($hostName,$username,$password);
        $this->m_View = new View($this->m_ERR_MSG_Handler);
        $this->m_PosterModel =new PosterModel($this->m_Model->GetAppModel_db());
        $this->m_FriendSuggestionSystemModel = new FriendSuggestionSystemModel($this->m_Model->GetAppModel_db());

    }


    public function GET_Current_Route():string|null
    {
        return explode('?', $_SERVER["REQUEST_URI"])[0];
    }
    public function AddRoute(string $method ,string $Route ,callable $RouteCallBackFunc)
    {
        if(($method != 'POST')&&($method != 'GET'))
        {
            echo "NOT_A_VALID_ROUTE_METHOD";
            throw (new Exception);
        } else {
            $this->Routes[$Route . $method] = $RouteCallBackFunc;
        }
    }
    public function resolve()
    {
        $CurrentRoute = explode('?', $_SERVER["REQUEST_URI"])[0];
        $CurrentRouteCallbackFunc =  $this->Routes[$CurrentRoute.$_SERVER['REQUEST_METHOD']] ?? null;
        if(!$CurrentRouteCallbackFunc)
        {
            
        }else{return call_user_func($CurrentRouteCallbackFunc);}
    }

    public function Run()
    {
/////////////////////////logIn///////////////////////////////////////////////////////////////////
        $this->AddRoute('POST', AppRoutes::LOG_IN, function () {
            if($_SESSION['CurrentUserLogingState']==true)
                {
                   header("Location:/bwsm/MainPage ");

                }
            else
                {  
                    
                    $this->m_View->showLoginPage();
                    $_SESSION = array();
                }});



        $this->AddRoute('POST',AppRoutes::USER_PASSWORD_VERTIFICATION, function () {    
            $temp ="";
            $this->m_CurrentUser->SetEmail($_POST['Email']);
            if(
                $this->m_Model->GetUserData($this->m_CurrentUser) 
                and 
                $this->m_Model->CheckUserPassword($this->m_CurrentUser))
            {
                $temp = ('/bwsm/MainPage');
                $this->m_CurrentUser->SetUserLogingState(true);
            } 
            else 
            {
                $temp = ('/bwsm/');
                $this->m_ERR_MSG_Handler->SET_ERR("User doesnot exist",'/bwsm/') ;
            }
           header("Location: $temp");
         });
///////////////////////////////signup/////////////////////////////////////////////////////////////////
        $this->AddRoute('POST',AppRoutes::SIGN_UP, 
        function () {       




           // $_SESSION = array();
        $this->m_View->showSignupPage();
            
         }
        );

        $this->AddRoute('POST', AppRoutes::NEW_USER_VERTIFICATION, function () {       ;

            if 
            (
                ($_POST['Email']!="") 
                and
                ($_POST['Password']!="") 
                and 
                ($_POST['UserName']!="")
            ) 
            {
                $this->m_Model->AddNewUser($this->m_CurrentUser, $_POST['Email'], $_POST['Password'], ($_POST['UserName']));
               header("Location:/bwsm/ProfileSetUpPage");
                $this->m_Model->GetUserData($this->m_CurrentUser);
                $this->m_Model->setUserProfilePicUrl($this->m_CurrentUser);
            }else
            {                
                $this->m_ERR_MSG_Handler->SET_ERR("Please enter Valied User data","/bwsm/SignupPage");
                header("Location:/bwsm/SignupPage");
            }
           
        });



        $this->AddRoute('POST',AppRoutes::PRPFILE_SETUP, function () {       

        $_FILES =array();
        $this->m_View->showProfileSetUpPage('view\Ref\MultiMedia\photos\example.jpg',AppRoutes::PICTURE_SAVING);

         });


         $this->AddRoute('POST',AppRoutes::PICTURE_SAVING, function () { 

            $File = new UplodedFile("Picture",(date("YmdH")).$this->m_CurrentUser->GetUserID(), 'pics\\',$this->m_ERR_MSG_Handler);
            $_SESSION["TempURL"] = $File->GetFileLocation();
            $FileValidty=$File->CheckFileValidation("png",524288,1024);
            if(!$FileValidty[UplodedFile::FILE_EXTENTION_STATE])
            {

                $this->m_ERR_MSG_Handler->SET_ERR("Please Use an Image with png format","/bwsm/ProfileSetUpPage");
                header("Location:/bwsm/ProfileSetUpPage");
                try{
               !unlink($File->GetTempFileLocation()) ;
               }catch(Exception $e)
               {
                    echo $e;
               }
            }
            elseif(!$FileValidty[UplodedFile::MAXFILE_SIZE_STATE])
            {
                $this->m_ERR_MSG_Handler->SET_ERR("Please use an image of size that doesnot exceed 512kb","/bwsm/ProfileSetUpPage");

                header("Location:/bwsm/ProfileSetUpPage");

                try{!unlink($File->GetTempFileLocation());}catch(Exception $e){// echo $e; some err func
                }
            }
            
                elseif(!$FileValidty[UplodedFile::MINFILE_SIZE_STATE])
            {
                $this->m_ERR_MSG_Handler->SET_ERR("Please Use a bigger image ","/bwsm/ProfileSetUpPage");

                header("Location:/bwsm/ProfileSetUpPage");
                try{
               !unlink($File->GetTempFileLocation()) ;
               }catch(Exception $e)
               {
                    //echo $e; some err func 
               }
            }else
            {
                $File->GetItOnTheServer();
                $this->m_CurrentUser->SetUserLogingState(true);
                header("Location:".AppRoutes::PICTURE_VIEWING);

            }
         });

        $this->AddRoute('POST', AppRoutes::PICTURE_VIEWING, function () {
            $this->m_View->showProfileSetUpPage((string)("pics/".(date("YmdH")).$this->m_CurrentUser->GetUserID().".png"));


        });



//////////////main page///////////////////
        $this->AddRoute('POST',AppRoutes::MAIN_PAGE, function () {

            $this->m_FriendSuggestionSystemModel->SetApp_db
            (
                $this->m_Model->GetAppModel_db()
            );
            if ($_SESSION == array()) {
                header("Location:/bwsm/");
            } else {
                $_SESSION["CameFromProfile"] = false;

                $this->m_View->showMainUserPage(
                    function () {
                        $this->m_FriendSuggestionSystemView->RenderUserFriendSuggestion($this->m_FriendSuggestionSystemModel->GetSuggestedFriends($this->m_CurrentUser->GetUserID()),$this->m_CurrentUser->GetUserID());

                    }
                    ,
                    function () {
                        $this->m_PosterView->RenderPosts($this->m_PosterModel->GetPosts($this->m_CurrentUser->GetUserID()));
                        
                    },
                    $this->m_CurrentUser
                );


                if ($this->m_PosterModel->GetPosts($this->m_CurrentUser->GetUserID()) !== null) {
                    $this->m_PosterModel->GetPosts($this->m_CurrentUser->GetUserID());
                }
                if(isset($_POST['NewPost']))
                {
                    $this->m_PosterModel->AddnewPost($_POST['NewPost'], $this->m_CurrentUser->GetUserID());
                }
               
            }
            ;
         });

         ///////////////profile////////////////////////
        $this->AddRoute('POST', AppRoutes::PROFILE, function () {
            if ($_SESSION == array()) {
                header("Location:/bwsm/");
            } else {
                $_SESSION["CameFromProfile"] = true;
                $this->m_View->showProfilePage($this->m_CurrentUser,
                
                    $this->m_PosterModel->GetCurrentUserPosts($this->m_CurrentUser),
                    $this->m_FriendSuggestionSystemModel->GetFollowedFriends($this->m_CurrentUser->GetUserID())
                );
            }
         });




        $this->AddRoute('POST', AppRoutes::ON_LOGING_OUT, function () {
            $this->m_CurrentUser->SetUserLogingState(false);
            header("Location:/bwsm/");

           });


        $this->AddRoute('POST', AppRoutes::ON_ADDING_NEW_FRIEND, function () {

            var_dump( $_SESSION['CurrentUserID']);
            if ($_POST['NewFollowedFriend'] != $this->m_CurrentUser->GetUserID()) {
                $this->m_FriendSuggestionSystemModel->AddFriend($this->m_CurrentUser->GetUserID(), $_POST['NewFollowedFriend']);
            }
           
            
            $_POST = array();
            header("Location:/bwsm/MainPage");
        });

        $this->AddRoute('POST', AppRoutes::ON_UNFOLLOWING_FRIEND, function () {

            if ($_POST['UnFollowedFriend'] != $this->m_CurrentUser->GetUserID()) {
                $this->m_FriendSuggestionSystemModel->UnFollowAfriend($this->m_CurrentUser->GetUserID(), $_POST['UnFollowedFriend']);
            }
           
            
            $_POST = array();
            header("Location:/bwsm/Profile");
        });


        $this->AddRoute('POST', AppRoutes::ON_ADDING_LIKE, function () {
            $redirect = "MainPage";
            if(isset($_POST['Like']))
            {              
                if ($_SESSION["CameFromProfile"] === true) {
                $this->m_PosterModel->AddLike($_POST['Like'],$this->m_CurrentUser->GetUserID());
                    $redirect = "Profile";
                } else {
                    $this->m_PosterModel->AddLike($_POST['Like'], $this->m_CurrentUser->GetUserID());
                }
            }                   
             $_SESSION["CameFromProfile"] = false;
        $_POST = array();
         header("Location:/bwsm/".$redirect);

           } );

       


           
        $this->resolve();
        $_POST = [];
    }

}
