<?php

namespace App\Repositories\Customer;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class CustomerRepositoryEloquent extends RepositoryEloquent implements CustomerRepositoryInterface
{
    public function model()
    {
        return Customer::class;
    }

    public function findBy($customerType_id,$keyword,$address, $phone)
    {
        $query = $this->model->newQuery();
        if (!empty($address)) {
            $query = $query->where('address', 'like', "%$address%");
        }
        if (!empty($phone)) {
            $query = $query->where('phone', 'like', "%$phone%");
        }
        if (!empty($keyword)) {
            $query = $query->where('name', 'like', "%$keyword%");
        }
        if (!empty($customerType_id)) {
            $query = $query->where('customerType_id', "$customerType_id");
        }
        return $query->orderBy('name', 'desc');
    }
    public function findById($customer_id)
    {
        $query = $this->model->newQuery();
        $query = $query->where('id',$customer_id);
         return $query;
    }

}
