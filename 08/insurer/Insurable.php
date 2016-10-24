<?php

/*
 * Insurable objects are capable of having calculations done one them by
 * acturial objects.
 */

/**
 *
 * @author Dan
 */
namespace insurer;
interface Insurable {
    public function getTotalEmployees();
    public function getTotalRisk();
    public function getTotalTerror();
    public function getTotalProfit();
    public function setIndex($value);
    public function setRate($value);
    public function getIndex();
    public function getRate();
}
