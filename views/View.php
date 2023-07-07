<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/../');
$dotenv->load();
/**
 *
 */
class View
{
    //vue file
    private $_file;

    //title of the page
    private $_t;

    function __construct($action)
    {
        $this->_file = 'views/view' . $action . '.php';
    }

    // Create a function that will
    // generate and display the view
    public function generate($data)
    {
        // Define the content to be sent
        $content = $this->generateFile($this->_file, $data);

        //template
        $view = $this->generateFile('views/template.php', array('t' => $this->_t, 'content' => $content));
        echo $view;
    }

    // Generate the view for an article
    public function generatePost($data)
    {
        // Define the content to be sent
        $content = $this->generateFile($this->_file, $data);

        //template
        $view = $this->generateFile('views/templateSingle.php', array('t' => $this->_t, 'content' => $content));
        echo $view;
    }

    // Generate the view for the article creation form
    public function generateForm()
    {
        // Define the content to be sent
        $content = $this->generateFileSimple($this->_file);

        //template
        $view = $this->generateFile('views/templateForm.php', array('t' => $this->_t, 'content' => $content));
        echo htmlspecialchars($view);
    }


    private function generateFile($file, $data)
    {
        if (file_exists($file)) {
            extract($data);

            //start temporisation
            ob_start();

            require $file;

            //end la temporisation
            return ob_get_clean();
        } else {
            throw new \Exception("Fichier " . $file . " introuvable", 1);
        }
    }

    private function generateFileSimple($file)
    {
        if (file_exists($file)) {

            require $file;
        } else {
            throw new \Exception("Fichier " . $file . " introuvable", 1);
        }
    }

    /**
     * Display the User page.
     */
    //Registation user view
    public function storeUser($data)
    {
        //définir le contenu à envoyer
        $content = $this->generateFile($this->_file, $data);

        //template
        $view = $this->generateFile('views/templateSingle.php', array('t' => $this->_t, 'content' => $content));
        echo $view;
    }

    /**
     * Display the home page.
     */
    public function home($data)
    {
        // Set the view file for the home page
        $this->_file = 'views/viewHome.php';

        // Set the title of the page
        $this->_t = 'Home';

        // Generate and display the view
        $content = $this->generateFile($this->_file, $data);
        $view = $this->generateFile('views/template.php', array('t' => $this->_t, 'content' => $content));
        echo $view;
    }
}
