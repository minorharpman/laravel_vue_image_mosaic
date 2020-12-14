<template>
  <div>
<Scene    @complete="complete" @before-render$="beforeRender"  fog="exp"    :fogColor="[0, 0.9, 0.85]"    v-model="sceneName" >

 <Camera  type="universal" :position="currentpos"  :radius="30" :beta="Math.PI / 16"  v-model="camera" ></Camera>
  <HemisphericLight diffuse="#FFFFFF" :direction="[5,10,-2]">
   
  </HemisphericLight>


<!--BG-->
<!--
  <Box :position="[5, 10, 50]"  :scaling="[300,300,1]" >  
  <Material diffuse="#000" > </Material>
  </Box>

  <Box :position="[-50, 5, 5]"  :scaling="[1, 300,300]" >  
  <Material diffuse="#000" > </Material>
  </Box>


  <Box :position="[5, -50, -5]"  :scaling="[300, 1, 300]" >  
  <Material diffuse="#000" > </Material>
  </Box>
-->
  <!--BG end -->
 
<!-- :scaling="[3,3,3]" :scaling="scale.box" -->
  <Box :position="[5, 10, -2]"  :scaling="scale.box"   v-model="box"   >  

     <Material>
      <Texture :src="uri+'/mosaic/'+image"></Texture>
    </Material>
  </Box>

<Entity v-for="(_, k) in 10 " :key="k"  >
    <Entity v-for="(_, i) in 10 " :key="i">
          <Box :position="[i*3, k*3, landarr[k][i] ]" :scaling="[3,3,3]"> 
             <Material>
              <Texture  :src="uri+'/mosaic/'+image"></Texture>
            </Material>
          </Box>
    </Entity>
</Entity>

<!-- :key="'A'+k" duplicate key detected hiba miatt -
https://stackoverflow.com/questions/51086657/vue-warn-duplicate-keys-detected-x-this-may-cause-an-update-error
-->

<Entity v-for="(_, k) in 10 " :key="'A'+k"  >
    <Entity v-for="(_, i) in 10 " :key="i">
          <Box :position="[landarr[k][i]  , k*3, -i*3]" :scaling="[3,3,3]"> 
             <Material>
              <Texture  :src="uri+'/mosaic/'+image"></Texture>
            </Material>
          </Box>
    </Entity>
</Entity>


<Entity v-for="(_, k) in 10 " :key="'B'+k"  >
    <Entity v-for="(_, i) in 10 " :key="i">
          <Box :position="[k*3, landarr[k][i]  ,  -i*3]" :scaling="[3,3,3]"> 
             <Material>
              <Texture  :src="uri+'/mosaic/'+image"></Texture>
            </Material>
          </Box>
    </Entity>
</Entity>

<!--
   <Box :position="[5, 0, 0]" :scaling="[1,3,3]">   
      <Material>
      <Texture   :src="uri+'/mosaic/'+key"></Texture>
    </Material>
  </Box>


     <Box :position="[0, 5, 0]" :scaling="[3,1,3]">
    
        <Material>
      <Texture  :src="uri+'/mosaic/'+key"></Texture>
    </Material>
  </Box>
-->


</Scene>

<div>
  <button type="button" class="btn btn-primary btn-lg" @click="mixBlocks()">Blocks with random holes</button> <br>   <br> 

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


import { Entity, Scene, Box, Material,  Texture, HemisphericLight , DirectionalLight, Camera, Ground } from 'vue-babylonjs';
export default {
  mixins: [Entity],
  components: { Entity, Scene, Box, Material,  Texture, HemisphericLight , DirectionalLight,  Camera, Ground  },
  props: ['workuri'],
  data() {
        return {
        uri: this.workuri,
        mosaics: "",
        foo: '',
        image:'',
        sceneName:null,

        box:null,
        time: performance.now(),
        landarr:[],
        empty_place_arr:[], //emelkedő számsor
        camera: null,
       // startingPoint:null,
      //  currentMesh:null,
      //  pointerInfo:null,
      camX:10,
      camY:15,
      camZ:-10,



        }
   },

     computed: {
    scale() {
      let a = 6 + Math.cos(this.time * 0.0001);
      let b = 6 + Math.sin(this.time * 0.0001);
      let c = 6 + Math.sin(this.time * 0.0001);
      return {
        box: [a, b, c],
      };
    },

        currentpos() {

           let a = this.camX; 
           let b = this.camY; 
           let c = this.camZ;

     // a = this.camera.x;

      return  [a, b, c] ;
    },

     },

   methods: {



 complete(event) {
     // console.log('complete', event);
     // console.log('box', this.box);
      //console.log('sphere', this.sphere);
      //console.log('scene', this.scene);
      console.log('scene', event.scene);

//Hozzáférés a Babylonjs Scene-hez, Igy sikerült
     let scene = event.scene;
     //scene.fogMode = BABYLON.Scene.FOGMODE_EXP;
     //scene.fogColor = new BABYLON.Color3(0.9, 0.9, 0.85);
        
      //Így nem megy: TypeError: Cannot set property 'fogMode' of null
     //this.sceneName.fogMode = BABYLON.Scene.FOGMODE_EX;
     //this.sceneName.fogColor = new BABYLON.Color3(0.9, 0.9, 0.85);

    },


       beforeRender() {
      
  //this.time = performance.now(); 


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



           landArrFiller(){
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
            },

           //button click Mix Blocks
        mixBlocks() {
          this.randomNumbers();
          

        },

        randomNumbers() {
          var numberArr = [];
          var num = 0;
             for (var i = 0; i < 20; i++) {
             num = Math.floor(Math.random() * 100 + 1);
             numberArr.push(num);
             numberArr.sort((a, b) => a - b);
             }
             

          this.empty_place_arr = this.removeDups(numberArr);

          this.landArrFiller();
        },

      removeDups(arr){
    let unique_array = []
    for(let i = 0;i < arr.length; i++){
        if(unique_array.indexOf(arr[i]) == -1){
            unique_array.push(arr[i])
        }
    }
    //console.log("unique_array: "+unique_array);
    return unique_array
     }



},

  updated() {

  },

  mounted() {

    //console.log("uri:"+this.uri);
  
    this.load();
   this.landArrFiller();



       const self = this;
    window.addEventListener("keypress", function(e) {
      // use self instead of this in here
      console.log(String.fromCharCode(e.keyCode));
      if(String.fromCharCode(e.keyCode) == "w"){
        self.camY =   self.camY+ 5;
      }
     if(String.fromCharCode(e.keyCode) == "s"){
           self.camY  =   self.camY - 5;
      }
      if(String.fromCharCode(e.keyCode) == "a"){
         self.camX  =    self.camX  + 5;
      }
     if(String.fromCharCode(e.keyCode) == "d"){      
         self.camX  =    self.camX  - 5;
      }
      if(String.fromCharCode(e.keyCode) == "1"){
         self.camZ  =    self.camZ  + 5;
      }
     if(String.fromCharCode(e.keyCode) == "3"){      
          self.camZ   =     self.camZ   - 5;
      }
    });


  

    },
};


</script>