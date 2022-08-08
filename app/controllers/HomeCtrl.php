<?php
class HomeCtrl extends RuterController
{
  public function __construct()
  {
    // echo "hola desde el Page controller";
  }

  //Metodos
  public function index()
  {
    $this->view('index');
  }
}
