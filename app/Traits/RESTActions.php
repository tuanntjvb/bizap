<?php

namespace App\Traits;

use App\Repositories\Contracts\IBaseRepository;
use App\Services\Contracts\IBaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\TransformerAbstract;

trait RESTActions
{
    /**
     * @var IBaseRepository
     */
    protected $repository;

    /**
     * @var TransformerAbstract
     */
    protected $transformer;

    /**
     * @var IBaseService
     */
    protected $service;

    //get
    public function all()
    {
        $list = $this->repository->findBy([], true);
        return $this->respondTransformer($list);
    }

    //get
    public function show($id)
    {
        $model = $this->repository->findOne($id);
        return $this->respondTransformer($model);
    }

    //post
    public function store(Request $request)
    {
        $model = $this->repository->save($request->all());
        return $this->respondTransformer($model);
    }

    //put
    public function update(Request $request, $id)
    {
        $model = $this->repository->findOne($id);
        if (is_null($model)) {
            return $this->respondNotfound();
        }
        $model = $this->repository->update($model, $request->all());
        return $this->respondTransformer($model);
    }

    //delete
    public function destroy($id)
    {
        $model = $this->repository->findOne($id);
        if (is_null($model)) {
            return $this->respondNotfound();
        }
        $this->repository->delete($model);
        return $this->respond([
            MESSAGE => 'Success',
            'code' => 200
        ], Response::HTTP_OK);
    }

    protected function respond($data = [], $status = Response::HTTP_OK, $message = '')
    {
        return self::respondFinal($message, $status, $data);
    }

    protected function respondTransformer($data, $transformer = null)
    {
        if (!empty($transformer)) {
            return $this->respond($this->transformer($data, $transformer));
        }
        return $this->respond($this->transformer($data, $this->transformer));
    }


    /**
     * @param Model|array $model
     * @param TransformerAbstract $transformer
     * @return array
     */
    protected function transformer($model, TransformerAbstract $transformer)
    {
        $ref = new \ReflectionClass($transformer);
        $resourceName = strtolower(str_replace('Transformer', '', $ref->getShortName()));
        //cannot replace data to resource name???
        $data_transform = fractal($model, $transformer)->withResourceName($resourceName)->toArray();
        if (isset($data_transform['data']) && isset($data_transform['data'][0])) {
            $data_transform[str_plural($resourceName)] = $data_transform['data'];
            unset($data_transform['data']);
        }
        if ($model instanceof Model) {
            $data_transform[$resourceName] = $data_transform['data'];
            unset($data_transform['data']);
        }
        return $data_transform;
    }

    protected function respondFail($message = '', $errors = null, $status = Response::HTTP_BAD_REQUEST)
    {
        return self::respondFinal($message, $status, null, $errors);
    }


    protected function respondAuthFail($message = '', $status = Response::HTTP_UNAUTHORIZED)
    {
        return self::respondFinal($message, $status);
    }

    protected function respondNotfound($message = '', $status = Response::HTTP_NOT_FOUND)
    {
        return self::respondFinal($message, $status);
    }

    protected function respondDBFail($message = '', $status = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return self::respondFinal($message, $status);
    }

    protected function respondFrameworkException($httpCode, $requestCode, $message = '', $data = [])
    {
        $data_response = [
            MESSAGE => $message,
            'code' => $requestCode,
            'data' => $data
        ];
        return response()->json($data_response, $httpCode);
    }

    private function respondFinal($message, $status, $data = null, $errors = null)
    {
        $data_response = [
            MESSAGE => $message ?: Response::$statusTexts[$status],
            'code' => $status,
            'data' => $data
        ];
        if ($errors) {
            $data_response['errors'] = $errors;
        }
        return response()->json($data_response, $status);
    }

}
