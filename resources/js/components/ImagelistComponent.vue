<template>
    <div class="container">


 <div  v-if="this.user_id == 1"   class="col-sm-12" >Selected Gallery:  {{selected_gallery_id }} </div>
         <div class="col-sm-12" >Number of the images: {{images_count }} </div>

  <!--  <div>
        Private gallery
        <label class="switch">
            <input type="checkbox" @click="publicMod()" v-model="public_status" >
            <span class="slider"></span>
        </label>
        Public gallery
    </div>-->
                <div class="row mb-5">
                     <div class="col mt-4">
                            <button @click="deleteImageAllModal()" class="btn btn-danger ">Delete All Pictures</button>
                     </div>
                </div>
                        <table  class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Image</th>
                                    <th>Date</th>
                                    <th>Delete</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(image, index) in images.data ">
                                    <td>{{ index+1 }}</td>
                                    <td> <img :src="uri+'/images/'+image.image_name"  style="width: 150px;">  </td>
                                    <td>{{ image.updated_at}}</td>
                                    <td> <button @click="deleteImageModal(index)" class="btn btn-danger ">Delete</button> </td>
                                </tr>
                            </tbody>
                        </table>


                <!-- Delete Modal-->
                <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Do you really want to delete this?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="deleteImage()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Delete All Modal-->
                <div class="modal fade" id="delete-all-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Delete All Pictures</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Do you really want to delete all pictures?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" @click="deleteImageAll()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>


                <pagination :data="images" @pagination-change-page="loadImages"></pagination>
              
    </div>
</template>
<script>
export default {
  props: ['workuri', 'setuserid'],
    data() {
        return {
            images: {},
            images_count: 0,
            uri: this.workuri,
            delete_image_index:'',
            user_status: '',
            user_id: 0,
            public_status: false,
            changeuserid: 0,

        }
    },

    methods: {
        publicMod(){
       //  console.log('public_status:'+ this.public_status);
        },
        loadImages(page) {
                this.changeuserid=  this.setuserid;

           // console.log('x setuserid:'+ this.changeuserid);

           if (typeof page === 'undefined') {
                page = 1;
            }

        


   
        // console.log("selected_gallery_id:"+this.selected_gallery_id);

            axios.post(this.uri+'/image/registeredindex'+ '?page=' + page, { gallery_id: this.selected_gallery_id, changeuserid: this.changeuserid }).then((response) => {
           
                this.images = response.data.images;
                this.images_count = response.data.images_count;
               // this.user_status = response.data.user_status;

                //console.log('image count: '+this.images.data.length);

                var upload_status = "on";

                if(this.images.data.length > 30){
                        upload_status = "off";
                }

                this.$root.$emit('uploadOff', upload_status);
           
            });

        },
        deleteImageModal(index) {

             //  console.log("index: " +index);

          //let confirmBox = confirm("Do you really want to delete this?");
           this.delete_image_index = index;


           $("#delete-modal").modal("show");
        },

        deleteImageAllModal() {

           $("#delete-all-modal").modal("show");
        },

        deleteImage() {

  // console.log("image id: " +this.images.data[this.delete_image_index].id);


            axios.post(this.uri + "/image/delete",
            { id: this.images.data[this.delete_image_index].id} )
                .then(response => {

                    if (response.data.status == "ok") {
                        this.$delete(this.images, this.delete_image_index);
                        //refresh public list
                        this.$root.$emit('loadImages');
                    }

                  //  toastr.success(response.data.message);
                    $("#delete-modal").modal("hide");

                }).catch(error => {
                   // console.log("Could not delete for some reason ");
                });



        },

        deleteImageAll() {

          //console.log("delete image all");

            axios.post(this.uri + "/image/deleteall", { gallery_id: this.selected_gallery_id })
                .then(response => {

                    if (response.data.status == "ok") {
                           this.images ={}
                          // console.log("delete image all");
                        //refresh public list
                        this.$root.$emit('loadImages');
                    }

                  //  toastr.success(response.data.message);
                    $("#delete-all-modal").modal("hide");

                }).catch(error => {
                   // console.log("Could not delete for some reason ");
                });

            var user_id = this.$store.getters.user_id;


           this.$cookie.set('pic_indexes'+user_id, JSON.stringify([]) , 1000);

        },

        getUserID(){
        //user_id kieg nélkül
        var pieces =this.$store.getters.user_id.split("_");
         this.user_id = pieces[pieces.length-1];
        }


    },

 computed : {
         selected_gallery_id:{

          get: function () {
            return this.$store.getters.selected_gallery_id;
        },
    }

  },

    mounted() {

        this.getUserID();
        this.loadImages();
        this.$root.$on('loadImages', this.loadImages );
        this.user_status = this.$store.state.user_status;
    }
}

</script>




