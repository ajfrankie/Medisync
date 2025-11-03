<?php

namespace App\Repositories;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DistrictReopository
{
    protected $model;

    public function __construct(District $district)
    {
        $this->model = $district;
    }

    public function get(Request $request)
    {
        $query = District::orderBy('created_at', 'desc');


        return $query;
    }
}
