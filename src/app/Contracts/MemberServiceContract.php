<?php

namespace app\Contracts;

interface MemberServiceContract
{
    /**
     * 회원가입을 처리합니다.
     *
     * @param string $id
     * @param string $password
     * @param string $displayName
     * @return boolean
     */
    public function join(string $id, string $password, string $displayName): bool;

    /**
     * 로그인을 처리합니다.
     *
     * @param string $id
     * @param string $password
     * @return boolean
     */
    public function login(string $id, string $password): bool;

    /**
     * 로그아웃을 처리합니다.
     *
     * @return boolean
     */
    public function logout(): bool;
}
