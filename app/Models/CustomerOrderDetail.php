<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerOrderDetail extends Model
{
    private $customer_id;
    private $order_id;
    private $date_created;
    private $productsCount;
    private $total_inc_tax;
}
