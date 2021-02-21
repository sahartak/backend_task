<?php

use app\models\{Administrator, Customer, Seller};
use app\services\UserManager;

require_once __DIR__.'/vendor/autoload.php';


$customer = new Customer(1, 'John', '100.55', '34');
$seller = new Seller(2, 'Alex', '550.87', '781');
$administrator = new Administrator(3, 'Arnold', '{reports, sales, users}');


$userManager = new UserManager();

echo $userManager->getUserInfo($customer);
echo $userManager->getUserInfo($seller);
echo $userManager->getUserInfo($administrator);
