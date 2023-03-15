<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taskuser extends Model
{
    use HasFactory;
    protected $table = 'taskusers';
    protected $casts = [
        'files' => 'array',
    ];
    protected $fillable = [
        'uid','tid','status','files','link','payment','invoice_id',
    ];
    public function users()
    {
        return $this->belongsTo('App\Http\Models\User');
    }
    public function tasks()
    {
        return $this->belongsTo('App\Http\Models\Task');
    }
    public function invoices()
    {
        return $this->belongsTo('App\Http\Models\Invoice');
    }

}
