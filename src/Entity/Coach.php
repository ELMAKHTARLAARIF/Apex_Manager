<?php
require_once 'Personne.php';

class Coach extends Personne {
    public ?int $id = null;
    public ?int $equipeId = null;

    public function __construct(
        public string $nom,
        public string $email,
        public string $nationalite,
        public string $styleDeCoaching,
        public int $anneesExperience,
        public float $salaire,
        public float $fraisDeplacement
    ) {
        parent::__construct($nom, $email, $nationalite);
    }

    public function getAnnualCost(): float {
        return $this->salaire * 12 + $this->fraisDeplacement;
    }

    public function addToTeam(PDO $pdo, int $teamId): void {
        $stmt = $pdo->prepare("INSERT INTO equipe_coach (coach_id, equipe_id) VALUES (?, ?)");
        $stmt->execute([$this->id, $teamId]);
        $this->equipeId = $teamId;
    }

    public static function all(PDO $pdo): array {
        $stmt = $pdo->query("SELECT * FROM coachs");
        $coachs = [];
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $c) {
            $coach = new Coach(
                $c['nom'],
                $c['email'],
                $c['nationalite'],
                $c['styleDeCoaching'],
                (int)$c['anneesExperience'],
                (float)$c['salaire'],
                (float)$c['fraisDeplacement']
            );
            $coach->id = (int)$c['id'];
            $coachs[] = $coach;
        }
        return $coachs;
    }
        public function save(PDO $pdo): void {
        $stmt = $pdo->prepare("INSERT INTO coachs (nom,email,nationalite,styleDeCoaching,anneesExperience,salaire,fraisDeplacement) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([
            $this->nom,
            $this->email,
            $this->nationalite,
            $this->styleDeCoaching,
            $this->anneesExperience,
            $this->salaire,
            $this->fraisDeplacement
        ]);
        $this->id = (int)$pdo->lastInsertId();
    }


}

