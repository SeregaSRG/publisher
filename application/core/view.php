<?php
class View
{
    
    function generate($content_view, $template_view, $data = null)
    {
        include HOME_DIR.'/application/views/'.$template_view;
    }
}