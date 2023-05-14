<?php namespace App\Models;

use CodeIgniter\Model;

class ModelEdukasi extends Model{
  protected $table = 'edukasi';
  protected $primaryKey = 'id';
  protected $allowedFields = ['judul','isi','media', 'created_by', 'created_at','update_at'];
}