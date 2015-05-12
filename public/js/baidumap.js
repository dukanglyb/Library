define('baidumap', function(require, exports, module) {

    var map;

    var fn = {
        //创建和初始化地图函数：
        initMap:function() {
            fn.createMap();//创建地图
            fn.setMapEvent();//设置地图事件
            fn.addMapControl();//向地图添加控件
            fn.addMapOverlay();//向地图添加覆盖物
        },

        createMap:function () {
            map = new BMap.Map("baidu_map");//116.403874,39.914889
            map.centerAndZoom(new BMap.Point(116.463539, 33.944946), 14);
        },

        setMapEvent:function () {
            map.enableScrollWheelZoom();
            map.enableKeyboard();
            map.enableDragging();
            map.enableDoubleClickZoom();
        },

        addClickHandler:function (target, window) {
            target.addEventListener("click", function () {
                target.openInfoWindow(window);
            });
        },

        addMapOverlay:function () {
        },

        //向地图添加控件
        addMapControl:function () {
            var scaleControl = new BMap.ScaleControl({anchor: BMAP_ANCHOR_BOTTOM_LEFT});
            scaleControl.setUnit(BMAP_UNIT_IMPERIAL);
            map.addControl(scaleControl);
            var navControl = new BMap.NavigationControl({
                anchor: BMAP_ANCHOR_TOP_LEFT,
                type: BMAP_NAVIGATION_CONTROL_LARGE
            });
            map.addControl(navControl);
            var overviewControl = new BMap.OverviewMapControl({anchor: BMAP_ANCHOR_BOTTOM_RIGHT, isOpen: true});
            map.addControl(overviewControl);
        }
    };

    module.exports = fn;

    fn.initMap();
});