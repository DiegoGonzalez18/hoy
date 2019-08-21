<?php

namespace App\Controllers;

use App\Models\Usuario;



    
class UsuarioController{
    public function login($email,$clave){
       
        $user = Usuario::where("email","=",$email)->where('clave','=',$clave)->first();
       //var_dump( $user);
      
        if($user->email==$email&&$user->clave==$clave){
            session_start();
            $_SESSION['email']=$user->email;
            $_SESSION['user']=$user->user;
            echo  $_SESSION['user'];
        }else{
            echo 0;
        }
    
    }
}
