<?php

class JoueursRepo
{
    public function save(PDO $pdo, Joueur $joueur): void
    {
        $stmt = $pdo->prepare(
            "INSERT INTO joueurs 
            (nom, email, nationalite, pseudo, role, salaire, bonus)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $joueur->nom,
            $joueur->email,
            $joueur->nationalite,
            $joueur->pseudo,
            $joueur->role,
            $joueur->amount,
            $joueur->bonus
        ]);

        $joueur->id = (int) $pdo->lastInsertId();
    }
public static function all(PDO $pdo): array
{
    $stmt = $pdo->query("SELECT * FROM joueurs");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function delete(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM joueurs WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    public function addToTeam(PDO $pdo, int $joueurId, int $teamId): void
    {
        $stmt = $pdo->prepare(
            "INSERT INTO equipe_joueur (joueur_id, equipe_id) VALUES (?, ?)"
        );
        $stmt->execute([$joueurId, $teamId]);
    }
}
