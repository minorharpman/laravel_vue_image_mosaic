<template>
   <div>
<Scene   @before-render$="beforeRender"  >
  <Camera type="arcRotate" :radius="10" :beta="Math.PI / 4"></Camera>
  <HemisphericLight diffuse="#FFFFFF" :direction="[5,10,-2]">
   
  </HemisphericLight>

  <!--BG-->

  <Box :position="[5, 10, 50]"  :scaling="[300,300,1]" >  
  <Material diffuse="#000" > </Material>
  </Box>

  <Box :position="[-50, 5, 5]"  :scaling="[1, 300,300]" >  
  <Material diffuse="#000" > </Material>
  </Box>


  <Box :position="[5, -50, -5]"  :scaling="[300, 1, 300]" >  
  <Material diffuse="#000" > </Material>
  </Box>

  <!--BG end -->

 <Ground :options="{ width: 10, height: 10 }">
    <Material diffuse="#000" > </Material>
    <Physics></Physics>
  </Ground>
  <Entity v-for="(_, i) in Array(81).fill()" :key="i" :position="[(i % 3) - 1, 2 + Math.floor(i / 9), (Math.floor(i / 3) % 3) - 1]" :scaling="[1, 1, 0.3]">
    <Physics :mass="1"></Physics>
    <Entity :scaling="[1, 1, 1 / 0.3]">
       <Box  > 
     <Material>
      <Texture :src="uri+'/mosaic/'+image"></Texture>
    </Material>

        </Box>

         <Box  > 
     <Material>
      <Texture :src="uri+'/mosaic/'+image"></Texture>
    </Material>
         </Box>

    </Entity>
  </Entity>
</Scene>

<div>


      <label for="sel1">Select picture: </label>
        <div class="row" >
               <div class="col-sm" v-for="(mosaic, index) in mosaics ">
              <input type="radio"  name="mosaic_gallery" :value="mosaic.image_name"  @change="onChange($event)"> &nbsp;&nbsp; <img :src="uri+'/mosaic/thumbnail_'+mosaic.image_name" />
             </div>
        </div>
<!--
      <select  class="form-control" v-model="foo" @change="onChange($event)">
        <option v-for="(mosaic, index) in mosaics "  :value="mosaic.image_name" >{{mosaic.image_name}} <img :src="uri+'/mosaic/'+mosaic.image_name" /></option>
      </select>
    -->
  </div>
  </div>
</template>

<script>


import { Entity, Scene, Box, Material,  Texture, HemisphericLight , DirectionalLight, Camera, Ground, Cannon as Physics } from 'vue-babylonjs';
export default {

  components: { Entity, Scene, Box, Material,  Texture, HemisphericLight , DirectionalLight,  Camera, Ground, Physics  },
  props: ['workuri'],
  data() {
        return {
        uri: this.workuri,
        mosaics: "",
        foo: '',
        image:'',

        box:null,
        time: performance.now(),
        landarr:[],
        empty_place_arr:[], //emelkedő számsor
        camera: null,
       // startingPoint:null,
      //  currentMesh:null,
      //  pointerInfo:null,



        }
   },

  /*  computed: {
    scale() {
      let a = 6 + Math.cos(this.time * 0.0001);
      let b = 6 + Math.sin(this.time * 0.0001);
      let c = 6 + Math.sin(this.time * 0.0001);
      return {
        box: [a, b, c],
      };
    },

        currentpos() {

           let a = 10; 
           let b = 15; 
           let c = -10;

     // a = this.camera.x;

      return  [a, b, c] ;
    },

     },*/

   methods: {




      beforeRender() {
      
  this.time = performance.now()*100; 


    },


       onChange(event) {
           // console.log("selected:"+event.target.value);
   
            this.image = event.target.value;
        
        },
       load() {

            axios.get(this.uri+'/mosaic/indexjson').then((response) => {
           
                this.mosaics = response.data.mosaics;  
                this.image = this.mosaics[0]['image_name'];

              //  console.log("mosaics:"+this.mosaics);

           
  
            });

             

        },



      /*  landArrFiller(){
            var counter =0;
            var k=0;
            var i=0;
            var currentValue =0;
            var baz= [];
              for (k = 0; k < 10; k++) {
                 baz[k] = [];
                for (i = 0; i < 10; i++) {

                  //empty block checker
                  if( this.empty_place_arr.includes(counter) ==false){
                   currentValue = Math.floor(Math.random() * 2) + 1;
                 // console.log("landarr:" + k +","+ i +"," +  currentValue  );
                  baz[k][i] = currentValue;
                  }
                 counter++;
                }
              }
              this.landarr = baz;
            },*/

           //button click Mix Blocks
     /*   mixBlocks() {
          this.randomNumbers();
          

        },*/

    /*   randomNumbers() {
          var numberArr = [];
          var num = 0;
             for (var i = 0; i < 20; i++) {
             num = Math.floor(Math.random() * 100 + 1);
             numberArr.push(num);
             numberArr.sort((a, b) => a - b);
             }
             

          this.empty_place_arr = this.removeDups(numberArr);

          this.landArrFiller();
        },*/

 /*   removeDups(arr){
    let unique_array = []
    for(let i = 0;i < arr.length; i++){
        if(unique_array.indexOf(arr[i]) == -1){
            unique_array.push(arr[i])
        }
    }
    //console.log("unique_array: "+unique_array);
    return unique_array
     }*/



},

  updated() {

  },

 mounted() {

    //console.log("uri:"+this.uri);
  
   this.load();
 //  this.landArrFiller();


  

    },
};


</script>