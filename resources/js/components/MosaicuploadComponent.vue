<template>
    <div  class="container"   :key="varThatChangesValue">
<h2>Picture direct upload</h2>
       
        <div v-if="loading">
            <img class="rounded mx-auto d-block" :src="loader_url" alt="loader" />
        </div>
        <div class="col-sm-12 my-2" ><!-- Gallery: {{selected_gallery_id }}--></div>

<!--{{this.$store.state.mainuri}}-->
        <div  class="large-12 medium-12 small-12 filezone">
            <input type="file" id="files" ref="files" multiple v-on:change="handleFiles()"/>
            <p>
                Drop your file here <br>or click to search
            </p>
        </div>

        <div v-for="(file, key) in files" class="file-listing">
            <img class="preview" v-bind:ref="'preview'+parseInt(key)"/>
            {{ file.name }}
            <div class="success-container" v-if="file.id > 0">
                Success
                <input type="hidden" :name="input_name" :value="file.id"/>
            </div>
            <div class="remove-container" v-else>
                <a class="remove" v-on:click="removeFile(key)">Remove</a>
            </div>
        </div>

        <div v-if="loading">
            <img class="rounded mx-auto d-block" :src="loader_url"  alt="loader" />
        </div>

        <a class="submit-button " v-on:click="submitFiles()" v-show="files.length > 0">Submit</a>
    </div>
</template>

<script>

    export default {
        props: ['input_name', 'workuri'],
        data() {
            return {
                varThatChangesValue: 0,
                files: [],
                files_index: 0,
                work_counter:0,
                uri: this.workuri,
                upload_status: 'on',
                image: 'design/loader.gif',
                loading: false,
                toastr: toastr.options = {
                "positionClass": "toast-top-full-width"
                  },
            }
        },
        methods: {
            removeFile( key ){
                this.files.splice( key, 1 );
                this.getImagePreviews();
            },
            handleFiles() {
                let uploadedFiles = this.$refs.files.files;

                var realNumber = 100;

                if(uploadedFiles.length > 100) {
                   realNumber = 100 
               }else{
                realNumber = uploadedFiles.length;
               }

                for(var i = 0; i < realNumber; i++) {
                    this.files.push(uploadedFiles[i]);
                }
                this.getImagePreviews();
            },
            getImagePreviews(){
                for( let i = 0; i < this.files.length; i++ ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.files[i].name ) ) {
                        let reader = new FileReader();
                        reader.addEventListener("load", function(){
                            this.$refs['preview'+parseInt(i)][0].src = reader.result;
                        }.bind(this), false);
                        reader.readAsDataURL( this.files[i] );
                    }
                    /*else{
                        this.$nextTick(function(){
                            this.$refs['preview'+parseInt(i)][0].src = '/img/generic.png';
                        });
                    }*/
                }
            },
            submitFiles() {
                  this.worker();  
                  this.loading = true; 

                  //delete file-listing   
                 $(".file-listing").remove();
            },
            worker(){

               

                    let formData = new FormData();
                    formData.append('file', this.files[this.files_index]);



                        if(this.files[this.files_index] !== undefined){

                          //  console.log(this.files_index + " filename: "+ this.files[this.files_index].name )
                                    axios.post(this.uri+'/mosaic/store',
                                    formData,
                                    {
                                        headers: {
                                            'Content-Type': 'multipart/form-data'
                                        }
                                    }
                                ).then(function(data) {
                                    // this.files[this.files_index].id = data['data']['id'];

                                    // this.files.splice(this.files_index, 1); 
                                    //console.log('success');
                                    //  alert(data.data.info);
                                  if(data.data.error ==''){
                                    toastr.success(data.data.info);
                                    this.$root.$emit('loadImages');

                                    //
                                    if(this.files_index < this.files.length+1){
                                        this.files_index++;
                                       // console.log("index: "+ this.files_index);
                                        this.worker(); 
                                    }
                                   
                                    //
                                    }else{
                                        toastr.error(data.data.error);
                                        this.$root.$emit('loadImages');
                                        //this.files.splice(this.files_index, 1); 
                                       // console.log("after error index: "+ this.files_index);
                                        if(this.files_index < this.files.length+1){
                                            this.files_index++;
                                            this.worker(); 
                                        }

                                    }

              
                                }.bind(this));
                            }else{
                                         //  this.files.splice(this.files_index, 1); 
                                           // console.log("after no image - index: "+ this.files_index);
                                            if(this.files_index < this.files.length+1){
                                            this.files_index++;
                                            this.worker(); 
                                        } 
                            }

                            
                             // console.log("work_counter: "+ this.work_counter + ", méret:"+ this.files.length);
                             this.work_counter++;
                             if(this.work_counter >this.files.length) {
                                this.files= [];
                                this.files_index=0;
                                this.work_counter=0;
                                this.loading=false; 
                             }

            },



          /*  uploadOff(status){
                this.upload_status = status;
            //console.log('status: '+ status);
            }*/

        }
        ,
           computed : {
                    images:{
                    get: function () {
                    return this.$store.getters.images;
                    }
                    },
                    loader_url:{

                    get: function () {
                    return this.uri +"/"+ this.image ;
                    }
                    },
                    selected_gallery_id:{

                    get: function () {
                    return this.$store.getters.selected_gallery_id;
                    }
                    },

          },
          
       mounted() {

            // this.$root.$on('uploadOff', this.uploadOff );
            }
    }
</script>

<style scoped>
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 200px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
        outline: 2px dashed grey;
        outline-offset: -10px;
        background: #ADD8E6;
        color: dimgray;
        padding: 10px 10px;
        min-height: 200px;
        position: relative;
        cursor: pointer;
    }
    .filezone:hover {
        background: #6495ED;
    }

    .filezone p {
        font-size: 1.2em;
        text-align: center;
        padding: 50px 50px 50px 50px;
    }
    div.file-listing img{
        max-width: 90%;
    }

    div.file-listing{
        margin: auto;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    div.file-listing img{
        height: 100px;
    }
    div.success-container{
        text-align: center;
        color: green;
    }

    div.remove-container{
        text-align: center;
    }

    div.remove-container a{
        color: red;
        cursor: pointer;
    }

    a.submit-button{
        display: block;
        margin: auto;
        text-align: center;
        width: 200px;
        padding: 10px;
        text-transform: uppercase;
        background-color: #6495ED;
        color: white;
        font-weight: bold;
        margin-top: 20px;
    }

    a.submit-button:hover {
        background: #4169E1;
    }

</style>