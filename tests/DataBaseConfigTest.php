<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\DataBaseConfig;
require_once 'DataBaseConfig.php';
class DataBaseConfigTest extends TestCase
{
    public function testProperties()
    {
        $config = new DataBaseConfig();

        $this->assertClassHasAttribute('rds_host', DataBaseConfig::class);
        $this->assertClassHasAttribute('username', DataBaseConfig::class);
        $this->assertClassHasAttribute('password', DataBaseConfig::class);
        $this->assertClassHasAttribute('databasename', DataBaseConfig::class);

        $this->assertObjectHasAttribute('rds_host', $config);
        $this->assertObjectHasAttribute('username', $config);
        $this->assertObjectHasAttribute('password', $config);
        $this->assertObjectHasAttribute('databasename', $config);

        $this->assertEquals('database-2.cod2dauaunkh.ap-south-1.rds.amazonaws.com', $config->rds_host);
        $this->assertEquals('admin', $config->username);
        $this->assertEquals('admin123', $config->password);
        $this->assertEquals('logindb', $config->databasename);
    }
}
