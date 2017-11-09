<?php

namespace App\Models\V1;

use App\Models\V1\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title'
	];

	/**
	 * Association with User's model
	 * Many books belong to one user
	 */
	public function user () {
		return $this->belongsTo(User::class);
	}
}