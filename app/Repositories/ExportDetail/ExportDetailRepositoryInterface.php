<?php
namespace App\Repositories\ExportDetail;

use App\Repositories\Contracts\RepositoryInterface;

interface ExportDetailRepositoryInterface extends RepositoryInterface
{
    public function findBy($keyword);
    public function findtam($customer,$dateFrom,$datoTo, $status,$category_id);
    public function findCarrierExport($customer,$dateFrom,$datoTo);
}