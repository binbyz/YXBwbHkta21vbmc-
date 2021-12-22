<?php

namespace App\Http\Services;

use App\Contracts\MemberServiceContract;
use App\Models\KmongMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MemberService implements MemberServiceContract
{
    /**
     * 회원가입
     *
     * @param string $email
     * @param string $password
     * @param string $displayName
     * @return boolean
     */
    public function join(string $email, string $password, string $displayName): bool
    {
        // 중복 체크는 `Validator` Facade로 대체합니다.
        // `\App\Http\Controllers\MemberController:store()` 참고

        $model = new KmongMember();
        $model->email = $email;
        $model->password = Hash::make($password);
        $model->display_name = $displayName;

        return $model->save();
    }

    /**
     * 로그인 처리
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    /**
     * 로그아웃 처리
     *
     * @return boolean
     */
    public function logout(): bool
    {
        Session::flush();
        Auth::logout();

        return true;
    }
}
