<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    private $indexKeys = ['ua', 'ip', 'ref', 'param1'];

    protected $fillable = ['id', 'ua', 'ip', 'ref', 'param1', 'param2'];
    protected $primaryKey = 'id';

    public $incrementing = false;
    public $timestamps = false;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->generateIndexKey();
    }

    private function generateIndexKey(): void
    {
        $hashedString = $this->generateHashedIndexKey();
        $this->attributes['id'] = $hashedString;
    }

    public function generateHashedIndexKey(): string
    {
        $stringToHash = '';

        foreach ($this->indexKeys as $key) {
            $stringToHash .= $this->attributes[$key] ?? '';
        }

        return $this->getHash($stringToHash);
    }

    private function getHash(string $stringToHash): string
    {
        return sha1($stringToHash);
    }

    public function getClick()
    {
        return $this->whereKey($this->attributes['id'])->first();
    }

}
