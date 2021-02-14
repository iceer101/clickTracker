<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BadDomain extends Model
{
    protected $fillable = ['id', 'name'];
    protected $name;
    public $timestamps = false;
    public $incrementing = false;

    public function isBadDomain(string $url): bool
    {
        $host = parse_url($url, PHP_URL_HOST);
        if (!$host) return false;


        if (strpos('www.', $host) === 0) {
            $host = substr($host, 4);
        }

        return $this->where('name', 'like', $host)->exists();
    }
}
