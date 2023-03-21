<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $table = 'estates';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function scopeGetByName($query, $name = null, $partial = false)
    {
        if (empty($name)) {
            return $query;
        }

        return $query->where($this->table . '.name', (! $partial ? '=' : 'like'),
            ($partial ? '%' : '') . $name . ($partial ? '%' : ''));
    }

    public function scopeGetByBedrooms($query, $bedrooms)
    {
        if (empty($bedrooms)) {
            return $query;
        }
        return $query->where($this->table . '.bedrooms', $bedrooms);
    }

    public function scopeGetByBathrooms($query, $bathrooms)
    {
        if (empty($bathrooms)) {
            return $query;
        }
        return $query->where($this->table . '.bathrooms', $bathrooms);
    }

    public function scopeGetByStoreys($query, $storeys)
    {
        if (empty($storeys)) {
            return $query;
        }
        return $query->where($this->table . '.storeys', $storeys);
    }

    public function scopeGetByGarages($query, $garages)
    {
        if (empty($garages)) {
            return $query;
        }
        return $query->where($this->table . '.garages', $garages);
    }

    public function scopeGetByPriceFrom($query, ?int $price = null)
    {
        if (empty($price)) {
            return $query;
        }

        return $query->whereRaw($this->table . '.price >= ' . $price);
    }

    public function scopeGetByPriceTill($query, ?int $price = null)
    {
        if (empty($price)) {
            return $query;
        }

        return $query->whereRaw($this->table . '.price <= ' . $price);
    }

}
