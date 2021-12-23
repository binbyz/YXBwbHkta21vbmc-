<?php

namespace App\Http\Controllers\Traits;

trait ResponseFormatGenerator
{
    /**
     * 통일된 응답 결과를 반환하기 위해 사용합니다.
     *
     * @param boolean $status
     * @param string $messages
     * @return array
     */
    protected function resformat(bool $status = false, string | array $messages = ''): array
    {
        $format = ['status' => $status];

        if (is_array($messages)) {
            $format = array_merge($format, $messages);
        } else {
            $format['messages'] = $messages;
        }

        return $format;
    }
}
