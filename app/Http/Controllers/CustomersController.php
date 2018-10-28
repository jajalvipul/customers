<?php

namespace App\Http\Controllers;

use App\Services\CustomerOrderService;
use App\Providers\CustomerOrderCacheServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\CustomerOrderCount;

class CustomersController extends BaseController
{

    protected $customers;

    public function index(Request $request, CustomerOrderCacheServiceProvider $customerOrderCacheServiceProvider,
                          CustomerOrderService $customerOrderService)
    {
        // Apply pagination filter for better user experience and performance.
        // Following parameters are defined here but ideally fit should be passed from the View UI.
        $filter = array("page" => 1, "limit" => 250);

        if ($customerOrderCacheServiceProvider->hasCustomerOrderCount()) {
            // Flash the message
            $request->session()->flash("status", "INFO:: Retrieving data from the CustomerOrderCache cache...");
            // customer are found in the cache
            $customersArr = $customerOrderCacheServiceProvider->getCustomerOrderCount();
        } else {
            // Get customers and their orders count
            $customersArr = $customerOrderService->getCustomersAndTheirOrderCounts($filter);
            // Populate the customer Order Cache
            $customerOrderCacheServiceProvider->putCustomerOrderCount($customersArr);
            // Flash the message
            $request->session()->flash("status", "INFO:: Populated data in the CustomerOrderCache cache...");
        }

        return view('customers', ['customers' => $customersArr]);
    }
}
