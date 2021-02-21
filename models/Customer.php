<?php


namespace app\models;


class Customer extends BaseUser
{
    public float $balance;
    public int $purchase_count;
    
    /**
     * Customer constructor.
     * @param int $id
     * @param string $name
     * @param float $balance
     * @param int $purchase_count
     */
    public function __construct(int $id, string $name, float $balance, int $purchase_count)
    {
        parent::__construct($id, $name);
        $this->balance = $balance;
        $this->purchase_count = $purchase_count;
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getAttributes(): array
    {
        $attributes = parent::getAttributes();
        $attributes['balance'] = $this->balance;
        $attributes['purchase-count'] = $this->purchase_count;
        return $attributes;
    }
    
}