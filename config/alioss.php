<?php

return [
    'ossServer' => env('ALIOSS_SERVER', 'http://oss-cn-beijing.aliyuncs.com'),                      // 外网
    'ossServerInternal' => env('ALIOSS_SERVERINTERNAL', 'http://oss-cn-beijing-internal.aliyuncs.com'),      // 内网
    'AccessKeyId' => env('ALIOSS_KEYID', 'LTAILL5VPO7heulm'),                     // key
    'AccessKeySecret' => env('ALIOSS_KEYSECRET', 'w4UgiS2d6uj7jiRPkbDIaFkcJwUez5'),             // secret
    'BucketName' => env('ALIOSS_BUCKETNAME', 'swdz-xcx') ,                 // bucket
    'FileUrl' => env('ALIOSS_FileUrl', 'http://ossxcx.9026.com/')
];