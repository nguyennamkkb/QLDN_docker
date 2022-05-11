<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CatDong\CatDongRepositoryInterface;
use App\Http\Resources\CatDongResource;
use Illuminate\Support\Facades\DB;
class CatDongController extends Controller
{
    protected $CatDongRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(CatDongRepositoryInterface $CatDongRepository)
    {
        $this->CatDongRepository = $CatDongRepository;
    }
    public function index(Request $request)
    {
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
        $employee_id = $request->employee_id;
        $limit = $request->limit;
        $list = $this->CatDongRepository->findBy($dateFrom,$dateTo,$employee_id)->paginate($limit);
        return CatDongResource::collection($list);
    }
    
    public function store(Request $request)
    {
        // $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->CatDongRepository->insertGetId([
                'employee_id' => $request->employee_id,
                'date' => $request->date,
                'weigh' => $request->weigh,
                'price' => $request->price,
                'xuongxe' => $request->xuongxe,
                'trudi' => $request->trudi,
                'ung' => $request->ung,
                'totalmomey' => $request->totalmomey,
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }
    public function update(Request $request, $id)
    {
        // $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->CatDongRepository->update($id,[
                'employee_id' => $request->employee_id,
                'date' => $request->date,
                'weigh' => $request->weigh,
                'price' => $request->price,
                'xuongxe' => $request->xuongxe,
                'trudi' => $request->trudi,
                'ung' => $request->ung,
                'totalmomey' => $request->totalmomey,
                'status' => $request->status,
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

       $resp = $this->CatDongRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
