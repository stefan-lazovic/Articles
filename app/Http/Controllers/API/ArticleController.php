<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\User;

class ArticleController extends Controller
{



    public function __construct() {
      $this->middleware('auth:api', ['except' => ['getAllArticles', 'getAllUsers']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        // now we have access to user's articles from 'articles' table thanks to 'hasMany' Eloquent relationship
        return $user->paginateArticles();
    }



    public function getUser()
    {
      return auth()->user();
    }



    public function getAllArticles()
    {
        return Article::orderBy('created_at', 'desc')->get();
    }



    public function getAllUsers()
    {
        return User::orderBy('created_at', 'desc')->get();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // you should not be able to submit the article form without filling these fields
        $this->validate($request, [
          'title' => 'required',
          'body' => 'required'
        ]);

        // create article
        $article = new Article;

        if ($request->image) {
          // name example: 1553349468.png
          $name = time() . '.' . explode('/', explode(';', $request->image)[0])[1];
          // http://image.intervention.io - it takes a base64 string and converts back into an image
          \Image::make($request->image)->save(public_path('./img/main/') . $name);
          $article->image = $name; // the custom name we created above with time() function
        }

        $article->title = $request->input('title');
        $article->body = $request->input('body');
        $article->user_id = auth()->user()->id;
        $article->save();
    }



    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // you should not be able to update the article form without filling these fields
        $this->validate($request, [
          'title' => 'required',
          'body' => 'required'
        ]);

        // update the existing article
        $article = Article::find($id);

        $currentImage = $article->image;

        if ($request->image != $currentImage) {
          // name example: 1553349468.png
          $name = time() . '.' . explode('/', explode(';', $request->image)[0])[1];
          // http://image.intervention.io - it takes a base64 string and converts back into an image
          \Image::make($request->image)->save(public_path('./img/main/') . $name);
          $article->image = $name; // the custom name we created above with time() function

          // delete an old image during uploading the new
          $articleImage = public_path('./img/main/') . $currentImage;
          if (file_exists($articleImage)) {
            // unlink() function deletes a file
            unlink($articleImage);
          }
        }

        $article->title = $request->input('title');
        $article->body = $request->input('body');
        $article->user_id = auth()->user()->id;
        $article->save();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        // delete an article image if we delete the article
        $currentImage = $article->image;
        $articleImage = public_path('./img/main/') . $currentImage;
        if (file_exists($articleImage)) {
          // unlink() function deletes a file
          unlink($articleImage);
        }
        $article->delete();
    }
}
