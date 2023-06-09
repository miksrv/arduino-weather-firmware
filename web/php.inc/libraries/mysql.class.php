<?php
/**
 * A U T O M A T E D    W E A T H E R    S T A T I O N
 * 
 * @author     Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @copyright  Copyright (c) 2016, Mikhail
 * @link       http://miksrv.ru
 */

    namespace Libraries;

/**
 * MySQL database class
 * 
 * @package Automated weather station
 * @subpackage Libraries
 * @category mysql
 * @author Mikhail (Mik™) <miksoft.tm@gmail.com>
 * @version 1.0.0 (25.08.2016)
 */
class MySQL {

    /**
     * The ID of the resource connection to MySQL
     * @var integer
     */
    var $_source;

    /**
     * Connection status database
     * @var integer
     */
    var $_state = 0;

    /**
     * The number of requests to the database
     * @var integer
     */
    var $counter = 0;

    /**
     * Database table prefix
     * @var string 
     */
    var $prefix = NULL;


    /**
     * CLASS CONSTRUCTOR
     */
    function __construct() {
        $this->connect();
    } // function __construct()


    /**
     * CLASS DESTRUCTOR
     */
    function __destruct() {
        $this->close();
    } // function __destruct()


    /**
     * Create a database connection
     * 
     * @final
     * @access private
     * @return void
     */
    final private function connect() {
        require_once COREPATH . 'config/mysql.php';

        if (!is_array($config) || empty($config)) {
            exit('Error! Emtpy mysql config file');
        }

        $this->_source = mysqli_connect($config['hostname'], $config['username'], $config['password']);
        $database_name = mysqli_select_db($this->_source, $config['database']);

        mysqli_query($this->_source, "SET NAMES 'utf8'");
        mysqli_query($this->_source, "SET CHARACTER SET 'utf8'");

        if ( ! $this->_source) {
            exit('Can not connect to MySQL');
        } else if ( ! $database_name) {
            exit('You can not choose a MySQL database');
        } else {
            $this->_state = 1;
        }

        if (isset($config['prefix']) && !empty($config['preifx'])) {
            $this->prefix = $config['prefix'];
        }
    } // final private function connect()


    /**
     * Closes a database connection
     * 
     * @final
     * @access private
     * @return void
     */
    final private function close() {
        if ($this->_source && $this->_state) {
            mysqli_close($this->_source);
            $this->_state = 0;
        }
    } // final private function close()


    /**
     * Query the database
     * 
     * @access private
     * @param string $sql
     * @return 
     */
    private function _query($sql) {
        if ($this->_state && $this->_source) {
            $this->counter++;
            $result = mysqli_query($this->_source, $sql);

            if (mysqli_errno($this->_source)) {
                exit(mysqli_errno($this->_source) . ": " . mysqli_error($this->_source) . "<br>" . $sql);
            }
            
            return $result;
        }

        return ;
    } // private function _query($sql)


    /**
     * Saves settings and inserts a new row in the database table
     * 
     * @param string table name
     * @param array conditions
     * @return boolean
     */
    function save($table, $params) {
        if (isset($params['data']) && ! empty($params['data']) && is_array($params['data'])) {

            if ( ! isset($params['where']) || empty($params['where'])) {
                $keys = " (";
                $vals = " (";
                $count = count($params['data']);

                foreach ($params['data'] as $key => $val) {
                    $sep = ( --$count ? ", " : ")");
                    $keys .= "`{$key}`{$sep}";
                    $vals .= "'{$val}'{$sep}";
                }

                $sql = "INSERT INTO {$this->prefix}{$table} {$keys} VALUES {$vals}";

            } else {
                $count = count($params['where']);
                $where = '';
                $data = '';
                foreach ($params['where'] as $key => $val) {
                    $sep = ( --$count ? " AND " : "");
                    $where .= "`{$key}` = '{$val}'{$sep}";
                }

                $count = count($params['data']);
                foreach ($params['data'] as $key => $val) {
                    $sep = ( --$count ? ", " : " WHERE {$where}");
                    $data .= "`{$key}` = '{$val}'{$sep}";
                }

                $sql = "UPDATE {$this->prefix}{$table} SET {$data}";
            }
            if ($this->_query($sql)) {
                return TRUE;
            }
        }
        return FALSE;
    } // function save($table, $params)


    /**
     * Get last insert ID
     * 
     * @return integer
     */
    function get_last_id() {
        return mysqli_insert_id($this->_source);
    } // function get_last_id()


    /**
     * Sample data from the database
     * 
     * @param string $table table name
     * @param array conditions
     * @param boolean $one line?
     * @return array
     */
    function get_data($table, $params = array(), $one = FALSE) {
        if ( ! isset($params['sql']) || empty($params['sql'])) {
            $orderby = (isset($params['orderBy']) && ! empty($params['orderBy'])) ? " ORDER BY {$params['orderBy']} " : NULL;
            $groupby = (isset($params['groupBy']) && ! empty($params['groupBy'])) ? " GROUP BY {$params['groupBy']} " : NULL;
            $perpage = (isset($params['perPage']) && ! empty($params['perPage'])) ? $params['perPage'] : NULL;
            $curpage = (isset($params['curPage']) && ! empty($params['curPage']) && ! empty($params['perPage'])) ? ($params['curPage'] - 1) * $params['perPage'] : 0;
            $limit  = (isset($params['limit']) && ! empty($params['limit'])) ? " LIMIT {$params['limit']} " : NULL;
            $limit  = ( ! empty($perpage) && empty($limit)) ? " LIMIT {$curpage},{$perpage}" : $limit;
            $where  = "";
            $fields = "*";

            if (isset($params['where']) && ! empty($params['where'])) {

                if (is_array($params['where'])) {
                    $count = count($params['where']);
                    $where = " WHERE ";
                    foreach ($params['where'] as $key => $val) {
                        $sep    = ( --$count ? " AND " : "");
                        $where .= "`{$key}` = '{$val}'{$sep}";
                    }

                } else {
                    $where = " WHERE {$params['where']} ";
                }
            }

            if (isset($params['fields']) && ! empty($params['fields'])) {
                if (is_array($params['fields'])) {
                    $fields = '';
                    $count  = count($params['fields']);
                    foreach ($params['fields'] as $key => $val) {
                        $sep     = ( --$count ? ", " : " ");
                        $fields .= "{$val}{$sep}";
                    }
                } else {
                    $fields = " {$params['fields']} ";
                }
            }

            $sql = "SELECT {$fields} FROM {$this->prefix}{$table}{$where}{$orderby}{$groupby}{$limit}";
        } else {
            $sql = $params['sql'];
        }

        $result = $this->_query($sql);
        if (mysqli_num_rows($result)) {
            if ($one === TRUE) {
                $data = mysqli_fetch_assoc($result);
            } else {
                while ($tmp = mysqli_fetch_assoc($result)) {
                    $data[] = $tmp;
                }
            }
            return $data;
        }
        return NULL;
    } // function get_data($table, $params = array(), $one = TRUE)
}

/* Location: /php.inc/libraries/mysql.class.php */