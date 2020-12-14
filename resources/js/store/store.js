import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

//https://vuex.vuejs.org/guide/
//https://www.youtube.com/watch?v=LW9yIR4GoVU
export const store = new Vuex.Store({
    state: {
        loadingStatus: 'not_loading',
        images: [] ,
        images_mini: [] ,
        user_id: '',
        user_status:'',
        selected_gallery_id:0,
        //work_url:'',
        


    },
    getters : {
    images : state => {
      return state.images;
    },
    images_mini : state => {
      return state.images_mini ;
    },

    user_id : state => {
      return state.user_id;
    },
    
    user_status : state => {
      return state.user_status;
    },

    selected_gallery_id : state => {
      return state.selected_gallery_id;
    },

  },
    mutations:{
		SET_LOADING_STATUS(state,status){
			state.loadingStatus = status;
		},
		SET_IMAGE_DATA(state,images){
			state.images = images;
		},
		SET_USER_ID(state,user_id){
			state.user_id = user_id;
		},
		SET_USER_STATUS(state,user_status){
			state.user_status = user_status;
		},

    },
    actions:{
    	   loadImages(context, work_url) {

    	   //	console.log("Loading images ..." + work_url);

    	   	context.commit('SET_LOADING_STATUS', 'loading');
            var page= 1;
            if (typeof page === 'undefined') {
                page = 1;
            }
   
          //this.uri ='http://localhost/projects/laravel5/laravel_vue_image_mosaic/public';

        //  console.log("store selected_gallery_id: "+ this.getters.selected_gallery_id);




          // axios.get(work_url+'/image/index/'+'?page=' + page,  { gallery_id: this.getters.selected_gallery_id} ).then((response) => {

           axios.post(work_url+'/image/index/'+this.getters.selected_gallery_id).then((response) => {

           	//console.log("Images loaded.");

           	context.commit('SET_LOADING_STATUS', 'not_loading');

            //console.log("store Images length "+ response.data.images.data.length);

           	context.commit('SET_IMAGE_DATA', response.data.images);

           	context.commit('SET_USER_ID', "_user_"+response.data.user_id);

           // console.log("USER_STATUS "+ response.data.user_status);

           	context.commit('SET_USER_STATUS', response.data.user_status);

          
            });

        }
    }
});