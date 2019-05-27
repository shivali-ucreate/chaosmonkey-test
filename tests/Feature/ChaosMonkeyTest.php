<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\ParentTestClass;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Components\QueryComponent;

class ChaosMonkeyTest extends TestCase
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
    public function testProduct(){
        $this->assertEquals('select * from products', QueryComponent::select(['select'=>'select','table'=>'products','select_output'=>'*','select_from'=>'from'])) ;

    }

    /***********Generate a select query to select specific columns from a table.**************/
    public function testProductSpecificColumns(){
        $this->assertEquals('select id, name from products', QueryComponent::select(['select'=>'select','table'=>'products','select_output'=>'id, name','select_from'=>'from'])) ;
    }

    /*******Generate a select query to select specific columns from a table, with order by on a column*******/
    public function testProductSpecificColumnsOrderBy(){
        $this->assertEquals('select id, name from products order by id desc', QueryComponent::select(['select'=>'select','table'=>'products','select_output'=>'id, name','order_by_variable'=>'id','order'=>'desc','select_from'=>'from','order_by'=>'order by'])) ;
    }

    /**********Generate a select query to select all columns from table with order by multiple columns**************/
    public function testProductOrderByMultipleColumns(){
        $this->assertEquals('select * from products order by name asc, category asc', QueryComponent::select(['select'=>'select','table'=>'products','select_output'=>'*','order_by_variable_first'=>'name','order_by_variable_second'=>'category','order'=>'asc','select_from'=>'from','order_by'=>'order by'])) ;
    }

    /*********Generate a select query to select specific columns from a table, with order by on a column - with capitalized keywords, and correct spacings.*******/
    public function testProductSpecificColumnsOrderByWithCapitalWords(){
        $this->assertEquals('SELECT id, name FROM products ORDER BY id DESC', QueryComponent::select(['select'=>'SELECT','table'=>'products','select_output'=>'id, name','select_from'=>'FROM','order_by'=>'ORDER BY','order_by_variable'=>'id','order'=>'DESC'])) ;
    }

    /*****************Generate a query that limits the result from products table to 10******************/
    public function testProductLimit(){
        $this->assertEquals('select * from products limit 10', QueryComponent::select(['select'=>'select','table'=>'products','select_output'=>'*','select_from'=>'from','limit'=>'10'])) ;
    }

    /******************Generate a query that limits the result from products table to 6 and offset is 5.*******************/
    public function testProductLimitAndOffset(){
        $this->assertEquals('select * from products limit 6 offset 5', QueryComponent::select(['select'=>'select','table'=>'products','select_output'=>'*','select_from'=>'from','limit'=>'6','offset'=>'5'])) ;
    }

    /**********************Generate a select query to get all the columns of table with a count column that give the total number of products*****************/
    public function testProductCount(){
        $this->assertEquals('select *, count("id") from products', QueryComponent::selectWithAggregateFunctions(['select'=>'select','table'=>'products','select_output'=>'*','select_from'=>'from','aggr_fun'=>'count','aggr_fun_var'=>'id']));
    }

    /**************Generate a select query to get the product with maximum cost****************/
    public function testProductMaxCost(){
        $this->assertEquals('select max("cost") from products', QueryComponent::select(['select'=>'select','table'=>'products','select_output'=>'max("cost")','select_from'=>'from']));
    }

    /************************Generate a select query to get the cost of products with group by**************************************/
    public function testProductMaxProductCost(){
        $this->assertEquals('select max("cost") from products group by cost', QueryComponent::select(['select'=>'select','table'=>'products','select_output'=>'max("cost")','select_from'=>'from','group_by'=>'group by','group_by_variable'=>'cost']));
    }

    /**********************Generate a query to get all the unique products in the table*********/
    public function testProductUniqueProducts(){
        $this->assertEquals('select DISTINCT name from products', QueryComponent::select(['select'=>'select','table'=>'products','select_output'=>'DISTINCT name','select_from'=>'from']));
    }

    /**********************Generate a query with a table joined with other table*********/
    public function testProductUsingJoinOnTwoTables(){
        $this->assertEquals('select * from products join categories on products.category_id=categories.id', QueryComponent::select(['select'=>'select','table'=>'products','join'=>'join','second_table'=>'categories','first_table_matching_parameter'=>'category_id','second_table_matching_parameter'=>'id','select_output'=>'*','select_from'=>'from']));
    }

    /*********************Generate an insert query to insert a row with name, cost, color*********/
    public function testInsertInTable(){
        $this->assertEquals('INSERT INTO products("id","name","cost","color") VALUES(1,"apple",100,"red")', QueryComponent::insert(['insert'=>'INSERT','table'=>'products','into'=>'INTO',"first_variable_name"=>'id',"second_variable_name"=>'name',"third_variable_name"=>'cost',"fourth_variable_name"=>'color',"first_variable_value"=>1,"second_variable_value"=>'apple',"third_variable_value"=>100,"fourth_variable_value"=>'red','values'=>'VALUES']));
    }

    /*****Generate an insert query to insert multiple rows of values with column : name, cost and color.*****/
    public function testInsertInMultipleRows(){
        $this->assertEquals('INSERT INTO products("id","name","cost","color") VALUES(1,"apple",100,"red"),(2,"orange",50,"orange")', QueryComponent::insert(['insert'=>'INSERT','table'=>'products','into'=>'INTO',"first_variable_name"=>'id',"second_variable_name"=>'name',"third_variable_name"=>'cost',"fourth_variable_name"=>'color',"first_variable_value"=>1,"second_variable_value"=>'apple',"third_variable_value"=>100,"fourth_variable_value"=>'red','values'=>'VALUES',"second_row_first_variable_value"=>2,"second_row_second_variable_value"=>'orange',"second_row_third_variable_value"=>50,"second_row_fourth_variable_value"=>'orange']));
    }

    /*******Generate an update query to update a row of products with where condition on the name of product*****/
    public function testUpdateRowValues(){
        $this->assertEquals('UPDATE products SET color="black" WHERE color="red"', QueryComponent::update(['update'=>'UPDATE','table'=>'products','set'=>'SET',"where"=>'WHERE',"variable_name"=>'color',"old_value"=>'red',"new_value"=>'black']));
    }

    /*******Generate a delete query to delete the product whose name is abc*****/
    public function testDeleteRow(){
        $this->assertEquals('DELETE FROM products WHERE name="abc"', QueryComponent::delete(['delete'=>'DELETE','table'=>'products','from'=>'FROM',"where"=>'WHERE',"comparison_variable"=>'name',"comparison_value"=>'abc',"comparison_operator"=>'=']));
    }

    /******Generate a delete query to delete the products whose cost is greater than 500*******/
    public function testDeleteWithCondition(){
        $this->assertEquals('DELETE FROM products WHERE cost>"500"', QueryComponent::delete(['delete'=>'DELETE','table'=>'products','from'=>'FROM',"where"=>'WHERE',"comparison_variable"=>'cost',"comparison_operator"=>'>','comparison_value'=>"500"]));
    }

    /********************Generate a delete query to delete all the products***************/
    public function testDelete(){
        $this->assertEquals('DELETE FROM products', QueryComponent::delete(['delete'=>'DELETE','table'=>'products','from'=>'FROM']));
    }

}
