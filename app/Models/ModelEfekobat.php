<?php namespace App\Models;

use CodeIgniter\Model;

class ModelEfekobat extends Model{
  protected $table = 'efekobat';
  protected $primaryKey = 'id';
  protected $allowedFields = ['awal','akhir','lupa', 'efeksamping', 'judul','id_pasien'];
}