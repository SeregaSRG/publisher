<?php
class Parameters
{
    static function Post($name)
    {
        if ( isset($_POST[$name]) ) {
            return htmlspecialchars($_POST[$name],ENT_QUOTES);
        } else {
            return null;
        }
    }

    static function Get($name)
    {
        if ( isset($_GET[$name]) ) {
            return htmlspecialchars($_GET[$name],ENT_QUOTES);
        } else {
            return null;
        }
    }
}