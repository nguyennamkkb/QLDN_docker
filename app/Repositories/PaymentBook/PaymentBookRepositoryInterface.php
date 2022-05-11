<?php
namespace App\Repositories\PaymentBook;

use App\Repositories\Contracts\RepositoryInterface;

interface PaymentBookRepositoryInterface extends RepositoryInterface
{
    public function findBy($keyword,$address, $phone);
    public function multiUpdateStatusById($arr_input,$value );
}