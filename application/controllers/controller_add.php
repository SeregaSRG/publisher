<?php
class Controller_Add extends Controller
{
    function __construct()
    {
        if( $_SESSION['suLogin'] != true ) {
            header('Location: /');
        }
        $this->model = new Model_Add();
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate('add_view.php', 'template_view.php');
    }
    
    function action_process()
    {
        $this->model->addTask();
        header('Location: /');
    }
}