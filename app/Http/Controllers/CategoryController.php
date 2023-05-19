<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     * path="/categories",
     * summary="Get and search Categories",
     * description="Get Categories",
     * operationId="indexCategories",
     * tags={"Category"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(
     * name="q",
     * in="query",
     * description="Buscar por Categoria",
     * required=false,
     * ),
     * @OA\Parameter(
     * name="page",
     * in="query",
     * description="Trocar de pagina",
     * required=false,
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Ok",
     *    @OA\JsonContent(
     *      type="object",
     *       @OA\Property(property="page", type="int64", example="1"),
     *       @OA\Property(property="data", type="array",
     *     @OA\Items(
     *       @OA\Property(property="id", type="string", example="bccddf99-6447-4a18-82a3-720551a4a28a"),
     *       @OA\Property(property="user_id", type="string", example="aaaddf99-6447-4a48-82a3-720tt1a4a28a"),
     *       @OA\Property(property="name", type="string", example="MyCategory"),
     *       @OA\Property(property="created_at", type="string", example="2023-05-19 18:59:18"),
     *       @OA\Property(property="updated_at", type="string", example="2023-05-19 18:59:18"),
     *        ),
     *        ),
     *       @OA\Property(property="first_page_url", type="string", example="http://127.0.0.1:8001/api/categories?page=1"),
     *       @OA\Property(property="from", type="int64", example="1"),
     *       @OA\Property(property="last_page", type="int64", example="2"),
     *       @OA\Property(property="last_page_url", type="string", example="http://127.0.0.1:8001/api/categories?page=1"),
     *       @OA\Property(property="links", type="array",
     *          @OA\Items( type="object",
     *       @OA\Property(property="url", type="string", example="null"),
     *       @OA\Property(property="label", type="string", example="pagination.previous"),
     *       @OA\Property(property="active", type="boolean", example=false),
     *        ),
     *          @OA\Items( type="object",
     *       @OA\Property(property="url", type="string", example="null"),
     *       @OA\Property(property="label", type="string", example="pagination.previous"),
     *       @OA\Property(property="active", type="boolean", example=false),
     *        ),
     *          @OA\Items( type="object",
     *       @OA\Property(property="url", type="string", example="null"),
     *       @OA\Property(property="label", type="string", example="pagination.previous"),
     *       @OA\Property(property="active", type="boolean", example=false),
     *        ),
     *          @OA\Items( type="object",
     *       @OA\Property(property="url", type="string", example="null"),
     *       @OA\Property(property="label", type="string", example="pagination.previous"),
     *       @OA\Property(property="active", type="boolean", example=false),
     *        ),
     *        ),
     *       @OA\Property(property="next_page_url", type="string", example="http://127.0.0.1:8001/api/categories?page=2"),
     *       @OA\Property(property="path", type="string", example="http://127.0.0.1:8001/api/categories"),
     *       @OA\Property(property="per_page", type="int64", example="10"),
     *       @OA\Property(property="prev_page_url", type="string", example="null"),
     *       @OA\Property(property="to", type="int64", example="10"),
     *       @OA\Property(property="total", type="int64", example="11"),
     * ),
     *     )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     * path="/categories",
     * summary="Cadastrar uma categoria",
     * description="Cadastrar uma categoria",
     * operationId="storeCategory",
     * tags={"Category"},
     * security={{"sanctum":{}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="Cadastrar uma categoria",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", format="name", example="categoria"),
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Ok",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="string", example="bccddf99-6447-4a18-82a3-720551a4a28a"),
     *       @OA\Property(property="user_id", type="string", example="aaaddf99-6447-4a48-82a3-720tt1a4a28a"),
     *       @OA\Property(property="name", type="string", example="MyCategory"),
     *       @OA\Property(property="created_at", type="string", example="2023-05-19 18:59:18"),
     *       @OA\Property(property="updated_at", type="string", example="2023-05-19 18:59:18"),
     *        )
     *     )
     * )
     */

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

    /**
     * @OA\Get(
     * path="/categories/{id}",
     * summary="Exibir uma categoria",
     * description="Exibir uma categoria",
     * operationId="showCategory",
     * tags={"Category"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(
     *    name="id",
     *    in="query",
     *    description="Buscar por id",
     *    required=true,
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Ok",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="string", example="bccddf99-6447-4a18-82a3-720551a4a28a"),
     *       @OA\Property(property="user_id", type="string", example="aaaddf99-6447-4a48-82a3-720tt1a4a28a"),
     *       @OA\Property(property="name", type="string", example="MyCategory"),
     *       @OA\Property(property="created_at", type="string", example="2023-05-19 18:59:18"),
     *       @OA\Property(property="updated_at", type="string", example="2023-05-19 18:59:18"),
     *        )
     *     )
     * )
     */
    public function show(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            response()->json(['message' => 'not found'], 404);
        }
        return response()->json($category);
    }

    /**
     * @OA\Put(
     * path="/categories/{id}",
     * summary="Editar uma categoria",
     * description="Editar uma categoria",
     * operationId="updateCategory",
     * tags={"Category"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(
     *    name="id",
     *    in="query",
     *    description="Buscar por id",
     *    required=true,
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Editar uma categoria",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", format="name", example="categoria"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Ok",
     *    @OA\JsonContent(
     *      @OA\Property(property="id", type="string", example="bccddf99-6447-4a18-82a3-720551a4a28a"),
     *      @OA\Property(property="user_id", type="string", example="aaaddf99-6447-4a48-82a3-720tt1a4a28a"),
     *      @OA\Property(property="name", type="string", example="MyCategory"),
     *      @OA\Property(property="created_at", type="string", example="2023-05-19 18:59:18"),
     *      @OA\Property(property="updated_at", type="string", example="2023-05-19 18:59:18"),
     *      )
     *   )
     * )
     */
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

    /**
     * @OA\Delete(
     * path="/categories/{id}",
     * summary="Deletar uma categoria",
     * description="Deletar uma categoria",
     * operationId="destroyCategory",
     * tags={"Category"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(
     *    name="id",
     *    in="query",
     *    description="Buscar por id",
     *    required=true,
     * ),
     * @OA\Response(
     *    response=204,
     *    description="No content",
     * )
     * )
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([], 204);
    }
}
