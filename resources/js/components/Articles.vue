<template>
  <div>

    <div class="container">
      <div v-if="showArticleComponent">
        <div class="row justify-content-center mt-5">
            <h1 class="display-5">All Articles</h1>
        </div>
        <div class="row py-5">

          <!-- show article content -->
          <div v-for="article in articles" :key="article.id" class="col-lg-4 col-md-6 mb-5">
            <div class="card">
              <img :src="article.image == 'main.png' ? 'img/default.jpg' : 'img/main/' + article.image" class="card-image-top">
              <div class="card-body">
                <h4 class="card-title">{{ article.title }}</h4>
                <froalaView v-bind:value="article.body | slice" class="card-text text-muted"></froalaView>
                <hr>
                <!-- bind the article with the name of the author -->
                <div class="d-inline" v-for="user in users" :key="users.id">
                  <div class="d-inline" v-if="article.user_id == user.id">
                    <button @click="readArticle(article, user)" class="btn btn-light btn-sm color-blue"><i class="fas fa-glasses"></i> Read</button>
                  </div>
                </div>
                <small class="text-muted float-right">
                   <span class="align-text-top">{{ article.created_at | myDate }}</span>
                </small>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  <!-- sending data from Articles to Read Component (Props) -->
  <read-component v-if="showReadComponent" :article="article" :user="user" v-on:goBack="toArticle()"></read-component>

  </div>
</template>

<script>
  export default {
    data() {
      return {

        articles: [],
        users: [],
        // article and user objects are going to Read component through Props
        article: {},
        user: {},
        showArticleComponent: true,
        showReadComponent: false

      }
    },
    created() {
      this.showAllArticles();
      this.showAllUsers();
    },
    methods: {

      showAllArticles() {
        axios.get('api/allArticles')
        .then(({ data }) => {
          this.articles = data;
        })
      },

      showAllUsers() {
        axios.get('api/allUsers')
        .then(({ data }) => {
          this.users = data;
        })
      },

      readArticle(article, user) {
        this.article = article;
        this.user = user;
        this.showArticleComponent = false;
        this.showReadComponent = true;
      },

      toArticle() {
        this.showArticleComponent = true;
        this.showReadComponent = false;
      }

    }
  }
</script>

<style scoped>
  .color-blue {
    color: blue;
  }

  .card-image-top {
    max-width:100%;
    height:auto;
  }
</style>
