<?php

/*
 * Actuarial objects are capable of doing computations on insurable objects.
 */

/**
 *
 * @author Dan
 */
namespace insurer;
interface Actuarial {
    
    public function insure(Insurable $insurable);
    public function isInsurable(Insurable $insurable);
}
