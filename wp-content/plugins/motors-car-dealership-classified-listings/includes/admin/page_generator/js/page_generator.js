(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);throw new Error("Cannot find module '"+o+"'")}var f=n[o]={exports:{}};t[o][0].call(f.exports,function(e){var n=t[o][1][e];return s(n?n:e)},f,f.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

Vue.component('mvl_page_generator', {
  props: ['field_data'],
  components: [],
  data: function data() {
    return {
      loading: false
    };
  },
  methods: {
    generatePages: function generatePages() {
      var vm = this;
      if (vm.loading) return false;
      vm.loading = true;
      this.$http.post(ajaxurl + '?action=wpcfto_generate_pages', JSON.stringify(vm.field_data)).then(function (data) {
        location.reload();
        vm.loading = false;
      });
    }
  }
});
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6WyJWdWUiLCJjb21wb25lbnQiLCJwcm9wcyIsImNvbXBvbmVudHMiLCJkYXRhIiwibG9hZGluZyIsIm1ldGhvZHMiLCJnZW5lcmF0ZVBhZ2VzIiwidm0iLCIkaHR0cCIsInBvc3QiLCJhamF4dXJsIiwiSlNPTiIsInN0cmluZ2lmeSIsImZpZWxkX2RhdGEiLCJ0aGVuIiwibG9jYXRpb24iLCJyZWxvYWQiXSwic291cmNlcyI6WyJmYWtlX2Y2OTY0NGRiLmpzIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xuXG5WdWUuY29tcG9uZW50KCdtdmxfcGFnZV9nZW5lcmF0b3InLCB7XG4gIHByb3BzOiBbJ2ZpZWxkX2RhdGEnXSxcbiAgY29tcG9uZW50czogW10sXG4gIGRhdGE6IGZ1bmN0aW9uIGRhdGEoKSB7XG4gICAgcmV0dXJuIHtcbiAgICAgIGxvYWRpbmc6IGZhbHNlXG4gICAgfTtcbiAgfSxcbiAgbWV0aG9kczoge1xuICAgIGdlbmVyYXRlUGFnZXM6IGZ1bmN0aW9uIGdlbmVyYXRlUGFnZXMoKSB7XG4gICAgICB2YXIgdm0gPSB0aGlzO1xuICAgICAgaWYgKHZtLmxvYWRpbmcpIHJldHVybiBmYWxzZTtcbiAgICAgIHZtLmxvYWRpbmcgPSB0cnVlO1xuICAgICAgdGhpcy4kaHR0cC5wb3N0KGFqYXh1cmwgKyAnP2FjdGlvbj13cGNmdG9fZ2VuZXJhdGVfcGFnZXMnLCBKU09OLnN0cmluZ2lmeSh2bS5maWVsZF9kYXRhKSkudGhlbihmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICBsb2NhdGlvbi5yZWxvYWQoKTtcbiAgICAgICAgdm0ubG9hZGluZyA9IGZhbHNlO1xuICAgICAgfSk7XG4gICAgfVxuICB9XG59KTsiXSwibWFwcGluZ3MiOiJBQUFBLFlBQVk7O0FBRVpBLEdBQUcsQ0FBQ0MsU0FBUyxDQUFDLG9CQUFvQixFQUFFO0VBQ2xDQyxLQUFLLEVBQUUsQ0FBQyxZQUFZLENBQUM7RUFDckJDLFVBQVUsRUFBRSxFQUFFO0VBQ2RDLElBQUksRUFBRSxTQUFTQSxJQUFJQSxDQUFBLEVBQUc7SUFDcEIsT0FBTztNQUNMQyxPQUFPLEVBQUU7SUFDWCxDQUFDO0VBQ0gsQ0FBQztFQUNEQyxPQUFPLEVBQUU7SUFDUEMsYUFBYSxFQUFFLFNBQVNBLGFBQWFBLENBQUEsRUFBRztNQUN0QyxJQUFJQyxFQUFFLEdBQUcsSUFBSTtNQUNiLElBQUlBLEVBQUUsQ0FBQ0gsT0FBTyxFQUFFLE9BQU8sS0FBSztNQUM1QkcsRUFBRSxDQUFDSCxPQUFPLEdBQUcsSUFBSTtNQUNqQixJQUFJLENBQUNJLEtBQUssQ0FBQ0MsSUFBSSxDQUFDQyxPQUFPLEdBQUcsK0JBQStCLEVBQUVDLElBQUksQ0FBQ0MsU0FBUyxDQUFDTCxFQUFFLENBQUNNLFVBQVUsQ0FBQyxDQUFDLENBQUNDLElBQUksQ0FBQyxVQUFVWCxJQUFJLEVBQUU7UUFDN0dZLFFBQVEsQ0FBQ0MsTUFBTSxDQUFDLENBQUM7UUFDakJULEVBQUUsQ0FBQ0gsT0FBTyxHQUFHLEtBQUs7TUFDcEIsQ0FBQyxDQUFDO0lBQ0o7RUFDRjtBQUNGLENBQUMsQ0FBQyIsImlnbm9yZUxpc3QiOltdfQ==
},{}]},{},[1])