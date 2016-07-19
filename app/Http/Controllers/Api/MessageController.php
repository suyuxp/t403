<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class MessageController extends Controller
{
    /**
     * 发送短信
     */
    public function sendMessage(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'content'       => 'required|max:300',
            'cellphones'    => 'required|regex:#^(\d{11}\,)*(\d{11})$#'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response($errors, 400);
        }

        $uid = env('message_uid');
        $passwd = env('message_passwd');
        $cellphones = $inputs['cellphones'];
        $content = urlencode(iconv('UTF-8', 'GBK', $inputs['content'] . '【' . env('message_corporation') . '】'));
        $gateway = "http://mb345.com:999/ws/BatchSend2.aspx?CorpID={$uid}&Pwd={$passwd}&Mobile={$cellphones}&Content={$content}";

        try {
            $result = file_get_contents($gateway);
        } catch (\Exception $e) {
            return response('网络错误', 400);
        }

        switch ($result) {
            case -1:    return response('账号未注册', 400);
            case -2:    return response('网络访问超时,请重试', 400);
            case -3:    return response('密码错误', 400);
            case -4:    return response('余额不足', 400);
            case -5:    return response('定时发送时间不是有效的时间格式', 400);
            case -6:    return response('提交信息末尾未加签名，请添加中文企业签名【 】', 400);
            case -7:    return response('发送内容需在1到300个字之间', 400);
            case -8:    return reponse('发送号码为空', 400);
            case -9:    return response('定时时间不能小于系统当前时间', 400);
            case -100:  return response('IP黑名单', 400);
            case -102:  return response('账号黑名单', 400);
            case -103:  return response('IP未导白', 400);
            case 0:     return response('error', 400);
            default:    return response('短信发送成功', 201);
        }
    }   
}
