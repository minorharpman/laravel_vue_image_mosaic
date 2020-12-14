<template>
  <div>
    <input type="file"
           name=""
           id="file-upload"
           multiple
           @change="filesChange($event.target.files)">
    <button @click="handleSubmit">Send</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: new FormData(),
    };
  },
  methods: {
    filesChange(fileList) {
      // First: append file to FormData
      Array.from(Array(fileList.length).keys()).map(x => {
        this.formData.append(fileList[x].name, fileList[x]);
      });
    },
    handleSubmit() {
      // Append Text
      this.formData.append('username', 'Jeremy');

      // Append Number: Will be string
      this.formData.append('number', 9527);

      // Append Array: Need to be converted to a string
      this.formData.append('arrData', JSON.stringify([1, 2, 3]));

      // Append Array: Need to be converted to a string
      this.formData.append(
        'objData',
        JSON.stringify({ name: 'Jeremy', age: 28 })
      );

      axios({
        method: 'post',
        url: 'http://localhost/projects/laravel5/laravel_vue_image_upload/public/image/store',
        data: this.formData,
      }).then(res => {
        console.log(res);
      });
    },
  },
};
</script>