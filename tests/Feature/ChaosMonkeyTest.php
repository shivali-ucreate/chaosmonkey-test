<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\ParentTestClass;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Components\Laraquery as laracomponent;

class ChaosMonkey extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

     

    public function testTrue()
    {
        $this->assertTrue(true);
    }

    public function testFalse()
    {
        $this->assertFalse(false);
    }

    public function testName()
    {

        $this->assertTrue(true);
        $user = ['name'=>'shivali'];
        $this->assertEquals($user,['name'=>'shivali']);
    }
   /*********Generate a select query to select all columns from a table.*********/
    public function testUserAll(){
        $this->assertEquals('select * from products', laracomponent::select(['select'=>'select','table'=>'products','select_output'=>'*','select_from'=>'from'])) ;

    }
    /***********Generate a select query to select specific columns from a table.**************/
    public function testUserSpecificColumns(){
        $this->assertEquals('select id, name from products', laracomponent::select(['select'=>'select','table'=>'products','select_output'=>'id, name','select_from'=>'from'])) ;
    }
    /*******Generate a select query to select specific columns from a table, with order by on a column*******/
    public function testUserSpecificColumnsOrderBy(){
        $this->assertEquals('select id, name from products order by id desc', laracomponent::select(['select'=>'select','table'=>'products','select_output'=>'id, name','order_by_variable'=>'id','order'=>'desc','select_from'=>'from','order_by'=>'order by'])) ;
    }
    /**********Generate a select query to select all columns from table with order by multiple columns**************/
    public function testUserOrderByMultipleColumns(){
        $this->assertEquals('select * from products order by name asc, category asc', laracomponent::select(['select'=>'select','table'=>'products','select_output'=>'*','order_by_variable_first'=>'name','order_by_variable_second'=>'category','order'=>'asc','select_from'=>'from','order_by'=>'order by'])) ;
    }
    /*********Generate a select query to select specific columns from a table, with order by on a column - with capitalized keywords, and correct spacings.*******/
    public function testUserSpecificColumnsOrderByWithCapitalWords(){
        $this->assertEquals('SELECT id, name FROM products ORDER BY id DESC', laracomponent::select(['select'=>'SELECT','table'=>'products','select_output'=>'id, name','select_from'=>'FROM','order_by'=>'ORDER BY','order_by_variable'=>'id','order'=>'DESC'])) ;
    }
    /*****************Generate a query that limits the result from products table to 10******************/
    public function testUserLimit(){
        $this->assertEquals('select * from products limit 10', laracomponent::select(['select'=>'select','table'=>'products','select_output'=>'*','select_from'=>'from','limit'=>'10'])) ;
    }
    /******************Generate a query that limits the result from products table to 6 and offset is 5.*******************/
    public function testUserLimitAndOffset(){
        $this->assertEquals('select * from products limit 6 offset 5', laracomponent::select(['select'=>'select','table'=>'products','select_output'=>'*','select_from'=>'from','limit'=>'6','offset'=>'5'])) ;
    }
    /**********************Generate a select query to get all the columns of table with a count column that give the total number of products*****************/
    public function testUserCount(){
        $this->assertEquals('select *, count("id") from products', laracomponent::selectWithAggregateFunctions(['select'=>'select','table'=>'products','select_output'=>'*','select_from'=>'from','aggr_fun'=>'count','aggr_fun_var'=>'id']));
    }
    /**************Generate a select query to get the product with maximum cost****************/
    public function testUserMaxCost(){
        $this->assertEquals('select max("cost") from products', laracomponent::select(['select'=>'select','table'=>'products','select_output'=>'max("cost")','select_from'=>'from']));
    }
    /************************Generate a select query to get the cost of products with group by**************************************/
    public function testUserMaxProductCost(){
        $this->assertEquals('select max("cost") from products group by cost', laracomponent::select(['select'=>'select','table'=>'products','select_output'=>'max("cost")','select_from'=>'from','group_by'=>'group by','group_by_variable'=>'cost']));
    }
    /**********************Generate a query to get all the unique products in the table*********/
    public function testUserUniqueProducts(){
        $this->assertEquals('select DISTINCT name from products', laracomponent::select(['select'=>'select','table'=>'products','select_output'=>'DISTINCT name','select_from'=>'from']));
    }
    /**********************Generate a query with a table joined with other table*********/
    public function testUsingJoinOnTwoTables(){
        $this->assertEquals('select * from products join categories on products.category_id=categories.id', laracomponent::select(['select'=>'select','table'=>'products','join'=>'join','second_table'=>'categories','first_table_matching_parameter'=>'category_id','second_table_matching_parameter'=>'id','select_output'=>'*','select_from'=>'from']));
    }
    /*********************Generate an insert query to insert a row with name, cost, color*********/
    public function testInsertInTable(){
        $this->assertEquals('INSERT INTO products("id","name","cost","color") VALUES(1,"apple",100,"red")', laracomponent::insert(['insert'=>'INSERT','table'=>'products','into'=>'INTO',"first_variable_name"=>'id',"second_variable_name"=>'name',"third_variable_name"=>'cost',"fourth_variable_name"=>'color',"first_variable_value"=>1,"second_variable_value"=>'apple',"third_variable_value"=>100,"fourth_variable_value"=>'red','values'=>'VALUES']));
    }
    /*****Generate an insert query to insert multiple rows of values with column : name, cost and color.*****/
    public function testInsertInMultipleRows(){
        $this->assertEquals('INSERT INTO products("id","name","cost","color") VALUES(1,"apple",100,"red"),(2,"orange",50,"orange")', laracomponent::insert(['insert'=>'INSERT','table'=>'products','into'=>'INTO',"first_variable_name"=>'id',"second_variable_name"=>'name',"third_variable_name"=>'cost',"fourth_variable_name"=>'color',"first_variable_value"=>1,"second_variable_value"=>'apple',"third_variable_value"=>100,"fourth_variable_value"=>'red','values'=>'VALUES',"second_row_first_variable_value"=>2,"second_row_second_variable_value"=>'orange',"second_row_third_variable_value"=>50,"second_row_fourth_variable_value"=>'orange']));
    }

    /*******Generate an update query to update a row of products with where condition on the name of product*****/
    public function testUpdateRowValues(){
        $this->assertEquals('UPDATE products SET color="black" WHERE color="red"', laracomponent::update(['update'=>'UPDATE','table'=>'products','set'=>'SET',"where"=>'WHERE',"variable_name"=>'color',"old_value"=>'red',"new_value"=>'black']));
    }
    /*******Generate a delete query to delete the product whose name is abc*****/
    public function testDeleteRow(){
        $this->assertEquals('DELETE FROM products WHERE name="abc"', laracomponent::delete(['delete'=>'DELETE','table'=>'products','from'=>'FROM',"where"=>'WHERE',"comparison_variable"=>'name',"comparison_value"=>'abc',"comparison_operator"=>'=']));
    }
    /******Generate a delete query to delete the products whose cost is greater than 500*******/
    public function testDeleteWithCondition(){
        $this->assertEquals('DELETE FROM products WHERE cost>"500"', laracomponent::delete(['delete'=>'DELETE','table'=>'products','from'=>'FROM',"where"=>'WHERE',"comparison_variable"=>'cost',"comparison_operator"=>'>','comparison_value'=>"500"]));
    }
    /********************Generate a delete query to delete all the products***************/
    public function testDelete(){
        $this->assertEquals('DELETE FROM products', laracomponent::delete(['delete'=>'DELETE','table'=>'products','from'=>'FROM']));
    }

}
