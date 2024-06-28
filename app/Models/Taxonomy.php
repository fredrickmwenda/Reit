<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    use HasFactory;
    protected $table = 'gmz_taxonomy';

	protected $fillable = [
		'taxonomy_title', 'taxonomy_name', 'taxonomy_description', 'post_type'
	];

    public function Term()
    {
        return $this->hasMany(Term::class,'taxonomy_id','id');
    }
}
