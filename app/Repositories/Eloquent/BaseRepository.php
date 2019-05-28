<?php

namespace App\Repositories\Eloquent;

use App\Contracts\CriteriaInterface;
use App\Contracts\RepositoryCriteriaInterface;
use App\Contracts\RepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository as PrettusRepository;

/**
 * Class BaseRepository.
 */
abstract class BaseRepository extends PrettusRepository implements RepositoryInterface, RepositoryCriteriaInterface
{

    /**
     * Apply criteria in current Query
     *
     * @return $this
     */
    protected function applyCriteria()
    {

        if ($this->skipCriteria === true) {
            return $this;
        }

        $criteria = $this->getCriteria();

        if ($criteria) {

            foreach ($criteria as $c) {

                if ($c instanceof CriteriaInterface) {
                    $this->model = $c->apply($this->model, $this);
                }

            }

        }

        return $this;
    }

    /**
     * Push Criteria for filter the query
     *
     * @param $criteria
     *
     * @return $this
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function pushCriteria($criteria)
    {

        if (is_string($criteria)) {
            $criteria = new $criteria;
        }

        if (!$criteria instanceof CriteriaInterface) {
            throw new RepositoryException("Class " . get_class($criteria) . " must be an instance of Litepie\\Repository\\Contracts\\CriteriaInterface");
        }

        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * Retrieve count of records.
     *
     *
     * @return mixed
     */
    public function count()
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->count();

        $this->resetModel();
        return $results;
    }

    /**
     * Find data by id or return new if not exists.
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function findOrNew($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->findOrNew($id, $columns);
        $this->resetModel();
        return $this->parserResult($model);
    }

    /**
     * Create a new instance of the model.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function newInstance(array $attributes)
    {
        $model = $this->model->newInstance($attributes);
        $this->resetModel();
        return $this->parserResult($model);
    }

    /**
     * Return data for datatable
     *
     * @param $limit
     * @return     array  array.
     */
    public function getDataTable($limit = "{config('app.limit')}")
    {
        $data = $this->paginate($limit);

        $data['recordsTotal']    = $data['meta']['pagination']['total'];
        $data['recordsFiltered'] = $data['meta']['pagination']['total'];
        $data['request']         = request()->all();
        return $data;
    }

    /**
     * Return data for bootstraptable
     *
     *
     * @return     array.
     */
    public function getBootstrapTable()
    {
        $data = $this->paginate();

        $data['total'] = count($data['data']);
        $data['rows']  = $data['data'];
        $data['request'] = request()->all();
        return $data;
    }

    /**
     * Delete multiple records.
     *
     * @param      array  $ids    The identifiers
     *
     * @return     result
     */
    public function delete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * Permanetly delete multiple records.
     *
     * @param      array  $ids    The identifiers
     *
     * @return     result
     */
    public function purge($ids)
    {
        return $this->model->onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }

    public function forceDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->forceDelete();
    }

    /**
     * Restore multiple records
     *
     * @param      array  $ids    The identifiers
     *
     * @return     result  retn result for the restore
     */
    public function restore($ids)
    {
        return $this->model->onlyTrashed()->whereIn('id', $ids)->update(['deleted_at' => null]);
    }

    /**
     * Change status of the records
     *
     * @param      string  $status  The status
     * @param      array  $ids     The identifiers
     *
     * @return     result  Result for the multiple updation
     */
    public function changeStatus($status, $ids)
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $status]);
    }

    /**
     * Select multiple records
     *
     * @param      array  $ids    The identifiers
     *
     * @return     Collection  Return eloquesnt collection
     */
    public function findIds($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * Find data by slug.
     *
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBySlug($value = null, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->whereSlug($value)->first($columns);
        $this->resetModel();
        return $this->parserResult($model);
    }

    /**
     * Find data by slug.
     *
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function toSql()
    {
        $this->applyCriteria();
        $this->applyScope();
        return $this->model->toSql();
    }
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        $this->model = $this->model->where($column, $operator = null, $value = null, $boolean = 'and');

        return $this;
    }
/*
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        // If the column is an array, we will assume it is an array of key-value pairs
        // and can add them each as a where clause. We will maintain the boolean we
        // received when the method was called and pass it into the nested where.
        if (is_array($column)) {
            return $this->addArrayOfWheres($column, $boolean);
        }

        // Here we will make some assumptions about the operator. If only 2 values are
        // passed to the method, we will assume that the operator is an equals sign
        // and keep going. Otherwise, we'll require the operator to be passed in.
        list($value, $operator) = $this->prepareValueAndOperator(
            $value, $operator, func_num_args() == 2
        );

        // If the columns is actually a Closure instance, we will assume the developer
        // wants to begin a nested where statement which is wrapped in parenthesis.
        // We'll add that Closure to the query then return back out immediately.
        if ($column instanceof Closure) {
            return $this->whereNested($column, $boolean);
        }

        // If the given operator is not found in the list of valid operators we will
        // assume that the developer is just short-cutting the '=' operators and
        // we will set the operators to '=' and set the values appropriately.
        if ($this->invalidOperator($operator)) {
            list($value, $operator) = [$operator, '='];
        }

        // If the value is a Closure, it means the developer is performing an entire
        // sub-select within the query and we will need to compile the sub-select
        // within the where clause to get the appropriate query record results.
        if ($value instanceof Closure) {
            return $this->whereSub($column, $operator, $value, $boolean);
        }

        // If the value is "null", we will just assume the developer wants to add a
        // where null clause to the query. So, we will allow a short-cut here to
        // that method for convenience so the developer doesn't have to check.
        if (is_null($value)) {
            return $this->whereNull($column, $boolean, $operator !== '=');
        }

        // If the column is making a JSON reference we'll check to see if the value
        // is a boolean. If it is, we'll add the raw boolean string as an actual
        // value to the query to ensure this is properly handled by the query.
        if (Str::contains($column, '->') && is_bool($value)) {
            $value = new Expression($value ? 'true' : 'false');
        }

        // Now that we are working with just a simple query we can put the elements
        // in our array and add the query binding to our array of bindings that
        // will be bound to each SQL statements when it is finally executed.
        $type = 'Basic';

        $this->wheres[] = compact(
            'type', 'column', 'operator', 'value', 'boolean'
        );

        if (! $value instanceof Expression) {
            $this->addBinding($value, 'where');
        }

        return $this;
    }
*/
    public function whereIn($field,$values)
    {
        $this->model = $this->model->whereIn($field, $values);
        return $this;
    }
    public function limit($count=10)
    {
        $this->model = $this->model->limit($count);
        return $this;
    }
}
