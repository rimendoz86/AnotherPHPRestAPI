<?php 
namespace Data;
class Connection {
    public $Servername = "localhost";
    public $Username = "root";
    public $Password = "";
    public $Database = "dbTest";
    public $Port = 3306;
    public $Conn;

    function __construct() {
        $conn = new \ mysqli($this->Servername, $this->Username,$this->Password, $this->Database, $this->Port);
        if ($conn->connect_error) {
            $error = [$conn->connect_error];
            $this->MapError($error);
        }
        $this->Conn = $conn;
    }

    function StmtToList($stmt){
        $results = [];
        $res = $stmt->get_result();
        while ($model = $res->fetch_object()) {
            array_push($results, $model);
        }
        return $results;
    }

    function dbSelect($SQLCommand, $types = false, $mixed = []){
        $stmt = $this->Conn->prepare($SQLCommand);   
        if($stmt == false){
            $error = [];
            array_push($error, "Error with SQL Statement:".$SQLCommand);
            array_push($error, $this->Conn->error_list);
            $this->MapError($error);
        }

        if($types != '' && count($mixed) > 0) $stmt->bind_param($types, ...$mixed);

        $stmt->execute();
        $res = $this->StmtToList($stmt);
        $stmt->close();
        return $res;
    }
    
    function dbInsert($SQLCommand, $types = false, $mixed = []){
        $stmt = $this->Conn->prepare($SQLCommand);   
        if($stmt == false){
            $error = [];
            array_push($error, "Error with SQL Statement:".$SQLCommand);
            array_push($error, $this->Conn->error_list);
            $this->MapError($error);
        }

        if($types != '' && count($mixed) > 0) $stmt->bind_param($types, ...$mixed);

        $stmt->execute();
        $stmt->close();
        return $this->Conn->insert_id;
    }
        
    function dbUpdate($SQLCommand, $types = false, $mixed = []){
        $stmt = $this->Conn->prepare($SQLCommand);   
        if($stmt == false){
            $error = [];
            array_push($error, "Error with SQL Statement:".$SQLCommand);
            array_push($error, $this->Conn->error_list);
            $this->MapError($error);
        }

        if($types != '' && count($mixed) > 0) $stmt->bind_param($types, ...$mixed);

        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    function MapError($errorList){
        $response = new \ API\Response();
        $response->ValidationMessages = $errorList;
        die(json_encode($response));
    }
}
?>