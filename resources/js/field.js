import LoadScript from 'vue-plugin-load-script';



Nova.booting((Vue, router) => {
	Vue.use(LoadScript);
    Vue.component('index-unlayerjs', require('./components/IndexField'));
    Vue.component('detail-unlayerjs', require('./components/DetailField'));
    Vue.component('form-unlayerjs', require('./components/FormField'));
});
