<?php namespace App\Models;

use CodeIgniter\Model;

class ModelPengambilan extends Model{
  protected $table = 'pemgambilan_obat';
  protected $primaryKey = 'id';
  protected $allowedFields = ['awal','ambil','lokasi','id_pasien'];
}