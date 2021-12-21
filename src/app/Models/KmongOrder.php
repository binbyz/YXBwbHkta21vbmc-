<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KmongOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * 주문 상태 정보
     *
     * 주문요청: 0
     * 입금대기: 1
     * 입금확인: 2
     * 판매자 확인: 3
     * 배송준비중 (작업중): 4
     * 배송완료: 5
     * 환불요청: 6
     * 환불거절: 7
     */
    const STATUS_ORDER_REQUEST = 0;
    const STATUS_INCOME_READY = 1;
    const STATUS_INCOME_COMPLETE = 2;
    const STATUS_SELLER_CHECKED = 3;
    const STATUS_SELLER_PACKAGING = 4;
    const STATUS_SELLER_DELIVERIED = 5;
    const STATUS_CLIENT_REFUND_REQUEST = 6;
    const STATUS_SELLER_REJECT_REFUND = 7;

    public static array $status = [
        self::STATUS_ORDER_REQUEST => '주문 요청',
        self::STATUS_INCOME_READY => '입금 대기',
        self::STATUS_INCOME_COMPLETE => '입금 확인',
        self::STATUS_SELLER_CHECKED => '판매자 확인',
        self::STATUS_SELLER_PACKAGING => '작업 중',
        self::STATUS_SELLER_DELIVERIED => '작업 완료',
        self::STATUS_CLIENT_REFUND_REQUEST => '환불 요청',
        self::STATUS_SELLER_REJECT_REFUND => '환불 거절',
    ];

    /**
     * 현재 배송상태를 텍스트로 리턴합니다.
     *
     * @return string
     */
    public function getStatusText(): string
    {
        if (array_key_exists($this->status, self::$status)) {
            return self::$status[$this->status];
        }

        return '';
    }
}
