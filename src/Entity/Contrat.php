<?php

class Contrat
{
    public readonly int $id;        
    public readonly int $personId;    
    public readonly int $teamId;
    public readonly string $startDate;
    public readonly string $endDate;
    private float $salary;
    private float $buybackClause;

    public function __construct(
        int $id,
        int $personId,
        int $teamId,
        string $startDate,
        string $endDate,
        float $salary,
        float $buybackClause
    ) {
        $this->id = $id;
        $this->personId = $personId;
        $this->teamId = $teamId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->salary = $salary;
        $this->buybackClause = $buybackClause;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function getBuybackClause(): float
    {
        return $this->buybackClause;
    }

    public function getDurationDays(): int
    {
        $start = new DateTime($this->startDate);
        $end = new DateTime($this->endDate);
        return $start->diff($end)->days;
    }
}
