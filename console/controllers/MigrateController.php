<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\console\controllers;

use app\models\CoreClient;
use yii\console\ExitCode;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\Console;

class MigrateController extends \yii\console\controllers\MigrateController
{
    const CORE_DOMAIN = 'core';
    /**
     * {@inheritdoc}
     */
    public $templateFile = '@app/views/console/skynix-migration.php';

    public $db = 'dbCore';
    /**
     * @var string the comment for the table being created.
     * @since 2.0.14
     */
    public $comment = '';

    protected $domainMigrations = [];
    protected $domain = '';

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->db = Instance::ensure($this->db, Connection::className());
            return true;
        }

        return false;
    }

    public function actionUp($limit = 0)
    {
        $this->domain = self::CORE_DOMAIN;
        //Core migrations history
        $dsnParts = explode(";", $this->db->dsn);
        $this->domainMigrations[ $this->domain ] = [
            'migrations'    => $this->getNewMigrations(),
            'connection'    => $this->db,
            'dbname'        => explode('=', $dsnParts[1])[1]
        ];
        //Clients migrations history
        $clients = $this->db->createCommand('SELECT * FROM clients')->queryAll();

        $dsn = $dsnParts[0] . ';name=<dbname>';

        /** @var  $client CoreClient */
        foreach ( $clients as $row ) {

            $dbName = "skynixcrm_db_" . $row['domain'];
            $connection = new \yii\db\Connection([
                'dsn' => str_replace('<dbname>', $dbName, $dsn),
                'username' => $row['mysql_user'],
                'password' =>  $row['mysql_password'],
                'charset' => 'utf8',
            ]);
            $connection->open();
            $connection->createCommand("use " . $dbName)->execute();

            $this->db = $connection;
            $this->domainMigrations[ $row['domain'] ] = [
                'migrations'    => $this->getNewMigrations(),
                'connection'    => $connection,
                'dbname'        => $dbName
            ];
        }
        $totalMigrations = 0;
        foreach ($this->domainMigrations as $m ) {

            $totalMigrations += count($m['migrations']);
        }
        if ($totalMigrations === 0 ) {
            $this->stdout("No new migrations found. Your system is up-to-date.\n", Console::FG_GREEN);

            return ExitCode::OK;
        }

        /*$total = count($migrations);
        $limit = (int) $limit;
        if ($limit > 0) {
            $migrations = array_slice($migrations, 0, $limit);
        }*/

        $this->stdout("Total $totalMigrations new " . ($totalMigrations === 1 ? 'migration' : 'migrations') . " to be applied:\n", Console::FG_YELLOW);
        $this->stdout("\n");

        $nameLimit = $this->getMigrationNameLimit();
        foreach ($this->domainMigrations as $domain => $m) {

            $this->stdout("\n\tClient: $domain\n", Console::FG_PURPLE);
            foreach ($m['migrations'] as $migration ) {
                if ($nameLimit !== null && strlen($migration) > $nameLimit) {
                    $this->stdout("\nThe migration name '$migration' is too long. Its not possible to apply this migration.\n", Console::FG_RED);
                    return ExitCode::UNSPECIFIED_ERROR;
                }
                $this->stdout("\t$migration\n");
            }
        }
        $this->stdout("\n");

        if ($this->confirm('Apply the above ' . ($totalMigrations === 1 ? 'migration' : 'migrations') . ' to all clients?')) {
            foreach ($this->domainMigrations as $domain => $row) {
                $this->domain = $domain;
                $migrations = $row['migrations'];
                $this->db->close();
                $this->db   = $row['connection'];
                $this->db->open();
                $this->db->createCommand("use " . $row['dbname'])->execute();
                $this->stdout("\nApplying migration for {$domain}\n", Console::FG_BLUE);
                $applied = 0;


                foreach ($migrations as $migration ) {

                    if (!$this->migrateUp($migration)) {
                        $this->stdout("\n$applied from $totalMigrations " . ($applied === 1 ? 'migration was' : 'migrations were') . " applied.\n", Console::FG_RED);
                        $this->stdout("\nMigration failed. The rest of the migrations are canceled.\n", Console::FG_RED);

                        return ExitCode::UNSPECIFIED_ERROR;
                    }
                    $applied++;

                }
            }

            $this->stdout("\n$totalMigrations " . ($totalMigrations === 1 ? 'migration was' : 'migrations were') . " applied.\n", Console::FG_GREEN);
            $this->stdout("\nMigrated up successfully.\n", Console::FG_GREEN);
        }
    }

    protected function migrateUp($class)
    {
        if ($class === self::BASE_MIGRATION) {
            return true;
        }

        $this->stdout("*** applying $class\n", Console::FG_YELLOW);
        $start = microtime(true);
        $migration = $this->createMigration($class);
        if ( ($migration->isCore === true && $this->domain !== self::CORE_DOMAIN ) ||
            ($migration->isCore === false && self::CORE_DOMAIN === $this->domain )) {

            echo 'Skipped migration : ' . $class. " on " . (self::CORE_DOMAIN === $this->domain ? "core" : "client" ) . " db \n";
            $this->addMigrationHistory($class);
            return true;

        }
        if ($migration->up() !== false) {
            $this->addMigrationHistory($class);
            $time = microtime(true) - $start;
            $this->stdout("*** applied $class (time: " . sprintf('%.3f', $time) . "s)\n\n", Console::FG_GREEN);

            return true;
        }

        $time = microtime(true) - $start;
        $this->stdout("*** failed to apply $class (time: " . sprintf('%.3f', $time) . "s)\n\n", Console::FG_RED);

        return false;
    }

    /**
     * public function actionUp($limit = 0)
    {
    $migrations = $this->getNewMigrations();
    if (empty($migrations)) {
    $this->stdout("No new migrations found. Your system is up-to-date.\n", Console::FG_GREEN);

    return ExitCode::OK;
    }

    $total = count($migrations);
    $limit = (int) $limit;
    if ($limit > 0) {
    $migrations = array_slice($migrations, 0, $limit);
    }

    $n = count($migrations);
    if ($n === $total) {
    $this->stdout("Total $n new " . ($n === 1 ? 'migration' : 'migrations') . " to be applied:\n", Console::FG_YELLOW);
    } else {
    $this->stdout("Total $n out of $total new " . ($total === 1 ? 'migration' : 'migrations') . " to be applied:\n", Console::FG_YELLOW);
    }

    foreach ($migrations as $migration) {
    $nameLimit = $this->getMigrationNameLimit();
    if ($nameLimit !== null && strlen($migration) > $nameLimit) {
    $this->stdout("\nThe migration name '$migration' is too long. Its not possible to apply this migration.\n", Console::FG_RED);
    return ExitCode::UNSPECIFIED_ERROR;
    }
    $this->stdout("\t$migration\n");
    }
    $this->stdout("\n");

    $applied = 0;
    if ($this->confirm('Apply the above ' . ($n === 1 ? 'migration' : 'migrations') . '?')) {
    foreach ($migrations as $migration) {
    if (!$this->migrateUp($migration)) {
    $this->stdout("\n$applied from $n " . ($applied === 1 ? 'migration was' : 'migrations were') . " applied.\n", Console::FG_RED);
    $this->stdout("\nMigration failed. The rest of the migrations are canceled.\n", Console::FG_RED);

    return ExitCode::UNSPECIFIED_ERROR;
    }
    $applied++;
    }

    $this->stdout("\n$n " . ($n === 1 ? 'migration was' : 'migrations were') . " applied.\n", Console::FG_GREEN);
    $this->stdout("\nMigrated up successfully.\n", Console::FG_GREEN);
    }
    }
     */
}
