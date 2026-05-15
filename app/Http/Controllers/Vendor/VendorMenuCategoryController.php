<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Category\StoreCategoryRequest;
use App\Http\Requests\Vendor\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorMenuCategoryController extends Controller
{
    public function index(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $categories = $restaurant->categories()->orderBy('sort_order')->paginate(30);

        return view('vendor.menu.categories.index', compact('restaurant', 'categories'));
    }

    public function create(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        return view('vendor.menu.categories.create', compact('restaurant'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $data = $request->validated();

        $restaurant->categories()->create([
            'name' => $data['name'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('vendor.menu.categories.index')->with('status', 'Category created.');
    }

    public function edit(Request $request, Category $category): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $category->restaurant_id === (int) $restaurant->getKey(), 404);
        $this->authorize('update', $category);

        return view('vendor.menu.categories.edit', compact('restaurant', 'category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $category->restaurant_id === (int) $restaurant->getKey(), 404);

        $data = $request->validated();

        $category->update([
            'name' => $data['name'],
            'sort_order' => $data['sort_order'] ?? $category->sort_order,
        ]);

        return redirect()->route('vendor.menu.categories.index')->with('status', 'Category updated.');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $category->restaurant_id === (int) $restaurant->getKey(), 404);
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()->route('vendor.menu.categories.index')->with('status', 'Category deleted.');
    }
}
