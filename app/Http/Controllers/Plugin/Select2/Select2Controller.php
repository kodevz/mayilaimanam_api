<?php

namespace App\Http\Controllers\Plugin\Select2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Select2Builder;
use Illuminate\Support\Carbon;

class Select2Controller extends Controller
{
    protected $request;

    /**
     * Filter of column values
     *
     * @var array
     */
    protected $filters;

    /**
     * Custom filter of column values
     *
     * @var array
     */
    protected $customFilters;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->filters = \Request::input('filters');

        $this->customFilters = \Request::input('customFilters');
    }


    /**
     * Build Select2
     *
     * @return void
     */
    public function buildSelect2()
    {
        
        $select2 = new Select2Builder();
        
        @list($connection, $table) = explode(".",$this->request['table']);

        
        if($table) {
            $select2->setConnection($connection);
        }else{
            $table = $connection;
        }

        $select2->setTable($table);

        if(isset($this->request['enumValue']) && $this->request['enumValue'])
        {
           return $this->enumValue();
        }
        
        $select2 = $select2->select(DB::raw( $this->request['value'] . " as value, IFNULL(" . $this->request['label'] .", 'Empty')  as label"));
        //$select2 = $this->checkConditinal($select2);

        $select2 = $this->multiColumnFilters($select2);

        $select2 = $this->customKeyFilters($select2);

        $select2 =  $select2->groupBy($this->request['label']);

        if($this->request['orderby'] != NULL)
        {  
            $column = $this->request['value'];
            $orderBy = $this->request['orderby'];

            if(\Request::has('datatype')) 
            {
                if($this->request['datatype'] == 'date')
                {
                    $sql = "STR_TO_DATE( $column, '%d-%m-%Y') DESC";
                    $select2 =  $select2->orderByRaw($sql);
                }
                if($this->request['datatype'] == 'int')
                {
                    $sql = "CAST( $column AS UNSIGNED) DESC";
                    $select2 =  $select2->orderByRaw($sql);
                }
            }
            else
            {
                $select2 =  $select2->orderBy($this->request['value'], $this->request['orderby']);
            }
            
        }
        
        //return $select2->toSql();
        $select2 =  $select2->get()->toArray();

        
       // exit;
        return $select2;
    }

    /**
     * Get enum column values
     *
     * @return void
     */
    public function enumValue() 
    {
        
        $table = $this->request['table'];

        $field =  $this->request['value'];

        $statement = DB::select("SHOW COLUMNS FROM `$table` LIKE '$field'");

        preg_match('/^enum\((.*)\)$/', $statement[0]->Type, $matches);

        $enum = array();
        if (empty($matches))
            return null;

        foreach (explode(',', $matches[1]) as $key => $value) 
        {
            $v = trim($value, "'");
            
            $enum[$key] = array(
                'label' => $v,
                'value' => $v
            );
        }

        return $enum;
       
    
    }

    /**
     * check if input of request has conditional
     *
     * @return void
     */
    public function multiColumnFilters($items)
    {
        if($this->filters)
        {
            $filters = collect($this->filters)->forget('global')->toArray();
           
            if($filters)
            {
                $items->where(function($query) use ($filters){

                    foreach($filters as $key => $row)
                    {
                       
                        if($row['matchMode'] == 'in')
                        {
                            $query->whereIn($key, $row['value']);
                        }
                        else if($row['matchMode'] == 'dateRange')
                        {
                            if($row['value'][1])
                            { 
                                $row['value'][1] = Carbon::parse($row['value'][1])->addDay()->format('Y-m-d');

                                $query->whereBetween($key, $row['value']); 
                            }
                            else
                            { 
                                $query->whereDate($key,'=',Carbon::parse($row['value'][0])->addDay()->format('Y-m-d')); 
                            }
                        }
                        else
                        {
                            $query->where($key,'like',$row['value']);
                        }
                    }

                    return $query;

                });
            } 
        }

        if(\Request::has('projectIdSearch'))
        {
            if(!$this->request['projectIdSearch'])
            {
                return $items;
            }
        }
        
        if(\Request::has('projectId') ) 
        {
            $item = $items->where('project_id', NULL);
            $items = $items->orWhere('project_id', $this->request['projectId']);
        }  
        

        return $items;
        
        

        



      
       
    }

    /**
     * Check custom filter options
     *
     * @param array $items
     * @return \Illuminate\Database\Eloquent\Builder $items
     */
    protected function customKeyFilters($items)
    {
        if($this->customFilters)
        {   
            $filters = $this->customFilters;

            if(count($filters))
            {
                $items->where(function($query) use ($filters){

                    foreach($filters as $key => $row)
                    {
                        $query->whereIn($key, $row['value']); 
                    }

                    return $query;

                });
            } 
        }
        

        return $items;
    }

}