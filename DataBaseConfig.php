<?php

class DataBaseConfig
{
    public $rds_host;
    public $username;
    public $password;
    public $databasename;

    public function __construct()
    {
        // Update these values with your RDS information
        $this->rds_host = 'database-2.cod2dauaunkh.ap-south-1.rds.amazonaws.com';
        $this->username = 'admin';
        $this->password = 'admin123';
        $this->databasename = 'logindb';
    }
}

?>
