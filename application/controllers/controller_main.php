<?php
class Controller_Main extends Controller
{
    function __construct()
    {
        if( $_SESSION['suLogin'] != true ) {
            header('Location: /login');
        }
        $this->model = new Model_Main();
        $this->view  = new View();
    }

    function action_index()
    {
        $data = $this->model->getAllTasks();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
}