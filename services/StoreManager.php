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
        foreach ($this->getProducts($storeId) as $product) {
            $orderItems = $this->getOrderItems($product['id']);
            
            $totalAmount = 0;
            foreach ($orderItems as $item) {
                $totalAmount += $item['price'];
            }
            
            $tags = $this->getProductTags($product['id']);
            $tagCount = $this->getTotalUniqueTags();
            
            $totalAmount = $totalAmount * (1 + count($tags) / $tagCount);
            
            foreach ($tags as $tag) {
                if ($tag['tag_name'] == 'Christmas') {
                    $totalAmount = $totalAmount * 1.01;
                }
                
                if ($tag['tag_name'] == 'Free') {
                    $totalAmount = $totalAmount * 0.5;
                }
            }
        }
    }
    
    /**
     * @param int $storeId
     *
     * @return array
     */
    protected function getProducts(int $storeId)
    {
        $query = 'SELECT * FROM products WHERE store_id = :store';
        
        return $this->dbManager->getData($query, ['store' => $storeId]);
    }
    
    /**
     * @param int $productId
     *
     * @return array
     */
    protected function getOrderItems(int $productId)
    {
        $query = 'SELECT * FROM order_items WHERE product_id = :product';
        
        return $this->dbManager->getData($query, ['product' => $productId]);
    }
    
    /**
    * @param int $productId
    *
    * @return array
    */
    protected function getProductTags(int $productId)
    {
        $query = 'SELECT * FROM tags WHERE id IN(SELECT tag_id FROM tag_connects WHERE product_id = :product)';
        
        return $this->dbManager->getData($query, ['product' => $productId]);
    }
    
    /**
     * return int
     */
    public function getTotalUniqueTags()
    {
        $query = 'SELECT COUNT(DISTINCT name) as count FROM tags';
        
        $result = $this->dbManager->getData($query, []);
        
        return count($result);
    }
    
}