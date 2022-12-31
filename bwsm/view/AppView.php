<?php
require_once("Utils\User");
require_once("controller\AppRoutes\AppRoutes");

class View 
{   
   // public const LoginPage = 1;
   private ERR_MSG_Handler $m_ERR_MSG_Handler;
    public function __construct(ERR_MSG_Handler  $ERR_MSG_Handler_Val)

    {
        $this->m_ERR_MSG_Handler=$ERR_MSG_Handler_Val;
    }
    public function showLoginPage()
    {

        print("
<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <link rel=\"stylesheet\" href=\"index.css?v=<?php echo time(); ?>\">  
  <title>Document</title>
</head>
<body>
  <div class=\"LogingWindow\">
    <div class=\"LogingWindow_InputFields\">
    <form action=\"/bwsm/userPasswordVertification\" method=\"POST\">   
      <input type=\"text\" id=\"Email\" name=\"Email\" placeholder=\"Gmail\"><br>
      <input type=\"password\" id=\"Password\" name=\"Password\" placeholder=\"Password\">
      <div class=\"LogingWindow_Buttoms\">
<button class=\"button-4\"type=\"submit\">log in</button>
</form>

");

if($this->m_ERR_MSG_Handler->GET_ERR_MSG()!== null){
  echo ("<span style=\"
  font-weight: 500;
  color: red;
  font-weight: 900;
  display: flex;
  font-size: 16px;
  font-family: monospace;
  text-align: center;
  width: 290px;
  margin-top: 15px;
  align-items: center;
  justify-content: space-around;
\">");
  print($this->m_ERR_MSG_Handler->GET_ERR_MSG());
  echo ("</span>");
}

    print("
<form action=\"/bwsm/SignupPage\" method=\"POST\">   
<div class=\"SignUpLink\" type=\"\"><a href=\"/bwsm/SignupPage\">Sign up</a></div>
  </form>
</div>
    </div>
  </div>
</body>
</html>

        
        
        ");




       




    }
    public function showSignupPage(){
        print("
<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <link rel=\"stylesheet\" href=\"view\Ref\CssFiles\SignupStyle\">  
  <title>Document</title>
  </head>
  <body>
  <div class=\"LogingWindow\">
    <div class=\"LogingWindow_InputFields\">
    
    <form action=\"/bwsm/NewUserVertification\" method=\"POST\">  
    
      <input type=\"text\" id=\"UserName\" name=\"UserName\" placeholder=\"UserName\"> 
      <input type=\"text\" id=\"Email\" name=\"Email\" placeholder=\"Gmail\"><br>
      <input type=\"password\" id=\"Password\" name=\"Password\" placeholder=\"Password\">

      ");
         
      if($this->m_ERR_MSG_Handler->GET_ERR_MSG()!== null)
      {
            echo ("<span style=\"
            font-weight: 500;
            color: red;
            font-weight: 900;
            display: flex;
            font-size: 16px;
            font-family: monospace;
            text-align: center;
            align-items: center;
            justify-content: space-around;
        \">");
            print($this->m_ERR_MSG_Handler->GET_ERR_MSG());
            echo ("</span>");
      }
      print("
      <div class=\"LogingWindow_Buttoms\">
<button class=\"button-4\"type=\"submit\"  value=\"SEND DATA\">login</button>
  </form>
</div>
    </div>
  </div>
</body>
</html>
  ");}


public function showMainUserPage(callable $FriendSuggetionSyStemFunc,callable $PosterFunc,User $CurrentUser_Val)
  {  include("view\Ref\CssFiles\style.css");
    print
        ("
          <!DOCTYPE html>
      <html lang=\"en\">
      <head>
      <meta charset=\"UTF-8\">
      <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
      <title>Document</title>
      <link rel=\"stylesheet\" href=\"style.css\">
      <style>
      <?php 

      include(\"style.css\")
      ?>
      </style>
      </head>
      <body>
      <header class=\"header\">
          
          <div>
          <span class=\"BWSM_LOGO\">DEMO</span></div>
        <div><a href=\"/bwsm/Profile\">
          <img src=\"pics\\".$CurrentUser_Val->getUserProfilePicUrl().".png\"  style=\"
          border-radius: 10px;
          width: 32;
          height: 32;\"></a></div>
        
      </header>

      <div class=\"MainContent\">
          <div class=\"MainContent_posts\">
            


              <nav class=\"SuggestedFriends\">

            
");
        call_user_func($FriendSuggetionSyStemFunc);
        print("</nav>");
        print(" 
           <div class=\"AddingPostDiv\">
           <form class=\"\">   </form>
           <div class=\"Poster_Buttoms\">
          <form class=\"InputPosterButtons\" action=\"/bwsm/MainPage\" method=\"post\">
          <div class=\"InputPoster\">      
          <textarea  class=\"TEXTINputField\" type=\"text\"   rows=\"5\" cols=\"60\" name=\"NewPost\" value=\"jjj\" placeholder=\"Enter text\"></textarea>
          </div>
          <input type=\"submit\" class=\"SAVEPOST_buttom\" value=\"POST\" />
          </form>
          </form>
          </div>
          </div>
          <pre>
          ");

           call_user_func($PosterFunc);
        print("
        </pre>
        </div>
        </div>
        </div>
        <footer class=\"Footer\">
        <form class=\"SuperContianer\" action=\"/bwsm/MainPage\" method=\"POST\"><button type=\"submit\"class=\"FooterButton\"><img src=\"view\Ref\MultiMedia\icons/house.png\"/></button></form></div>

        <form class=\"SuperContianer\" action=\"/bwsm/Profile\" method=\"POST\"><button type=\"submit\" class=\"FooterButton\"><img src=\"view\Ref\MultiMedia\icons/user.png\"/></button></form></div>
        <form class=\"SuperContianer\" action=\"/bwsm/LogOut\" method=\"POST\"><button type=\"submit\" class=\"FooterButton\"><img src=\"view\Ref\MultiMedia\icons\logout.png\"/></button></form></div>
        </footer>
        </body>
        </html>
        ");

    }
   
    public function showProfileSetUpPage(string $TempPhoto)
    {


        print("
<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <link rel=\"stylesheet\" href=\"view\Ref\CssFiles\ProfileSetupPage\">  
  <title>Document</title>
</head>
<body>
  <div class=\"LogingWindow\">
    <div class=\"LogingWindow_InputFields\">
    
    <form action=\"".AppRoutes::PICTURE_SAVING."\" enctype=\"multipart/form-data\" method=\"post\">  
    
<img src=\"$TempPhoto\" alt=\"\" srcset=\"\"  class=\"UserPICExample\">
<label class=\"label\" >
<input type=\"file\" name=\"Picture\" id=\"\">
<span>uplode A photo</span>
</label>
      <div class=\"LogingWindow_Buttoms\">
      <button class=\"button-4\" type=\"submit\"> <div>View</div></button>
      <a class=\"button-4\" style=\"text-decoration: 0;\"href=\"".AppRoutes::MAIN_PAGE."\"> Save and GetStarted</a>

    
    ");
            
      if($this->m_ERR_MSG_Handler->GET_ERR_MSG() !==null){
        echo ("<span style=\"
        font-weight: 500;
        color: red;
        font-weight: 900;
        display: flex;
        font-size: 16px;
        font-family: monospace;
        text-align: center;
        width: 290px;
        margin-top: 15px;
        align-items: center;
        justify-content: space-around; \">");
        print($this->m_ERR_MSG_Handler->GET_ERR_MSG());
        echo ("</span>");
  };print("
</div>
  </form>

    </div>
    
  </div>
</body>
<style>
</style>
</html>
        ");

    }
    public function showProfilePage(User &$CurrentUser_Val,array $UserPostsData ,array $followedFriends)
    {
        include("view\Pages\ProfilePage");
        $name = $CurrentUser_Val->GetName();
        $Email = $CurrentUser_Val->GetEmail();
        $img_src =  $CurrentUser_Val->GetName().$CurrentUser_Val->GetEmail();
            
    include("view\Ref\CssFiles\UserProfilePage.css");
    print
      ("
          <!DOCTYPE html>
      <html lang=\"en\">
      <head>
      <meta charset=\"UTF-8\">
      <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
      <title>Document</title>
      <link rel=\"stylesheet\" href=\"style.css\">
      <style>
      <?php 

      include(\"style.css\")
      ?>
      </style>
      </head>
      <body>
      <header class=\"header\">
          
          <div>
          <span class=\"BWSM_LOGO\">DEMO</span></div>
        <div><a href=\"/bwsm/Profile\">
          <img src=\"pics\\" .$CurrentUser_Val->getUserProfilePicUrl().".png\"  style=\"
          border-radius: 10px;
          width: 32;
          height: 32;\"></a></div>
        
      </header>

      <div class=\"MainContent\">
          <div class=\"MainContent_posts\">
    
    
    ");


    print("<nav class=\"SuggestedFriends\">");
    if ($followedFriends !== null) {
      foreach ($followedFriends as $Friend) {
        print
          ("
          <div class=\"Friends_Suggition\">
          <img src=\"pics/" . $Friend->getPhotoURL() . ".png\"  class=\"FriendsPhotos\" alt=\"\" srcset=\"\">
          <div class=\"Poster_Buttoms\">
          <p>" . $Friend->getFriendName() . " </p>
                  <form class=\"Reaction_buttoms\" method=\"post\" action=\"/bwsm/UnfollowingFriend\">
                  <button value=\"" . $Friend->getFriendId() . "\" name=\"UnFollowedFriend\"     type=\"submit\"class=\"Follow_button\" id=\"search-btn\">UnFollow</button></form>
              </div>
         </div>   
      
      
      ");
      }

      }
    print("</nav>");

    print("<pre>");

    
    foreach ($UserPostsData as $Post) {
      print(" 
         
          
          
      
        <div class=\"Poster\">
                    <div style=\"
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            /* margin-left: 46px; */
            padding: 0;
            justify-content: flex-start;
            \">
                    <img src=\"pics/" .$CurrentUser_Val->getUserProfilePicUrl(). ".png\" 
                    style=\"
            height: 32;
            width: 32;
            margin-left: 33px;
            margin-bottom: 0px;
            border-radius: 8px;
            \">
                    <div style=\"
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            width:0px;
\"> 
        " .
        $CurrentUser_Val->GetName()
        . "
        </div>
        </div>
        <textarea class=\"text-Container\" rows=\"4\" cols=\"50\" readonly>
" .
        $Post->getContent()
        . "

</textarea>
 <form action=\"/bwsm/Alike\" method=\"post\" class=\"LIKEFORM\">
<button type=\"submit\" name=\"Like\" value=\"".$Post->getPostID()."\"><img src=\"view\Ref\MultiMedia\icons\like.png\" alt=\"\" srcset=\"\"><span>" . $Post->getNumberOFlikes()."</span></button>
</form>
        </div>
          ");
    }
      print("
        </pre>
        </div>
        </div>
        </div>
        <footer class=\"Footer\">
        <form class=\"SuperContianer\" action=\"/bwsm/MainPage\" method=\"POST\"><button type=\"submit\"class=\"FooterButton\"><img src=\"view\Ref\MultiMedia\icons/house.png\"/></button></form></div>

        <form class=\"SuperContianer\" action=\"/bwsm/Profile\" method=\"POST\"><button type=\"submit\" class=\"FooterButton\"><img src=\"view\Ref\MultiMedia\icons/user.png\"/></button></form></div>
        <form class=\"SuperContianer\" action=\"/bwsm/LogOut\" method=\"POST\"><button type=\"submit\" class=\"FooterButton\"><img src=\"view\Ref\MultiMedia\icons\logout.png\"/></button></form></div>
        </div>
        </div></footer>
        </body>
        </html>
        ");
    

    }
  
    
}



