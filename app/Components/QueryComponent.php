<?php

namespace App\Components;

class QueryComponent
{
	public static function select($array){

		if(isset($array['select']) && $array['select_output']!=null) {
			$query = $array['select']." ".$array['select_output']." ".$array['select_from']." ".$array['table'];
		}
		if(isset($array['order_by_variable']) && isset($array['order'])){
			$query .= " ".$array['order_by']." ".$array['order_by_variable']." ".$array['order'];
		}
		if(isset($array['order_by_variable_first']) && isset($array['order'])){
			$query .= " ".$array['order_by']." ".$array['order_by_variable_first']." ".$array['order'];
		}
		if(isset($array['order_by_variable_second'])){
			$query .= ", ".$array['order_by_variable_second']." ".$array['order'];
		}

		if(isset($array['limit'])){
			$query .= " limit ".$array['limit'];
		}

		if(isset($array['offset'])){
			$query .= " offset ".$array['offset'];
		}
		if(isset($array['group_by']) && isset($array['group_by_variable'])){
              $query .= " ".$array['group_by']." ".$array['group_by_variable'];
		}
		if(isset($array['join']) && isset($array['second_table']) && isset($array['first_table_matching_parameter']) && isset($array['second_table_matching_parameter'])){
			  $query .= " ".$array['join']." ".$array['second_table']." on ".$array['table'].".".$array['first_table_matching_parameter']."=".$array['second_table'].".".$array['second_table_matching_parameter'];
		}
        
        return $query;


    }

    public static function selectWithAggregateFunctions($array){
    	if(isset($array['select']) && isset($array['aggr_fun']) && isset($array['aggr_fun_var']) && $array['select_output']!=null) {
			 $query = $array['select']." ".$array['select_output'].", ".$array['aggr_fun'].'("'.$array['aggr_fun_var'].'") '.$array['select_from']." ".$array['table'];
		}
		return $query;
    }
    
    public static function insert($array){
    	if(isset($array['insert']) && isset($array['first_variable_name'])) {
			 $query = $array['insert']." ".$array['into']." ".$array['table'].'("'.$array['first_variable_name'].'","'.$array['second_variable_name'].'","'.$array['third_variable_name'].'","'.$array['fourth_variable_name'].'") '.$array['values'].'('.$array['first_variable_value'].',"'.$array['second_variable_value'].'",'.$array['third_variable_value'].',"'.$array['fourth_variable_value'].'")';
		}
		if(isset($array['second_row_first_variable_value'])){
			$query .= ',('.$array['second_row_first_variable_value'].',"'.$array['second_row_second_variable_value'].'",'.$array['second_row_third_variable_value'].',"'.$array['second_row_fourth_variable_value'].'")';
		}

		return $query;
    }

    public static function update($array){
    	if(isset($array['update'])) {
			 $query = $array['update'].' '.$array['table'].' '.$array['set'].' '.$array['variable_name'].'="'.$array['new_value'].'" ' .$array['where']. ' '.$array['variable_name'].'="'.$array['old_value'].'"';
		}

		return $query;
    }

    public static function delete($array){
    	if(isset($array['delete'])) {
			 $query = $array['delete'].' '.$array['from'].' '.$array['table'];
		}
		if(isset($array['where'])){
			$query .= ' '.$array['where']. ' '.$array['comparison_variable'].$array['comparison_operator'].'"'.$array['comparison_value'].'"';
		}
		return $query;
    }
		
}