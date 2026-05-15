<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HubFavoriteController extends Controller
{
    public function index(Request $request): View
    {
        $favorites = $request->user()
            ->favorites()
            ->with(['product.restaurant'])
            ->whereHas('product')
            ->orderByDesc('id')
            ->paginate(16);

        return view('account.favorites.index', compact('favorites'));
    }
}
