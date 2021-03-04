<template>
  <div class="add-website-container">
    <div class="backdrop-shadow"></div>
    <div class="model-container">
      <button class="btn close-btn"  v-on:click="$root.toggleAdd()">
        <i class="fa fa-arrow-right"></i>
      </button>
      <h1 class="model-message">
        Add a Webite
      </h1>
      <div class="form">
        <div class="form-group">
          <label for="exampleInputEmail1">Website Name:</label>
          <input type="text" class="form-control" placeholder="Example: Google" v-model.trim.lazy="$root.addedName">
          <small class="error" v-if="this.$root.errors['websiteName'].indexOf('required') > -1">required</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Website Url:</label>
          <input type="text" class="form-control" placeholder="Example: google.com" v-model="$root.addedUrl">
          <small class="error" v-if="this.$root.errors['websiteUrl'].indexOf('required') > -1">required</small>
          <small class="error" v-if="this.$root.errors['websiteUrl'].indexOf('unvaild') > -1">unvaild</small>
        </div>
        <button class="btn btn-primary" v-on:click="$root.add()">Add</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {

};
</script>
