<?php


namespace app\models;


class Seller extends BaseUser
{
    public float $earning_balance;
    public int $product_count;
    
    
    /**
     * Seller constructor.
     * @param int $id
     * @param string $name
     * @param int $earning_balance
     * @param int $product_count
     */
    public function __construct(int $id, string $name, int $earning_balance, int $product_count)
    {
        parent::__construct($id, $name);
        $this->earning_balance = $earning_balance;
        $this->product_count = $product_count;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getAttributes(): array
    {
        $attributes = parent::getAttributes();
        $attributes['earnings-balance'] = $this->earning_balance;
        $attributes['product-count'] = $this->product_count;
        return $attributes;
    }
    
}