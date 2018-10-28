<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerOrderTest extends TestCase
{

    /**
     * Test the root uri "/".
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
                 ->assertViewIs('welcome');
    }

    /**
     * Test the uri "/customers"
     *
     *  @return void
     */
    public function testCustomersUriTest()
    {
        $response = $this->get('/customers');

        $response->assertStatus(200)
                 ->assertViewIs('customers');
    }

    /**
     * Test the uri "/customers/{id}" with customer_id 10.
     *
     *  @return void
     */
    public function testCustomerWithIdUriTest()
    {
        $response = $this->get('/customers/10');

        $response->assertStatus(200)
                 ->assertViewIs('details');
    }

    /**
     * Test the uri "/customers/{id}" with customer_id 0 (which is a Guest Customer)
     *
     *  @return void
     */
    public function testGuestCustomerTest()
    {
        $response = $this->get('/customers/0');

        $response->assertStatus(200)
            ->assertSee("Guest");

    }

    /**
     * Test the uri "/customers/{id}" with invalid customer_id 'abc'
     *
     *  @return void
     */
    public function testInvalidCustomerTest()
    {
        $response = $this->get('/customers/abc');

        // For the invalid customer_id 'abc', ensure that the site is not crashed and the response status is 200.
        //
        // Ideally we should return 404 - Not found and that should be handled to display appropriate error message in the User Interface.
        //
        $response->assertStatus(200)
            ->assertSee("")
            ->assertViewIs('details');
    }
}
