<?php


class Connection extends PDO {

    private $dsn = 'mysql:dbname=photos;host=localhost';
    private $username = 'root';
    private $password = '123456';
    private $options = array();
    /**
     *
     * @var PDO
     */
    public $Con;

    function __construct() {
        try {

            if ($this->Con == NULL) {
                $con = parent::__construct($this->dsn, $this->username, $this->password, $this->options);
                parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $this->Con = $con;
            }
            
            return $this->Con;
        } catch (Exception $ex) {
            error_log('[Conexao][__construct]-> ' . $ex->getMessage());
            return false;
        }
    }
    
    function __destruct() {
        $this->Con = NULL;
    }
    
}
