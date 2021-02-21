#Show Stores, that have products with Christmas, Winter Tags
SELECT `Store`.id, `Store`.`name` FROM `Store`
 INNER JOIN `Product` ON `Store`.`id` = `Product`.`store_id`
 INNER JOIN `TagConnect` ON `Product`.id = `TagConnect`.`product_id` 
 INNER JOIN `Tag` ON `TagConnect`.`tag_id` = `Tag`.`id` 
 WHERE `Tag`.`tag_name` IN ('Christmas', 'Winter') GROUP BY `Store`.id
 
#Show Users, that never bought Product from Store with id == 5
SELECT * FROM `User` WHERE id NOT IN (
    SELECT DISTINCT `Order`.`customer_id` FROM `Product`
	INNER JOIN `OrderItem` ON `OrderItem`.`product_id` = `Product`.`id`
	INNER JOIN `Order` ON `Order`.`id` = `OrderItem`.`order_id`
    WHERE `Product`.`store_id` = 5
);

#Show Users, that had spent more than $1000 
SELECT `User`.`name`, SUM(`Product`.price) as spent FROM `Order` 
INNER JOIN `OrderItem` ON `OrderItem`.`order_id` = `Order`.`id`
INNER JOIN `Product` ON `Product`.`id` = `OrderItem`.`product_id`
INNER JOIN `User` ON `User`.id = `Order`.`customer_id`
GROUP BY `User`.`id` HAVING (SUM(`Product`.price) > 1000);

#Show Stores, that have not any Sells
SELECT `Store`.name FROM `Store` 
LEFT JOIN `Product` ON `Product`.`store_id` = `Store`.`id`
LEFT JOIN `OrderItem` ON `OrderItem`.`product_id` = `Product`.`id`
WHERE `OrderItem`.`product_id` IS NULL
GROUP BY `Store`.`id`;

#Show Mostly sold Tags
SELECT `Tag`.`tag_name`, COUNT(`Tag`.`id`) as sold FROM `OrderItem` 
INNER JOIN `Product` ON `Product`.`store_id` = `OrderItem`.`product_id`
INNER JOIN `TagConnect` ON `TagConnect`.`product_id` = `Product`.`id`
INNER JOIN `Tag` ON `Tag`.`id` = `TagConnect`.`tag_id`
GROUP BY `Tag`.id 
ORDER BY sold DESC;


#Show Monthly Store Earnings Statistics 
SELECT `Store`.`name`, SUM(`Product`.`price`) as earnings FROM `Store`
INNER JOIN `Product` ON `Product`.`store_id` = `Store`.`id`
INNER JOIN `OrderItem` ON `OrderItem`.`product_id` = `Product`.`id`
INNER JOIN `Order` ON `Order`.`id` 
WHERE `Order`.`order_date` > DATE_FORMAT(NOW(), "%Y-%m-01")
GROUP BY `Store`.`id`;