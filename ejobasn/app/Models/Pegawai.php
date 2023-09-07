<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model {

  protected $guarded = array();
  
  protected $connection = "kepegawaian";

  protected $table = "tb_01";
}
