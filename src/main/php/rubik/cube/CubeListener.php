<?php
/*
 * @(#)CubeListener.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/CubeEvent.php';

/**
 * The listener interface for receiving cube events.
 *
 * @author  Werner Randelshofer
 */
interface CubeListener  {
    public function cubeTwisted(CubeEvent $evt);
    public function cubeChanged(CubeEvent $evt);
}
