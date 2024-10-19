Vue.component('mvl_page_generator', {
	props: ['field_data'],
	components: [],
	data() {
		return {
			loading : false
		};
	},
	methods: {
		generatePages() {
			let vm = this;
			if(vm.loading) return false;
			vm.loading = true;
			this.$http.post(ajaxurl + '?action=wpcfto_generate_pages', JSON.stringify(vm.field_data)).then(function (data) {
				location.reload();
				vm.loading = false;
			});
		}
	},
});