<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
   protected function initialize()
   {
      $this->allowedFields = [
         'email',
         'username',
         'password_hash',
         'is_superadmin'
      ];
   }

   protected $table = 'users';

   protected $primaryKey = 'id';

   public function getAllPetugas()
   {
      if (user()->toArray()['is_superadmin'] == '1') {
         return $this->findAll();
      }
      elseif (user()->toArray()['is_superadmin'] == '0') {
         // return all petugas with is superadmin = 2 and 3
         return $this->where('is_superadmin', '2')->orWhere('is_superadmin', '3')->findAll();
      }
      else {
         // redirect to admin dashboard
         return redirect()->to('admin');
      }
   }

   public function getPetugasById($id)
   {
      return $this->where([$this->primaryKey => $id])->first();
   }

   public function savePetugas($idPetugas, $email, $username, $passwordHash, $role)
   {
      return $this->save([
         $this->primaryKey => $idPetugas,
         'email' => $email,
         'username' => $username,
         'password_hash' => $passwordHash,
         'is_superadmin' => $role ?? '0',
      ]);
   }
}
