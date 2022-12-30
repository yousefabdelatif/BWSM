<?php 
class FriendSuggestionSystemView
{


    public function RenderUserFriendSuggestion(array|null $SuggestedFriends,$CurrendUserID)
    {
        if ($SuggestedFriends !== null) {
            foreach ($SuggestedFriends as $Friend) {
                print
                    ("
                <div class=\"Friends_Suggition\">
                <img src=\"pics/" . $Friend->getPhotoURL() . ".png\"  class=\"FriendsPhotos\" alt=\"\" srcset=\"\">
                <div class=\"Poster_Buttoms\">
                <p>" . $Friend->getFriendName() . " </p>
                        <form class=\"Reaction_buttoms\" method=\"post\" action=\"/bwsm/AddnewFriend\">
                        <button value=\"" . $Friend->getFriendId(). "\" name=\"NewFollowedFriend\"     type=\"submit\"class=\"Follow_button\" id=\"search-btn\">Follow</button></form>
                    </div>
               </div>   
            
            
            ");

            }
            ;
        }


  



    
    
}

    public function GetRenderUserFriendSuggestionFunc(array $SuggestedFriends):callable
    {
        return $this->RenderUserFriendSuggestion($SuggestedFriends);
    }

    

}