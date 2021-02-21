<?php


namespace app\services;


class StoreManager
{
    /**
     * @var DatabaseManager $dbManager
     */
    protected $dbManager = null;
    
    
    /**
     * StoreManager constructor.
     * @param DatabaseManager $dbManager
     */
    public function __construct(DatabaseManager $dbManager)
    {
        $this->dbManager = $dbManager;
    }
    
    /**
     * @param int $storeId
     *
     * @return float
     */
    public function calculateStoreEarnings(int $storeId)
    {
        $tagCount = $this->getTotalUniqueTags();
        $storeTotal = 0;
        foreach ($this->getProducts($storeId) as $product) {
            $totalAmount = 0;
            $orderItems = $this->getOrderItems($product['id']);
            
            foreach ($orderItems as $item) {
                $totalAmount += $item['price'];
            }
            
            $tags = $this->getProductTags($product['id']);
            
            $totalAmount *= (1 + count($tags) / $tagCount);
            
            foreach ($tags as $tag) {
                if ($tag['tag_name'] == 'Christmas') {
                    $totalAmount *= 1.01;
                } elseif ($tag['tag_name'] == 'Free') {
                    $totalAmount *= 0.5;
                }
            }
            $storeTotal += $totalAmount;
        }
        return $storeTotal;
    }
    
    /**
     * @param int $storeId
     *
     * @return array
     */
    protected function getProducts(int $storeId)
    {
        $query = 'SELECT * FROM Product WHERE store_id = :store';
        
        return $this->dbManager->getData($query, ['store' => $storeId]);
    }
    
    /**
     * @param int $productId
     *
     * @return array
     */
    protected function getOrderItems(int $productId)
    {
        $query = 'SELECT * FROM OrderItem WHERE product_id = :product';
        
        return $this->dbManager->getData($query, ['product' => $productId]);
    }
    
    /**
    * @param int $productId
    *
    * @return array
    */
    protected function getProductTags(int $productId)
    {
        $query = 'SELECT * FROM Tag WHERE id IN(SELECT tag_id FROM TagConnect WHERE product_id = :product)';
        
        return $this->dbManager->getData($query, ['product' => $productId]);
    }
    
    /**
     * @return int
     */
    public function getTotalUniqueTags()
    {
        $query = 'SELECT COUNT(DISTINCT tag_name) as count FROM Tag';
        
        $result = $this->dbManager->getData($query, []);
        
        return $result[0]['count'];
    }
    
}