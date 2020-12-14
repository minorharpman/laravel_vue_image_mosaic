// ImageuploadComponent.vue
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Image Gallery</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3" v-if="image">
                                <img :src="image" class="img-responsive" height="70" width="90">
                           </div>
                                <div class="col-md-6">
                                    <input type="file" v-on:change="onImageChange" multiple class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-success btn-block" @click="uploadImage">Upload Image</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
export default {
    data() {
        return {
            image: ''
        }
    },
    methods: {
        onImageChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        uploadImage() {

            let formData = new FormData();
            

            formData.append('file', this.image);
           // formData.append('_method','PATCH');
            formData.append('_method','POST');


            /*axios.post('http://localhost/projects/laravel5/laravel_vue_image_upload/public/image/store',
            formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }*/
                    axios.post('http://localhost/projects/laravel5/laravel_vue_image_upload/public/image/store',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }

            ).then(response => {
                if (response.data.success) {
                    // alert(response.data.success);

                    this.$root.$emit('loadImages');
                }
            });
        }
    }
}

</script>
