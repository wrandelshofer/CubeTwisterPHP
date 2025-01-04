<?php
/*
 * @(#)CubeEvent.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/Cube.php';


/**
 * CubeEvent is used to notify interested parties that an event has occured
 * in a Cube object.
 */
class CubeEvent  {
    private Coube $source;
    private int $axis;
    private int $layerMask;
    private int $angle;

    /** Creates a new instance. */
    public function __construct(Cube $src, int $axis, int $layerMask, int $angle) {
        $this->source = src;
        $this->axis = axis;
        $this->layerMask = layerMask;
        $this->angle = angle;
    }

    public function getCube() {
        return $this->source;
    }

    public function getAxis() {
        return $this->axis;
    }

    public function getLayerMask() {
        return $this->layerMask;
    }

    public function getAngle() {
        return $this->angle;
    }

    /**
     * Returns a list of part ID's, for each part location which is affected
     * if a cube is transformed using the axis, layerMask and angle
     * parameters of this event.
     */
    public function getAffectedLocations() {
        $c1 = $this->getCube()->clone();
        $c1->reset();
        $c1->transform($this->axis, $this->layerMask, $this->angle);
        return $c1->getUnsolvedParts();
    }
}
