<?php

namespace App\Models;

use App\Models\Scopes\SimpleSoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'company_id'
    ];
    // protected $guarded = [];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new SimpleSoftDeletingScope);
        // static::addGlobalScope('softDeletes', function (Builder $builder) {
        //     $builder->whereNull('deleted_at');
        // });
    }
}
