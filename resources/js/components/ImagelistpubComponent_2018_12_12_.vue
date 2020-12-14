<template>
    <div>


     <div>
    <gallery :images="images" :index="index" @close="index = null"></gallery>
    <div
      class="image"
      v-for="(image, imageIndex) in images"
      :key="imageIndex"
      @click="index = imageIndex"
      :style="{ backgroundImage: uri+'/images/'+ image.image_name , width: '300px', height: '200px' }"
    ></div>
  </div>

                        <table  class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Image</th>
                                     <th>User</th>
                                    <th>Date</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(image, index) in images ">
                                    <td>{{ index+1 }}</td>
                                    <td> <img :src="uri+'/images/'+image.image_name"  style="width: 100px;">  </td>
                                    <td> {{ image.imageowner.name }} </td>
                                     <td> {{ image.updated_at }} </td>

                                </tr>
                            </tbody>
                        </table>



              
    </div>
</template>
<script>

  import VueGallery from 'vue-gallery';


export default {
  props: ['workuri'],
    data() {
        return {
            images: [],
            uri: this.workuri,
            delete_image_index:'',
            
        }
    },

    methods: {
        loadImages() {

            axios.get(this.uri+'/image/index').then((response) => {
                this.images = response.data.images;
               // this.$store.state.user_status = response.data.user_status;
                this.$root.$emit('userStatusChange', response.data.user_status);

                //console.log(this.images);
           
            });

        },




    },

    mounted() {
        this.loadImages();
        this.$root.$on('loadImages', this.loadImages );

    },

     components: {
      'gallery': VueGallery
    },
}

</script>


<style scoped>
  .image {
    float: left;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    border: 1px solid #ebebeb;
    margin: 5px;
  }
</style>