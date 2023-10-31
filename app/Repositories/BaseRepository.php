<?php

namespace App\Repositories;

use App\Traits\DTOToArray;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    use DTOToArray;

    protected $model;
    /**
     * @var array
     */
    // const PER_PAGE = 50;

    protected $wheres = [];
    protected $whereIns = [];
    protected $whereNots = [];
    protected $whereLikes = [];
    protected $orderBys = [];
    protected $orWhereLikes = [];
    protected $whereRelation = [];
    protected $latest = false;
    protected $relations = [];
    protected $uuidColumn = 'unique_id';

    public function __construct()
    {
        $this->attachModel();
    }

    public function attachModel()
    {
        $this->model = app()->make($this->model());
    }

    abstract public function model();

    public function all()
    {
        return $this->model::all();
    }

    public function allOrdered($column, $order)
    {
        return $this->model::orderBy($column, $order)->get();
    }

    public function create($data)
    {
        return $this->model->create($this->toArray($data));
    }

    public function exist($column, $data): bool
    {
        return $this->model->where($column, $data)->exists();
    }

    public function first($column, $data)
    {
        return $this->model->where($column, $data)->first();
    }

    public function get($column, $data, $fieldsToFetch = ['*'], $chronological = false)
    {
        $query = $this->model->where($column, $data);

        if ($chronological) {
            $query = $query->orderBy('created_at', 'desc');
        }

        return $query->get($fieldsToFetch);
    }

    public function firstWithRelation($column, $data, $models = [])
    {
        return $this->model->where($column, $data)->with($models)->first();
    }

    public function getWithRelation($column, $data, $models = [], $chronological = false)
    {
        $query = $this->model->where($column, $data)->with($models);

        if ($chronological) {
            $query = $query->orderBy('created_at', 'desc');
        }

        return $query->paginate();
    }

    public function firstLike($column, $data)
    {
        return $this->model->where($column, 'like', "%$data%")->first();
    }

    public function manyLike($column, $data)
    {
        return $this->model->where($column, 'like', "%$data%")->get();
    }

    public function getMany($column, array $data)
    {
        return $this->model->whereIn($column, $data)->get();
    }

    public function getWithTrashed($column, $data)
    {
        return $this->model->where($column, $data)->withTrashed()->get();
    }

    public function getManyWithTrashed($column, array $data)
    {
        return $this->model->whereIn($column, $data)->withTrashed()->get();
    }

    public function deleteById($id)
    {
        $model = $this->model::find($id);

        return $model->delete();
    }

    public function delete(Model $model)
    {
        $model->deleteOrFail();
    }

    public function update($column, $value, $data)
    {
        return $this->model->where($column, $value)->update($data);
    }

    public function updateOrCreate($condition, $data)
    {
        return $this->model->updateOrCreate($condition, $data);
    }

    public function updateById($id, $updateData)
    {
        $model = $this->model::find($id);

        $model->update($updateData);

        return $model->fresh();
    }

    public function updateByUuid(string $uuid, $updateData)
    {
        $model = $this->model::where([$this->uuidColumn => $uuid])->first();

        if ($model) {
            $model->update($updateData);

            return $model;
        }

        return false;
    }

    public function toArray($data)
    {
        return (array) $data;
    }
}
