<?php

class JoueursRepo
{

    public function save(PDO $pdo, Joueur $joueur): void
    {
        $stmt = $pdo->prepare(
            "INSERT INTO persons (name, email, nationality) VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $joueur->name,
            $joueur->email,
            $joueur->nationality
        ]);

        $joueur->person_id = (int) $pdo->lastInsertId();

        $stmt = $pdo->prepare(
            "INSERT INTO players (person_id, pseudo, role, market_value) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            $joueur->person_id,
            $joueur->pseudo,
            $joueur->role,
            $joueur->market_value,
        ]);
    }

    public static function all(PDO $pdo): array
    {
        $stmt = $pdo->query("
            SELECT players.person_id, players.pseudo, players.role, players.market_value,
                   persons.name, persons.email, persons.nationality
            FROM players 
            JOIN persons  ON persons.id = players.person_id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getJoueur(PDO $pdo, int $person_id)
    {
        $stmt = $pdo->prepare("
            SELECT players.person_id, players.pseudo, players.role, players.market_value,
                   persons.name, persons.email, persons.nationality
            FROM players 
            JOIN persons persons ON persons.id = players.person_id
            WHERE players.person_id = ?
        ");
        $stmt->execute([$person_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete(PDO $pdo, int $personId): bool
    {
        $stmt = $pdo->prepare("DELETE FROM persons WHERE id = ?");
        $stmt->execute([$personId]);
        return $stmt->rowCount() > 0;
    }


    public static function addToTeam(PDO $pdo, Joueur $joueur, int $teamId, float $salary = 0): void
    {
        if (!$joueur->personId) {
            throw new Exception("Player personId is not set.");
        }

        $stmt = $pdo->prepare("
            INSERT INTO contracts (person_id, team_id, salary, start_date, end_date)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $joueur->person_id,
            $teamId,
            $salary,
            date('Y-m-d'),
            date('Y-m-d', strtotime('+1 year'))
        ]);

        $joueur->equipeId = $teamId;
    }

    public static function update(PDO $pdo, Joueur $joueur)
    {
        $stmt = $pdo->prepare("
            UPDATE persons SET name = ?, email = ?, nationality = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $joueur->name,
            $joueur->email,
            $joueur->nationality,
            $joueur->person_id
        ]);


        $stmt = $pdo->prepare("
            UPDATE players SET pseudo = ?, role = ?, market_value = ?
            WHERE person_id = ?
        ");
        $stmt->execute([
            $joueur->pseudo,
            $joueur->role,
            $joueur->market_value,
            $joueur->person_id
        ]);
        return $stmt;
    }

    public static function getPlayersWithoutTeam(PDO $pdo): array
    {
        $stmt = $pdo->prepare("
            SELECT players.person_id, players.pseudo, players.role, players.market_value,
                   persons.name, persons.email, persons.nationality
            FROM players 
            JOIN persons  ON persons.id = players.person_id
            LEFT JOIN contracts ON players.person_id = contracts.person_id
            WHERE contracts.person_id IS NULL
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
