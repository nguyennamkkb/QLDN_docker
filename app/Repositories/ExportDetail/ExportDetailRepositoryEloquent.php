<?php

namespace App\Repositories\ExportDetail;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\ExportDetail\ExportDetailRepositoryInterface;
use App\Models\ExportDetail;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;
use Illuminate\Support\Facades\DB;


class ExportDetailRepositoryEloquent extends RepositoryEloquent implements ExportDetailRepositoryInterface
{
    public function model()
    {
        return ExportDetail::class;
    }

    public function findBy($keyword)
    {
        $query = $this->model->newQuery();
        // if (!empty($address)) {

        //     $query = $this->model->where('address', 'like', "%$address%");
        // }
        // if (!empty($phone)) {
        //     $query = $this->model->where('phone', 'like', "%$phone%");
        // }
        // if (!empty($keyword)) {
        //     $query = $this->model->where('name', 'like', "%$keyword%");
        // }

        return $query;
    }
    public function findtam($customer,$dateFrom,$datoTo, $status,$category_id)
    {
        // dd($category_id);
        $query = $this->model->newQuery();
        $query = $query->select('exports.date','exports.id','export_details.price','export_details.total')
                        ->join('customers','customers.id','export_details.customer_id')
                        ->join('exports','exports.id','export_details.export_id')
                        ->where([
                            ['customers.id', '=', $customer],
                            ['exports.category_id',$category_id],
                            ['exports.status', '=', $status],
                            ['exports.date', '>=', $dateFrom],
                            ['exports.date', '<=', $datoTo],
                        ]);
                        
        return $query->orderBy('date', 'desc');
    }
    public function findCarrierExport($employee,$dateFrom,$datoTo)
    {
        $query = $this->model->newQuery();
        $query = $query->select('exports.date',DB::raw('SUM(export_details.weight) as weight'))
                        ->join('exports','exports.id','export_details.export_id')
                        ->join('employees','employees.id','exports.carrier_id')
                        ->where([
                            ['employees.id', '=', $employee],
                            ['exports.date', '>=', $dateFrom],
                            ['exports.date', '<=', $datoTo],
                        ])->groupBy('exports.date');
                        
        return $query->orderBy('exports.date', 'desc');
    }

}
