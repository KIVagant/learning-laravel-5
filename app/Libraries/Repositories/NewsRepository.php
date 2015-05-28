<?php

namespace App\Libraries\Repositories;

use App\Models\News;
use Illuminate\Support\Facades\Schema;
use Bosnadev\Repositories\Eloquent\Repository;

class NewsRepository extends Repository
{

    /**
    * Configure the Model
    *
    **/
    public function model()
    {
      return 'App\Models\News';
    }

	public function search($input)
    {
        $query = News::query();

        $columns = Schema::getColumnListing('news');
        $attributes = array();

        foreach($columns as $attribute)
        {
            if(isset($input[$attribute]) and !empty($input[$attribute]))
            {
                $query->where($attribute, $input[$attribute]);
                $attributes[$attribute] = $input[$attribute];
            }
            else
            {
                $attributes[$attribute] =  null;
            }
        }

        return [$query->get(), $attributes];
    }
}
