Vue.component('wpcfto_mew_repeater_radio', {
    props: ['fields', 'field_label', 'field_name', 'field_id', 'field_value', 'field_data'],
    data: function () {
        return {
            repeater: [],
            selected: '',
            loading: false
        }
    },
    template: `
    <div class="wpcfto_generic_field wpcfto_generic_field_mew_repeater_radio wpcfto-repeater unflex_fields">

        <wpcfto_fields_aside_before :fields="fields" :field_label="field_label"></wpcfto_fields_aside_before>
        
        <div class="wpcfto-field-content">

            <div v-for="(field, area_key) in repeater" class="wpcfto-repeater-radio-single" :class="'wpcfto-repeater_' + field_name + '_' + area_key ">
    
                <div class="wpcfto-info-wrap">
                    <label>
                        <input type="radio" name="selected_listing_template" v-model="selected" :value="field.post_id" @click="setSelected(field.post_id)" :checked="field.post_id == selected" />
                       <div class="wpcfto_group_title" :class="{'active': field.post_id == selected}" v-html="field.title"></div>
                   </label>
                   
                   <div class="wpcfto-repeater-radio-actions">
                        <span class="wpcfto-repeater-single-edit">
                            <i class="fa fa-edit"></i>
                            <a :href="field.edit_link" target="_blank">Edit</a>
                        </span>
            
                        <span class="wpcfto-repeater-single-view">
                            <i class="fa fa-eye"></i>
                            <a :href="field.view_link" target="_blank">View</a>
                        </span>
            
                        <span class="wpcfto-repeater-single-delete" @click="removeArea(area_key)">
                            <i class="fa fa-trash-alt"></i>Delete
                        </span>
                    </div>
                </div>
            </div>
  
            <div class="addListingTemplate" :class="{'loading': loading}" @click="addListingTemplate">
                <i class="fa fa-plus-circle"></i>
                <span>Listing Template</span>
            </div>
        
        </div>
        
        <wpcfto_fields_aside_after :fields="fields"></wpcfto_fields_aside_after>

    </div>
    `,
    mounted: function () {

        var _this = this;

        _this.repeater = _this.fields.fields;
        _this.selected = _this.field_value;
    },
    methods: {
        addListingTemplate: function () {
            let vm = this;
            if(vm.loading) return;
            vm.loading = true;

            this.$http
                .post(mew_nonces.ajaxurl + '?action=motors_wpcfto_create_template&security=' + mew_nonces.tm_nonce )
                .then(function (response) {

                    let dataResponse = response.body;
                    vm.loading = false;
                    vm.repeater.push(dataResponse.msg);
                });

        },
        removeArea: function (areaIndex) {

            let _this = this;
            let removeTemplate = this.repeater[areaIndex];

            if(confirm('Do your really want to delete this field?')) {
                this.$http
                    .post(mew_nonces.ajaxurl + '?action=motors_wpcfto_delete_template&post_id=' + removeTemplate.post_id + '&security=' + mew_nonces.tm_delete_nonce )
                    .then(function (response) {
                        let dataResponse = response.body;
                        if(dataResponse.hasOwnProperty('status') && dataResponse.status == 200) {
                            _this.repeater.splice(areaIndex, 1);
                        }
                    });
            }
        },
        setSelected(selected_value) {
            this.selected = selected_value;
        },
    },
    watch: {
        selected: {
            deep: true,
            handler: function (value) {
                this.$emit('wpcfto-get-value', value);
            }
        },
    }
});
