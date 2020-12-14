<template>
    <div class="container-fluid">
<div class="row justify-content-center my-5" >   
  <div  id="download_place" style="font-size:20px;font-weight:bold;"></div>
<!--<div class="col-sm-12 text-center mb-5">
  <a id="btn_generate_image_c" type="button" class="btn btn-primary btn-lg" style="display:none;"   >Download Image</a>
</div>-->
<div class="col-sm-12 text-center ">
   <button id="btn_generate_image" type="button" class="btn btn-primary btn-lg" style="display:none;" @click="generateImage()"  >Generate Image</button>
</div>
   <div v-if="generating_image_status === 'on'"  class=" ml-5" style="color:red;"> 
<br>Please wait while the image is being prepared.<br>
    <img class="rounded mx-auto d-block" :src="image" alt="loader" /> </div>

<a id="btn_download_image" :href="mosaic_download_uri"  target="_blank" style="display:none;"><button  type="button" class="btn btn-success btn-lg"   >Download Image</button></a>
<!--
<div class="col-sm-12 text-center ">
   <button id="btn_download_image" type="button" class="btn btn btn-success btn-lg" style="display:none;"  @click="downloadImage()"  >Download Image</button>
</div>
-->

</div>


<div id="canvas_wrapper" class="row justify-content-center" style="max-width:100%; max-height: 500px;overflow: scroll; display:none;">

<div class="col-sm-12 text-center">
          <canvas id="canvas" ref="myCanvas"   :width="mosaic_data.canvas_width" :height="mosaic_data.canvas_height"></canvas>
          <br><br>
    
 </div> 
      </div> 




    <div   class="row " style="margin: 20px 0px;">

    <div class="col-sm-12 card card-body bg-light">
            <form class="form-inline ">


            <div class="d-flex flex-column align-items-start mr-2 mb-2 " >
              <label >mosaic title:</label>
              <input v-model="mosaic_data.title" type="text" />
            </div>

            <div class="d-flex flex-column align-items-start mr-2 mb-2 ">
              <div class="form-inline ">
              <input type="radio" class="mr-2" value="center" v-model="mosaic_data.title_status" >
               <label > Center</label>
              </div>
            <div class="form-inline ">
              <input type="radio" class="mr-2" value="header" v-model="mosaic_data.title_status" >
               <label> Header</label>
              </div>
              </div>
               <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
             <div class="form-inline ">
              <input type="radio" class="mr-2" value="bottom" v-model="mosaic_data.title_status" >
               <label> Bottom</label>
              </div>
              <div class="form-inline ">
              <input type="radio" class="mr-2" value="no" v-model="mosaic_data.title_status" >
               <label  > No title</label>
              </div>
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
            <button type="button" class="btn btn-primary btn-lg" @click="createMosaic()">Make Collage</button>
            </div>
            </form>

 <!--   <div>
    <b-form-slider :value="mosaic_data.canvas_width" @slide-start="slideStart" @slide-stop="slideStop"></b-form-slider>
    <p>canvas width {{ mosaic_data.canvas_width }}</p>
  </div>-->
    </div>
        
    </div>


      
    </div>
</template>
<script>

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
              title:'Photo Collage',
              title_status: 'center',
                row: 10,
                col: 6,
                width: 150,
                height: 90,
                canvas_width: 1000,
                canvas_height: 800
            },
            generator_mode: 'automata',
            generating_image_status: 'off',
           // images: [],
            images_mini: [],
            images_width_data: {},
            index: null,
            uri: this.workuri,
            users: [],
            user_id :0,
            selected_user: "",
            indexArray:[],
            mosaic_download_uri:"",
            canvas_chunk_array:[],
            storeMosaicParts_counter:0,
            image: 'design/loader.gif',
            current_my_uniqid: '',
            server_mosaic_parts_status:'',
            
        }
    },

    methods: {


      createMosaic() {

     // console.log('mosaic data: ' + this.mosaic_data.row + '  , ' + this.mosaic_data.col);

        
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

   
        $('#canvas_wrapper').show();
        $('#btn_generate_image').show();


        //test https://jsfiddle.net/codepo8/V6ufG/2/
      /*  var canvas  = this.$refs.myCanvas;
     var link = document.createElement('a');
    link.innerHTML = '--> Download the Image <--';
    link.addEventListener('click', function(ev) {
    link.href = canvas.toDataURL();
    link.download = "myphotocollage.png";
    }, false);
        $('#download_place').append(link);
*/

          $('#btn_generate_image_c').show();
         var canvas  = this.$refs.myCanvas;
        $( "#btn_generate_image_c" ).bind( "click", function() {
         // console.log("katt");
     this.href = canvas.toDataURL();
     this.download = "myphotocollage.png";
          });

        /////

        

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



          var images = this.$store.getters.images_mini;

          for ( var i = 0; i < images.length; i++) { 

                 if(images[i].opacity == 1){

                    workArr.push(images[i].image_name);
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

        if(workArr.length == 28 || workArr.length == 29){
          mosaic_row = 7;
          mosaic_col = 4;
          mosaic_width = canvas_width/7;
          mosaic_height = canvas_height/4;
        }
        if(workArr.length == 30 || workArr.length == 31){
          mosaic_row = 6;
          mosaic_col = 5;
          mosaic_width = canvas_width/6;
          mosaic_height = canvas_height/5;
        }

         if(workArr.length == 32 || workArr.length == 33 || workArr.length == 34 || workArr.length > 34  ){
          mosaic_row = 8;
          mosaic_col = 4;
          mosaic_width = canvas_width/8;
          mosaic_height = canvas_height/4;
        }

       if(workArr.length == 35   ){
          mosaic_row = 7;
          mosaic_col = 5;
          mosaic_width = canvas_width/7;
          mosaic_height = canvas_height/5;
        }

       if(workArr.length == 36  || workArr.length == 37  || workArr.length == 39){
          mosaic_row = 6;
          mosaic_col = 6;
          mosaic_width = canvas_width/6;
          mosaic_height = canvas_height/6;
        }

         if(workArr.length == 40  || workArr.length == 41){
          mosaic_row = 10;
          mosaic_col = 4;
          mosaic_width = canvas_width/10;
          mosaic_height = canvas_height/4;
        }

          if(workArr.length == 42  || workArr.length == 43 || workArr.length == 44 ){
          mosaic_row = 7;
          mosaic_col = 6;
          mosaic_width = canvas_width/7;
          mosaic_height = canvas_height/6;
        }

        if(workArr.length == 45  || workArr.length == 46 || workArr.length == 47 ){
          mosaic_row = 9;
          mosaic_col = 5;
          mosaic_width = canvas_width/9;
          mosaic_height = canvas_height/5;
        }


        if(workArr.length == 48 ){
          mosaic_row = 8;
          mosaic_col = 6;
          mosaic_width = canvas_width/8;
          mosaic_height = canvas_height/6;
        }

        if(workArr.length == 49 ||  workArr.length == 50 || workArr.length == 51 || workArr.length == 52 || workArr.length == 53 ){
          mosaic_row = 7;
          mosaic_col = 7;
          mosaic_width = canvas_width/7;
          mosaic_height = canvas_height/7;
        }

        if(workArr.length == 54 ){
          mosaic_row = 9;
          mosaic_col = 6;
          mosaic_width = canvas_width/9;
          mosaic_height = canvas_height/6;
        }

         if(workArr.length == 55 ){
          mosaic_row = 11;
          mosaic_col = 5;
          mosaic_width = canvas_width/11;
          mosaic_height = canvas_height/5;
        }

        if(workArr.length == 56 || workArr.length == 57 || workArr.length == 58 || workArr.length == 59 ){
          mosaic_row = 8;
          mosaic_col = 7;
          mosaic_width = canvas_width/8;
          mosaic_height = canvas_height/7;
        }

        if(workArr.length == 60 || workArr.length == 61 || workArr.length == 62 ){
          mosaic_row = 10;
          mosaic_col = 6;
          mosaic_width = canvas_width/10;
          mosaic_height = canvas_height/6;
        }

       if(workArr.length == 63 ){
          mosaic_row = 9;
          mosaic_col = 7;
          mosaic_width = canvas_width/9;
          mosaic_height = canvas_height/7;
        }

       if(workArr.length == 64 || workArr.length == 65 ){
          mosaic_row = 8;
          mosaic_col = 8;
          mosaic_width = canvas_width/8;
          mosaic_height = canvas_height/8;
        }

        if(workArr.length == 66 || workArr.length == 67 || workArr.length == 68 || workArr.length == 69 || workArr.length == 70 || workArr.length == 71){
          mosaic_row = 11;
          mosaic_col = 6;
          mosaic_width = canvas_width/11;
          mosaic_height = canvas_height/6;
        }
      if(workArr.length == 72 || workArr.length == 73  || workArr.length == 74 || workArr.length == 75 || workArr.length == 76  ){
          mosaic_row = 9;
          mosaic_col = 8;
          mosaic_width = canvas_width/9;
          mosaic_height = canvas_height/8;
        }

      if(workArr.length == 77 || workArr.length == 78  || workArr.length == 79  ){
          mosaic_row = 11;
          mosaic_col = 7;
          mosaic_width = canvas_width/11;
          mosaic_height = canvas_height/7;
        }
         if(workArr.length == 80  ){
          mosaic_row = 10;
          mosaic_col = 8;
          mosaic_width = canvas_width/10;
          mosaic_height = canvas_height/8;
        }

       if(workArr.length == 81 || workArr.length == 82 || workArr.length == 83 ){
          mosaic_row = 9;
          mosaic_col = 9;
          mosaic_width = canvas_width/9;
          mosaic_height = canvas_height/9;
        }

        if(workArr.length == 84  || workArr.length == 85 || workArr.length == 86 || workArr.length == 87 ){
          mosaic_row = 14;
          mosaic_col = 6;
          mosaic_width = canvas_width/14;
          mosaic_height = canvas_height/6;
        }

         if(workArr.length == 88 || workArr.length == 89 ){
          mosaic_row = 11;
          mosaic_col = 8;
          mosaic_width = canvas_width/11;
          mosaic_height = canvas_height/8;
        }

         if(workArr.length == 90 || workArr.length == 91  || workArr.length == 92 || workArr.length == 93 || workArr.length == 94   || workArr.length == 95){
          mosaic_row = 10;
          mosaic_col = 9;
          mosaic_width = canvas_width/10;
          mosaic_height = canvas_height/9;
        }

        if(workArr.length == 96 || workArr.length == 97 || workArr.length == 98){
          mosaic_row = 16;
          mosaic_col = 6;
          mosaic_width = canvas_width/16;
          mosaic_height = canvas_height/6;
        }

       if(workArr.length == 99){
          mosaic_row = 11;
          mosaic_col = 9;
          mosaic_width = canvas_width/11;
          mosaic_height = canvas_height/9;
        }

         if(workArr.length == 100 || workArr.length > 100 ){
          mosaic_row = 10;
          mosaic_col = 10;
          mosaic_width = canvas_width/10;
          mosaic_height = canvas_height/10;
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

            if(this.mosaic_data.title_status !="no"){
              var title_text_width = this.mosaic_data.title.length*20;
              //console.log("title_text_width: " + title_text_width);
              
              
              if(this.mosaic_data.title_status == "center"){
                 ctx.fillStyle = "white";
                ctx.fillRect((canvas_width/2)-(title_text_width/2)-20, (canvas_height/2)-35, title_text_width+40, 40);
                ctx.fillStyle = "black";
                      ctx.fillText( mosaic_title , canvas_width/2, canvas_height/2); 
              }else if(this.mosaic_data.title_status == "header"){
                ctx.fillStyle = "white";
                
                ctx.fillRect((canvas_width/2)-(title_text_width/2)-20, 0, title_text_width+40, 40);
                ctx.fillStyle = "black";
                      ctx.fillText( mosaic_title , canvas_width/2, 35 ); 
                  }
                  else if(this.mosaic_data.title_status == "bottom"){
                ctx.fillStyle = "white";               
                ctx.fillRect((canvas_width/2)-(title_text_width/2)-20, (canvas_height)-40, title_text_width+40, 40);
                ctx.fillStyle = "black";
                      ctx.fillText( mosaic_title , canvas_width/2, (canvas_height)-5 ); 
                  }  
            }

          
            ctx.font = "15px Comic Sans MS";
            ctx.textAlign = "left";
            ctx.fillStyle = "white";
            ctx.fillRect(0, canvas_height- 18, 110, 20);
            ctx.fillStyle = "black";
            ctx.fillText( "mosaicpic.com" , 5, canvas_height-5); 

       

     },




    generateImage() {
      //reset counter

      this.storeMosaicParts_counter =0;
      this.server_mosaic_parts_status ="";
      
       var c  = this.$refs.myCanvas;

       this.generating_image_status="on";
      //var image = c.toDataURL("image/png").replace("image/png", "image/octet-stream");

      this.current_my_uniqid = this.myUniqid();

      //console.log("download image, id:" + this.current_my_uniqid );
      

     this.canvas_chunk_array = [];
      for (var i = 0; i < 10; i++ ) {
        var canvas_part = document.createElement("canvas");
        canvas_part.width  = c.width/10;
        canvas_part.height  = c.height;

        var context = canvas_part.getContext('2d');
        //console.log("canvas: "+ c.width+ " x "+ c.height);

       //context.drawImage(imageObj, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);

       var xpos = i*(c.width/10);
       //console.log("xpos: "+ xpos);
       context.drawImage(c, xpos, 0, c.width/10, c.height,  0, 0, c.width/10, c.height);

        var image = canvas_part.toDataURL();

        this.canvas_chunk_array[i]= image ;
      // console.log('image: '+ image);

      }
     // console.log('canvas_chunk_array meret: '+ this.canvas_chunk_array.length);
      if(this.canvas_chunk_array.length == 10){
        this.storeMosaicParts();

      }



     },


     myUniqid(){
          return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
     },


     storeMosaicParts() {
    var   i = this.storeMosaicParts_counter;

    
    if(i<10){
          var  image = this.canvas_chunk_array[this.storeMosaicParts_counter];
    //console.log("images: " +  image );
                  let formData = new FormData();
                    formData.append('order', i);
                    formData.append('current_my_uniqid', this.current_my_uniqid);                  
                    formData.append('file', image);


                                    axios.post(this.uri+'/image/storecanvas',
                                 formData ,
                                    {
                                        headers: {
                                            'Content-Type': 'multipart/form-data'
                                        }
                                    }
                                ).then((response) => {
                                 if(this.storeMosaicParts_counter <10){
                                  this.storeMosaicParts_counter++;
                                  this.storeMosaicParts();
                                 } 
                                  //console.log('url:'+this.uri+'/'+ response.data.path);
                                 // this.mosaic_download_uri = this.uri+'/'+ response.data.path;


                                });
    }else{
             this.generating_image_status="off";
             $("#btn_generate_image").hide();
             //$("#btn_download_image").show();

             this.collectingImage();
    }

                               
    },

collectingImage(){

  this.generating_image_status="on";

              axios.post(this.uri + "/image/collectimage",
            { 
              id: this.current_my_uniqid,
              canvas_width: this.mosaic_data.canvas_width,
              canvas_width_part: this.mosaic_data.canvas_width/10,
              canvas_height: this.mosaic_data.canvas_height,
              server_mosaic_parts_status: this.server_mosaic_parts_status,

               } )
                .then(response => {
                
                this.server_mosaic_parts_status = response.data.server_mosaic_parts_status;
                
                //console.log("canvas: "+response.data.canvas );

                this.mosaic_download_uri = this.uri+'/mosaic/'+ response.data.canvas;

                this.generating_image_status="off";

                $("#btn_download_image").show();

                }).catch(error => {

                });
}




      },
    //https://vuejs.org/v2/guide/computed.html
   computed : {
         images:{

          get: function () {
            return this.$store.getters.images;
        },
         // setter
            set: function (val) {

            }
           }
  },
 watch: {
  images: function (){
    // console.log('changed');

     var images = this.images;
           ///////
      this.images_mini = [];
      var user_id = this.$store.getters.user_id;

             if(this.$cookie.get('pic_indexes'+ user_id )){
              // a store-ba berakni süti helyett
               this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'+user_id ));

                  }



   }

},
    mounted() {

    
    },

  updated() {
  
    // Fired every second, should always be true

  },



     components: {

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
