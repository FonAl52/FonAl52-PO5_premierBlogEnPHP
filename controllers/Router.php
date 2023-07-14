<?php
session_start();
require_once 'views/View.php';


/**
 * Router class responsible for routing requests.
 */
class Router
{


    /**
     * The controller instance.
     *
     * @var Controller
     */
    private $ctrl;

    /**
     * View instance.
     *
     * @var View
     */
    private $view;


    /**
     * Routes the request.
     *
     * @return void
     */
    public function routeReq()
    {

        try {
            // Automatic loading of classes from the models folder.
            spl_autoload_register(
                function ($class) {
                    require_once('models/' . $class . '.php');
                }
            );
            // Create a variable $url.
            $url = '';
            // Determine the controller based on the value of this variable.
            if (isset($_GET['url'])) {
                // Split and filter the URL.
                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));

                // Get the first parameter from the URL.
                // Convert it to lowercase.
                // Capitalize the first letter.
                $controller = ucfirst(strtolower($url[0]));

                $controllerClass = "Controller" . $controller;
                // Find the path of the desired controller.
                $controllerFile = "controllers/" . $controllerClass . ".php";
                // Check if the controller file exists.
                if (file_exists($controllerFile)) {
                    // Launch the respective class.
                    // with all URL parameters.
                    // to respect encapsulation.
                    require_once($controllerFile);
                    $this->ctrl = new $controllerClass($url);
                } else {
                    $this->view = new View('404');
                    $this->view->generate(['errorMsg' => $errorMsg]);
                    throw new \Exception("Page introuvable", 1);
                }
            }
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            $this->view = new View('Error');
            $this->view->generate(['errorMsg' => $errorMsg]);
        }

    }//end routeReq()


}
