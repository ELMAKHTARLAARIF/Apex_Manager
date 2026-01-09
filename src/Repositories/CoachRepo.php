<?php 

class CoachRepo{

        public static function deleteCoach($pdo,$CoachId){
        $stmt = $pdo->prepare("DELETE FROM coachs WHERE id = ?");
        $stmt->execute([$CoachId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}