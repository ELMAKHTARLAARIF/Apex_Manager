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
        public float $amount,
        public float $bonus
    ) {
        parent::__construct($nom, $email, $nationalite);
    }

    public   function getAnnualCost(): float
    {
        return $this->amount * 12 + $this->bonus;
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





}