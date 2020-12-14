<template>

        <vue-tabs>
        <v-tab title="Mosaic Creator" @tab-change="handleTabChange">
        <mosaic-component :workuri="uri"></mosaic-component> 
         <select-component :workuri="uri" ></select-component> 
        <imagelistpub-component :workuri="uri"></imagelistpub-component>
       
        </v-tab>
        <v-tab title="My Pictures" >
	        <div v-if="user_status === 'registered'">
		     <imageupload-component :workuri="uri"></imageupload-component>
         <select-component :workuri="uri" ></select-component> 
		     <imagelist-component :workuri="uri"></imagelist-component> 
	        </div>
	        <div v-if="user_status !== 'registered'">
                        <div v-if="user_status !== 'registered'" class="alert alert-primary" style="margin:20px;">
                        Please Login or Register!

<br>
Test login: <br>
email: test@test.com <br>
password: 123456<br>
<br>
Check me on the Facebook: Online Fast Photo Mosaic and Collage Maker <a href="https://www.facebook.com/Online-Fast-Photo-Mosaic-and-Collage-Maker-313781452590056/" target="_blank"> CLICK! </a>
<br>
The Mosaic and Collage Maker is on the Pinterest. <a href="https://hu.pinterest.com/zsoltkunsagi9/mosaic-and-collage" target="_blank"> CLICK! </a>


<br>
<br>

<ul>
<li> You can create almost 2000KB JPG picture at normal setting.* </li>
<li> Add photos after login, create your own photo mosaic or collage. You can upload 100 pictures.   </li>
<li> You can edit your pictures in private mode. Nobody can see your pictures. </li>
<li> You can delete all pictures with one click. </li>
</ul>

<br>
*If you want bigger pictures than 2500px X 1500px Please write me: <br>
webeswork@yahoo.com.
                       <br>
                    </div>
	        </div>
         </v-tab>

        </vue-tabs>

</div>
</template>
<script>
import VueTabs from 'vue-nav-tabs'
import 'vue-nav-tabs/themes/vue-tabs.css'
Vue.use(VueTabs)
export default {
props: ['workuri'],
data() {
        return {
        uri: this.workuri,
      //  user_status: '',
        }
},
methods: {
handleTabChange(tabIndex, newTab, oldTab) {
},
userStatusChange(status){
 this.user_status = status ;  
}

},
   computed : {

           user_status:{
            get: function () {
            return this.$store.getters.user_status;
             }
           }
  },
mounted() {

    this.$root.$on('userStatusChange', this.userStatusChange );
}
}
</script>