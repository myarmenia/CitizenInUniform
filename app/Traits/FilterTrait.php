<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;


trait FilterTrait
{
    public function scopeFilter($builder, $filters = [])
    {

        if (!$filters) {
            return $builder;
        }


        $tableName = $this->getTable();
        $defaultFillableFields = $this->defaultFillableFields;
        $relationFilter = $this->relationFilter;
        $multiLikeFilterFields = $this->multiLikeFilterFields;

        foreach ($filters as $field => $value) {

              if(isset($this->boolFilterFields) && in_array($field, $this->boolFilterFields) && $value !== null) {

                  $builder->where($field, (bool)$value);
                  continue;
              }


            if(isset($this->likeFilterFields) && in_array($field, $this->likeFilterFields)) {
                $builder->where($tableName. '.' . $field, 'like', '%' . $value . '%');
            }

            if (isset($multiLikeFilterFields) && in_array($field, $this->multiLikeField)) {

                $builder->where(function ($q) use ($multiLikeFilterFields, $value, $tableName) {
                    foreach ($multiLikeFilterFields as $field) {
                        $q->orWhere($tableName . '.' . $field, 'like', '%' . $value . '%');
                    }
                });
                continue;

            }

            if ($field == "from_created_at") {

                $builder->whereDate('created_at', '>=', $value);

            }

            if ($field == "to_created_at") {

                $builder->whereDate('created_at', '<=', $value);

            }


            //   if (isset ($relationFilter) && $this->getKeyFromValue($field, $relationFilter)) {
            //       $relationModel  = $this->getKeyFromValue($field, $relationFilter);

            //         $builder->whereHas($relationModel, function ($query) use ($filters) {
            //             $query->filter($filters);
            //         });

            //   }

            if (isset($defaultFillableFields) && in_array($field, $defaultFillableFields)) {

                $builder->where($field, $value);
            } else if (is_array($value)) {
                $builder->whereIn($field, $value);
            } else {

            }

        }


        return $builder;


    }

    public function getKeyFromValue($needle, $haystack)
    {
        $collection = new Collection($haystack);

        return $collection->search(function ($values) use ($needle) {
            return in_array($needle, $values);
        });
    }

}

