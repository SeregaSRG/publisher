<?php
class Controller_Send extends Controller
{
    function __construct()
    {
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate('send_view.php', 'send_view.php', Parameters::Get('link') );
    }
}