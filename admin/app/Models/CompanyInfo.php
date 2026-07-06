<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    protected $table = 'company_info';

    protected $guarded = ['id'];

    /**
     * Return the single company-info record, creating a blank one if needed.
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            ['company_name' => 'Gagan Dental & Aesthetics Clinic']
        );
    }
}
