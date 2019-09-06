<template>
  <div>

    <div v-if="showProfileComponent" class="container pt-5">
      <div class="row justify-content-center mb-5">
          <h1 class="display-5">Your Articles</h1>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header">
              Your Articles
              <span>
                <a href="/create" class="btn btn-success btn-sm float-right">
                  <i class="fas fa-plus"></i>
                  Create New Article
                </a>
              </span>
            </div>

              <div class="card-body table-responsive p-0">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th scope="col">Article Title</th>
                      <th scope="col">Created At</th>
                      <th scope="col">Edit / Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="article in articles.data" :key="article.id">
                      <td>{{ article.title }}</td>
                      <td>{{ article.created_at | myDate }}</td>
                      <td>
                        <button @click="editArticle(article)" class="btn btn-primary btn-sm mr-2"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button @click="deleteArticle(article.id)" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer p-0">
                <!-- laravel-vue-pagination -->
                <pagination class="pagination-sm mb-0 p-2 pl-4" :data="articles" @pagination-change-page="getResults"></pagination>
              </div>

          </div>
        </div>
      </div>
    </div>
    <!-- sending data from Profile to Edit Component (Props) -->
    <edit-component v-if="showEditComponent" :article="article" :user="user"></edit-component>

  </div>
</template>

<script>
  export default {
    data() {
      return {

        articles: {},
        // article and user objects are going to Read component through Props
        article: {},
        user: {},
        showProfileComponent: true,
        showEditComponent: false

      }
    },
    created() {

      // fetch the user name
      this.showUser();

      // feth the data when you click on 'Your Profile' vue link
      this.showUserArticles();

      // show articles table when we successfully delete some article
      Fire.$on('ShowArticles', () => {
        this.showUserArticles();
      });

    },
    methods: {

      showUser() {
        axios.get('api/user')
        .then(({ data }) => {
          this.user = data;
        })
      },

      showUserArticles() {
        axios.get('api/articles')
        .then(({ data }) => {
          this.articles = data;
        })
      },

      // laravel-vue-pagination
      getResults(page = 1) {
  			axios.get('api/articles?page=' + page)
  			.then(response => {
  				this.articles = response.data;
  			})
		  },

      editArticle(data) {
        this.article = data;
        this.showProfileComponent = false;
        this.showEditComponent = true;
      },

      deleteArticle(id) {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3490dc',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            // if you click yes...
            axios.delete(`api/articles/${id}`)
            .then(() => {
              Swal.fire(
                'Deleted!',
                'Your article has been deleted.',
                'success'
              )
              // show the remain articles
              Fire.$emit('ShowArticles');
            })
          }
        }).catch(() => {
          // fire sweet alert message if it's refused to proceed
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Something went wrong!'
          });
        })
      }

    }
  }
</script>
