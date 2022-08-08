<?php
/*
TODO :  Mapear la url ingresada en el navegador y dividirla
1-controlador
2-metodo
3-parametro

Ejemplo=  articulo/actualizar/4

*/
class UrlController
{
  protected $currentController = 'HomeCtrl';
  protected $currentMethod = 'index';
  protected $params = [];

  //Constructor
  public function __construct()
  {
    // print_r($this->getUrl());

    $url = $this->getUrl();

    // ******************** Definiendo el Controlador ********************


    // Look in BLL for first value
    if (file_exists('../app/controllers/' . ucwords($url[0]) . 'Ctrl' . '.php')) {
      // If exists, set as controller
      $this->currentController = ucwords($url[0]) . "Ctrl";
      // Unset 0 Index
      unset($url[0]);
    }
    // Require the controller
    require_once '../app/controllers/' . $this->currentController   . '.php';

    // Instantiate controller class
    $this->currentController = new $this->currentController;


    // ********************/ Fin del Controlador ********************

    // ********************Definiendo Metodo ********************
    // Check for second part of url
    if (isset($url[1])) {
      // Check to see if method exists in controller
      if (method_exists($this->currentController, $url[1])) {
        $this->currentMethod = $url[1];
        // Unset 1 index
        unset($url[1]);
        // echo "o methodo existe";
      } else {
        echo "el metodo no existe UrlController linea 42";
      }
    }
    // ********************/ Fin del Metodo ********************


    // ******************** Definiendo Parametros  ********************
    // Get params
    $this->params = $url ? array_values($url) : [];

    // ********************/fin de Parametros  ********************


    // Call a callback with array of params
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  } // end constructor

  public function getUrl()
  {
    if (isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
  }
}
