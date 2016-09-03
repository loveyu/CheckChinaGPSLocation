<?php
/**
 * User: loveyu
 * Date: 2016/9/4
 * Time: 1:51
 */
require_once __DIR__."/src/CheckChinaGPSLocation.php";
var_dump(CheckChinaGPSLocation::inTaiwan(22.0925481, 112.8715602));
var_dump(CheckChinaGPSLocation::inTaiwan(23.641818, 120.590892));