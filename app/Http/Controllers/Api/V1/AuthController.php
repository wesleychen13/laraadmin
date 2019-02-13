<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UserInfoModel;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
//use App\Http\HelperTraits\AttachmentHelper;
use App\Services\Base\ErrorCode;
use Illuminate\Support\Facades\Hash;
use Validator, Auth, Cache;

class AuthController extends Controller
{

    private $expireTime     = 1;
    private $keySmsCode     = 'auth:sms:';
    private $keySmsCodeExist     = 'auth:sms:exist';
    private $expireTimeExist     = 24*60;
    protected $app;


    /**
     * @api {post} /api/auth/login 登陆（login）
     * @apiDescription 登陆(login)
     * @apiGroup Auth
     * @apiPermission none
     * @apiVersion 0.1.0
     * @apiParam {string}    code               小程序登陆后返回的code
     * @apiParam {string}    nickName           微信昵称
     * @apiParam {string}    avatar             微信头像
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "state": true,
     *     "code": 0,
     *     "message": "",
     *     "data": {
     *         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjdjYWUyYzFmYTUwMTIyZDI0ZTRiYTZhZGZhNmQxYmZlOWNiMzIxMTBmYWJlZjNjYzIyNmViZjRmNGExNWM3NjllNmU2ZTNiYWE5OGNhOWUzIn0.eyJhdWQiOiIxIiwianRpIjoiN2NhZTJjMWZhNTAxMjJkMjRlNGJhNmFkZmE2ZDFiZmU5Y2IzMjExMGZhYmVmM2NjMjI2ZWJmNGY0YTE1Yzc2OWU2ZTZlM2JhYTk4Y2E5ZTMiLCJpYXQiOjE0NzU0MTE1NTgsIm5iZiI6MTQ3NTQxMTU1OCwiZXhwIjo0NjMxMDg1MTU4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.E9YGEzuRUOk02aV1EiWLJ_pD0hKoCyW0k_sGy63hM3u5X8K_HI1kVhaU6JNLqLZeszIAroTEDB8XMgZKAqTLlwtL8PLCJcuDoxfk1BRHbfjhDheTsahBysKGalvNEpzRCrGlao0mS0Cg9qDpEsndtypPFS8sfaflToOzbJjiSK2DvQiHSH8xZI3zHJTezgZMz-pB_hPTxp8ajdv0ve1gWtWjs3vERr0Y91X4hngO8X7LuXtAYtfxGZRIye12YE7TuLBMYzj8CCfiRt7Smhyf4palNW5mzKlZpa2l87n6NQ14Iy4oMzQ2PON1j_swrosuE2yZohGOn6fDdSCBRdJ6dLD_emjBdQCQOoB63R7BbhFZgvFX25TjzFJ7r9AdVMiGmebuRKEVSZV_JCGu1C71OIbQk-UK35s00gSr2fmJGBbN2cZTXBRTJpfuMZ_ihFYEZrvVq_Ih2X0xkd36JUuxaUld1BXRgPZvH-9jBuhe0YW2OOlgwpdm6ZB8BMcuS4ftLoi6FipgzFqfIuy-0ZqPMDnJaG7Gycrdpxza00mgOFxYxJtqwZNsUWFRZEVU881l6VC_cy294YXSPQxUwEoyKg-G5Pm8AEB9bqv5z4EU4B8-XTd3zKNqtNba_snHbc711i4EytCiZfYSjNB1hwenq45YYOAhPTwOpFI0kxyRazc",
     *         "user": {
     *             "id": 1,
     *             "name": "15888888888",
     *             "email": "abcdefg@gmail.com",
     *             "phone": "15888888888",
     *             "avatar": null,
     *             "last_ip": null,
     *             "created_at": "2016-09-30 00:45:13",
     *             "updated_at": "2016-09-29 16:43:36"
     *         }
     *     }
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 400 Bad Request
     * {
     *     "state": false,
     *     "code": 1000,
     *     "message": "传入参数不正确",
     *     "data": null or []
     * }
     * 可能出现的错误代码：
     *    1000    CLIENT_WRONG_PARAMS             传入参数不正
     *    1001                                    获取OpenId失败
     */
    public function login(Request $request) {
        /*  //EasyWechat 小程序登录
         * $code = $request->get('code');

        $config = [
            'app_id' => '',
            'secret' => '',

            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
        ];
        $this->app = Factory::miniProgram($config);
        $session = $this->app->auth->session($code);
        \Log::info(json_encode($session));

        $openid = $session['id'];
        if (!$openid) {
            $data = [
                'code' => 1001,
                'msg' => '获取openid失败！'
            ];
            return $this->api($data);
        }
        */

        $userinfo = UserInfoModel::first();

        if (Auth::loginUsingId($userinfo->id)) {
            $user = Auth::user();
            $token = $user->createToken($user->id . '-' . $user->openid)->accessToken;
            return $this->api(compact('token', 'user'));
        } else {
            return $this->error(ErrorCode::INCORRECT_USER_OR_PASS);
        }
    }

    /**
     * @api {get} /api/auth/logout 退出(logout)
     * @apiDescription 退出(logout)
     * @apiGroup Auth
     * @apiPermission Passport
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "state": true,
     *     "code": 0,
     *     "message": "",
     *     "data": {
     *         "code": 200,
     *           "msg": "退出登录成功"
     *     }
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 400 Bad Request
     * {
     *     "state": false,
     *     "code": 1104,
     *     "message": "退出失败",
     *     "data": null
     * }
     * 可能出现的错误代码：
     *    1104    LOGOUT_FAILED                   退出失败
     */
    public function logout() {
        if (Auth::guard('api')->check()){
            Auth::guard('api')->user()->token()->revoke();
            return $this->api(['code' => 200,'msg'=> '退出登录成功']);
        }
        return $this->error(ErrorCode::LOGOUT_FAILED);
    }




}
