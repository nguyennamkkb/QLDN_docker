<?php

namespace App\Repositories\Payment;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Models\InputDetail;
use App\Models\ExportDetail;
use Illuminate\Support\Facades\DB;

use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class PaymentRepositoryEloquent extends RepositoryEloquent implements PaymentRepositoryInterface
{
    public function model()
    {
        return InputDetail::class;
    }
    public function findvau($customer,$dateFrom,$datoTo, $status,$category_id)
    {
        $query = $this->model->newQuery();
        $query = $query->select('inputs.date','inputs.id','input_details.weight','input_details.price','input_details.total')
                        ->join('customers','customers.id','input_details.customer_id')
                        ->join('inputs','inputs.id','input_details.input_id')
                        ->where([
                            ['customers.id', '=', $customer],
                            ['inputs.category_id',$category_id],
                            ['inputs.status', '=', $status],
                            ['inputs.date', '>=', $dateFrom],
                            ['inputs.date', '<=', $datoTo],
                        ]);
        return $query->orderBy('date', 'desc');
    }
    public function findtam($customer,$dateFrom,$datoTo, $status,$category_id)
    {
        $query = $this->model1->newQuery();
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
    public function findCarrierInput($employees,$dateFrom,$datoTo){
        // $query = InputDetail::select('inputs.date',DB::raw('SUM(input_details.weight) as weight'))
        //                 ->join('inputs','inputs.id','input_details.input_id')
        //                 ->join('employees','employees.id','inputs.carrier_id')
        //                 ->where([
        //                     ['employees.id', '=', $employees],
        //                     ['inputs.date', '>=', $dateFrom],
        //                     ['inputs.date', '<=', $datoTo],
        //                 ])->groupBy('inputs.date');

        $query = $this->model->newQuery();
        $query = $query->select('inputs.date',DB::raw('SUM(input_details.weight) as weight'))
                        ->join('inputs','inputs.id','input_details.input_id')
                        ->join('employees','employees.id','inputs.carrier_id')
                        ->where([
                            ['employees.id', '=', $employees],
                            ['inputs.date', '>=', $dateFrom],
                            ['inputs.date', '<=', $datoTo],
                        ])->groupBy('inputs.date');
        return $query->orderBy('inputs.date', 'desc');
    }

}
