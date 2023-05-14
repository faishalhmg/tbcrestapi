<?php namespace App\Models;

use CodeIgniter\Model;

class ModelPeriksaDahak extends Model{
  protected $table = 'periksa_dahak';
  protected $primaryKey = 'id';
  protected $allowedFields = ['sebelumnya','selanjutnya','lokasi_periksa','id_pasien'];
}