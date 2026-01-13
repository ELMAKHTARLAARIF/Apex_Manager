<?php

class Equipe 
{
    public ?int $id = null;

    public function __construct(
        public string $name,
        public float $budget,
        public string $manager
    ) {}
}
