<?php

class ContractRepo
{
    public static function save($pdo,$contract): bool
    {
        return $pdo->prepare("
            INSERT INTO contrats (, salaire, clause, date_creation)
            VALUES (?, ?, ?, ?)
        ")->execute([
            $contract->uuid,
            $contract->salaire,
            $contract->clause,
            $contract->dateCreation
        ]);
    }
}
