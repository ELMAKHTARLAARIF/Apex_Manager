<?php

final class Transfert
{
    public ?PDO $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function transferPlayer(
        int $personId,
        int $fromTeamId,
        int $toTeamId,
        float $amount
    ) {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("
            SELECT id, budget
            FROM teams
            WHERE id IN (?, ?)
            FOR UPDATE
        ");
            $stmt->execute([$fromTeamId, $toTeamId]);
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($teams) < 2) {
                throw new Exception("One of the teams does not exist.");
            }

            $fromBudget = 0;
            $toBudget   = 0;

            foreach ($teams as $team) {
                if ($team['id'] == $fromTeamId) {
                    $fromBudget = (float) $team['budget'];
                }
                if ($team['id'] == $toTeamId) {
                    $toBudget = (float) $team['budget'];
                }
            }

            if ($toBudget < $amount) {
                throw new Exception("Destination team does not have enough budget.");
            }

            $stmt = $this->pdo->prepare("UPDATE teams SET budget = budget + ? WHERE id = ?");
            $stmt->execute([$amount, $fromTeamId]);

            $stmt = $this->pdo->prepare("UPDATE teams SET budget = budget - ? WHERE id = ?");
            $stmt->execute([$amount, $toTeamId]);

            $stmt = $this->pdo->prepare("
            UPDATE contracts
            SET end_date = CURRENT_DATE
            WHERE person_id = ? AND team_id = ? AND end_date >= CURRENT_DATE
        ");
            $stmt->execute([$personId, $fromTeamId]);

            $stmt = $this->pdo->prepare("
            INSERT INTO contracts (person_id, team_id, salary, start_date, end_date)
            VALUES (?, ?, ?, CURRENT_DATE, DATE_ADD(CURRENT_DATE, INTERVAL 1 YEAR))
        ");
            $stmt->execute([
                $personId,
                $toTeamId,
                0
            ]);

            $stmt = $this->pdo->prepare("
            INSERT INTO transfers (
                reference,
                person_id,
                current_team_id,
                new_team_id,
                amount,
                status
            ) VALUES (?, ?, ?, ?, ?, 'valid')
        ");
            $stmt->execute([
                uniqid('TRF-'),
                $personId,
                $fromTeamId,
                $toTeamId,
                $amount
            ]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
