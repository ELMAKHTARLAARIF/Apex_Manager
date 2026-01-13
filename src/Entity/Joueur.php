<?php
require_once 'Personne.php';

class Joueur extends Personne
{
     public ?int $personId = null;
    public ?int $equipeId = null;
    public function __construct(
        string $nom,
        string $email,
        string $nationality,
        public string $pseudo,
        public string $role,
        public float $market_value,
    ) {
        parent::__construct($nom, $email, $nationality);
    }

    public   function getAnnualCost(): float
    {
        return $this->market_value * 12;
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