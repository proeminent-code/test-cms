<?php


namespace Classes;


class Database
{
    /**
     * The database host
     *
     * @var string
     */
    private $host = 'localhost';

    /**
     * The database username
     *
     * @var string
     */
    private $user = 'root';

    /**
     * The database password
     *
     * @var string
     */
    private $pass = '';

    /**
     * The database name
     *
     * @var string
     */
    private $name = 'cms_db';

    /**
     * The database options
     *
     * @var array
     */
    private $options = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );

    /**
     * The database data source name
     *
     * @var null|string
     */
    private $dsn = null;

    /**
     * The database connection
     *
     * @var null|string
     */
    public $dbc = null;

    /**
     * @var null|string
     */
    public $error;

    /**
     * Connect to database
     *
     * @return PDO|string
     */
    public function connect()
    {
        try {
            // Create new PDO connection
            $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->name;
            $this->dbc = new PDO($this->dsn, $this->user, $this->pass, $this->options);

            return $this->dbc;
        } catch (PDOException $exception) {
            // Get error
            $this->error = $exception;

            return $this->error;
        }
    }
}


?>