<?php
namespace App\Repositories\Payment;

use App\Repositories\Contracts\RepositoryInterface;

interface PaymentRepositoryInterface extends RepositoryInterface
{
    public function findvau($customer,$dateFrom,$datoTo, $status,$category_id);
    public function findtam($customer,$dateFrom,$datoTo, $status,$category_id);
    public function findCarrierInput($customer,$dateFrom,$datoTo);
}