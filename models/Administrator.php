<?php


namespace app\models;


class Administrator extends BaseUser
{
    public string $permissions;
    
    /**
     * Administrator constructor.
     * @param int $id
     * @param string $name
     * @param string $permissions
     */
    public function __construct(int $id, string $name, string $permissions)
    {
        parent::__construct($id, $name);
        $this->permissions = $permissions;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getAttributes(): array
    {
        $attributes = parent::getAttributes();
        $attributes['permissions'] = $this->permissions;
        return $attributes;
    }
}