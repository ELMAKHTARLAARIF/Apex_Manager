<?php
abstract class Personne {
    public function __construct(
        public string $nom,
        public string $email,
        public string $nationalite
    ) {}

    abstract public function getAnnualCost(): float;
}
