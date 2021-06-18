<?php
class Sliders{
    // database connection and table name
    private $conn;
    private $table_name = "sliders";
    
    // object properties
    public $id;
    public $app_id;
    public $image;    

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;        
    }

    // read All Apps
    function getSliders(){
  
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
    function getSlider(){
  
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
    function getSliderByApp(){
  
        // select all query
        $query = 'SELECT
                    *
                FROM
                    ' . $this->table_name.' 
                WHERE app_id=?';
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->app_id=htmlspecialchars(strip_tags($this->app_id));
        
        // bind id of record 
        $stmt->bindParam(1, $this->app_id);

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