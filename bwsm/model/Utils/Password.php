<?php
class Password
{

    private string $HashedPassCode ="";

   
    public function SetHashedPassCode(string $Password_Val)
    {
        $this->HashedPassCode =password_hash($Password_Val, PASSWORD_DEFAULT);
    }
    public function GetHashedPassCode():string
    {
        return $this->HashedPassCode 
        ;}
    public function VerifyPassword(string $Password_Val):bool
    {
        return (bool) password_verify($Password_Val, $this->HashedPassCode);
    }
}