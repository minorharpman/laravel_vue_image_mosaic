<template>
    <div class="container-fluid">
     
<div  class="row align-items-center justify-content-center">
          <div class="col-sm-3  " >
          <!--  Gallery:  {{selected_gallery_id }}-->
            <button type="button" class="btn btn-primary btn-lg" @click="mixPicture()">Mix picture</button>
          </div>
</div>
  <div  class="row" id="pics_list">

      <div class="col-sm-12" v-if="images_mini.length" >Number of the images: {{images_mini.length-indexArray.length}}/{{images_mini.length}} </div>
      <div
        class="image"
        v-for="(image, imageIndex) in images_mini"
 
       
        :style="{color: 'white' }"
      >
      
         <a  @click="onoffpicture($event, image.id)" style=" cursor: pointer;color:black;background:white; opacity: 1 !important;">ON</a>  
&nbsp;&nbsp;
         <a  class="main_mosaic" @click="mainMosaic($event, image.id)" style=" cursor: pointer;color:black;background:white; opacity: 1 !important;">main mosaic</a>
         <br>
          <img :src="uri+'/images/'+image.image_name"  :style="{width: '150px',height:'90px',opacity:image.opacity  }">
      </div>
   

    
  </div>

<!--
  <pagination :data="images_width_data" @pagination-change-page="loadImages"></pagination>
-->      
    </div>
</template>
<script>



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
     
            images_mini: [],
            images_width_data: {},
            index: null,
            uri: this.workuri,
            users: [],
           // user_id :0,
            selected_user: "",
            indexArray:[],
            mosaic_download_uri:""
            
        }
    },

    methods: {

//a feltöltés miatt kell ez a funkció!
        loadImages() {

          this.$store.dispatch('loadImages' ,  this.uri );
        },
        
     /*   loadImages(page) {

            if (typeof page === 'undefined') {
                page = 1;
            }
   


           axios.get(this.uri+'/image/index/'+'?page=' + page).then((response) => {
              this.images_width_data  = response.data.images;

              this.$store.state.mosaic_data = response.data.images;
              
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

        },*/



        mixPicture(){
        //console.log('click mix counts: '+  this.images_mini.length);
       let mix   = this.shuffle(this.images_mini);   
        this.images_mini  = [];
        this.images_mini  = mix;
        this.$store.state.images_mini = this.images_mini;
        
        //test
      /*  for ( var i = 0; i < this.images_mini.length; i++) { 
         // this.images_mini.push(this.uri+'/images/'+ this.images_mini[i].image_name);
          console.log('image: '+ this.images_mini[i].image_name + ' opacity: '+ this.images_mini[i].opacity);
          }
          console.log('image: *****************');
          */
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


     mainMosaic(event, imageIndex){

        $(".main_mosaic").html("main mosaic");

            if(event.target.innerText ="main mosaic")
              {
                event.target.innerText ="MAIN MOSAIC" 
              }

            for (var i = 0; i < this.images_mini.length; i++) {
        
            if(this.images_mini[i].id == imageIndex ){
                  if(this.images_mini[i].main == 1){
                    this.images_mini[i].main =0;
                   }else{
                     this.images_mini[i].main =1; 
                  }
         
               }else{
                this.images_mini[i].main =0;
               } 
            }
          },


     onoffpicture(event, imageIndex){
      //console.log("imageIndex:"+imageIndex+ ',cookie '+this.$cookie.get('pic_indexes'));
    // console.log("images_mini.length: "+this.images_mini.length  );  


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


var user_id = this.$store.getters.user_id;
     if(this.$cookie.get('pic_indexes'+user_id)){
         this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'+user_id));
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

      this.$cookie.set('pic_indexes'+user_id,  JSON.stringify(this.indexArray) , 1000);

   
     },




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
           },

       selected_gallery_id:{

          get: function () {
            return this.$store.getters.selected_gallery_id;
        },
       }
          /* user_status:{
            get: function () {
            return this.$store.getters.user_status;
             }
           }*/
  },
 watch: {
  images: function (){
    // console.log('changed');

     var images = this.images;
     //console.log('images lenght'+ images.data.length );
           ///////
      this.images_mini = [];
      var user_id = this.$store.getters.user_id;

             if(this.$cookie.get('pic_indexes'+ user_id )){
               this.indexArray = JSON.parse(this.$cookie.get('pic_indexes'+user_id ));

                  }

                for ( var i = 0; i < images.data.length; i++) { 

                 if(this.indexArray.indexOf(images.data[i].id) ==-1){
                    this.images_mini.push({id:images.data[i].id, image_name:images.data[i].image_name, opacity:1});
                  }else{
                    this.images_mini.push({id:images.data[i].id, image_name:images.data[i].image_name, opacity:0.2});
                  }
                
                }
                /////////////
                this.$store.state.images_mini = this.images_mini;

   }

},

    mounted() {

      this.$store.dispatch('loadImages' ,  this.uri );
      //start

        //imagelistből
       this.$root.$on('loadImages', this.loadImages );
       //mosaicból
       this.$root.$on('mixPicture', this.mixPicture );

     
    },

  updated() {
    // Fired every second, should always be true
  },

  components: {

  },
}

</script>


<style>

#pics_list{
  overflow: auto;
  max-height: 300px;

}
</style>




