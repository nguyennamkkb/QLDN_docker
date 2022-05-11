<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FreeResource;
use App\Http\Resources\PaymentBookResource;
use  App\Repositories\Export\ExportRepositoryInterface;
use App\Repositories\ExportDetail\ExportDetailRepositoryInterface;
use App\Repositories\PaymentBook\PaymentBookRepositoryInterface;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Input\InputRepositoryInterface;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class PaymentController extends Controller
{
   protected $paymentbookRepository;
   protected $paymentRepository;
   protected $customerRepository;
   protected $InputRepository;
   protected $exportDetailRepository;
   protected $ExportRepository;
   protected $EmployeeRepository;
   public function __construct(
       PaymentBookRepositoryInterface $paymentbookRepository,
       ExportDetailRepositoryInterface $exportDetailRepository,
       ExportRepositoryInterface $ExportRepository,
       PaymentRepositoryInterface $paymentRepository,
       CustomerRepositoryInterface $customerRepository,
       InputRepositoryInterface  $InputRepository,
       EmployeeRepositoryInterface  $EmployeeRepository
       )
    {
        $this->paymentbookRepository = $paymentbookRepository;     
        $this->paymentRepository = $paymentRepository;     
        $this->customerRepository = $customerRepository;     
        $this->InputRepository = $InputRepository;
        $this->exportDetailRepository = $exportDetailRepository;
        $this->ExportRepository = $ExportRepository;
        $this->EmployeeRepository = $EmployeeRepository;
    }
    public function getlistvau(Request $request)
    {
        $status = $request->status;
        $category_id = $request->category_id;
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
        $customer_id = $request->customer_id;
        $list = $this->paymentRepository->findvau($customer_id,$dateFrom,$dateTo,$status,$category_id)->get();
        
        $customer = $this->customerRepository->findById($customer_id)->first();
        $input = $this->InputRepository->findByCustomerId($dateFrom, $dateTo,$customer_id,$status)->get();
        $collection = collect($input);
        return response()->json([
            'status' => true,
            'data'=>$list,
            'customer'=>$customer->name,
            'prepay'=>$collection->sum('prepay'),
            'totalmoney'=>$collection->sum('totalmoney'),
    ], 200);  
    }
    public function getlisttam(Request $request)
    {
        $status = $request->status;
        $category_id = $request->category_id;
        $category_idvau = $request->category_idvau;
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
        $customer_id = $request->customer_id;
        $list = $this->paymentRepository->findvau($customer_id,$dateFrom,$dateTo,$status,$category_id)->get();
        $list1 = $this->ExportDetailRepository->findtam($customer_id,$dateFrom,$dateTo,$status,$category_idvau)->get();
        
        $customer = $this->customerRepository->findById($customer_id)->first();
        $export = $this->ExportRepository->findByCustomerId($dateFrom, $dateTo,$customer_id,$status)->get();
        // $import = $this->ExportRepository->findByCustomerId($dateFrom, $dateTo,$customer_id,$status)->get();
        $collection = collect($export);
        return response()->json([
            'status' => true,
            'data'=>$list,
            'data1'=>$list1,
            'customer'=>$customer->name,
            'prepay'=>$collection->sum('prepay'),
            'totalmoney'=>$collection->sum('totalmoney'),
    ], 200);  
    }
    public function createBook(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->inputid) {
               foreach ($request->inputid as $value) {
                $this->InputRepository->update($value,['status' => '2']);
                }    
            }
            if ($request->inputid1) {
               foreach ($request->inputid1 as $value) {
                $this->ExportRepository->update($value,['status' => '2']);
                }    
            }
            $this->paymentbookRepository->insertGetId([
                'date' => Carbon::now(),
                'customer' => $request['customer'],
                'paid' => $request['paid'],
                'prepay' => $request['prepay'],
                'totalmoney' => $request['totalmoney'],
                'data' => $request['data'],
                'data1' => $request['data1'],
            ]);
            
            DB::commit();
            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => $e], 200);
        }
    }
    public function listpaymentbook()
    {
        $data11 = $this->paymentbookRepository->get(1);
        return response()->json([
            'status' => true,
            'data'=>PaymentBookResource::collection($data11)
            
    ], 200);  
    }
    public function getlistWorkedCarrier(Request $request)
    {
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
        $employee_id = $request->employee_id;
        $list = $this->paymentRepository->findCarrierInput($employee_id,$dateFrom,$dateTo)->get();
        $list1 = $this->exportDetailRepository->findCarrierExport($employee_id,$dateFrom,$dateTo)->get();
        $employee = $this->EmployeeRepository->find($employee_id);
        $collectionInput = collect($list);
        $collectionExport= collect($list1);
        return response()->json([
            'status' => true,
            'data'=>$list,
            'data1'=>$list1,
            'employee'=>$employee->name,
            'totalweigh'=>$collectionInput->sum('weight')+$collectionExport->sum('weight'),
    ], 200);  
    }
}
