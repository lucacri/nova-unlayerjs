<template>
    <div>
        <div id="editor-container" style="height: 800px"></div>
        <p>NOTE: changes done here are not saved.</p>
    </div>
</template>

<script>
	export default {
		props: ['resource', 'resourceName', 'resourceId', 'field'],
		mounted() {
			console.log(this.field);
			this.$loadScript("https://editor.unlayer.com/embed.js")
				.then(() => {
					window.unlayer.init({
						id: 'editor-container',
						displayMode: 'email',
						mergeTags: this.field.mergeTags
					});
					var obj = JSON.parse(this.field.value);

					if (obj.json !== undefined) {
						window.unlayer.loadDesign(obj.json);
					}
				})
				.catch(() => {
					// Failed to fetch script
				});
		}
	}
</script>
