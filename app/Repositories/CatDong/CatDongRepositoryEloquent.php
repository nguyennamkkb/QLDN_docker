<?php

namespace App\Repositories\CatDong;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\CatDong\CatDongRepositoryInterface;
use App\Models\CatDong;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class CatDongRepositoryEloquent extends RepositoryEloquent implements CatDongRepositoryInterface
{
    public function model()
    {
        return CatDong::class;
    }

    public function findBy($dateFrom,$dateTo,$employee_id)
    {
        $query = $this->model->newQuery();
        if (!empty($date)) {
            $query = $query->where('date', '>=', $dateFrom);
        }
        if (!empty($date)) {
            $query = $query->where('date', '<=', $dateTo);
        }
        if (!empty($employee_id)) {
            $query = $query->where('phone', $employee_id);
        }
        return $query->orderBy('date', 'desc');
    }
    public function findById($customer_id)
    {
        $query = $this->model->newQuery();
        $query = $query->where('id',$customer_id);
         return $query;
    }

}
