<?php

namespace App\Libraries\Repositories;

use App\Models\Dingo;
use Illuminate\Support\Facades\Schema;
use Bosnadev\Repositories\Eloquent\Repository;

class DingoRepository extends Repository
{

    /**
    * Configure the Model
    *
    **/
    public function model()
    {
      return 'App\Models\Dingo';
    }

	public function search($input)
    {
        $query = Dingo::query();

        $columns = Schema::getColumnListing('dingos');
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
