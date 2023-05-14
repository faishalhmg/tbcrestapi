<?php namespace App\Models;

use CodeIgniter\Model;

class ModelKeluarga extends Model{
  protected $table = 'data_keluarga';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nama','usia','riwayat', 'jenis', 'id_pasien'];
}