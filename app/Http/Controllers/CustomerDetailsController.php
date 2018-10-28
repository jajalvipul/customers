<?php

namespace App\Http\Controllers;

use App\Services\CustomerOrderService;
use App\CustomerOrderDetail;
use Illuminate\Routing\Controller as BaseController;


class CustomerDetailsController extends BaseController
{
    protected $customer;

    public function show(CustomerOrderService $customerOrderService, $id)
    {

        $customer = $customerOrderService->getCustomer($id);

        // Lifetime Value (defined as the total value of all of their orders)
        $lifeTimeValue = 0;
        $CustomerOrderDetails = $customerOrderService->getCustomersAndTheirOrders($id, $lifeTimeValue);

        return view('details', [
            'customer' => $customer,
            'customerOrders' => $CustomerOrderDetails,
            'lifeTimeValue' => $lifeTimeValue,
        ]);
    }
}
