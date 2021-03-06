<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\BaseController;
use App\Models\Movie\Movie;
use Exception;
use Illuminate\Http\Request;
use View;

class SearchMovieController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        View::share('hots', Movie::hot()->take(8)->get());
        View::share('news', Movie::newUpdated()->take(6)->get());
    }

    public function simpleSearch(Request $request)
    {
        $movies = Movie::query();
        if ($request->query('query')) {
            $movies->where('name', 'like', '%' . $request->query('query') . '%');
        }
        if ($request->query('category')) {
            $movies->where('movie_category_id', $request->query('category'));
        }
        if ($request->query('language')) {
            $movies->where('movie_language_id', $request->query('language'));
        }
        if ($request->query('nation')) {
            $movies->where('movie_nation_id', $request->query('nation'));
        }
        if ($request->query('date_range')) {
            try {
                $dates = explode('to', $request->query('date_range'));
                $startDate = strtotime(trim($dates[0]));
                $endDate = strtotime(trim($dates[1]));
                $movies->where('release_date', '>=', date('Y-m-d', $startDate));
                $movies->where('release_date', '<=', date('Y-m-d', $endDate));
            } catch (Exception $ignored) {
            }
        }

        if ($request->query('genre')) {
            $movies->whereHas('genres', function ($genres) use ($request) {
                $genres->where('id', $request->get('genre'));
            });
        }

        return view('home.search-movie', [
            'movies' => $movies->toPage(24)
        ]);
    }

    public function typeSearch(Request $request)
    {
        try {
            $movies = Movie::whereHas($request->query('type'), function ($type) use ($request) {
                $type->where('id', $request->query('id'));
            });
        } catch (Exception $e) {
            return abort(404);
        }

        return view('home.subtype', [
            'movies' => $movies->toPage(24),
        ]);
    }
}
