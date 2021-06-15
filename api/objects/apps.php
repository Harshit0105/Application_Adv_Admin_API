<?php
class Apps{
    // database connection and table name
    private $conn;
    private $table_name = "apps";
    
    // object properties
    public $id;
    public $status;
    public $image;
    public $appName;
    public $packageName;  
    public $url;  
    public $reference;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;        
    }

    // read All Apps
    function getApps(){
  
        // select all query
        $query = 'SELECT
                    *
                FROM
                    ' . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);        
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    // read One App
    function getApp(){
  
        // select all query
        $query = 'SELECT
                    *
                FROM
                    ' . $this->table_name.' 
                WHERE Id=?';
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        // bind id of record 
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // read One App By Package
    function getAppByPackage(){
  
        // select all query
        $query = 'SELECT
                    *
                FROM
                    ' . $this->table_name.' 
                WHERE packageName=?';
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->packageName=htmlspecialchars(strip_tags($this->packageName));
        
        // bind id of record 
        $stmt->bindParam(1, $this->packageName);

        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // read One App By Package
    function getMoreAppByReference(){
  
        // select all query
        $query = 'SELECT
                    *
                FROM
                    apks 
                WHERE reference_app=?';
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->reference=htmlspecialchars(strip_tags($this->reference));
        
        // bind id of record 
        $stmt->bindParam(1, $this->reference);

        // execute query
        $stmt->execute();
    
        return $stmt;
    }
}

?>