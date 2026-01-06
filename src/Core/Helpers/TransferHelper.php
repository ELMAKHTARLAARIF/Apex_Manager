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
    SELECT j.pseudo, td.nom AS depart, ta.nom AS arrivee, t.montant
    FROM transferts t
    JOIN joueurs j ON j.id = t.joueur_id
    JOIN equipes td ON td.id = t.equipe_depart_id
    JOIN equipes ta ON ta.id = t.equipe_arrivee_id
    WHERE t.statut='termine'
")->fetchAll();
return $transferts;
    }
}
