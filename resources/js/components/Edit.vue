<template>
  <div>

    <!-- Page Header -->
    <header class="masthead" :style="displayMainImage()">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="post-heading">
              <h1><p>{{ form.title }}</p></h1>
              <span class="meta">
                Posted by {{ user.name }} on {{ article.created_at | myDate }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="container py-5">
      <div class="row">
        <div class="col-12">
          <form @submit.prevent="updateArticle()">
            <!-- this is the way how to style default input file button -->
            <div class="form-group">
              <label style="display: block">Change Main Image</label>
              <label for="image" class="btn btn-primary mr-2"><i class="fas fa-image"></i> Choose File</label> <span>{{ imageName }}</span>
              <div class="col-sm-12">
                  <input id="image" @change="changeMainImage" type="file" name="image" class="form-input" style="display: none">
              </div>
            </div>

            <div class="form-group py-2">
              <label>Edit Title</label>
              <input v-model="form.title" name="title" type="text" class="form-control" placeholder="Article Title" :class="{ 'is-invalid': form.errors.has('title') }">
              <has-error :form="form" field="title"></has-error>
            </div>

            <div class="form-group py-2">
              <label>Edit Body</label>
              <!-- Froala WYSIWYG -->
              <froala v-model="form.body" class="form-control" name="body" :tag="'textarea'" :class="{ 'is-invalid': form.errors.has('body') }"></froala>
              <has-error :form="form" field="body"></has-error>
            </div>

            <div class="form-group pt-4">
              <button type="submit" class="btn btn-success mr-2" style="width: 200px;">Update Article</button>
              <a href="/profile" class="btn btn-primary">Cancel</a>
            </div>
          </form>

        </div>
      </div>
    </div>

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
        required:true
      }
    },
    data() {
      return {

        form: new Form({
          image: '',
          title: '',
          body: ''
        }),
        imageName: ''

      }
    },
    created() {
      this.fetchArticleData();
    },
    methods: {

      changeMainImage(e) {
        // display file's name
        this.imageName = e.target.files[0].name;
        // base64
        let file = e.target.files[0];
        let reader = new FileReader();
        reader.onloadend = () => {
          // console.log('RESULT', reader.result)
          // put the converted image base64 string into form image to submit on the server
          this.form.image = reader.result;
        }
        reader.readAsDataURL(file);
      },

      displayMainImage() {
        // in case you guys are both empty, I'm gonna display default image only
        if (this.article.image == 'main.png' && this.form.image == '') {
          return 'background-image: url(img/default.jpg)';
        }
        // in case article.image has something, I will display him, but only if form.image has nothing
        else if (this.article.image != 'main.png' && this.form.image == '') {
          return `background-image: url(img/main/${this.article.image})`;
        }
        // in case form.image has something, I'm gonna display him
        else if (this.article.image == 'main.png' && this.form.image != '') {
          return `background-image: url(${this.form.image})`;
        }
        // in case form.image has something, I'm gonna display him, even if article.image has something
        else if (this.article.image != 'main.png' && this.form.image != '') {
          return `background-image: url(${this.form.image})`;
        }
      },

      fetchArticleData() {
        if (!this.article) {
          return;
        }
        this.form.title = this.article.title;
        this.form.body = this.article.body;
      },

      updateArticle() {
        if (this.form.image.length < 200) {
          this.form.image = this.article.image;
        }
        this.form.put('api/articles/' + this.article.id)
        .then(() => {
          Swal.fire({
            position: 'center',
            type: 'success',
            title: 'Your work has been updated',
            showConfirmButton: false,
            timer: 2000
          })
          // redirect to main page
          this.$router.push("/");
        })
        .catch(() => {
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

<style lang="scss" scoped>
  @import "../../sass/header.scss";
</style>
