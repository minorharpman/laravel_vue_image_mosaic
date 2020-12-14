<template>
    <div class="container-fluid">

    <div   class="row " style="margin: 20px 0px;">

          <label class="col-sm-3 ">Users gallery:</label>
          <select class="form-control col-sm-6" @change="onChangeUser()" v-model="selected_user">
              <option   v-for="user in users"  :value="{id:user.id, name:user.name}" >{{user.name}}</option>
          </select>
        
    </div>

       <button type="button" class="btn btn-primary" @click="mixPicture()">Mix picture</button>

  <div   v-if="images" class="row">
    <gallery :images="images" :index="index" @close="index = null"></gallery>
    <div
      class="image"
      v-for="(image, imageIndex) in images_width_data.data"
      :key="imageIndex"
      @click="index = imageIndex"
      :style="{ backgroundImage: ' url('+uri+'/images/'+ image.image_name + ')', width: '150px', height: '90px', color: 'white' }"
    ></div>

    
  </div>

  <pagination :data="images_width_data" @pagination-change-page="loadImages"></pagination>
      
    </div>
</template>
<script>

  import VueGallery from 'vue-gallery';


export default {
  props: ['workuri'],
    data() {
        return {
            images: [],
            images_width_data: {},
            index: null,
            uri: this.workuri,
            users: [],
            selected_user: ""
            
        }
    },

    methods: {
        loadImages(page) {

            if (typeof page === 'undefined') {
                page = 1;
            }
   
          let user_id =0;
           if(this.$cookie.get('user_id')){
            user_id = this.$cookie.get('user_id');
          }else{
            user_id =0;
          }
           


           axios.get(this.uri+'/image/index/'+user_id+ '?page=' + page).then((response) => {
              this.images_width_data  = response.data.images;

               this.images  = [];

                for ( var i = 0; i < response.data.images.data.length; i++) { 
                 this.images.push(this.uri+'/images/'+ response.data.images.data[i].image_name);
               // console.log('image: '+ response.data.images.data[i].image_name);
                }
                this.$root.$emit('userStatusChange', response.data.user_status);

                //console.log(this.images);
           
            });

        },
        loadUsers() {
           axios.get(this.uri+'/users').then((response) => {
              this.users  = response.data.users;
           
            });

        },

        onChangeUser() {
           //  console.log('selected user:'+this.selected_user.id +", "+this.selected_user.name);

               //expires 1 day
             this.$cookie.set('user_id', this.selected_user.id, 1);

        axios.get(this.uri+'/image/index/'+this.selected_user.id ).then((response) => {
              this.images_width_data  = response.data.images;

               this.images  = [];

                for ( var i = 0; i < response.data.images.data.length; i++) { 
                 this.images.push(this.uri+'/images/'+ response.data.images.data[i].image_name);
               // console.log('image: '+ response.data.images.data[i].image_name);
                }
           
            });
        },

        mixPicture(){
        console.log('click mix'+  this.images_width_data.data.length);

        let foo   = this.shuffle(this.images_width_data.data );   
        //force update helyett így frissült 
        this.images_width_data.data =[];
        this.images_width_data.data  = foo;
         this.images  = [];

          for ( var i = 0; i < this.images_width_data.data.length; i++) { 
          this.images.push(this.uri+'/images/'+ this.images_width_data.data[i].image_name);
          // console.log('image: '+ response.data.images.data[i].image_name);
          }
        /* for (let i = this.images_width_data.data.length - 1; i > 0; i--) {
                console.log(this.images_width_data.data[i].id);
        }*/
        //this.$forceUpdate();
       
        },

        shuffle(a) {
        var j, x, i;
        for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
        }
        return a;
        }




    },

    mounted() {
        this.loadImages(1);
        this.$root.$on('loadImages', this.loadImages );

        this.loadUsers();

    },

     components: {
      'gallery': VueGallery
    },
}

</script>

<style>
.blueimp-gallery-controls>.close, .blueimp-gallery>.close{
 color: white !important;
 opacity: 1 !important;
 font-size: 40px !important;
 font-weight: bold !important;

  }

 .blueimp-gallery > .slides > .slide-loading {
  background: url(https://blogbook.hu/img/blueimp-gallery/loading.gif) !important;

}
</style>

<style scoped>
  .image {
    float: left;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    border: 1px solid #ebebeb;
    margin: 0px;
  }


</style>