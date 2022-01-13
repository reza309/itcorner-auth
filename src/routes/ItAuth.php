<?php
 namespace ItCorner\Auth\routes;
 class ItAuth
 {
      public $verify =false;
     
     public function route($data)
     {
         $this->verify = $data;
     }
     public function routeCheck()
     {
        // $ob = new ItAuth();
         return $this->verify;
     }
 }