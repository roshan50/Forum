<?php
/**
 * Created by PhpStorm.
 * User: roshan
 * Date: 1/12/18
 * Time: 9:05 PM
 */

namespace App\Filters;
use Illuminate\Http\Request;
use function method_exists;

abstract class Filters
{
    protected $request,$builder;
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value){
            if(method_exists($this, $filter)){
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilters()
    {
        return array_filter($this->request->only($this->filters));
    }

    /**
     * @param $filter
     * @return bool
     */

}