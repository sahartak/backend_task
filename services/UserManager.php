<?php


namespace app\services;


use app\interfaces\IUser;

class UserManager
{
    
    /**
     * Returns string with info about user
     * @param IUser $user
     * @return string
     */
    public function getUserInfo(IUser $user): string
    {
        $result = [];
        $attributes = $user->getAttributes();
        foreach ($attributes as $attribute => $value) {
            $result[] = $attribute . ': ' . $value;
        }
        return PHP_EOL . implode(PHP_EOL, $result) . PHP_EOL;
    }
    
}