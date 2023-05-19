<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->when($request->has('q') && $request->get('q') != '', function (Builder $builder) use ($request) {
                $builder->whereFullText('name', $request->get('q'));
//                $builder->where('name', 'LIKE', "%{$request->get('q')}%");
                // TODO: Fica aqui dependendo da estratégia a tomada de decisão
            })
            ->userAuth(auth()->id())
            ->paginate(10)
            ->withQueryString();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $category = new Category;
        $category->fill($request->all());
        $category->save();

        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            response()->json(['message' => 'not found'], 404);
        }
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            response()->json(['message' => 'not found'], 404);
        }

        $request->validate([
            'name' => ['required'],
        ]);

        $category->fill($request->all());
        $category->save();

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([], 204);
    }
}
