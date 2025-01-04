<?php
/*
 * @(#)CMCube.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/CubeKindEnum.php';
require_once __DIR__ . '/CMColor.php';
require_once __DIR__ . '/CMPart.php';
require_once __DIR__ . '/CMSticker.php';
require_once __DIR__ . '/CMStickersImage.php';
/**
 * Holds Cube Data.
 */
class CMCube {
    public ?string $name;
    public ?string $description;
    public ?string $author;
    public ?string $date;
    /** List<CMColor> */
    public array $colors = array();
    /** List<CMPart> */
    public array $parts = array();
    /** List<CMSticker> */
    public array $stickers = array();
    public ?CMStickersImage $stickersImage;
    public float $explode;
    public ?string $id;
    public float $scale;
    public float $twistDuration;
    public float $alpha;
    public float $beta;
    public CubeKindEnum $kind;
    public ?string $backgroundColor;
}