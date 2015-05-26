<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dingo extends Model
{
    
	public $table = "dingos";

	public $primaryKey = "id";
    
	public $timestamps = true;

	public $fillable = [
	    "title",
		"body"
	];

	public static $rules = [
	    "title" => "required"
	];

}
