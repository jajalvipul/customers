<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\CustomerOrderService;

class CustomerOrderServiceTest extends TestCase
{
    private $customerOrderService;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->customerOrderService = new CustomerOrderService;
    }

    /**
     * Test customer_id 0 is for the Guest customer.
     *
     * @return void
     */
    public function testCustomerGuestTest()
    {
        $customerId = 0;
        $customer = $this->customerOrderService->getCustomer($customerId);

        $this->assertTrue("Guest" == $customer->first_name);
    }

    /**
     * Test invalid customer_id 'abc'.
     *
     * @return void
     */
    public function testInvalidCustomerIdTest()
    {
        $customerId = 'abc';
        $customer = $this->customerOrderService->getCustomer($customerId);

        $this->assertTrue("" == $customer->first_name);
    }

    /**
     * Test valid customer_id '10' for a customer having first name 'Juanita'.  .
     *
     * @return void
     */
    public function testValidCustomerIdTest()
    {
        $customerId = '10';
        $expected_customer_first_Name = 'Juanita';
        $customer = $this->customerOrderService->getCustomer($customerId);

        $this->assertTrue($expected_customer_first_Name == $customer->first_name);
    }

    /**
     * Test Service Method CustomersAndTheirOrderCounts.
     *
     * @return void
     */
    public function testCustomersAndTheirOrderCounts() {
        // filter criteria
        $filter = array("page" => 1, "limit" => 15);
        // get the customer order data
        $customerArray = $this->customerOrderService->getCustomersAndTheirOrderCounts($filter);
        // assert that 15 customers are returned based on the limit specified in filter.
        $this->assertTrue(sizeof($customerArray) == $filter['limit']);
    }

    /**
     * Test Service Method getCustomersAndTheirOrders.
     *
     * @return void
     */
    public function testgetCustomersAndTheirOrders() {

        // customer 'Juanita' has id = 10.
        $customerId = 10;
        $lifeTimeValue = 0;

        $customerOrderArray = $this->customerOrderService->getCustomersAndTheirOrders($customerId, $lifeTimeValue);

        // Verify that the customer 'Juanita' [id = 10] has three orders.
        $this->assertTrue(sizeof($customerOrderArray) == 3);
        // Verify the returned $lifeTimeValue is same as the sum of the each customer order field 'total_inc_tax'.
        $this->assertTrue(collect($customerOrderArray)->sum('total_inc_tax') == $lifeTimeValue);
    }
}
