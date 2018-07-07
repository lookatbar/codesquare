## 获取js票据接口



REQUEST (请求):

|  请求方式    |    POST     |
| :------- | ----: | :---:  |
| 请求地址 | {host}/codesquare/weixin/get-sign-package   |





Response(响应)
```
{
    "success": 0,
    "message": "ok",
    "data": {
        "appId": "wxfe3aa6c1dd22f053",
        "nonceStr": "M09r9fbOSoGCVDsB",
        "timestamp": 1530961717,
        "url": "http://jkds.cracher.top/codesquare/weixin/get-sign-package",
        "signature": "90a28453955d22d24c9376f331871c341677bc78",
        "rawString": "jsapi_ticket=bxLdikRXVbTPdHSM05e5uxYHOWLPm4p56q9uRo4JQGKUei5oBTn6dzzdZ0ZgCzxiYxp3rg1KXu25cGhGckoNYA&noncestr=M09r9fbOSoGCVDsB×tamp=1530961717&url=http://jkds.cracher.top/codesquare/weixin/get-sign-package"
    },
    "code": ""
}
```

响应参数说明：

    | 参数名称  | 参数类型 |  描述   |备注 |
    |:------- | ----:|  ---: |---:   |---:   |
    |data      | array |方式列表||
    |--appId|int| 必填，公众号的唯一标识||
    |--timestamp|string| 必填，生成签名的时间戳||
    |--nonceStr|string| 必填，生成签名的随机串||
    |--signature|string| 签名||
    
    
