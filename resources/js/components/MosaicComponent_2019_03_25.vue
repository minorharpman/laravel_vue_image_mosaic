<template>
    <div class="container-fluid">
    window size:{{  window_width }} px
<div class="row justify-content-center my-5" >   
  <div  id="download_place" style="font-size:20px;font-weight:bold;"></div>
<!--<div class="col-sm-12 text-center mb-5">
  <a id="btn_generate_image_c" type="button" class="btn btn-primary btn-lg" style="display:none;"   >Download Image</a>
</div>-->
<div class="col-sm-12 text-center ">
   <button id="btn_generate_image" type="button" class="btn btn-primary btn-lg" style="display:none;" @click="generateImage()"  >Generate Image</button>
</div>
   <div v-if="generating_image_status === 'on'"  class=" ml-5" style="color:red;"> 
<br><img  :src="image" alt="loader" />  <span style="font-weight:bold;font-size:4em;" >{{10-storeMosaicParts_counter}}...</span> Please wait while the image is being prepared.
    </div>

<a id="btn_download_image" :href="mosaic_download_uri"  target="_blank" style="display:none;"><button  type="button" class="btn btn-success btn-lg"   >Download Image</button></a>
<!--
<div class="col-sm-12 text-center ">
   <button id="btn_download_image" type="button" class="btn btn btn-success btn-lg" style="display:none;"  @click="downloadImage()"  >Download Image</button>
</div>
-->

</div>


<div id="canvas_wrapper" class="row justify-content-center" style="max-width:100%; max-height: 500px ;overflow: scroll; display:none;">

          <div class="col-sm-12 text-center"   >
                    <canvas id="canvas" ref="myCanvas"   :width="mosaic_data.canvas_width" :height="mosaic_data.canvas_height"></canvas>
                
           </div> 

          
</div> 


      <div class="row " style="margin: 20px 0px;">

<div class="col-sm-12 ">
         <button type="button" class="btn btn-primary btn-lg" @click="createMosaic(1), messageChange('mosaic')">Make Mosaic</button> <br>   
         Mosaic photo effects:
<div class="form-inline ">

<div><input type="radio" class="m-2" value="overlay" v-model="mosaic_effect" > Overlay | &nbsp;  &nbsp; </div>
<div><input type="radio" class="m-2" value="lighter" v-model="mosaic_effect" > Lighter |  &nbsp; &nbsp;</div>

<div><input type="radio" class="m-2" value="exclusion" v-model="mosaic_effect" > Exclusion |  &nbsp;&nbsp;</div>
<div><input type="radio" class="m-2" value="multiply" v-model="mosaic_effect" > Multiply |  &nbsp;&nbsp;</div>
<div><input type="radio" class="m-2" value="soft-light" v-model="mosaic_effect" > Soft-light |  &nbsp;&nbsp;</div>


<div><input type="radio" class="m-2" value="hard-light" v-model="mosaic_effect" > Hard-light |  &nbsp;&nbsp;</div>


<div><input type="radio" class="m-2" value="darken" v-model="mosaic_effect" > Darken |  &nbsp;&nbsp;</div>

<div><input type="radio" class="m-2" value="color-dodge" v-model="mosaic_effect" > Color-dodge |  &nbsp;&nbsp;</div>
<div><input type="radio" class="m-2" value="color-burn" v-model="mosaic_effect" > Color-burn |  &nbsp;&nbsp;</div>

<div><input type="radio" class="m-2" value="luminosity" v-model="mosaic_effect" > Luminosity |  &nbsp;&nbsp;</div>

</div> 
<br><br>


  <div class="form-group">
    <label for="formControlRange"TEST</label>
    <input type="range" class="form-control-range" v-model="mosaic_saturate" > : {{mosaic_saturate}}
  </div>

If the dragging is not working on the mobile phone, Please click on the line! <br>
      
      Saturate: <input type="checkbox" value=true  v-model="mosaic_saturate_status"> 
            &nbsp; &nbsp; <b-form-slider v-model="mosaic_saturate"   :min="0" :max="100" trigger-change-event ></b-form-slider>
      : {{mosaic_saturate}}
      <br><br>


 

</div> 
      <div class="col-sm">
     Opacity: &nbsp;&nbsp; &nbsp;  <b-form-slider v-model="mosaic_opacity"   :min="0" :max="100" trigger-change-event ></b-form-slider>
      : {{mosaic_opacity}}
<br>
<br>
     Threshold: &nbsp;&nbsp; &nbsp;  <b-form-slider v-model="mosaic_threshold"  :min="0" :max="255" trigger-change-event ></b-form-slider>
      : {{mosaic_threshold}}
<br>
<br>
   Invert: <input type="checkbox" value=true  v-model="mosaic_invert_status">
      </div> 
  </div> 


    <div   class="row " style="margin: 20px 0px;">

                    <div class="col-sm-12 col-md-4 mb-3">
<input type="radio" class="mr-2" value="20" v-model="mosaic_part_size" > 20x20 &nbsp;&nbsp;
<input type="radio" class="mr-2" value="10" v-model="mosaic_part_size" > 10x10 &nbsp;&nbsp;
<input type="radio" class="mr-2" value="5" v-model="mosaic_part_size" > 5x5 &nbsp;&nbsp;
<input type="radio" class="mr-2" value="3" v-model="mosaic_part_size" > 3x3 &nbsp;&nbsp;
<input type="radio" class="mr-2" value="2" v-model="mosaic_part_size" > 2x2 &nbsp;&nbsp;   
<input type="radio" class="mr-2" value="1" v-model="mosaic_part_size" > 1x1 &nbsp;&nbsp;      
            </div>

    <div class="col-sm-12 card card-body bg-light">
            

            <div class="form-inline ">


            <div class="d-flex flex-column align-items-start mr-2 mb-2 " >
              <label >mosaic title:</label>
              <input v-model="mosaic_data.title" type="text" />
            </div>

            <div class="d-flex flex-column align-items-start mr-2 mb-2 ">
              <div class="form-inline ">
              <input type="radio" class="m-2" value="center" v-model="mosaic_data.title_status" >
               <label > Center</label>
              </div>
            <div class="form-inline ">
              <input type="radio" class="m-2" value="header" v-model="mosaic_data.title_status" >
               <label> Header</label>
              </div>
              </div>
               <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
             <div class="form-inline ">
              <input type="radio" class="m-2" value="bottom" v-model="mosaic_data.title_status" >
               <label> Bottom</label>
              </div>
              <div class="form-inline ">
              <input type="radio" class="m-2" value="no" v-model="mosaic_data.title_status" >
               <label  > No title</label>
              </div>
            </div>

<!--
           <div class="d-flex flex-column align-items-start mr-2 mb-2 vertical-divider">
              <div class="form-inline ">
              <input type="radio" class="m-2" value="automata" v-model="generator_mode" >
               <label for="one"> Automatic</label>
              </div>
              <div class="form-inline ">
              <input type="radio" class="m-2" value="mysetting" v-model="generator_mode">
               <label for="two" > My setting</label>
              </div>
            </div>
       -->

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

            </div>
            <div class="form-group">

             <div id="make_mosaic" class="col-sm-12 mt-3 ">
                    <div class="alert alert-info" role="alert">
  1. Click one of the "main mosaic" button in the picture list to select the main mosaic. (at the last part of this site)    


  2. Click on the "Make Mosaic" button. Then   Mosaic picture  and the "Generate Image" button (the picture above) appear. 

  3. Try the photo effects. You can change the opacity, saturation. After the setting click on the "Make Mosaic" to see the result.


  4. If you click on the "Generate Image" button You can download the picture (PNG format). Please wait while the image is being generated. This process takes some time.
                    </div>
             </div>
            <div  id="make_video" class="col-sm-12 mt-3 " style="display:none;">
                    <div class="alert alert-info" role="alert">
   1. Click one of the "main mosaic" button in the picture list to select the main mosaic. (at the last part of this site) 2. If you click on the  Mosaic video the Mosaic is changing every 1 seconds. You can record with screen recorder like OBS studio <a href="https://obsproject.com" target="_blank"> https://obsproject.com </a> 3. You can stop the animation with clicking "Stop Mosaic video"
                    </div>
             </div>

             <div id="make_collage" class="col-sm-12 mt-3 " style="display:none;">
                    <div class="alert alert-info" role="alert">
1. If you click on the  "Make Collage" the Collage picture  and the "Generate Image" button (the picture above) appear. 2. If you click on the "Generate Image" button You can download the picture (PNG format). Please wait while the image is being generated. This process takes some time.
                    </div>
             </div>
         
            <div class="row" >




            <div class="col-sm-12 col-md-4  mt-3">
 <button style="display:none;" type="button" class="btn btn-primary btn-lg" id="btn_start_video"  @click="startVideo() , messageChange('video')"  
  >Mosaic video</button>
 <button type="button" class="btn btn-danger btn-lg"  id="btn_stop_video" style="display:none;" @click="stopVideo()">Stop Mosaic video</button>
            </div>

              <div class="col-sm-12  col-md-4  mt-3">
            <button style="display:none;" type="button" id="btn_make_collage" class="btn btn-primary btn-lg" @click="createMosaic(0) , messageChange('collage')">Make Collage</button>
            </div>


             </div>
            </div>
         



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
              title:'Photo Mosaic',
              title_status: 'no',
                row: 10,
                col: 6,
                width: 150,
                height: 90,
                canvas_width: 1000,
                canvas_height: 800,
                main_pic:'',
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
            mosaic_threshold: 0,
            mosaic_opacity: 100,
            mosaic_saturate_status: true,
            mosaic_saturate: 100,
            mosaic_invert_status: false,
            mosaic_effect: 'overlay',
            mosaic_part_size: 10,

            refreshIntervalId:'',
            window_width: '',


    
   

            
        }
    },

    methods: {


      createMosaic(status) {

        var is_mosaic = status;

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

       var selectedPic =0;



          var images = this.$store.getters.images_mini;

          for ( var i = 0; i < images.length; i++) { 

                 if(images[i].opacity == 1){

                    workArr.push(images[i].image_name);
                  }

                   if(images[i].main == 1){

                    selectedPic = i;
                  }
                
         }

//Ha Mosaik akkor feltolti, de kollázsnál is
if(true ||  is_mosaic  == 1){
while (workArr.length < 400) {
 workArr = workArr.concat(workArr);
}

         }

    //console.log('workArr:'+ workArr.length);

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
 ///////////////////////////       
//kollázshoz
/// a darab szerinti megjelenites kivéve MosaicComponent_2019_03_11_vue -után
//ezt majd később rendezni!!
          mosaic_row = 10;
          mosaic_col = 10;
          mosaic_width = canvas_width/10;
          mosaic_height = canvas_height/10;

         if(workArr.length == 400 || workArr.length > 400 ){
          mosaic_row = this.mosaic_part_size;
          mosaic_col = this.mosaic_part_size;
          mosaic_width = canvas_width/this.mosaic_part_size;
          mosaic_height = canvas_height/this.mosaic_part_size;
        }
///////////////////////

/////Mozaik
if(  is_mosaic  == 1){

//console.log("mosaic size: " + this.mosaic_part_size );
         if(workArr.length == 400 || workArr.length > 400 ){
          mosaic_row = this.mosaic_part_size;
          mosaic_col = this.mosaic_part_size;
          mosaic_width = canvas_width/this.mosaic_part_size;
          mosaic_height = canvas_height/this.mosaic_part_size;
        }



    var   base_image = new Image();
    base_image.src =  this.uri+'/images/'+ workArr[selectedPic];

    ctx.drawImage(base_image, 0, 0, canvas_width, canvas_height);
    ctx.globalAlpha  = this.mosaic_opacity/100;

    //////kép átfordítás INVERT  

if(this.mosaic_invert_status == true){
   var d = ctx.getImageData(0, 0, canvas_width, canvas_height);  // Get image Data from Canvas context

      for (var i=0; i<d.data.length; i+=4) { // 4 is for RGBA channels
        d.data[i] = d.data[i]^ 255;
        d.data[i+1] = d.data[i+1]^ 255;
        d.data[i+2] = d.data[i+2]^ 255;
      }

      ctx.putImageData(d, 0, 0);  
}


    ///////Saturate////////  
  //console.log("mosaic_saturate_status: "+ this.mosaic_saturate_status);
 if(this.mosaic_saturate_status == true){
   ctx.globalCompositeOperation = "saturation";
   // ctx.fillStyle = "hsl(0,100%,50%)";  // saturation at 100%
    //mosaic_saturate
    ctx.fillStyle = "hsl(1,"+this.mosaic_saturate+"%, 50%)"; 
    ctx.fillRect(0,0,canvas_width,canvas_height);  // apply the comp filter
   //ctx.globalCompositeOperation = "source-over";  // restore default comp
}
   


    /////Threshold////////
    //console.log( "threshold:" + this.mosaic_threshold)

    if(this.mosaic_threshold >0){
        var d = ctx.getImageData(0, 0, canvas_width, canvas_height);  // Get image Data from Canvas context

      for (var i=0; i<d.data.length; i+=4) { // 4 is for RGBA channels
        // R=G=B=R>T?255:0
        d.data[i] = d.data[i+1] = d.data[i+2] = d.data[i+1] > this.mosaic_threshold ? 255 : 0;
      }

      ctx.putImageData(d, 0, 0);  
    }

    //////////////////
}

//https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/globalCompositeOperation

//mosaic_effect
if( is_mosaic ==1  ){
  //console.log(" effect"+this.mosaic_effect);
       ctx.globalCompositeOperation = this.mosaic_effect;
     
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




    


             ///Mozaik///
             ctx.globalAlpha  = "1";
              /////
              ctx.globalCompositeOperation = "source-over";

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
,
      startVideo(){
        $("#btn_start_video").hide();
        $("#btn_stop_video").show();
        $("#canvas_wrapper").css({'max-height' : '100%'});  
        var foo = this;
       this.refreshIntervalId = setInterval(function() {
       foo.videoWorker();
      }, 1000);
      },

      videoWorker(){
              this.createMosaic(1);
              this.$root.$emit('mixPicture');
             
      },

      stopVideo(){
        $("#btn_start_video").show();
        $("#btn_stop_video").hide();
        $("#canvas_wrapper").css({'max-height' : '500px'}); 
        clearInterval(this.refreshIntervalId);

      },

      messageChange(status){

          if(status == 'video'){
            $("#make_video").show();
            $("#make_mosaic").hide();
            $("#make_collage").hide();
          }

          if(status == 'mosaic'){
            $("#make_video").hide();
            $("#make_mosaic").show();
            if(this.window_width < 1300){
              $("#make_mosaic").hide();
            }
            $("#make_collage").hide();
          }


          if(status == 'collage'){
            $("#make_collage").show();
            $("#make_video").hide();
            $("#make_mosaic").hide();
          }

      },


      handleResize() {
      this.window_width = window.innerWidth;
      if(this.window_width < 1300){
            this.mosaic_part_size = 5;
            this.mosaic_data.canvas_width =500;
            this.mosaic_data.canvas_height =300;
            $("#btn_start_video").hide();
            $("#btn_make_collage").hide();
            $("#make_mosaic").hide();
            $("#make_video").hide();
            $("#make_collage").hide();

              
      }

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

  created() {
    window.addEventListener('resize', this.handleResize)
    this.handleResize();
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
