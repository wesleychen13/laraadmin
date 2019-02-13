<?php

/**
 * 二维数组去重
 * @return array
 */
if (!function_exists('array_unique_two_dimensional')) {
    function array_unique_multidimensional(array $input)
    {
        $unique = [];
        foreach ($input as $item) {
            if (!is_array($item)) {
                return $input;
            }

            $str = implode(',', $item); //利用implode，将二维数组中的下层数组变成字符串
            $strArr[] = $str;

            $unique = array_unique($strArr); //去掉重复的字符串，也就是生成一个干净的一维数组
        }

        $output = [];
        foreach ($unique as $item) {
            $output[] = explode(',', $item);
        }

        return $output;
    }
}


if (!function_exists('array_to_sort')) {
    /**
     * 对二维数组排序
     * @param string $arr old数组
     * @param string $keys 要排序的键
     * @param string $type 排序类型[asc,desc]
     * @param string $reset 重新排列数组key
     * @return string 返回排序之后的数组
     */
    function array_to_sort($arr, $keys, $type = 'asc', $reset = false)
    {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v) {
            $keysvalue[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($keysvalue);
        } else {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            if ($reset) {
                $new_array[] = $arr[$k];
            } else {
                $new_array[$k] = $arr[$k];
            }
        }
        return $new_array;
    }
}


/**
 * 写作的时间人性化
 *
 * @param int $time 写作的时间
 * @return string
 */
if (!function_exists('showWriteTime')) {
    function showWriteTime($time)
    {
        $interval = time() - $time;
        $format = array(
            '31536000' => '年',
            '2592000' => '个月',
            '604800' => '星期',
            '86400' => '天',
            '3600' => '小时',
            '60' => '分钟',
            '1' => '秒'
        );
        foreach ($format as $key => $value) {
            $match = floor($interval / (int)$key);
            if (0 != $match) {
                return $match . $value . '前';
            }
        }
        return date('Y-m-d', $time);
    }
}
if (!function_exists('pairList')) {
    function pairList($list, $keyField, $valueField)
    {
        $pairList = array();
        foreach ($list as $one) {
            $pairList[$one[$keyField]] = $one[$valueField];
        }
        return $pairList;
    }
}


/**
 * 重新组装url ，如果没有host回自动添加当前host
 * @param string $url
 * @param array $query key=>val
 * @return string
 */
function U($url, $query = [])
{
    $url = ltrim($url, '/');
    $urlInfo = parse_url($url);
    $aQuery = [];

    if (isset($urlInfo['query']) && $urlInfo['query'] !== '') {
        parse_str($urlInfo['query'], $aQuery);
    }
    $queryString = http_build_query(array_merge($aQuery, $query));
    if (isset($urlInfo['host'])) {
        $url = $urlInfo['scheme'] . '://' . $urlInfo['host'] . '/admin/';
    } else {
        $url = request()->root() . '/admin/';
    }
    $url .= isset($urlInfo['path']) ? $urlInfo['path'] : '';
    $url .= $queryString === '' ? '' : ('?' . $queryString);
    return $url;
}

/**
 * 验证角色菜单权限
 *
 * @param string $route 路由
 * @param string $params 附带参数
 * @return bool
 */

if (!function_exists('role')) {
    function role($route, $params = [])
    {
        $user = \Auth::guard('admin')->user();
        $role = session()->get(LOGIN_MARK_SESSION_KEY);
        if ($user['is_root']) {
            return true;
        }
        $route = trim($route);
        $roles = $role['role'];
        if (isset($roles[$route])) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('dict')) {
    function dict()
    {
        return new App\Services\Base\Dictionary;
    }
}


/**
 * 隐藏部分手机号码
 * @param $mobile
 * @param $hide_length
 * @return string
 */
if (!function_exists('hidePartMobile')) {
    function hidePartMobile($mobile, $hide_length = 5)
    {
        $hide_length = intval($hide_length);
        $hide = '';
        for ($i = 0; $i < $hide_length; $i++) {
            $hide .= '*';
        }
        $pattern = "/(1\d{1,2})([0-9]{" . $hide_length . "," . $hide_length . "})(\d+)/";
        $replacement = "\$1{$hide}\$3";
        return preg_replace($pattern, $replacement, $mobile);
    }
}

/**
 * Function echo_log
 * 输出调试日志
 * @param $content 输出内容
 */
if (!function_exists('echoLog')) {
    function echoLog($content, $filename = '')
    {
        if (is_object($content) || is_array($content)) {
            $content = var_export($content, true);
        }
        $log_path = storage_path() . DIRECTORY_SEPARATOR . "debug_log" . DIRECTORY_SEPARATOR;

        if ($filename) {
            $file_path = $log_path . $filename;
        } else {
            $file_path = $log_path . "debug_log_" . date("Ymd") . ".txt";
        }

        if (!file_exists($log_path)) {
            mkdir($log_path, 0777);
        }

        $fp = fopen($file_path, "a");
        flock($fp, LOCK_EX);
        fwrite($fp, "执行日期：" . date("Y-m-d H:i:s", time()) . "\n" . $content . "\n\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}
if (!function_exists('curlAjax')) {
    function curlAjax($url)
    {
        $cookieStr = '';
        if ($_COOKIE) {
            foreach ($_COOKIE as $key => $val) {
                $cookieStr .= $key . '=' . $val . ';';
            }
            $cookieStr = substr($cookieStr, 0, -1);
        }
        $headers = array(
            'Content-Type' => 'text/json;charset=utf-8', // 设置为Ajax方式
            'X-Requested-With' => 'XMLHttpRequest', // 设置为Ajax方式
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36', // 设置为Ajax方式
            'Referer' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            'Cookie' => $cookieStr
        );
        $headerArr = array();
        foreach ($headers as $n => $v) {
            $headerArr[] = $n . ':' . $v;
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }
}

if (!function_exists('img')) {
    function img($system, $system_primary = NULL, $system_key = NULL, $first = false, $pagesize = PAGE_MAX_NUMS)
    {
        $paramArgs = func_get_args();
        $key = "system_img" . md5(serialize($paramArgs));
        if (!Cache::has($key) || request('no_cache') === 'true') {
            $data = \App\Services\Base\Images::getSrc($system, $system_primary, $system_key, $first, $pagesize);
            \Cache::forever($key, $data);
        }
        $data = \Cache::get($key);
        return $data;
    }
}

/**
 * 字符截取 支持UTF8/GBK
 * @param $string
 * @param $length
 * @param $dot
 */
if (!function_exists('str_cut')) {
    function str_cut($string, $length, $dot = '...')
    {
        $strlen = strlen($string);
        if ($strlen <= $length) return $string;
        $string = str_replace(array(' ', '&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵', ' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
        $strcut = '';
        if (strtolower('utf-8') == 'utf-8') {
            $length = intval($length - strlen($dot) - $length / 3);
            $n = $tn = $noc = 0;
            while ($n < strlen($string)) {
                $t = ord($string[$n]);
                if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1;
                    $n++;
                    $noc++;
                } elseif (194 <= $t && $t <= 223) {
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                } elseif (224 <= $t && $t <= 239) {
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                } elseif (240 <= $t && $t <= 247) {
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                } elseif (248 <= $t && $t <= 251) {
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                } elseif ($t == 252 || $t == 253) {
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                } else {
                    $n++;
                }
                if ($noc >= $length) {
                    break;
                }
            }
            if ($noc > $length) {
                $n -= $tn;
            }
            $strcut = substr($string, 0, $n);
            $strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
        } else {
            $dotlen = strlen($dot);
            $maxi = $length - $dotlen - 1;
            $current_str = '';
            $search_arr = array('&', ' ', '"', "'", '“', '”', '—', '<', '>', '·', '…', '∵');
            $replace_arr = array('&amp;', '&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;', ' ');
            $search_flip = array_flip($search_arr);
            for ($i = 0; $i < $maxi; $i++) {
                $current_str = ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
                if (in_array($current_str, $search_arr)) {
                    $key = $search_flip[$current_str];
                    $current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
                }
                $strcut .= $current_str;
            }
        }
        return $strcut . $dot;
    }
}

/**
 * 取得文件扩展
 *
 * @param $filename 文件名
 * @return 扩展名
 */
if (!function_exists('fileExt')) {
    function fileExt($filename)
    {
        return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
    }
}

/**
 * 过滤参数
 *
 * @param $param    参数数组
 * @param $allowKey 被允许的KEY集合数组
 * @return 扩展名
 */
if (!function_exists('filterParam')) {
    function filterParam(array $param, array $allowKey)
    {
        $data = array();
        foreach ($param AS $key => $val) {
            if (in_array($key, $allowKey)) $data[$key] = $val;
        }
        return $data;
    }
}
if (!function_exists('list_to_tree')) {
    function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}


/**
 * 判断远程文件是否存在
 * @param unknown $url
 * @return boolean
 */
function check_remote_file_exists($url)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    $result = curl_exec($curl);
    $found = false;
    if ($result !== false) {
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($statusCode == 200) {
            $found = true;
        }
    }
    curl_close($curl);
    return $found;
}

if (!function_exists('getCacheKey')) {
    /**
     * 更具参数获取一个唯一的缓存KEY
     * @param string $name 名称
     * @param obj|array|string $data 参数
     */
    function getCacheKey($name, $data)
    {
        return $name . md5(serialize($data));

    }
}

function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA'])) {
        // 找不到为false,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}


/**
 * post 提交
 * @param strint $url
 * @param array $post_data
 * @return mixed
 */
function formPost($url, $post_data = array(), $timeout = 60, $userpwd = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // 设置超时限制防止死循环
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    // 		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    if ($userpwd) {
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
    }
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        // echo curl_error($ch);exit;
    }
    curl_close($ch); // 关键CURL会话
    //	CBase::write_log('formPost' . date("Ymd") . ".log", $result);
    return $result;
}


/***
 * @param string $position 图片保存地址
 * @return string
 */
function editor($position = 'local')
{
    $token = csrf_token();
    $editer = <<<HTML
    <!-- 配置文件 -->
    <script type="text/javascript" src="/base/neditor-1.5.3/neditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/base/neditor-1.5.3/neditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
   
        var ue = UE.getEditor('container',{
             toolbars: [
          ["fullscreen","source","autotypeset","bold", "italic","underline","forecolor", "paragraph","fontfamily","fontsize","indent","justifyleft", "justifycenter","justifyright","justifyjustify","link","unlink","simpleupload","insertimage"
          ]],
           autoHeightEnabled: true,
           autoFloatEnabled: true,
           initialFrameHeight:320
        });
         UE.Editor.prototype._bkGetActionUrl = UE.Editor.prototype.getActionUrl;
         UE.Editor.prototype.getActionUrl = function(action) {
        if (action == 'simpleupload' ||  action == 'uploadimage') {
          return '/admin/Base/AttachmentInfo/upload?folder=upload&editor=1&position={$position}';
        } else {
            return this._bkGetActionUrl.call(this, action);
        }
    };
   
        ue.ready(function(){
        ue.execCommand('serverparam', '_token', '{$token}');
    })
    </script>
HTML;

    return $editer;
}


if (!function_exists('widget')) {
    function widget($widgetName)
    {
        $widgetNameEx = explode('.', $widgetName);
        if (!isset($widgetNameEx[1])) return false;
        $widgetClass = 'App\\Widget\\' . $widgetNameEx[0] . '\\' . $widgetNameEx[1];
        if (app()->bound($widgetName)) return app()->make($widgetName);
        app()->singleton($widgetName, function () use ($widgetClass) {
            return new $widgetClass();
        });
        return app()->make($widgetName);
    }
}