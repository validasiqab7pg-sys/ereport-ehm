<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 * 
 * KONFIGURASI UNTUK PostgreSQL
 * Updated untuk connect ke PostgreSQL database
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to
     * use if no other is specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection.
     * 
     * DIUBAH KE PostgreSQL:
     * - DBDriver: MySQLi → Postgre
     * - Port: 3306 → 5432
     * - DBCollat: utf8_general_ci → (PostgreSQL tidak perlu)
     */
    public array $default = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'postgres',
        'password' => '',
        'database' => 'validas1_ehm_report',
        'DBDriver' => 'Postgre',      // ✅ DIUBAH KE PostgreSQL
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8',
        'DBCollat' => '',              // PostgreSQL tidak perlu collation di sini
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 5432,            // ✅ PORT PostgreSQL
        'schema'   => 'public',        // ✅ TAMBAHAN: PostgreSQL schema
        'sslmode'  => 'prefer',        // ✅ TAMBAHAN: SSL mode
    ];

    /**
     * This database connection is used when
     * running PHPUnit database tests.
     */
    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => 'postgres',
        'password'    => '',
        'database'    => 'validas1_ehm_report_test',
        'DBDriver'    => 'Postgre',    // ✅ UBAH KE PostgreSQL JUGA
        'DBPrefix'    => 'db_',
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => '',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 5432,         // ✅ PostgreSQL PORT
        'schema'      => 'public',
        'sslmode'     => 'prefer',
    ];

    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
