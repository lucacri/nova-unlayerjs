<template>
    <default-field :field="field">
        <template slot="field">
            <div id="editor-container" style="height: 800px"></div>
            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }} </p>
        </template>
    </default-field>
</template>

<script>
	import {FormField, HandlesValidationErrors} from 'laravel-nova'

	export default {
		mixins: [FormField, HandlesValidationErrors],

		props: ['resourceName', 'resourceId', 'field'],
		mounted() {
			this.$loadScript("https://editor.unlayer.com/embed.js")
				.then(() => {
					window.unlayer.init({
						id: 'editor-container',
						displayMode: 'email',
						mergeTags: this.field.mergeTags
					});
					if (this.value.json !== undefined) {
						window.unlayer.loadDesign(this.value.json);
					}
					window.unlayer.addEventListener('design:updated', this.designUpdated);
					window.unlayer.registerCallback('image', this.uploadImage);
				})
				.catch(() => {
					// Failed to fetch script
				});
		},
		methods: {
			/*
             * Set the initial, internal value for the field.
             */
			setInitialValue() {
				this.value = JSON.parse(this.field.value) || {}
			},

			uploadImage(file, done) {
				let data = new FormData();
				data.append('photo', file.attachments[0]);
				let config = {
					onUploadProgress: (progressEvent) => {
						let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
						done({progress: percentCompleted});
					},
				};
				axios.post(this.field.uploadUrl, data, config)
					.then((response) => {
						done({progress: 100, url: response.data.url});
					})
					.catch((error) => {
						let err = new Error('Error while uploading the image');
						throw err;
					});
			},

			/**
			 * Fill the given FormData object with the field's internal value.
			 */
			fill(formData) {
				this.errors.clear();
				formData.append(this.field.attribute, JSON.stringify(this.value) || '');
			},

			designUpdated(data) {
				window.unlayer.exportHtml((data) => {

					this.value = {
						'html': data.html,
						'json': JSON.parse(JSON.stringify(data.design))
					};
				});
			},
		}
	}
</script>
