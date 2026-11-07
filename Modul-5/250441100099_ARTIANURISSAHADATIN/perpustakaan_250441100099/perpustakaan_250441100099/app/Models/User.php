<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    public function anggota(): HasOne
    {
        return $this->hasOne(Anggota::class, 'user_id');
    }

    /**
     * Ambil data anggota milik user ini. Jika belum ada, hubungkan dengan
     * data anggota lama (yang emailnya sama dan belum punya akun) atau buat baru.
     */
    public function anggotaOrCreate(): Anggota
    {
        $anggota = $this->anggota;

        if ($anggota) {
            return $anggota;
        }

        $anggota = Anggota::whereNull('user_id')->where('email', $this->email)->first();

        if ($anggota) {
            $anggota->update(['user_id' => $this->id]);
        } else {
            $anggota = Anggota::create([
                'user_id'    => $this->id,
                'nama'       => $this->name,
                'email'      => $this->email,
                'no_telepon' => '',
            ]);
        }

        $this->setRelation('anggota', $anggota);

        return $anggota;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
