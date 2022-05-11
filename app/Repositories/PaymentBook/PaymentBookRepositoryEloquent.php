<?php

namespace App\Repositories\PaymentBook;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\PaymentBook\PaymentBookRepositoryInterface;
use App\Models\PaymentBook;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class PaymentBookRepositoryEloquent extends RepositoryEloquent implements PaymentBookRepositoryInterface
{
    public function model()
    {
        return PaymentBook::class;
    }

    public function findBy($keyword,$shortName, $phone)
    {
        $query = $this->model->newQuery();
        if (!empty($address)) {

            $query = $this->model->where('address', 'like', "%$address%");
        }
        if (!empty($phone)) {
            $query = $this->model->where('phone', 'like', "%$phone%");
        }
        if (!empty($keyword)) {
            $query = $this->model->where('name', 'like', "%$keyword%");
        }

        return $query->orderBy('name', 'desc');
    }

    public function multiUpdateStatusById($arr_input,$value )
    {
        $arr_input = is_array($arr_input) ? $arr_input : [$arr_input];
        $query = $this->model->whereIn('id', $arr_input)->update($arr_input,['status'=>$value]);
        return $query;
    }
}
