<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Liberfly Documetantion Test",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="duureis@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )

 *
 * @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints de Autenticação"
 * )

 *
 * @OA\Tag(
 *     name="Category",
 *     description="API Endpoints de Categorias"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
