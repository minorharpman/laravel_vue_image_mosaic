<template>
    <div class = "container-fluid" >

    <div id = "canvas_wrapper"
style = "max-width:100%; max-height: 500px;overflow: scroll; display:none;" >
    <canvas id = "canvas"
ref = "myCanvas"
width = "1000px"
height = "600px" > </canvas> <br > <br >
    <a id = "download"
download = "mymosaic.jpg"
href = ""
@click = "downloadMosaic()" > Download the Mosaic </a></div> 



<div class = "row "
style = "margin: 20px 0px;" >

    <label class = "col-sm-3 " > Users gallery: </label> <select class = "form-control col-sm-6"
@change = "onChangeUser()"
v - model = "selected_user" >
    <option: value = "{id:'', name:''}" > All users </option> <option v -
    for = "user in users": value = "{id:user.id, name:user.name}" > {
        {
            user.name
        }
    } </option> </select>


</div>

<div class = "row "
style = "margin: 20px 0px;" >

    <button type = "button"
class = "btn btn-primary"
@click = "createMosaic()" > make mosaic </button>

</div>

<!--  <button type="button" class="btn btn-primary" @click="mixPicture()">Mix picture</button>-->

<div v -
    if = "images"
class = "row" >
    <gallery: images = "images": index = "index"
@close = "index = null" > </gallery>

<div
class = "image"
v -
    for = "(image, imageIndex) in images_mini": key = "imageIndex"

: style = "{color: 'white' }" >

    <a @click = "onoffpicture(image.id)"
style = " cursor: pointer;color:black;background:white; opacity: 1 !important;" > OFF / ON </a>  <a  @click="index = imageIndex" style=" cursor: pointer;color:black;background:#ccc; ">GALLERY</a > <br >
    <img: src = "uri+'/images/'+image.image_name": style = "{width: '150px',height:'90px',opacity:image.opacity  }" >
    </div>



</div>

<pagination: data = "images_width_data"
@pagination - change - page = "loadImages" > </pagination>

</div> 
</template> 
<script>

import VueGallery from 'vue-gallery';

export default {
    props: ['workuri'],
    data() {
        return {
            images: [],
            images_mini: [],
            images_width_data: {},
            index: null,
            uri: this.workuri,
            users: [],
            selected_user: "",
            indexArray: []

        }
    },

    methods: {
        loadImages(page) {

            if (typeof page === 'undefined') {
                page = 1;
            }

            let user_id = 0;
            if (this.$cookie.get('user_id')) {
                user_id = this.$cookie.get('user_id');
            } else {
                user_id = 0;
            }



            axios.get(this.uri + '/image/index/' + user_id + '?page=' + page).then((response) => {
                this.images_width_data = response.data.images;

                this.images = [];
                this.images_mini = [];

                if (this.$cookie.get('pic_indexes')) {
                    this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'));
                }


                for (var i = 0; i < response.data.images.data.length; i++) {
                    this.images.push(this.uri + '/images/' + response.data.images.data[i].image_name);

                    if (this.indexArray.indexOf(this.images_width_data.data[i].id) == -1) {
                        this.images_mini.push({
                            id: response.data.images.data[i].id,
                            image_name: response.data.images.data[i].image_name,
                            opacity: 1
                        });
                    } else {
                        this.images_mini.push({
                            id: response.data.images.data[i].id,
                            image_name: response.data.images.data[i].image_name,
                            opacity: 0.2
                        });
                    }

                    // console.log('image: '+ response.data.images.data[i].image_name);
                }
                this.$root.$emit('userStatusChange', response.data.user_status);

                //console.log(this.images);


            });

        },
        loadUsers() {
            axios.get(this.uri + '/users').then((response) => {
                this.users = response.data.users;

            });

        },

        onChangeUser() {
            //  console.log('selected user:'+this.selected_user.id +", "+this.selected_user.name);

            //expires 1 day
            this.$cookie.set('user_id', this.selected_user.id, 1);

            axios.get(this.uri + '/image/index/' + this.selected_user.id).then((response) => {
                this.images_width_data = response.data.images;

                this.images = [];
                this.images_mini = [];

                if (this.$cookie.get('pic_indexes')) {
                    this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'));
                }


                for (var i = 0; i < response.data.images.data.length; i++) {
                    this.images.push(this.uri + '/images/' + response.data.images.data[i].image_name);


                    if (this.indexArray.indexOf(this.images_width_data.data[i].id) == -1) {
                        this.images_mini.push({
                            id: response.data.images.data[i].id,
                            image_name: response.data.images.data[i].image_name,
                            opacity: 1
                        });
                    } else {
                        this.images_mini.push({
                            id: response.data.images.data[i].id,
                            image_name: response.data.images.data[i].image_name,
                            opacity: 0.2
                        });
                    }
                    // console.log('image: '+ response.data.images.data[i].image_name);
                }


            });
        },

        mixPicture() {
            //console.log('click mix counts: '+  this.images_width_data.data.length);

            let foo = this.shuffle(this.images_width_data.data);
            //force update helyett így frissült 
            //this.images_width_data.data =[];
            this.images_width_data.data = foo;
            this.images = [];

            for (var i = 0; i < this.images_width_data.data.length; i++) {
                this.images.push(this.uri + '/images/' + this.images_width_data.data[i].image_name);
                // console.log('image: '+ response.data.images.data[i].image_name);
            }


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
        },


        createMosaic() {
            this.mixPicture();
            $('#canvas_wrapper').show();
            var c = this.$refs.myCanvas;
            var ctx = c.getContext("2d");
            ctx.clearRect(0, 0, 1000, 600);

            ctx.font = "30px Comic Sans MS";
            ctx.fillStyle = "red";
            ctx.textAlign = "center";
            ctx.fillText("Online Mosaic", 500, 50);




            var workArr = [];
            if (this.$cookie.get('pic_indexes')) {
                this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'));
            }
            for (var m = 0; m < this.images_width_data.data.length; m++) {
                //console.log('on off: ' +this.indexArray.indexOf(this.images_width_data.data[m].id));
                if (this.indexArray.indexOf(this.images_width_data.data[m].id) == -1) {

                    //console.log('image name: ' + this.images_width_data.data[m].image_name);

                    workArr.push(this.images_width_data.data[m].image_name);
                }
            }

            // console.log('workArr:'+ workArr);

            var k = 0;
            for (var i = 0; i < 10; i++) {
                for (var j = 1; j < 6; j++) {

                    var base_image = new Image();
                    // console.log ('id:' + this.images_width_data.data[k].id+ ' on/off: '+this.indexArray.indexOf(this.images_width_data.data[k].id));

                    //console.log('url:'+ this.uri+'/images/'+ this.images_width_data.data[i].image_name);
                    //  console.log('id:'+ this.images_width_data.data[k].id);
                    base_image.src = this.uri + '/images/' + workArr[k];
                    ctx.drawImage(base_image, i * 100, j * 100, 100, 100);

                    k++;
                }
            }



        },
        downloadMosaic() {
            var c = this.$refs.myCanvas;
            var image = c.toDataURL("image/png").replace("image/png", "image/octet-stream");
            // console.log('image: '+ image);
            download.setAttribute("href", image);
        },

        onoffpicture(imageIndex) {
            console.log("imageIndex:" + imageIndex + ',cookie ' + this.$cookie.get('pic_indexes'));
            //////////////
            /*for (var i = 0; i < this.images_mini.length; i++) {
            
            }*/
            //////////////
            if (this.$cookie.get('pic_indexes')) {
                this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'));
            }

            console.log('this.indexArray: ' + this.indexArray);
            // this.indexArray.indexOf(imageIndex) === -1 ? this.indexArray.push(imageIndex) : console.log("This item already exists");
            if (this.indexArray.indexOf(imageIndex) === -1) {
                this.indexArray.push(imageIndex);
            } else {
                delete this.indexArray[imageIndex];
            }

            this.$cookie.set('pic_indexes', JSON.stringify(this.indexArray), 1000);
        },

        /*
            isEmpty(obj) {
            for(var key in obj) {
                if(obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        }
        */




    },

    mounted() {
        this.loadImages(1);
        this.$root.$on('loadImages', this.loadImages);

        this.loadUsers();


    },

    updated() {
        // Fired every second, should always be true
    },

    components: {
        'gallery': VueGallery
    },
}

</script>

<style >
    .blueimp - gallery - controls > .close, .blueimp - gallery > .close {
        color: white!important;
        opacity: 1!important;
        font - size: 40 px!important;
        font - weight: bold!important;

    }

.blueimp - gallery > .slides > .slide - loading {
        background: url(https: //blogbook.hu/img/blueimp-gallery/loading.gif) !important;

        }

            canvas {
                /* background: green;*/
                box - shadow: 0 px 2 px 3 px rgba(0, 0, 0, 0.2);
            } 
</style>

<style scoped >
            .image {
                float: left;
                background - size: cover;
                background - repeat: no - repeat;
                background - position: center center;
                border: 1 px solid # ebebeb;
                margin: 0 px;
            }

</style>