<?php
class Adv{
    // database connection and table name
    private $conn;
    private $table_name = "ads_id";
    
    // object properties
    public $id;
    public $ads_enabled;
    public $adMobBannerId;
    public $adMobInterstitialId;
    public $adMobNativeId;
    public $appOpenId;
    public $app_id;
    public $fb_ad_banner;
    public $fb_ad_inter;
    public $fb_ad_native;
    public $onesignal_app_id;
    public $onesignal_rest_key;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;        
    }

    // read All Advs
    function getAdvIds(){
  
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
    
    // read One Adv
    function getAdvId(){
  
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
    // read One Adv
    function getAdvIdByApp(){
  
        // select all query
        $query = 'SELECT
                    *
                FROM
                    ' . $this->table_name.' 
                WHERE app_id=?';
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        // bind id of record 
        $stmt->bindParam(1, $this->app_id);

        // execute query
        $stmt->execute();
    
        return $stmt;
    }

}

?>