<?php

class CSP
{
    public $vars;
    public $domains;
    public $constraints;

    public function __construct($vars, $domains, $constraints) {
        $this->vars = $vars;
        $this->domains = $domains;
        $this->constraints = $constraints;
    }
    public function assign($var, $val,& $assignment) {
        $assignment[$var] = $val;
    }

    public function unAssign($var,& $assignment) {
        unset($assignment[$var]);
    }

    public function nConflicts($var, $val,& $assignment) {

    }

    public function isComplete($assignment) {

    }
}

class MapColoringCSP extends CSP
{
    public $neighbors;

    public function __construct($vars, $domains, $constraints, $neighbors)
    {
        parent::__construct($vars, $domains, $constraints);
        $this->neighbors = $neighbors;
    }

    public static function generateVars() {
        $cities  = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
        return $cities;
    }

    public static function generateDomains() {
        return ['R', 'G', 'B'];
    }

    public static function generateNeighbors() {
        $neighbors = [
            'A' => ['D', 'E', 'B'],
            'B' => ['E', 'F', 'C', 'A'],
            'C' => ['F', 'B'],
            'D' => ['A', 'E', 'H', 'G'],
            'E' => ['H', 'B', 'D', 'F', 'I', 'A'],
            'F' => ['C', 'I', 'E'],
            'G' => ['D', 'H'],
            'H' => ['E', 'D', 'I', 'G'],
            'I' => ['H', 'E', 'F'],
        ];
        return $neighbors;
    }

    public function nConflicts($var, $val,& $assignment)
    {
        $i = 0;
        if(isset($assignment[$var]) && !empty($assignment[$var])) $i++;
        foreach ($this->neighbors[$var] as $neighbor) {
            if(key_exists($neighbor, $assignment) && $assignment[$neighbor] == $val) $i++;
        }

        return $i;
    }

    public function isComplete($assignment) {
        if(sizeof($assignment) == sizeof($this->vars)) return true;
        return false;
    }
}