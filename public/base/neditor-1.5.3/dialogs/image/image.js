/**
 * User: Jinqn
 * Date: 14-04-08
 * Time: 下午16:34
 * 上传图片对话框逻辑代码,包括tab: 远程图片/上传图片/在线图片/搜索图片
 */

(function () {

    var onlineImage;

    window.onload = function () {
        initButtons();
    };


    /* 初始化onok事件 */
    function initButtons() {

        dialog.onok = function () {
            list = getInsertList();
            if(list) {
                editor.execCommand('insertimage', list);
                //editor.fireEvent("catchRemoteImage");
            }
        };
    }

    function  getInsertList() {
        var i, lis = $('div.img-card span.checked'), list = [];

        for (i = 0; i < lis.length; i++) {
                var img = lis[i]
                    src = img.getAttribute('data-src');

                list.push({
                    src: src,
                    _src: src,
                    alt: src.substr(src.lastIndexOf('/') + 1),
                });

        }
        return list;
    }


})();
