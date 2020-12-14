<template>
    <div class="container-fluid">
     

             <div id="canvas_wrapper" class="row justify-content-center" style="max-width:100%; max-height: 500px;overflow: scroll; display:none;">
<div class="py-4 col-sm-12 text-center">
<button id="btn_generate_image" type="button" class="btn btn-primary" @click="downloadMosaic()"  >Generate Image</button>
<a id="btn_download_image" :href="mosaic_download_uri"  target="_blank"><button  type="button" class="btn btn-success"   >Download Image</button></a>
</div>
<div class="col-sm-12 text-center">
          <canvas id="canvas" ref="myCanvas"   :width="mosaic_data.canvas_width" :height="mosaic_data.canvas_height"></canvas>
          <br><br>
    
 </div> 
      </div> 



   <!-- <div   class="row " style="margin: 20px 0px;">

          <label class="col-sm-3 ">Users gallery:</label>
          <select class="form-control col-sm-6" @change="onChangeUser()" v-model="selected_user">
              <option  :value="{id:'', name:''}"  >All users</option>
              <option   v-for="user in users"  :value="{id:user.id, name:user.name}" >{{user.name}}</option>
          </select>

        
    </div>-->

    <div   class="row " style="margin: 20px 0px;">

    <div class="col-sm-12 card card-body bg-light">
            <form class="form-inline ">


            <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider" >
              <label >mosaic title:</label>
              <input v-model="mosaic_data.title" type="text" />
            </div>

            <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
              <label> cols:</label>
              <input v-model="mosaic_data.row" type="text" size="2" :maxlength="2"  >
            </div>
            <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
              <label> rows: </label>
              <input v-model="mosaic_data.col" type="text"  size="2" :maxlength="2">
            </div>
            <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
            <label> item width: </label>  
            <input v-model="mosaic_data.width" type="text" size="3" :maxlength="3" >
            </div>
            <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
            <label> item height: </label>  
            <input v-model="mosaic_data.height" type="text" size="3" :maxlength="3" >
            </div>
            <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
            <label> canvas width: </label>  
            <input v-model="mosaic_data.canvas_width" type="text" size="4" :maxlength="4" >
            </div>
            <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
            <label> canvas height: </label>  
            <input v-model="mosaic_data.canvas_height" type="text" size="4" :maxlength="4" >
            </div>

            <div class="form-group">&nbsp;<br>
            <button type="button" class="btn btn-primary" @click="createMosaic()">Make Mosaic</button>
            </div>
            </form>
    </div>
        
    </div>

<!--  <button type="button" class="btn btn-primary" @click="mixPicture()">Mix picture</button>-->

  <div   v-if="images" class="row">

    <gallery :images="images" :index="index" class="col-lg-3 col-sm-6 col-xs-12" @close="index = null"></gallery>
  
      <div
        class="image"
        v-for="(image, imageIndex) in images_mini"
        :key="imageIndex"
       
        :style="{color: 'white' }"
      >
      
         <a  @click="onoffpicture($event, image.id)" style=" cursor: pointer;color:black;background:white; opacity: 1 !important;">ON</a>  <a  @click="index = imageIndex" style=" cursor: pointer;color:black;background:#ccc; "> view </a><br>
          <img :src="uri+'/images/'+image.image_name"  :style="{width: '150px',height:'90px',opacity:image.opacity  }">
      </div>
   

    
  </div>

  <pagination :data="images_width_data" @pagination-change-page="loadImages"></pagination>
      
    </div>
</template>
<script>

  import VueGallery from 'vue-gallery';
  import _ from 'lodash';


export default {
  props: ['workuri'],
    data() {
        return {
            mosaic_data: {
              title:'Online mosaic',
                row: 10,
                col: 6,
                width: 150,
                height: 90,
                canvas_width: 1000,
                canvas_height: 600
            },
            images: [],
            images_mini: [],
            images_width_data: {},
            index: null,
            uri: this.workuri,
            users: [],
            selected_user: "",
            indexArray:[],
            mosaic_download_uri:""
            
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
               this.images_mini  = [];

                if(this.$cookie.get('pic_indexes')){
               this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'));
                  }


                for ( var i = 0; i < response.data.images.data.length; i++) { 
                 this.images.push(this.uri+'/images/'+ response.data.images.data[i].image_name);

                 if(this.indexArray.indexOf(this.images_width_data.data[i].id) ==-1){
                       this.images_mini.push({id:response.data.images.data[i].id, image_name:response.data.images.data[i].image_name, opacity:1});
                  }else{
                    this.images_mini.push({id:response.data.images.data[i].id, image_name:response.data.images.data[i].image_name, opacity:0.2});
                  }
                
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
               this.images_mini  = [];

               if(this.$cookie.get('pic_indexes')){
               this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'));
                  }


                for ( var i = 0; i < response.data.images.data.length; i++) { 
                 this.images.push(this.uri+'/images/'+ response.data.images.data[i].image_name);
                 

                if(this.indexArray.indexOf(this.images_width_data.data[i].id) ==-1){
                       this.images_mini.push({id:response.data.images.data[i].id, image_name:response.data.images.data[i].image_name, opacity:1});
                  }else{
                    this.images_mini.push({id:response.data.images.data[i].id, image_name:response.data.images.data[i].image_name, opacity:0.2});
                  }
               // console.log('image: '+ response.data.images.data[i].image_name);
                }

           
            });
        },

        mixPicture(){
        //console.log('click mix counts: '+  this.images_width_data.data.length);

        let foo   = this.shuffle(this.images_width_data.data );   
        //force update helyett Ă­gy frissĂźlt 
        //this.images_width_data.data =[];
        this.images_width_data.data  = foo;
         this.images  = [];

          for ( var i = 0; i < this.images_width_data.data.length; i++) { 
          this.images.push(this.uri+'/images/'+ this.images_width_data.data[i].image_name);
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

      //console.log('mosaic data: ' + this.mosaic_data.row + '  , ' + this.mosaic_data.col);

        $("#btn_generate_image").show();
        $("#btn_download_image").hide();

       var canvas_width = 1000;
       if(this.mosaic_data.canvas_width != "") {
       canvas_width  = this.mosaic_data.canvas_width;
       }
       if(this.mosaic_data.canvas_width > 2500) {
       this.mosaic_data.canvas_width = 2500;
       canvas_width  = 2500;
       }
       var canvas_height = 600;
       if(this.mosaic_data.canvas_height != "") {
        canvas_height = this.mosaic_data.canvas_height;
       }
       if(this.mosaic_data.canvas_height > 1500) {
       this.mosaic_data.canvas_height = 1500;
       canvas_height   = 1500;
       }

        this. mixPicture();
        $('#canvas_wrapper').show();
        var c  = this.$refs.myCanvas;
        var ctx = c.getContext("2d");
        ctx.clearRect(0,0,canvas_width,canvas_height);

        ctx.font = "30px Comic Sans MS";
        ctx.fillStyle = "black";
        ctx.textAlign = "center";
        var mosaic_title = "Online Mosaic";
        if(this.mosaic_data.title !=""){
          mosaic_title = this.mosaic_data.title;
        }
        ctx.fillText( mosaic_title , canvas_width/2, 30); 

        
  
       
       var workArr =[];
       if(this.$cookie.get('pic_indexes')){
        this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'));
      }
         for ( var m = 0; m < this.images_width_data.data.length; m++) {
          //console.log('on off: ' +this.indexArray.indexOf(this.images_width_data.data[m].id));
            if(this.indexArray.indexOf(this.images_width_data.data[m].id) ==-1){

               //console.log('image name: ' + this.images_width_data.data[m].image_name);

                 workArr.push(this.images_width_data.data[m].image_name);
            }
        }

       // console.log('workArr:'+ workArr);

      var mosaic_row = 10;
       if(this.mosaic_data.row != "") {
        mosaic_row = this.mosaic_data.row;
       }
       var mosaic_col = 9;
       if(this.mosaic_data.col != "") {
        mosaic_col = this.mosaic_data.col;
       }
       var mosaic_width = 150;
       if(this.mosaic_data.width != "") {
       var mosaic_width = this.mosaic_data.width;
       }
       var mosaic_height = 90;
       if(this.mosaic_data.height != "") {
        var mosaic_height = this.mosaic_data.height;
       }

  
     
     var k = 0;
         for ( var i = 0; i < mosaic_row ; i++) { 
             for ( var j = 0; j < mosaic_col; j++) { 

                    var   base_image = new Image();
                   // console.log ('id:' + this.images_width_data.data[k].id+ ' on/off: '+this.indexArray.indexOf(this.images_width_data.data[k].id));
                  
                   //console.log('url:'+ this.uri+'/images/'+ this.images_width_data.data[i].image_name);
                   //  console.log('id:'+ this.images_width_data.data[k].id);
                    base_image.src =  this.uri+'/images/'+ workArr[k];
                    ctx.drawImage(base_image, i*mosaic_width +0, j*mosaic_height+50, mosaic_width, mosaic_height);
                  
                    k++;
                    }
            }

       

     },
    downloadMosaic() {
       var c  = this.$refs.myCanvas;
      var image = c.toDataURL("image/png").replace("image/png", "image/octet-stream");
      // console.log('image: '+ image);

                  let formData = new FormData();
                    formData.append('file', image);

                                    axios.post(this.uri+'/image/storecanvas',
                                 formData ,
                                    {
                                        headers: {
                                            'Content-Type': 'multipart/form-data'
                                        }
                                    }
                                ).then((response) => {
                                  console.log('url:'+this.uri+'/'+ response.data.path);
                                  this.mosaic_download_uri = this.uri+'/'+ response.data.path;
                                 $("#btn_generate_image").hide();
                                 $("#btn_download_image").show();

                                });
      //download.setAttribute("href", image);

     },

     onoffpicture(event, imageIndex){
              if(event.target.innerText ="ON")
              {
                event.target.innerText ="OFF" 
              }else{
                event.target.innerText ="ON"; 
              }
              
          //console.log("imageIndex:"+imageIndex+ ',cookie '+this.$cookie.get('pic_indexes'));
            for (var i = 0; i < this.images_mini.length; i++) {
        
            if(this.images_mini[i].id == imageIndex ){
                  if(this.images_mini[i].opacity == 1){
                    this.images_mini[i].opacity =0.2;
                   }else{
                     this.images_mini[i].opacity =1; 
                  }
         
               } 
            }

      if(this.$cookie.get('pic_indexes')){
         this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'));
      }
     
      console.log('this.indexArray: '+this.indexArray);
     // this.indexArray.indexOf(imageIndex) === -1 ? this.indexArray.push(imageIndex) : console.log("This item already exists");
      if( this.indexArray.indexOf(imageIndex) === -1){
       this.indexArray.push(imageIndex);
      }else{
        delete this.indexArray[imageIndex];
      }

      this.$cookie.set('pic_indexes',  JSON.stringify(this.indexArray) , 1000);
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
        this.$root.$on('loadImages', this.loadImages );

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

canvas {
 /* background: green;*/
  box-shadow: 0px 2px 3px rgba(0, 0, 0, 0.2);
}

.vertical-divider{
  border-right: 1px  solid #ccc;
  padding-right:10px;
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
