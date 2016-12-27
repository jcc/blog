<?php

namespace App\Http\Controllers\Api;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use App\Http\Controllers\Controller;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ApiController extends Controller
{
    /**
     * @var int $statusCode
     */
    protected $statusCode = 200;

    const CODE_WRONG_ARGS = 'GEN-FUBARGS';
    const CODE_NOT_FOUND = 'GEN-LIKETHEWIND';
    const CODE_INTERNAL_ERROR = 'GEN-AAAGGH';
    const CODE_UNAUTHORIZED = 'GEN-MAYBGTFO';
    const CODE_FORBIDDEN = 'GEN-GTFO';
    const CODE_INVALID_MIME_TYPE = 'GEN-UMWUT';

    /**
     * @var Manager $fractal
     */
    protected $fractal;

    public function __construct()
    {
        $this->fractal = new Manager;

        if (isset($_GET['include'])) {
            $this->fractal->parseIncludes($_GET['include']);
        }
    }

    /**
     * Get the status code.
     *
     * @return int $statusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the status code.
     *
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Repond a no content response.
     * 
     * @return response
     */
    public function noContent()
    {
        return response()->json(null, 204);
    }

    /**
     * Respond the item data.
     *
     * @param $item
     * @param $callback
     * @return mixed
     */
    public function respondWithItem($item, $callback)
    {
        $resource = new Item($item, $callback);

        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * Respond the collection data.
     *
     * @param $collection
     * @param $callback
     * @return mixed
     */
    public function respondWithCollection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);

        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     *  Respond the collection data with pagination.
     *
     * @param $paginator
     * @param $callback
     * @return mixed
     */
    public function respondWithPaginator($paginator, $callback)
    {
        $resource = new Collection($paginator->getCollection(), $callback);

        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * Respond the data.
     *
     * @param array $array
     * @param array $headers
     * @return mixed
     */
    public function respondWithArray(array $array, array $headers = [])
    {
        return response()->json($array, $this->statusCode, $headers);
    }

    /**
     * Respond the error message.
     * 
     * @param  string $message
     * @param  string $errorCode
     * @return json
     */
    protected function respondWithError($message, $errorCode)
    {
        if ($this->statusCode === 200) {
            trigger_error(
                "You better have a really good reason for erroring on a 200...",
                E_USER_WARNING
            );
        }

        return $this->respondWithArray([
            'error' => [
                'code' => $errorCode,
                'http_code' => $this->statusCode,
                'message' => $message,
            ]
        ]);
    }

    /**
     * Respond the error of 'Forbidden'
     * 
     * @param  string $message
     * @return json
     */
    public function errorForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(500)
                    ->respondWithError($message, self::CODE_FORBIDDEN);
    }

    /**
     * Respond the error of 'Internal Error'.
     * 
     * @param  string $message
     * @return json
     */
    public function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)
                    ->respondWithError($message, self::CODE_INTERNAL_ERROR);
    }

    /**
     * Respond the error of 'Resource Not Found'
     * 
     * @param  string $message
     * @return json
     */
    public function errorNotFound($message = 'Resource Not Found')
    {
        return $this->setStatusCode(404)
                    ->respondWithError($message, self::CODE_NOT_FOUND);
    }

    /**
     * Respond the error of 'Unauthorized'.
     * 
     * @param  string $message
     * @return json
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)
                    ->respondWithError($message, self::CODE_UNAUTHORIZED);
    }

    /**
     * Respond the error of 'Wrong Arguments'.
     * 
     * @param  string $message
     * @return json
     */
    public function errorWrongArgs($message = 'Wrong Arguments')
    {
        return $this->setStatusCode(400)
                    ->respondWithError($message, self::CODE_WRONG_ARGS);
    }
}
