<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Tour;
use App\Models\Article;
use App\Models\Comment;

class HomeController extends Controller
{
    //
    public function index()
    {
        $locations = Location::with('tours')->active()->get();
        $articles = Article::orderBy('id')->limit(NUMBER_PAGINATION_PAGE)->get();
        $tours = Tour::orderBy('id')->limit(NUMBER_PAGINATION_PAGE)->get();
        $comments = Comment::with('user')->where('cm_status', 2)->limit(10)->get();
        $viewData = [
            'locations' => $locations,
            'articles' => $articles,
            'tours' => $tours,
            'comments' => $comments
        ];
        return view('page.home.index', $viewData);
    }

    public function contact()
    {
        return view('page.contact.index');
    }

    public function about()
    {
        $comments = Comment::with('user')->where('cm_status', 2)->limit(10)->get();
        return view('page.about.index', compact('comments'));
    }

    public function transport()
    {
        return view('page.transport.index');
    }

    public function changeReturn()
    {
        return view('page.return.index');
    }

    public function security()
    {
        return view('page.security.index');
    }
}
