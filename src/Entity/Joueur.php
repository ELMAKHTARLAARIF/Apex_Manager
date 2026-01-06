<?php
require_once 'Personne.php';

class Joueur extends Personne
{
    public ?int $id = null;
    public ?int $equipeId = null;

    public function __construct(
        string $nom,
        string $email,
        string $nationalite,
        public string $pseudo,
        public string $role,
        public float $salaire,
        public float $bonus
    ) {
        parent::__construct($nom, $email, $nationalite);
    }

    public  function getAnnualCost(): float
    {
        return $this->salaire * 12 + $this->bonus;
    }
    // public static function getTotalAnnualCost(PDO $pdo): float
    // {
    //     $joueurs = self::all($pdo);

    //     $total = 0;
    //     foreach ($joueurs as $joueur) {
    //         $total += $joueur->getAnnualCost();
    //     }

    //     return $total;
    // }
    public function addToTeam(PDO $pdo, int $teamId): void
    {
        $stmt = $pdo->prepare("INSERT INTO equipe_joueur (joueur_id, equipe_id) VALUES (?, ?)");
        $stmt->execute([$this->id, $teamId]);
        $this->equipeId = $teamId;
    }

    public static function all(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM joueurs");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function save(PDO $pdo): void
    {
        $stmt = $pdo->prepare("INSERT INTO joueurs (nom,email,nationalite,pseudo,role,salaire,bonus) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([
            $this->nom,
            $this->email,
            $this->nationalite,
            $this->pseudo,
            $this->role,
            $this->salaire,
            $this->bonus
        ]);
        $this->id = (int)$pdo->lastInsertId();
    }

    public function delete($pdo,int $id)
    {
        $stmt= $pdo->prepare("DELETE FROM joueurs WHERE id = ?");
        $stmt->execute([(int)$id]);
    }
}