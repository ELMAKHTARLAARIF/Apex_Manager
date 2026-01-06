<?php

class Contrat
{
    public readonly string $uuid;
    public readonly string $dateCreation;
    private float $salaire;
    private float $clause;

    public function __construct(float $salaire, float $clause)
    {
        $this->uuid = uniqid("CTR-");
        $this->dateCreation = date('Y-m-d');
        $this->salaire = $salaire;
        $this->clause = $clause;
    }

    public function save(): bool
    {
        $pdo = Database::getInstance()->getConnection();
        return $pdo->prepare("
            INSERT INTO contrats (uuid, salaire, clause, date_creation)
            VALUES (?, ?, ?, ?)
        ")->execute([
            $this->uuid,
            $this->salaire,
            $this->clause,
            $this->dateCreation
        ]);
    }
}
