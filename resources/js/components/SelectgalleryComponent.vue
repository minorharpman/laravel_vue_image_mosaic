<template>

<div>
 <!-- {{user_id}}-->
    <div v-if="user_id == '_user_1' || user_id == '_user_demo'" class="form-group">
      <label for="sel1">Select demo gallery:</label>
      <select  class="form-control" v-model="key" @change="onChange($event)">
        <option v-for="(gallery, index) in galleries "  :value="gallery.id" >{{gallery.gallery_name}}</option>

      </select>
    </div>
</div>
</template>
<script>
//help: https://stackoverflow.com/questions/50982408/vue-js-get-selected-option-on-change
export default {
 props: ['workuri'],
data() {
        return {
            uri: this.workuri,
            key: 1,
            galleries:0,
           
        }
},
methods: {
      onChange(event) {
            //console.log("selected:"+event.target.value)
            this.$store.state.selected_gallery_id = event.target.value;
            this.$root.$emit('loadImages');
        },

         load() {

            axios.get(this.uri+'/gallery/index').then((response) => {
           
                this.galleries = response.data.galleries;

                //console.log('galleries count: '+this.galleries.length);

              // console.log('key: '+this.galleries[0]['id']);

               //setting key 
               this.key = this.galleries[0]['id'];


           
            });

        },


},
   computed : {
           user_id:{

          get: function () {
            return this.$store.getters.user_id;
        },
         }

  },
mounted() {
this.load();

}
}
</script>