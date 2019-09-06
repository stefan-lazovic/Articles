<template>
  <div>
    
    <!-- Page Header -->
    <header class="masthead" :style="article.image == 'main.png' ? { 'background-image': 'url(img/default.jpg)' } : { 'background-image': 'url(' + 'img/main/' + article.image + ')' }">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="post-heading">
              <h1><p>{{ article.title }}</p></h1>
              <span class="meta">
                Posted by {{ user.name }} on {{ article.created_at | myDate }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Post Content -->
    <article>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <button @click="goBack()" class="btn btn-primary btn-sm float-right"><i class="fas fa-angle-left"></i> Go Back</button>
            <br>
            <hr>
              <!-- display content created with the froala editor -->
              <froalaView v-bind:value="article.body" class="card-text text-muted"></froalaView>
            <hr>
            <button @click="goBack()" class="btn btn-primary btn-sm float-right"><i class="fas fa-angle-left"></i> Go Back</button>
            <br>
            <br>
          </div>
        </div>
      </div>
    </article>

  </div>
</template>

<script>
  export default {
    props: {
      article: {
        type: Object,
        required: true
      },
      user: {
        type: Object,
        required: true
      }
    },
    methods: {
      goBack() {
        this.$emit('goBack');
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../sass/header.scss";
</style>
