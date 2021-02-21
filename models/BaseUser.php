<?php


namespace app\models;


use app\interfaces\IUser;

class BaseUser implements IUser
{
    public int $id;
    public string $name;
    
    /**
     * BaseUser constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    
    /**
     * Returns attributes data array
     * @return array
     */
    public function getAttributes(): array
    {
        $types = explode('\\', static::class);
        $type = array_pop($types);
        return [
            'user-type' => $type,
            'id' => $this->id,
            'name' => $this->name
        ];
    }
    
}