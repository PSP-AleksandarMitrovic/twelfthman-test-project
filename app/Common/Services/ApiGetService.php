<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/13/2017
 * Time: 5:26 PM
 */

namespace App\Common\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ApiGetService
 * @package App\Common\Services
 */
abstract class ApiGetService
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Endpoint reserved words
     *
     * @var array
     */
    protected $api_keyword_filters = [
        "count",
        "page",
        "sort",
        "fields",
        "embed"
    ];

    /**
     * Endpoint available operators
     *
     * @var array
     */
    protected $api_operators = [
        "eq"  => "=",
        "ne"  => "!=",
        "gt"  => ">",
        "gte" => ">=",
        "lt"  => "<",
        "lte" => "<="
    ];

    /**
     * Sent endpoint query
     *
     * @var array
     */
    protected $api_query = [];

    /**
     * WHERE SQL filters
     *
     * @var array
     */
    protected $where_filters = [];

    /**
     * Fields for relations
     *
     * @var array
     */
    protected $relation_fields = [];

    /**
     * Fields
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Prepare single entity
     *
     * @param int $id
     * @return ApiGetService
     */
    protected function prepareSingle(int $id) : ApiGetService
    {
        $this->builder
            ->where($this->builder->getModel()->getKeyName(),  $id)
            ->take(1);

        return $this;
    }

    /**
     * Get table name of relation
     *
     * @param string $relation
     * @return string
     */
    protected function getRelationTable(string $relation) : string
    {
        return $this->builder
            ->getModel()
            ->{$relation}()
            ->getRelated()
            ->getTable();
    }

    /**
     * Prepare WHERE SQL filters
     */
    protected function prepareFilters()
    {
        if(count($this->api_query) === 0){
            return;
        }

        // Matched WHERE filters would be all
        // that are not KEYWORDS (count, page, embed...)
        foreach($this->api_query as $column => $value) {
            if(in_array($column, $this->api_keyword_filters)){
                continue;
            }

            $this->where_filters[$column]= $value;
        }
    }

    /**
     * @param array $data
     */
    protected function setApiQuery(array $data) {
        $this->api_query = $data;
    }

    /**
     * Set WHERE constraint on buidler
     *
     * @return ApiGetService
     */
    protected function setWhereFilters() : ApiGetService
    {
        if(count($this->where_filters) === 0){
            return $this;
        }

        // Traverse prepared filters
        foreach($this->where_filters as $column => $value){
            // {column}:{operator} = {value}
            $column_operator = preg_split('/[:\s]+/', $column);

            // Split value by " , "
            $splited_value = preg_split('/[,]+/', $value);

            //... and if {value} is not scalar
            if(count($splited_value) > 1){
                // ... we know that we will have SQL IN operator in WHERE
                $in_operator = true;
            }
            // ... else we are good with simple " = "
            else{
                $in_operator = false;
            }

            // Depending on $in_operator, we know if we are using IN or =
            $this->builder
                ->when($in_operator ,
                    // If it is true, we are using IN
                    function ($query) use($column_operator, $splited_value){
                        if(isset($column_operator[1]) && $column_operator[1] == "eq"){

                            return $query->whereIn($column_operator[0], $splited_value);

                        }elseif(isset($column_operator[1]) && $column_operator[1] == "ne"){

                            return $query->whereNotIn($column_operator[0], $splited_value);

                        }else{

                            return $query->whereIn($column_operator[0], $splited_value);
                        }
                    },
                    // Else, we are using scalar operators...
                    function ($query) use($column_operator, $splited_value) {

                        return $query->where($column_operator[0],
                            ((isset($column_operator[1]) && $column_operator[1] != "") ? $this->api_operators[$column_operator[1]] : "="),
                            $splited_value[0]);
                    });
        }

        return $this;
    }

    /**
     * Prepare SELECT fields
     */
    protected function prepareFields()
    {
        if(!isset($this->api_query['fields'])){
            return;
        }

        // We will have fileds as {column1},{column2},{column3}
        $splited_fields = preg_split('/[,\s]+/', $this->api_query['fields']);

        if(count($splited_fields) === 0)  {
            return;
        }

        foreach($splited_fields as $field)  {
            // If we have dot in our fields
            if(strpos($field, ".") !== false){
                // ... we know that we are using relation fields
                // and that we can split them by dot
                $splited_field = preg_split('/[.\s]+/', $field);

                // {relation}.{field}
                $this->relation_fields[ $splited_field[0] ][]= $this->getRelationTable( $splited_field[0] ).".".$splited_field[1];

            }else{
                // ... else, we are using regular fields
                $this->fields[]= $field;
            }
        }
    }

    /**
     * Set SELECT statement on query
     * 
     * @return ApiGetService
     */
    protected function setSelectFields() : ApiGetService
    {
        if(count($this->fields) === 0){
            return $this;
        }

        $this->builder
            ->select($this->fields);

        return $this;
    }

    /**
     * Load relations
     *
     * @return ApiGetService
     */
    protected function loadRelations() : ApiGetService
    {
        // If we are using relations
        if(isset($this->api_query['embed']))    {
            // If relations are correctly sent -> embed={relation},{relation}
            if(count($relation_loaders = preg_split('/[,\s]+/', $this->api_query['embed'])) == 0){
                return $this;
            }

            // ... build SELECT statement
            $filtered_relations = $this->getFilteredFieldsRelations($relation_loaders);

            // ... and load relations
            $this->builder ->with($filtered_relations);
        }

        return $this;
    }

    /**
     * @param array $relation_loaders
     * @return array
     */
    protected function getFilteredFieldsRelations(array $relation_loaders) : array
    {
        $relations = [];

        // We are traversing through all relations
        foreach($relation_loaders as $relation) {
            // If our relation is not noted as available for that model
            // We will skip that relation
            if(!in_array($relation, $this->builder->getModel()->relationships())){
                continue;
            }

            $relations [$relation]= function($query) use($relation) {
                // And we are binding SELECT fields on each relation
                if(isset($this->relation_fields[$relation])){
                    $query->select($this->relation_fields[$relation]);
                }
            };
        }

        return $relations;
    }

    /**
     * Prepare ORDER BY
     *
     * @return ApiGetService
     */
    protected function setSortFilters() : ApiGetService
    {
        if(!isset($this->api_query['sort'])){
            return $this;
        }

        // If our SORT fields is correctly sent
        if(count(($sort_filters = preg_split('/[,\s]+/', $this->api_query['sort']))) === 0){
            return $this;
        }

        // ... traverse all SORT criterias
        foreach($sort_filters as $sort_criteria){
            $criteria_split = preg_split('/[:\s]+/', $sort_criteria);

            // ... and bind sort criteria to builder
            if($criteria_split[0] && $criteria_split[1]){
                $this->builder
                    ->orderBy($criteria_split[0], $criteria_split[1]);
            }
        }

        return $this;
    }

    /**
     * Get collection data
     *
     * @return LengthAwarePaginator
     */
    protected function getData() : LengthAwarePaginator
    {
        return $this->builder->paginate($this->api_query["count"] ?? config("api.count_per_page"));
    }

    /**
     * Get single entity
     *
     * @return Model
     */
    protected function getSingle() : Model
    {
        return $this->builder->first();
    }
}