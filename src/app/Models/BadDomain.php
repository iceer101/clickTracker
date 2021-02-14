<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BadDomain extends Model
{
    protected $fillable = ['id', 'name'];
    protected $name;
    public $timestamps = false;
    public $incrementing = false;

}
