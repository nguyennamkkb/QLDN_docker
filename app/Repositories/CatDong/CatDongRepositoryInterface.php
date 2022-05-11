<?php
namespace App\Repositories\CatDong;

use App\Repositories\Contracts\RepositoryInterface;

interface CatDongRepositoryInterface extends RepositoryInterface
{
    public function findBy($dateFrom,$dateTo,$employee_id);
    public function findById($customer_id);
}