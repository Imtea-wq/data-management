<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargos';

    protected $fillable = [
        'nama_perusahaan',
        'no_bl',
        'party',
        'marking',
        'cargo',
        'lokasi',
        'foto',
        'status',
    ];

    public function scopeProses($query)
    {
        return $query->where('status', 'proses');
    }

    public function scopeComplete($query)
    {
        return $query->where('status', 'complete');
    }

    public function getFotoPublicPathAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }

        $path = ltrim($this->foto, '/');

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $path = Str::replaceFirst('storage/', '', $path);
        $path = Str::replaceFirst('public/', '', $path);

        if (!Str::contains($path, '/')) {
            $path = 'cargo-photos/' . $path;
        }

        return $path;
    }

    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto_public_path) {
            return null;
        }

        if (Str::startsWith($this->foto_public_path, ['http://', 'https://'])) {
            return $this->foto_public_path;
        }

        return asset($this->foto_public_path);
    }
}
