<?php namespace App\Models;

use CodeIgniter\Model;

class ModelPengingatobat extends Model{
  protected $table = 'pengingat_obat';
  protected $primaryKey = 'id';
  protected $allowedFields = ['judul','hari','waktu','id_pasien'];
}