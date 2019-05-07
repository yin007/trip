<?php

// 公共助手函数

if (!function_exists('__')) {

    /**
     * 获取语言变量值
     * @param string $name 语言变量名
     * @param array $vars 动态变量值
     * @param string $lang 语言
     * @return mixed
     */
    function __($name, $vars = [], $lang = '')
    {
        if (is_numeric($name) || !$name)
            return $name;
        if (!is_array($vars)) {
            $vars = func_get_args();
            array_shift($vars);
            $lang = '';
        }
        return \think\Lang::get($name, $vars, $lang);
    }

}

if (!function_exists('format_bytes')) {

    /**
     * 将字节转换为可读文本
     * @param int $size 大小
     * @param string $delimiter 分隔符
     * @return string
     */
    function format_bytes($size, $delimiter = '')
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $size >= 1024 && $i < 6; $i++)
            $size /= 1024;
        return round($size, 2) . $delimiter . $units[$i];
    }

}

if (!function_exists('datetime')) {

    /**
     * 将时间戳转换为日期时间
     * @param int $time 时间戳
     * @param string $format 日期时间格式
     * @return string
     */
    function datetime($time, $format = 'Y-m-d H:i:s')
    {
        $time = is_numeric($time) ? $time : strtotime($time);
        return date($format, $time);
    }

}

if (!function_exists('human_date')) {

    /**
     * 获取语义化时间
     * @param int $time 时间
     * @param int $local 本地时间
     * @return string
     */
    function human_date($time, $local = null)
    {
        return \fast\Date::human($time, $local);
    }

}

if (!function_exists('cdnurl')) {

    /**
     * 获取上传资源的CDN的地址
     * @param string $url 资源相对地址
     * @param boolean $domain 是否显示域名 或者直接传入域名
     * @return string
     */
    function cdnurl($url, $domain = false)
    {
        $url = preg_match("/^https?:\/\/(.*)/i", $url) ? $url : \think\Config::get('upload.cdnurl') . $url;
        if ($domain && !preg_match("/^(http:\/\/|https:\/\/)/i", $url)) {
            if (is_bool($domain)) {
                $public = \think\Config::get('view_replace_str.__PUBLIC__');
                $url = rtrim($public, '/') . $url;
                if (!preg_match("/^(http:\/\/|https:\/\/)/i", $url)) {
                    $url = request()->domain() . $url;
                }
            } else {
                $url = $domain . $url;
            }
        }
        return $url;
    }

}


if (!function_exists('is_really_writable')) {

    /**
     * 判断文件或文件夹是否可写
     * @param    string $file 文件或目录
     * @return    bool
     */
    function is_really_writable($file)
    {
        if (DIRECTORY_SEPARATOR === '/') {
            return is_writable($file);
        }
        if (is_dir($file)) {
            $file = rtrim($file, '/') . '/' . md5(mt_rand());
            if (($fp = @fopen($file, 'ab')) === FALSE) {
                return FALSE;
            }
            fclose($fp);
            @chmod($file, 0777);
            @unlink($file);
            return TRUE;
        } elseif (!is_file($file) OR ($fp = @fopen($file, 'ab')) === FALSE) {
            return FALSE;
        }
        fclose($fp);
        return TRUE;
    }

}

if (!function_exists('rmdirs')) {

    /**
     * 删除文件夹
     * @param string $dirname 目录
     * @param bool $withself 是否删除自身
     * @return boolean
     */
    function rmdirs($dirname, $withself = true)
    {
        if (!is_dir($dirname))
            return false;
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirname, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }
        if ($withself) {
            @rmdir($dirname);
        }
        return true;
    }

}

if (!function_exists('copydirs')) {

    /**
     * 复制文件夹
     * @param string $source 源文件夹
     * @param string $dest 目标文件夹
     */
    function copydirs($source, $dest)
    {
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }
        foreach (
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            if ($item->isDir()) {
                $sontDir = $dest . DS . $iterator->getSubPathName();
                if (!is_dir($sontDir)) {
                    mkdir($sontDir, 0755, true);
                }
            } else {
                copy($item, $dest . DS . $iterator->getSubPathName());
            }
        }
    }

}

if (!function_exists('mb_ucfirst')) {

    function mb_ucfirst($string)
    {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_strtolower(mb_substr($string, 1));
    }

}

if (!function_exists('addtion')) {

    /**
     * 附加关联字段数据
     * @param array $items 数据列表
     * @param mixed $fields 渲染的来源字段
     * @return array
     */
    function addtion($items, $fields)
    {
        if (!$items || !$fields)
            return $items;
        $fieldsArr = [];
        if (!is_array($fields)) {
            $arr = explode(',', $fields);
            foreach ($arr as $k => $v) {
                $fieldsArr[$v] = ['field' => $v];
            }
        } else {
            foreach ($fields as $k => $v) {
                if (is_array($v)) {
                    $v['field'] = isset($v['field']) ? $v['field'] : $k;
                } else {
                    $v = ['field' => $v];
                }
                $fieldsArr[$v['field']] = $v;
            }
        }
        foreach ($fieldsArr as $k => &$v) {
            $v = is_array($v) ? $v : ['field' => $v];
            $v['display'] = isset($v['display']) ? $v['display'] : str_replace(['_ids', '_id'], ['_names', '_name'], $v['field']);
            $v['primary'] = isset($v['primary']) ? $v['primary'] : '';
            $v['column'] = isset($v['column']) ? $v['column'] : 'name';
            $v['model'] = isset($v['model']) ? $v['model'] : '';
            $v['table'] = isset($v['table']) ? $v['table'] : '';
            $v['name'] = isset($v['name']) ? $v['name'] : str_replace(['_ids', '_id'], '', $v['field']);
        }
        unset($v);
        $ids = [];
        $fields = array_keys($fieldsArr);
        foreach ($items as $k => $v) {
            foreach ($fields as $m => $n) {
                if (isset($v[$n])) {
                    $ids[$n] = array_merge(isset($ids[$n]) && is_array($ids[$n]) ? $ids[$n] : [], explode(',', $v[$n]));
                }
            }
        }
        $result = [];
        foreach ($fieldsArr as $k => $v) {
            if ($v['model']) {
                $model = new $v['model'];
            } else {
                $model = $v['name'] ? \think\Db::name($v['name']) : \think\Db::table($v['table']);
            }
            $primary = $v['primary'] ? $v['primary'] : $model->getPk();
            $result[$v['field']] = $model->where($primary, 'in', $ids[$v['field']])->column("{$primary},{$v['column']}");
        }

        foreach ($items as $k => &$v) {
            foreach ($fields as $m => $n) {
                if (isset($v[$n])) {
                    $curr = array_flip(explode(',', $v[$n]));

                    $v[$fieldsArr[$n]['display']] = implode(',', array_intersect_key($result[$n], $curr));
                }
            }
        }
        return $items;
    }

}

if (!function_exists('var_export_short')) {

    /**
     * 返回打印数组结构
     * @param string $var 数组
     * @param string $indent 缩进字符
     * @return string
     */
    function var_export_short($var, $indent = "")
    {
        switch (gettype($var)) {
            case "string":
                return '"' . addcslashes($var, "\\\$\"\r\n\t\v\f") . '"';
            case "array":
                $indexed = array_keys($var) === range(0, count($var) - 1);
                $r = [];
                foreach ($var as $key => $value) {
                    $r[] = "$indent    "
                        . ($indexed ? "" : var_export_short($key) . " => ")
                        . var_export_short($value, "$indent    ");
                }
                return "[\n" . implode(",\n", $r) . "\n" . $indent . "]";
            case "boolean":
                return $var ? "TRUE" : "FALSE";
            default:
                return var_export($var, TRUE);
        }
    }


    if (!function_exists('build_order_no')) {
        /**
         * 生成唯一订单号
         *
         * @return string
         * */
        function build_order_no($type)
        {
            if ($type == 1) {
                //生成唯一商品订单号
//                return 'Ord' . date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
                return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
            }
        }
    }


    if (!function_exists('lock_url')) {
        //加密函数
        function lock_url($txt, $key = 'penghaiyang')
        {
            $txt = $txt . $key;
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
            $nh = rand(0, 64);
            $ch = $chars[$nh];
            $mdKey = md5($key . $ch);
            $mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
            $txt = base64_encode($txt);
            $tmp = '';
            $i = 0;
            $j = 0;
            $k = 0;
            for ($i = 0; $i < strlen($txt); $i++) {
                $k = $k == strlen($mdKey) ? 0 : $k;
                $j = ($nh + strpos($chars, $txt[$i]) + ord($mdKey[$k++])) % 64;
                $tmp .= $chars[$j];

            }

            return urlencode(base64_encode($ch . $tmp));

        }
    }

    if (!function_exists('lock_url')) {
        //加密函数
        function lock_url($txt, $key = 'penghaiyang')
        {
            $txt = $txt . $key;
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
            $nh = rand(0, 64);
            $ch = $chars[$nh];
            $mdKey = md5($key . $ch);
            $mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
            $txt = base64_encode($txt);
            $tmp = '';
            $i = 0;
            $j = 0;
            $k = 0;
            for ($i = 0; $i < strlen($txt); $i++) {
                $k = $k == strlen($mdKey) ? 0 : $k;
                $j = ($nh + strpos($chars, $txt[$i]) + ord($mdKey[$k++])) % 64;
                $tmp .= $chars[$j];

            }

            return urlencode(base64_encode($ch . $tmp));

        }
    }
    if (!function_exists('unlock_url')) {
        //解密函数

        function unlock_url($txt,$key='penghaiyang')
        {
            $txt = base64_decode(urldecode($txt));

            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";

            $ch = $txt[0];

            $nh = strpos($chars,$ch);

            $mdKey = md5($key.$ch);

            $mdKey = substr($mdKey,$nh%8, $nh%8+7);

            $txt = substr($txt,1);

            $tmp = '';

            $i=0;$j=0; $k = 0;

            for ($i=0; $i<strlen($txt); $i++) {
                $k = $k == strlen($mdKey) ? 0 : $k;

                $j = strpos($chars,$txt[$i])-$nh - ord($mdKey[$k++]);

                while ($j<0) $j+=64;

                $tmp .= $chars[$j];
            }

            return trim(base64_decode($tmp),$key);
        }
    }



}
function get_route($value='')
{
    $url = $_SERVER['REQUEST_SCHEME'].'://' . $_SERVER['HTTP_HOST'];
    return $url;
}
/**
 * @param string $url
 * @param array $data
 * @return json|html
 * curl请求
 */
function http_request($url, $data = null) {
    //初识化
    $ch = curl_init();
    //设置变量
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded'
    ));
    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //执行
    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'ERROR ' . curl_error($ch);
    }
    curl_close($ch);
    return $output;
}
/**
* @return string $token
* 获取保存的微信token
* @param [bool] 当文件中token过期，可以通过定义$reset来重新获取token
*/
function get_token($reset=0) {
    $arr['time'] = time();

    $ser_arr = file_get_contents("../public/token.txt");
    if ($reset) {
        $ser_arr=0;
    }
    if ($ser_arr) {
        $old_arr = unserialize($ser_arr);
        if ($arr['time'] - $old_arr['time'] > 6000) {
            $arr['token'] = get_newtoken();
            $token = $arr['token'];
            $arr = serialize($arr);
            file_put_contents("../public/token.txt", $arr);
        } else {
            $token = $old_arr['token'];
        }
    } else {
        $arr['token'] = get_newtoken();
        $token = $arr['token'];
        $arr = serialize($arr);
        file_put_contents("../public/token.txt", $arr);
    }
    return $token;
}
/**
 * @return string $token
 * 请求服务器获取微信token
 */
function get_newtoken() {
    $appid = 'wx6de23865414dc10a';
    $appsecret = 'e517ddb289ec59f19c4b4345347a287c';
    $new_access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
    $new_access_token_json = http_request($new_access_token_url);
    $new_access_token_array = json_decode($new_access_token_json, true);
    $new_access_token = $new_access_token_array['access_token'];
    return $new_access_token;
}
/**
 * @return array $signPackage
 * 用于调用高级接口的信息
 */
function getSignPackage() {
    $jsapiTicket = get_ticket();
    //$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $timestamp = time();
    $nonceStr = createNonceStr();
    $string = "jsapi_ticket={$jsapiTicket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";
    $signature = sha1($string);
    $signPackage = array(
        "appId" => 'wx6de23865414dc10a' ,
        "nonceStr" => $nonceStr,
        "url" => $url,
        "timestamp" => $timestamp,
        "signature" => $signature,
        "rawString" => $string
    );
    return $signPackage;
}
/**
 * @return string $ticket
 * 获取保存的微信ticket
 */
function get_ticket() {
    $arr['time'] = time();
    $ser_arr = file_get_contents('../public/ticket.txt');
    if ($ser_arr) {
        $old_arr = unserialize($ser_arr);
        if ($arr['time'] - $old_arr['time'] > 6666) {
            $token = get_token();
            $arr['ticket'] = get_newticket($token);
            $ticket = $arr['ticket'];
            $arr = serialize($arr);
            file_put_contents('../public/ticket.txt', $arr);
        } else {
            $ticket = $old_arr['ticket'];
        }
    }
    //第一次 操作
    else {
        $token = get_token();
        $arr['ticket'] = get_newticket($token);
        $ticket = $arr['ticket'];
        $arr = serialize($arr);
        file_put_contents('../public/ticket.txt', $arr);
    }
    return $ticket;
}
/**
 * @return string $ticket
 * 获取保存的微信ticket
 */
function get_newticket($token) {
    $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=" . $token . "&type=jsapi";
    $data = json_decode(http_request($url) , true);
    return $data['ticket'];
}
/**
 * @param int $length
 * @return string $str
 * 获取随机字符
 */
function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str.= substr($chars, mt_rand(0, strlen($chars) - 1) , 1);
    }
    return $str;
}