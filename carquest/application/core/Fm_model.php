<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Flick Base App
 * Model File
 * @package   Flick Base App
 * @author    Khairul Azam (Flick Team)  
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;


class Fm_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }		
}
