<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\MemberServiceContract;
use App\Http\Controllers\Traits\ResponseFormatGenerator;
use App\Exceptions\MemberException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * 통일된 응답결과를 사용하기 위한 메소드가 포함돼 있습니다.
     */
    use ResponseFormatGenerator;

    private MemberServiceContract $memberService;

    /**
     * Constructor
     */
    public function __construct(MemberServiceContract $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * 계정을 생성합니다.
     *
     * @method POST
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'bail|string|required|email:rfc,dns|max:50|unique:kmong_members,email',
            'password' => 'bail|string|required|min:7',
            'display_name' => 'required|string|min:3|max:10|unique:kmong_members,display_name',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $this->resformat(false, json_decode($validator->errors(), true)),
                Response::HTTP_BAD_REQUEST,
            );
        }

        try {
            $message = '';
            $joinned = $this->memberService->join(
                $request->get('email'),
                $request->get('password'),
                $request->get('display_name'),
            );
        } catch (MemberException $e) {
            $message = $e->getMessage();
        }

        return response()->json($this->resformat($joinned, $message));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
