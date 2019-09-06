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
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="container py-5">
      <div class="row">
        <div class="col-12">

          <form @submit.prevent="createArticle()">
            <!-- this is the way how to style default input file button -->
            <div class="form-group">
              <label style="display: block">Upload Main Image</label>
              <label for="image" class="btn btn-primary mr-2"><i class="fas fa-image"></i> Choose File</label> <span>{{ imageName }}</span>
              <div class="col-sm-12">
                  <input id="image" @change="uploadMainImage" type="file" name="image" class="form-input" style="display: none">
              </div>
            </div>

            <div class="form-group py-2">
              <label>Title</label>
              <input v-model="form.title" name="title" type="text" class="form-control" placeholder="Article Title" :class="{ 'is-invalid': form.errors.has('title') }">
              <has-error :form="form" field="title"></has-error>
            </div>

            <div class="form-group py-2">
              <label>Body</label>
              <!-- Froala WYSIWYG -->
              <froala class="form-control froala" v-model="form.body" name="body" :tag="'textarea'" :class="{ 'is-invalid': form.errors.has('body') }"></froala>
              <has-error :form="form" field="body"></has-error>
            </div>

            <div class="form-group pt-4">
              <button type="submit" class="btn btn-success mr-2" style="width: 200px;">Create Article</button>
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
    methods: {

      uploadMainImage(e) {
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
        if (this.form.image == '') {
          return 'background-image: url(img/default.jpg)';
        }
        return `background-image: url(${this.form.image})`;
      },

      createArticle() {
        this.form.post('api/articles')
        .then(() => {
          Swal.fire({
            position: 'center',
            type: 'success',
            title: 'Your article has been saved',
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
