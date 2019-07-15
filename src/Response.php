<?php

namespace Matu\Response;

use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Class Response
 * @package App\Support
 */
class Response
{


    /**
     * HTTP Response.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    private $response;

    /**
     * API transformer helper.
     *
     * @var \App\Support\Transform
     */
    public $transform;

    /**
     * HTTP status code.
     *
     * @var int
     */
    private $statusCode = HttpResponse::HTTP_OK;

    /**
     * Create a new class instance.
     *
     * @param $response
     * @param $transform
     */
    public function __construct(ResponseFactory $response, Transform $transform)
    {
        $this->response  = $response;
        $this->transform = $transform;
    }

    /**
     * Return a 201 response with the given created resource.
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function withCreated($message = '请求成功')
    {

        return $this->setStatusCode(
            HttpResponse::HTTP_CREATED
        )->withError($message);

    }

    /**
     * Make a 204 no content response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNoContent()
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_NO_CONTENT
        )->json();
    }

    /**
     * Make a 400 'Bad Request' response.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withBadRequest($message = 'Bad Request')
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_BAD_REQUEST
        )->withError($message);
    }

    /**
     * Make a 401 'Unauthorized' response.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_UNAUTHORIZED
        )->withError($message);
    }

    /**
     * Make a 403 'Forbidden' response.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_FORBIDDEN
        )->withError($message);
    }

    /**
     * Make a 404 'Not Found' response.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_NOT_FOUND
        )->withError($message);
    }

    /**
     * Make a 429 'Too Many Requests' response.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withTooManyRequests($message = 'Too Many Requests')
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_TOO_MANY_REQUESTS
        )->withError($message);
    }

    /**
     * Make a 500 'Internal Server Error' response.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withInternalServer($message = 'Internal Server Error')
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_INTERNAL_SERVER_ERROR
        )->withError($message);
    }

    /**返回 Validator 数据验证，与 Form Request 结构保持一致， http 状态码 422
     *
     * @param array $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function withUnprocessableEntity($message = ['message' => 'Unprocessable Entity'])
    {
        return $this->setStatusCode(
            HttpResponse::HTTP_UNPROCESSABLE_ENTITY
        )->json([
            'errors'  => $message,
            'message' => 'The given data was invalid.'
        ]);
    }

    /**
     * Make an error response.
     *
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withError(string $message)
    {
        return $this->json([
            'message' => $message
        ]);
    }

    /**
     * Make a JSON response with the transformed items.
     *
     * @param $item
     * @param TransformerAbstract|null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function item($item, TransformerAbstract $transformer = null)
    {
        return $this->json(
            $this->transform->item($item, $transformer)
        );
    }

    public function withData($data)
    {
        return $this->json([
            'data' => $data
        ]);
    }

    /**
     * Make a JSON response.
     *
     * @param $items
     * @param TransformerAbstract|null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function collection($items, TransformerAbstract $transformer = null)
    {
        return $this->json(
            $this->transform->collection($items, $transformer)
        );
    }

    /**
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data = [], array $headers = [])
    {
        return $this->response->json($data, $this->statusCode, $headers);
    }

    /**
     * Set HTTP status code.
     *
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Gets the HTTP status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
