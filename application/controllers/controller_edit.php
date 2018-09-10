<?php
class Controller_Edit extends Controller
{
    function __construct()
    {
        if( $_SESSION['suLogin'] != true ) {
            header('Location: /');
        }
        $this->model = new Model_Edit();
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate('edit_view.php', 'template_view.php');
    }

    function action_process()
    {
        $this->model->edit();
        header('Location: /');
    }
}