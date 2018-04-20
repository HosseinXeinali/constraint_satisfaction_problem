<?php
require_once 'CSP.php';

function backtrackingSearch($csp) {
    $assignment = [];
    return recursiveBacktracking($assignment, $csp);
}

function recursiveBacktracking(& $assignment, $csp) {
    if($csp->isComplete($assignment)) return $assignment;
    $var = selectUnassignedVariable($assignment, $csp);
    foreach (orderDomainValues($var, $assignment, $csp) as $val) {
        if($csp->nConflicts($var, $val, $assignment) == 0) {
            $csp->assign($var, $val, $assignment);
            $result = recursiveBacktracking($assignment, $csp);
            if($result != false) return $result;
        }
        $csp->unAssign($var, $assignment);
    }
    return false;
}

function selectUnAssignedVariable($assignment, $csp) {
    foreach ($csp->vars as $k => $var) {
        if(!key_exists($var, $assignment))
            return $var;
    }
}

function orderDomainValues($var, $assignment, $csp) {
    return $csp->domains;
}

$vars = MapColoringCSP::generateVars();
$domains = MapColoringCSP::generateDomains();
$neighbors = MapColoringCSP::generateNeighbors();
$csp = new MapColoringCSP($vars, $domains, [], $neighbors);
$solution = backtrackingSearch($csp);
print_r($solution);
