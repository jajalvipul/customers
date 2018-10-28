<?php

namespace App\Services;

use Bigcommerce\Api\Client;
use Bigcommerce\Api\Resources\Customer;
use App\Models\CustomerOrderCount;
use App\Models\CustomerOrderDetail;

class CustomerOrderService
{

    /**
     * Get customer by identifier.
     *
     * @param $customerId
     * @return \Bigcommerce\Api\Resources\Customer
     */
    public function getCustomer($customerId) {
        $customer = null;
        $customer = (object)$customer;
        # Check if $customerId variable is an integer
        if ( filter_var($customerId, FILTER_VALIDATE_INT) === false ) {
            $customer->first_name = "";
            return $customer;
        } elseif ($customerId == 0) {
            // The Guest customers have 0 as id.
            $customer->first_name = "Guest";
            return $customer;
        }

        // get customer details
        $customer = Client::getCustomer($customerId);
        return $customer;
    }

    /**
     * Get list of Customers, including the total number of orders they have placed.
     *
     * @param $filter Filter criteria
     * @return array Array of CustomerOrderCount models
     */
    public function getCustomersAndTheirOrderCounts($filter) {
        // Customers array containing the CustomerOrderCount Model
        $customersArr = [];

        // Get the customers
        $customers = Client::getCustomers($filter);

        foreach ($customers as $customer) {
            // filter for customer id
            $orderfilter = array("customer_id" => $customer->id);

            // Invoke API to get customer order count
            $customerOrders = Client::getOrdersCount($orderfilter);

            // Initialise and populate the CustomerOrderCount model
            $customerOrderCount = new CustomerOrderCount;
            $customerOrderCount->customer_id = $customer->id;
            $customerOrderCount->first_name = $customer->first_name;
            $customerOrderCount->last_name = $customer->last_name;
            $customerOrderCount->total_orders = $customerOrders;

            $customersArr[] = $customerOrderCount;
        }

        return $customersArr;
    }

    /**
     * Get customer order history and their lifetime Value (defined as the total value of all of their orders).
     *
     * @param $customerId Customer identifier
     * @param $lifeTimeValue Total value of customer's orders
     * @return array Array of CustomerOrderDetail model
     */
    public function getCustomersAndTheirOrders($customerId, &$lifeTimeValue) {

        // Customer Orders array containing the CustomerOrderDetail Model
        $CustomerOrderDetails = [];

        # Check if $customerId variable is an integer
        if ( filter_var($customerId, FILTER_VALIDATE_INT) === false ) {
            $customerOrderDetail = new CustomerOrderDetail;
            $CustomerOrderDetails[] = $customerOrderDetail;
            return $CustomerOrderDetails;
        }


        $orderfilter = array("customer_id"=>$customerId);

        $customerOrders = Client::getOrders($orderfilter);


        foreach ($customerOrders as $order) {
            // Initialise and populate the CustomerOrderDetail model
            $customerOrderDetail = new CustomerOrderDetail;
            $customerOrderDetail->customer_id = $customerId;
            $customerOrderDetail->order_id = $order->id;
            $customerOrderDetail->date_created = $order->date_created;
            $customerOrderDetail->productsCount = count($order->products);
            $customerOrderDetail->total_inc_tax = $order->total_inc_tax;

            $CustomerOrderDetails[] = $customerOrderDetail;
        }

        // Lifetime Value (defined as the total value of all orders)
        $lifeTimeValue = collect($customerOrders)->sum('total_inc_tax');

        return $CustomerOrderDetails;
    }

}