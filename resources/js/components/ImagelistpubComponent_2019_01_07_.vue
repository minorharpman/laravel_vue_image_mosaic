<template>
    <div class="container-fluid">
     

             <div id="canvas_wrapper" class="row justify-content-center" style="max-width:100%; max-height: 500px;overflow: scroll; display:none;">
<div class="py-4 col-sm-12 text-center">
<button id="btn_generate_image" type="button" class="btn btn-primary" @click="downloadMosaic()"  >Generate Image</button>
<div v-if="generating_image_status === 'on'"  style="color:red;"> Generating image... </div>
<a id="btn_download_image" :href="mosaic_download_uri"  target="_blank"><button  type="button" class="btn btn-success"   >Download Image</button></a>
</div>
<div class="col-sm-12 text-center">
          <canvas id="canvas" ref="myCanvas"   :width="mosaic_data.canvas_width" :height="mosaic_data.canvas_height"></canvas>
          <br><br>
    
 </div> 
      </div> 




    <div   class="row " style="margin: 20px 0px;">

    <div class="col-sm-12 card card-body bg-light">
            <form class="form-inline ">


            <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider" >
              <label >mosaic title:</label>
              <input v-model="mosaic_data.title" type="text" />
            </div>

           <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
              <div class="form-inline ">
              <input type="radio" class="mr-2" value="automata" v-model="generator_mode" >
               <label for="one"> Automatic</label>
              </div>
              <div class="form-inline ">
              <input type="radio" class="mr-2" value="mysetting" v-model="generator_mode">
               <label for="two" > My setting</label>
              </div>
            </div>

            <div  v-if="generator_mode === 'mysetting'"  class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
              <label> cols:</label>
              <input v-model="mosaic_data.row" type="text" size="2" :maxlength="2"  >
            </div>
            <div    v-if="generator_mode === 'mysetting'"  class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
              <label> rows: </label>
              <input v-model="mosaic_data.col" type="text"  size="2" :maxlength="2">
            </div>
            <div  v-if="generator_mode === 'mysetting'"  class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
            <label> item width: </label>  
            <input v-model="mosaic_data.width" type="text" size="3" :maxlength="3" >
            </div>
            <div  v-if="generator_mode === 'mysetting'"  class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
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
            <button type="button" class="btn btn-primary btn-lg" @click="createMosaic()">Make Mosaic</button>
            </div>
            </form>

    <div>
    <b-form-slider :value="mosaic_data.canvas_width" @slide-start="slideStart" @slide-stop="slideStop"></b-form-slider>
    <p>canvas width {{ mosaic_data.canvas_width }}</p>
  </div>
    </div>
        
    </div>

<!--  <button type="button" class="btn btn-primary" @click="mixPicture()">Mix picture</button>-->

  <div   v-if="images" class="row">

    <gallery :images="images" :index="index" class="col-lg-3 col-sm-6 col-xs-12" @close="index = null"></gallery>
  
      <div class="col-sm-12" v-if="images_mini.length" >Number of the images: {{images_mini.length-indexArray.length}}/{{images_mini.length}} </div>
      <div
        class="image"
        v-for="(image, imageIndex) in images_mini"
        :key="imageIndex"
       
        :style="{color: 'white' }"
      >
      
         <a  @click="onoffpicture($event, image.id)" style=" cursor: pointer;color:black;background:white; opacity: 1 !important;">ON</a>  
       <!--  <a  @click="index = imageIndex" style=" cursor: pointer;color:black;background:#ccc; "> view </a> -->
         <br>
          <img :src="uri+'/images/'+image.image_name"  :style="{width: '150px',height:'90px',opacity:image.opacity  }">
      </div>
   

    
  </div>

  <pagination :data="images_width_data" @pagination-change-page="loadImages"></pagination>
      
    </div>
</template>
<script>

  import VueGallery from 'vue-gallery';
  import _ from 'lodash';

//https://www.npmjs.com/package/vue-bootstrap-slider
  import bFormSlider from 'vue-bootstrap-slider';
   Vue.use(bFormSlider);
  import 'bootstrap-slider/dist/css/bootstrap-slider.css';


export default {
  props: ['workuri'],
    data() {
        return {
            mosaic_data: {
              title:'Mosaic Postcard',
                row: 10,
                col: 6,
                width: 150,
                height: 90,
                canvas_width: 1000,
                canvas_height: 800
            },
            generator_mode: 'automata',
            generating_image_status: 'off',
            images: [],
            images_mini: [],
            images_width_data: {},
            index: null,
            uri: this.workuri,
            users: [],
            user_id :0,
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
   


           axios.get(this.uri+'/image/index/'+'?page=' + page).then((response) => {
              this.images_width_data  = response.data.images;
              this.user_id  = "_user_"+response.data.user_id;

               this.images  = [];
               this.images_mini  = [];

                if(this.$cookie.get('pic_indexes'+this.user_id )){
               this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'+this.user_id));
              //console.log('pic_indexes'+this.user_id+' this.indexArray: '+this.indexArray);
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
       var canvas_height = 1000;
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

        ctx.font = "40px Comic Sans MS";
        ctx.fillStyle = "white";
        ctx.textAlign = "center";
        var mosaic_title = "Online Mosaic";
        if(this.mosaic_data.title !=""){
          mosaic_title = this.mosaic_data.title;
        }

        

        
  
       
       var workArr =[];
       if(this.$cookie.get('pic_indexes'+this.user_id)){
        this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'+this.user_id));
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

        
        //console.log("workArr size:"+workArr.length)

        if(this.generator_mode == "automata"){
                  //workArr size rules
        if(workArr.length == 1){
          mosaic_row = 1;
          mosaic_col = 1;
          mosaic_width = canvas_width/1;
          mosaic_height = canvas_height/1;
        }
        if(workArr.length == 2 || workArr.length == 3){
          mosaic_row = 2;
          mosaic_col = 1;
          mosaic_width = canvas_width/2;
          mosaic_height = canvas_height/1;
        }
        if(workArr.length == 4 || workArr.length == 5){
          mosaic_row = 2;
          mosaic_col = 2;
          mosaic_width = canvas_width/2;
          mosaic_height = canvas_height/2;
        }
        if(workArr.length == 6 || workArr.length == 7){
          mosaic_row = 3;
          mosaic_col = 2;
          mosaic_width = canvas_width/3;
          mosaic_height = canvas_height/2;
        }
        if(workArr.length == 8 ){
          mosaic_row = 4;
          mosaic_col = 2;
          mosaic_width = canvas_width/4;
          mosaic_height = canvas_height/2;
        }
       if(workArr.length == 9 || workArr.length == 10  || workArr.length == 11 ){
          mosaic_row = 3;
          mosaic_col = 3;
          mosaic_width = canvas_width/3;
          mosaic_height = canvas_height/3;
        }

      if(workArr.length == 12 || workArr.length == 13 || workArr.length == 14 ){
          mosaic_row = 4;
          mosaic_col = 3;
          mosaic_width = canvas_width/4;
          mosaic_height = canvas_height/3;
        }
       if(workArr.length == 15 ){
          mosaic_row = 5;
          mosaic_col = 3;
          mosaic_width = canvas_width/5;
          mosaic_height = canvas_height/3;
        }

        if(workArr.length == 16 || workArr.length == 17){
          mosaic_row = 4;
          mosaic_col = 4;
          mosaic_width = canvas_width/4;
          mosaic_height = canvas_height/4;
        }

        if(workArr.length == 18 || workArr.length == 19){
          mosaic_row = 6;
          mosaic_col = 3;
          mosaic_width = canvas_width/6;
          mosaic_height = canvas_height/3;
        }

         if(workArr.length == 20 ){
          mosaic_row = 5;
          mosaic_col = 4;
          mosaic_width = canvas_width/5;
          mosaic_height = canvas_height/4;
        }

        if(workArr.length == 21 || workArr.length == 22  || workArr.length == 23 ){
          mosaic_row = 7;
          mosaic_col = 3;
          mosaic_width = canvas_width/7;
          mosaic_height = canvas_height/3;
        }

         if(workArr.length == 24  ){
          mosaic_row = 6;
          mosaic_col = 4;
          mosaic_width = canvas_width/6;
          mosaic_height = canvas_height/4;
        }

      if(workArr.length == 25  || workArr.length == 26 ){
          mosaic_row = 5;
          mosaic_col = 5;
          mosaic_width = canvas_width/5;
          mosaic_height = canvas_height/5;
        }

        if(workArr.length == 27){
          mosaic_row = 9;
          mosaic_col = 3;
          mosaic_width = canvas_width/9;
          mosaic_height = canvas_height/3;
        }

        if(workArr.length == 28 || workArr.length > 28){
          mosaic_row = 7;
          mosaic_col = 4;
          mosaic_width = canvas_width/7;
          mosaic_height = canvas_height/4;
        }
        }




     
     var k = 0;
         for ( var i = 0; i < mosaic_row ; i++) { 
             for ( var j = 0; j < mosaic_col; j++) { 

                    var   base_image = new Image();
                   // console.log ('id:' + this.images_width_data.data[k].id+ ' on/off: '+this.indexArray.indexOf(this.images_width_data.data[k].id));
                  
                   //console.log('url:'+ this.uri+'/images/'+ this.images_width_data.data[i].image_name);
                   //  console.log('id:'+ this.images_width_data.data[k].id);
                    base_image.src =  this.uri+'/images/'+ workArr[k];
                    ctx.drawImage(base_image, i*mosaic_width +0, j*mosaic_height, mosaic_width, mosaic_height);
                  
                    k++;
                    }
            }
            var title_text_width = this.mosaic_data.title.length*20;
            //console.log("title_text_width: " + title_text_width);
            ctx.fillRect((canvas_width/2)-(title_text_width/2)-20, (canvas_height/2)-35, title_text_width+40, 40);
            ctx.fillStyle = "black";
            ctx.fillText( mosaic_title , canvas_width/2, canvas_height/2); 
          
            ctx.font = "20px Comic Sans MS";
            ctx.textAlign = "left";
            
            ctx.fillText( "mosaictool.mosaicpic.com" , 30, canvas_height-30); 

       

     },
    downloadMosaic() {
       var c  = this.$refs.myCanvas;

       this.generating_image_status="on";
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
                                  this.generating_image_status="off";
                                  //console.log('url:'+this.uri+'/'+ response.data.path);
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
              
         // console.log("imageIndex:"+imageIndex+ ',cookie '+this.$cookie.get('pic_indexes'));
            for (var i = 0; i < this.images_mini.length; i++) {
        
            if(this.images_mini[i].id == imageIndex ){
                  if(this.images_mini[i].opacity == 1){
                    this.images_mini[i].opacity =0.2;
                   }else{
                     this.images_mini[i].opacity =1; 
                  }
         
               } 
            }

      if(this.$cookie.get('pic_indexes'+this.user_id)){
         this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'+this.user_id));
      }
     
    //  console.log("imageIndex:"+imageIndex+' this.indexArray: '+this.indexArray);
     // this.indexArray.indexOf(imageIndex) === -1 ? this.indexArray.push(imageIndex) : console.log("This item already exists");
       var n =  this.indexArray.indexOf(imageIndex)
      if( n === -1){
       this.indexArray.push(imageIndex);
      }else{
    //    console.log(" delete action ");
        //delete this.indexArray[n];
       this.indexArray.splice(n, 1); 
      }

     //  console.log(' - after this.indexArray: '+this.indexArray);

      this.$cookie.set('pic_indexes'+this.user_id,  JSON.stringify(this.indexArray) , 1000);
     },






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
