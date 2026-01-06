<?php 

class CoachRepo{
    protected ?PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo=$pdo;
    }

        public function deleteCoach($CoachId){
        $stmt = $this->pdo->prepare("DELETE FROM Coach WHERE id = ?");
        
    }
}