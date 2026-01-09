<?php

class Equipe
{
    public ?int $id = null;

    public function __construct(
        public string $nom,
        public float $budget,
        public string $manager
    ) {}
}
