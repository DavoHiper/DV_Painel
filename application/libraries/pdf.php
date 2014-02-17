<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . '/third_party/fpdf/fpdf.php';

class pdf extends FPDF {

    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4') {
        parent::__construct($orientation, $unit, $size);
    }

}