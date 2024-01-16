<?php

use PHPUnit\Framework\TestCase;

require_once 'DataBase.php';

class DataBaseTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        $this->db = new DataBase();
    }

    public function testDbConnect()
    {
        $this->assertNotNull($this->db->dbConnect());
    }

    public function testPrepareData()
    {
        $inputData = "Test Input";
        $this->assertEquals("Test Input", $this->db->prepareData($inputData));
    }

    public function testLogIn()
    {
        // Assuming you have a 'users' table with known test data for login testing
        $this->assertTrue($this->db->logIn('users', 'test_user', 'test_password'));
        $this->assertFalse($this->db->logIn('users', 'nonexistent_user', 'invalid_password'));
    }

    public function testSignUp()
    {
        // Assuming you have a 'users' table and no user with the specified username exists
        $this->assertTrue($this->db->signUp('users', 'Test User', 'test@example.com', 'new_user', 'new_password'));
        // Add more test cases for signUp based on different scenarios
    }
}
