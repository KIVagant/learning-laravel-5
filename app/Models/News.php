<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    
	public $table = "news";

	public $primaryKey = "id";
    
	public $timestamps = true;

	public $fillable = [
	    "title",
		"preview",
		"body",
		"author"
	];

	public static $rules = [
	    "title" => "required",
		"preview" => "required"
	];

}
