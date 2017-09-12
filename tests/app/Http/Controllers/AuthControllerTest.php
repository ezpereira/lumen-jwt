<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    const USER_VALID_EMAIL = 'SET A VALID EMAIL HERE';
    const USER_VALID_PASS  = 'SET A VALID PASSWORD HERE';

    /** @test **/
    public function index_status_code_should_be_422()
    {
        $this->post('/auth/login')->seeStatusCode(422);
    }

    /** @test */
    public function store_should_respond_with_a_200_when_successful()
    {
        //$this->markTestIncomplete('pending');
        $this->post('/auth/login', [
            'email'    => self::USER_VALID_EMAIL,
            'password' => self::USER_VALID_PASS
        ]);

        $this->seeStatusCode(200)
             ->seeJsonStructure(['token']);
    }

    /** @test */
    public function should_respond_with_a_400_when_email_no_exists()
    {
        $this->post('/auth/login', [
            'email'    => 'user@faker.com',
            'password' => 'nopass'
        ]);

        $this->seeStatusCode(400)
             ->seeJsonEquals([
                'error' => "Email does not exist."
             ]);
    }

    /** @test */
    public function store_should_respond_with_a_400_when_fail()
    {
        $this->post('/auth/login', [
            'email'    => self::USER_VALID_EMAIL,
            'password' => 'nopass'
        ]);

        $this->seeStatusCode(400)
            ->seeJsonEquals([
                'error' => "Email or password is wrong."
            ]);
    }
}
