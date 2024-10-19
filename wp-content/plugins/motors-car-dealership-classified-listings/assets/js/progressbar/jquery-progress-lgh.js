/*!
 * jquery-progress-lgh v1.0 (https://github.com/honguangli/jquery-progress-lgh)
 * Copyright honguangli
 * Licensed under the MIT license
 */
;
var Progress;
(function($) {
    "use strict";
    Progress = function(option) {
        const self = this;
        // 默认配置
        const defaults = {
            percentage: 0,         // 实时进度
            debounce: true,  // 防抖
            debouncePercentage: 0, // 防抖进度
            url: '',         // 进度轮询接口地址
            data: {},        // 进度轮询接口参数
            get: null,       // 进度轮询回调（配置此项后会忽略url和data参数）
            set: null,       // 进度更新回调
            pf0: null,       // 实时进度定时器
            pf1: null,       // 进度防抖定时器
            pf0Delay: 400,  // 实时进度定时器延迟
            pf1Delay: 50,    // 进度防抖定时器延迟
        };
        self.options = $.extend(true, defaults, option)
        self.options.percentage = 0;
        self.options.debouncePercentage = 0;
    };
    Progress.prototype.start = function() {
        const self = this;
        // 若配置了进度轮询回调则采用该回调查询最新进度，否则采用配置的url接口查询
        if ($.isFunction(self.options.get)) {
            self.options.pf0 = setInterval(self.options.get, self.options.pf0Delay);
        } else {
            self.options.pf0 = setInterval(getRate, self.options.pf0Delay);
        }
        self.options.pf1 = setInterval(debounce, self.options.pf1Delay);

        // 实时进度查询接口
        function getRate() {
            $.getJSON(self.options.url, self.options.data, function(res) {
                let v = Number(res.percentage);
                if (v <= 0) {
                    self.options.percentage = 0;
                } else if (v >= 100) {
                    self.options.percentage = 100;
                    clearInterval(self.options.pf0);
                } else {
                    self.options.percentage = v;
                }
            });
        }

        // 进度防抖更新
        function debounce() {
            self.refresh();
        }
    };
    // 设置实时进度
    Progress.prototype.update = function(percentage, jump) {
        const self = this;
        if (percentage <= 0) {
            self.options.percentage = 0;
        } else if (percentage >= 100) {
            self.options.percentage = 100;
            clearInterval(self.options.pf0);
        } else {
            self.options.percentage = percentage;
        }
        if (jump) {
            self.refresh(true);
        }
    };
    // 强制完成
    Progress.prototype.finish = function() {
        const self = this;
        self.stop();
        if ($.isFunction(self.options.set)) {
            self.options.set(100);
        }
    };
    // 强制停止
    Progress.prototype.stop = function() {
        const self = this;
        clearInterval(self.options.pf0);
        clearInterval(self.options.pf1);
    };
    // 强制重置
    Progress.prototype.reset = function() {
        const self = this;
        self.stop();
        if ($.isFunction(self.options.set)) {
            self.options.set(0);
        }
    };
    // 刷新进度、防抖
    Progress.prototype.refresh = function(jump) {
        const self = this;
        if (self.options.debouncePercentage >= 100) {
            self.finish();
        } else if (self.options.debouncePercentage < self.options.percentage) {
            if (jump) {
                self.options.debouncePercentage = self.options.percentage;
            } else if (!self.options.debounce) {
                self.options.debouncePercentage = self.options.percentage;
            } else {
                self.options.debouncePercentage++;
            }
            if ($.isFunction(self.options.set)) {
                self.options.set(self.options.debouncePercentage);
            }
        }
    }
})(jQuery);
