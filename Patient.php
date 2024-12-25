<?php class Patients{
    private $conn;
    private $table = 'patients';
    public $id;
    public $name;
    public $email;
    public $phone;
    public function_construct($db)
    {

      $this->conn = $db;
    }
 
  public function read() 
  {
     $query = 'SELECT * FORM' . $this->table;
    $stmt = $this->conn->prepare($query);
    stmt->execute();
    return $stmt;
    }

     public function create()
     {
   $query = 'INSRT INTO ' . $this->table . 'SET name = : name , email = :email , phone= :phone';
   $stmt = $this->conn->prepare($query);

       $stmt->bindparam(':name' , $this->name);
       $stmt->bindparam(':email' , $this->email;
       $stmt->bindparam(':phone' , $this->nphone);
         
          if($stmt->xecute())
          {
            return true;
          }
             return false;
     } 

     public function getPatientById(){

           $query = 'SELECT * From patients WHERE id = :id' ;
           $stmt = $this->conn->prepare($query);
           $stmt->bindParam(':id' ,$this->id);
           $stmt->execute();

           return $stmt->fetch(PDO::FETCH_ASSOC);

     }

     public function update(){

        $query = 'UPDATE patients
        SET name = :name , email = :email, phone = :phone,
        gender = :gender , dob = :dba
        WHERE id = :id';
     }
}
    