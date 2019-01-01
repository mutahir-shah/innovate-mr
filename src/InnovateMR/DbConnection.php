<?php 
namespace InnovateMR;


class DbConnection
{ 
    /**
     * 
     * 
     * @example localhost  
     * @var string
     */
    protected $dbHost     = 'localhost';
    /**
     *  Name of your data base.
     *
     * @example dbname
     * @var string
     */
    protected $dbName   = NULL;
    /**
     * Authorize user of the database
     * 
     * @example root 
     * @var string
     */
    protected $dbUser    = 'root';
    /**
     * Authorize password of the database user
     * 
     * @example root 
     * @var string
     */
    protected $dbPassword    = 'root';

    /**
     * Database connection string.
     * 
     * @example root 
     * @var string
     */

    protected $dbConnection  = NULL;
    /**
     * Path to cookie to save session for requests.
     * 
     * @var string - path to cookie. Must be writable */

     
      public function __construct($options)
    {
         $this->dbHost = $options['dbhost'];
         $this->dbName = $options['dbname'];
         $this->dbUser = $options['dbuser'];
         $this->dbPassword = $options['dbpassword'];

        $this->dbConnection = new \mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName); // For Scoutts Database

        if ($this->dbConnection->connect_errno || $this->dbConnection->connect_errno) {
        die("Error in Connection !!!" . $this->dbConnection->connect_errno);
    } 
         
    }// CONSTRUCTOR ENDS HERE.


    public function closeDbConnection(){
            $this->dbConnection->close();
    }

   public function insert($table, $values = array(), $duplicate='') { 
        $this->dbConnection->query("SET SESSION sql_mode = ''");
        $query = "INSERT INTO " . "`$table`" . " (";
        $columns = ""; 
        foreach ($values as $k => $v) {
            $columns .= "`" . $k . "`,";
        } 
        $query .= substr($columns, 0, -1) . ") VALUES(";

        $val = "";
        foreach ($values as $key => $valu) {
            $val .= "'" . $valu . "',";
        }
        $query .= substr($val, 0, -1) . ") ";
        $query .= $duplicate;
        $dbResult = $this->dbConnection->query($query);
        if($dbResult){
            $last_id = $this->dbConnection->insert_id;
            $result = array('status'=>'success','lastInsertedId'=>$last_id,'msg'=>'Record Inserted='.$dbResult);
        }
        else 
        { 
            $result = array('status'=>'fail','lastInsertedId'=>0,'msg'=>'There is an error ='.$this->dbConnection->error.$dbResult);
        }
        return $result;

    }

    public function select($table, $columns, $where = "", $return_format = 1) { 
        $this->dbConnection->query("SET character_set_results=utf8");
        $str = "SELECT $columns FROM $table $where";  
        $dbResult = $this->dbConnection->query($str);

        if($dbResult->num_rows > 0){
            switch ($return_format) {
                case 1 :
                    $result = $dbResult->fetch_assoc(); 
                    break;
                case 2 : 
                    while ($row = $dbResult->fetch_assoc()) {
                        $result[] = $row;
                    }
                    break;
                case 3 :
                    $result = $dbResult->num_rows; 
                    break; 
                default :
                  $result = $dbResult->fetch_assoc(); 
            }
        } else $result = 0;
        return $result;
    } 
}
