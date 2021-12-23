<?php

namespace App\Contracts;

use App\Models\KmongOrder;
use App\Models\KmongProduct;

interface OnlineShopContract
{
    /**
     * 상품을 주문합니다.
     *
     * @param integer $productId
     * @param integer $status
     * @return boolean
     */
    public function order(int $productId, int $status = KmongOrder::STATUS_ORDER_REQUEST): bool;

    /**
     * 현재 회원의 주문 리스트를 가져옵니다.
     *
     * @return Array
     */
    public function orderList(): Array;

    /**
     * 상품을 조회합니다.
     *
     * @param integer $productId
     * @return nullable|KmongProduct
     */
    public function getProduct(int $productId): ?KmongProduct;
}
