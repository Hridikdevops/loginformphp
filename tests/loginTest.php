<?php

use PHPUnit\Framework\TestCase;

// Include the files containing the classes to be tested
require_once 'DataBase.php';
require_once 'DataBaseConfig.php';

class LoginTest extends TestCase
{
    public function testSuccessfulLogin()
    {
        // Mock database configuration
        $configMock = $this->createMock(DataBaseConfig::class);
        $configMock->method('getRdsHost')->willReturn('database-2.cod2dauaunkh.ap-south-1.rds.amazonaws.com');
        $configMock->method('getUsername')->willReturn('admin');
        $configMock->method('getPassword')->willReturn('admin123');
        $configMock->method('getDatabaseName')->willReturn('logindb');

        // Mock database connection
        $dbMock = $this->getMockBuilder(DataBase::class)
            ->onlyMethods(['dbConnect', 'logIn'])
            ->getMock();

        $dbMock->expects($this->once())
            ->method('dbConnect')
            ->willReturn(true);

        $dbMock->expects($this->once())
            ->method('logIn')
            ->with('users', 'test_user', 'test_password')
            ->willReturn(true);

        // Create an instance of the login script
        include 'login.php';

        // Capture the output (e.g., echo statements) of the login script
        $output = ob_get_clean();

        // Assert the expected output
        $this->assertStringContainsString('Login Success', $output);
    }

    public function testFailedLogin()
    {
        // Mock database configuration
        $configMock = $this->createMock(DataBaseConfig::class);
        $configMock->method('getRdsHost')->willReturn('database-2.cod2dauaunkh.ap-south-1.rds.amazonaws.com');
        $configMock->method('getUsername')->willReturn('admin');
        $configMock->method('getPassword')->willReturn('admin123');
        $configMock->method('getDatabaseName')->willReturn('logindb');

        // Mock database connection
        $dbMock = $this->getMockBuilder(DataBase::class)
            ->onlyMethods(['dbConnect', 'logIn'])
            ->getMock();

        $dbMock->expects($this->once())
            ->method('dbConnect')
            ->willReturn(true);

        $dbMock->expects($this->once())
            ->method('logIn')
            ->with('users', 'nonexistent_user', 'invalid_password')
            ->willReturn(false);

        // Create an instance of the login script
        include 'login.php';

        // Capture the output (e.g., echo statements) of the login script
        $output = ob_get_clean();

        // Assert the expected output
        $this->assertStringContainsString('Username or Password wrong.', $output);
    }
}
