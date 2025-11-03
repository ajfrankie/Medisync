<?php

namespace App\Repositories;

use App\Models\GnDivision;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DistrictReopository
{
    protected $model;

    public function __construct(GnDivision $gnDivision)
    {
        $this->model = $gnDivision;
    }

    public function get(Request $request)
    {
        $query = GnDivision::orderBy('created_at', 'desc');


        return $query;
    }
}
