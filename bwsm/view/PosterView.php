<?php

class PosterView
{
    public function RenderPosts($Posts){
         
    //array OfPosts :: aps
    $Posts = (array) $Posts;
    
    for ($i=0; $i <count ($Posts); $i++) { 
      # code...
   

      if ($Posts[$i]->getContent() != "") {


        print("
                <div class=\"Poster\">
                <div class=\"PostConTainer\" style=\"
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: center;
    /* margin-left: 46px; */
    padding: 0;
    justify-content: flex-start;
\">
                <img src=\"pics/".$Posts[$i]->getPosterProFilePictureUrl().".png\" 
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
                ".
                $Posts[$i]->getPosterName()
                
                ."
                </div>
                </div>
                <textarea class=\"text-Container\" rows=\"4\" cols=\"50\" readonly>
                
            
       " .
        $Posts[$i]->getContent()
           . "
        
        </textarea>
        <form action=\"/bwsm/Alike\" method=\"post\" class=\"LIKEFORM\">
          <button type=\"submit\" name=\"Like\" value=\"".$Posts[$i]->getPostID()."\"><img src=\"view\Ref\MultiMedia\icons\like.png\" alt=\"\" srcset=\"\"><span>" . $Posts[$i]->getNumberOFlikes()."</span></button>
        </form>
        
         

                </div>
            ");


      }
    }
        }
}
?>
