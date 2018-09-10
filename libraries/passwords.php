<?php
class Passwords
{
    static function generate($max = 8)
    {
        $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP!@$%";
        $size=StrLen($chars)-1;
        $password=null;
        while($max--) {
            $password.=$chars[rand(0,$size)];
        }
        return $password;
    }
}