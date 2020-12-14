<template>
  <div>
<Scene  @complete="complete" @before-render$="beforeRender" @pointer$="onPointer"   >

 <Camera  type="free" :position="currentpos"  ></Camera>
  <HemisphericLight diffuse="#FFFFFF" :direction="[5,10,-2]">
   
  </HemisphericLight>


<!--BG-->

  <Box :position="[5, 10, 50]"  :scaling="[300,300,1]" name="hatter" >  
  <Material diffuse="#000" > </Material>
  </Box>

  <Box :position="[-50, 5, 5]"  :scaling="[1, 300,300]" name="hatter"  >  
  <Material diffuse="#000" > </Material>
  </Box>


  <Box :position="[5, -50, -5]"  :scaling="[300, 1, 300]" name="hatter"  >  
  <Material diffuse="#000" > </Material>
  </Box>

  <!--BG end -->
 
<!-- :scaling="[3,3,3]" :scaling="scale.box" -->
 <!-- <Box :position="[5, 10, -2]"  :scaling="scale.box"   v-model="box"   >  

     <Material>
      <Texture :src="uri+'/mosaic/'+image"></Texture>
    </Material>
  </Box>-->

<Entity v-for="(_, k) in 10 " :key="k"  >
    <Entity v-for="(_, i) in 10 " :key="i">
       <Entity v-for="(_, l) in 10 " :key="l">
      
              <Box :position="[i*3, k*3, l*3 ]" :scaling="[3,3,3]"   :name="landarr[k][i][l]" v-if="!picked_block_arr.includes(landarr[k][i][l])" > 
                 <Material>
                  <Texture  :src="uri+'/mosaic/'+image"></Texture>
                </Material>

              </Box>


          </Entity>
    </Entity>
</Entity>

<!-- :key="'A'+k" duplicate key detected hiba miatt -
https://stackoverflow.com/questions/51086657/vue-warn-duplicate-keys-detected-x-this-may-cause-an-update-error
-->
<!--
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
-->
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
  <h2>Direction :a,s,d,w,1,3,  Mining: mouse click</h2>
<!--  <button type="button" class="btn btn-primary btn-lg" @click="mixBlocks()">Blocks with random holes</button> <br>   <br> -->

      <label for="sel1">Select picture: </label>
        <div class="row" >
               <div class="col-sm" v-for="(mosaic, index) in mosaics ">
              <input type="radio"  name="mosaic_gallery" :value="mosaic.image_name" @change="onChange($event)" > &nbsp;&nbsp; <img :src="uri+'/mosaic/thumbnail_'+mosaic.image_name" />
             </div>
        </div>
<!--
      <select  class="form-control"  @change="onChange($event)">
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
  components: { Entity, Scene, Box, Material,  Texture, HemisphericLight , DirectionalLight,  Camera, Ground },
  props: ['workuri'],
  data() {
        return {
        uri: this.workuri,
        mosaics: "",
        image:'',

        box:null,
        time: performance.now(),
        landarr:[],
        empty_place_arr:[], //emelkedő számsor
        camera: null,
        currentMesh:null,
        pointerInfo:null,
        camX:10,
        camY:30,
        camZ:-20,
        picked_block_arr:[],





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
      //console.log('scene', event.scene);

//Hozzáférés a Babylonjs Scene-hez, Igy sikerült
     let scene = event.scene;


     //scene.fogMode = BABYLON.Scene.FOGMODE_EXP;
     //scene.fogColor = new BABYLON.Color3(0.9, 0.9, 0.85);
        
      //Így nem megy: TypeError: Cannot set property 'fogMode' of null
     //this.sceneName.fogMode = BABYLON.Scene.FOGMODE_EX;
     //this.sceneName.fogColor = new BABYLON.Color3(0.9, 0.9, 0.85);

    },


    /*
    selected:{"observable":{"_observers":[{"mask":-1,"scope":null,"_willBeUnregistered":false,"unregisterOnNextCall":false},{"mask":7,"scope":null,"_willBeUnregistered":false,"unregisterOnNextCall":false},{"mask":7,"scope":null,"_willBeUnregistered":false,"unregisterOnNextCall":false}],"_eventState":{"mask":4,"skipNextObservers":false,"lastReturnValue":{"type":4,"event":{"isTrusted":true},"pickInfo":{"hit":false,"distance":0,"pickedPoint":null,"pickedMesh":null,"bu":0,"bv":0,"faceId":-1,"subMeshId":0,"pickedSprite":null}}}},"observer":{"mask":-1,"scope":null,"_willBeUnregistered":false,"unregisterOnNextCall":false}}
    */

        onPointer(event) {

   //console.log("full:"+JSON.stringify(event));
   //console.log("_observers:"+JSON.stringify(event.observable._observers));
    
    //console.log("selected:"+event.observable._eventState.lastReturnValue.pickInfo.pickedMesh);
   // console.log("click info:"+event.observable._eventState.lastReturnValue.type + ", "+ BABYLON.PointerEventTypes.POINTERDOWN);
    

    this.pointerInfo = event.observable._eventState.lastReturnValue;

  // console.log("hit:"+this.pointerInfo.pickInfo.hit);
  // console.log("pickedPoint:"+this.pointerInfo.pickInfo.pickedPoint);

   //console.log("mesh:"+this.pointerInfo.pickInfo.pickedMesh);
   

      switch (this.pointerInfo.type) {
      case BABYLON.PointerEventTypes.POINTERDOWN:
        if(this.pointerInfo.pickInfo.hit ) {
                    this.pointerDown(this.pointerInfo.pickInfo.pickedMesh)
                }
        break;
       
        }

    },

    pointerDown(mesh) {
           this.currentMesh = mesh;

      if(this.currentMesh && this.currentMesh.name !="hatter" ){
      //https://doc.babylonjs.com/api/classes/babylon.mesh
      console.log("milyen nev:" +this.currentMesh.name );
      this.picked_block_arr.push(this.currentMesh.name);
      this.currentMesh.setPositionWithLocalVector(new BABYLON.Vector3(1000, 1100, 10000));
      }
    
    },




       beforeRender() {
      
// this.time = performance.now(); 


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
            var l=0;
            var currentValue =0;
            var baz= [];
              for (k = 0; k < 10; k++) {
                 baz[k] = [];
                for (i = 0; i < 10; i++) {
                     baz[k][i] = [];
                     for (l = 0; l < 10; l++) {
                        //  console.log("landarr:" + k +","+ i +"," +  l +", val: "+counter );
                  baz[k][i][l] = counter.toString();

                 counter++;
                  }
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
   //véletlen szám 
 this.landArrFiller();

    const self = this;
    window.addEventListener("keypress", function(e) {
      // use self instead of this in here
    

      // setTimeout(function () {

      //console.log(String.fromCharCode(e.keyCode));

      if(String.fromCharCode(e.keyCode) == "w"){
        self.camY =   self.camY+ 1;
      }
     if(String.fromCharCode(e.keyCode) == "s"){
           self.camY  =   self.camY - 1;
      }
      if(String.fromCharCode(e.keyCode) == "a"){
         self.camX  =    self.camX  + 1;
      }
     if(String.fromCharCode(e.keyCode) == "d"){      
         self.camX  =    self.camX  - 1;
      }
      if(String.fromCharCode(e.keyCode) == "1"){
         self.camZ  =    self.camZ  + 1;
      }
     if(String.fromCharCode(e.keyCode) == "3"){      
          self.camZ   =     self.camZ   - 1;
      }
     //   }, 1000);   

    });


  

    },
};


</script>