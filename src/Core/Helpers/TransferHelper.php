<?php
final class TransferHelper
{
    public ?PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public static function generateReference(): string
    {
        return 'TR-' . date('Y') . '-' . random_int(1000, 9999);
    }

    public function getTransferDetails()
    {
        $transferts = $this->pdo->query("
SELECT 
    p.pseudo,
    td.name AS depart,
    ta.name AS arrivee,
    t.amount
FROM transfers 
JOIN players ON players.person_id = transfers.person_id
JOIN teams td  ON td.id = transfers.current_team_id
JOIN teams ta  ON ta.id = transfers.new_team_id
WHERE t.status = 'valid';

")->fetchAll();
        return $transferts;
    }
}
