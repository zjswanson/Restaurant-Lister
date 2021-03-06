<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Cuisine.php";
require_once "src/Restaurant.php";

$server = 'mysql:host=localhost:8889;dbname=restaurant_guide_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class CuisineTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Cuisine::deleteAll();
        Restaurant::deleteAll();
    }

    function test_getters()
    {
        // Arrange
        $id = 1;
        $cuisine_name = 'Thai';
        $test_cuisine = new Cuisine ($cuisine_name,$id);

        // Act
        $result = array($test_cuisine->getId(), $test_cuisine->getCuisineName());
        $expected_result = array(1, 'Thai');

        // Assert
        $this->assertEquals($result, $expected_result);
    }

    function test_save()
    {
      // Arrange
      $cuisine_name = 'Thai';
      $test_cuisine = new Cuisine ($cuisine_name);
      $test_cuisine->save();

      // Act
      $result = Cuisine::getAll();

      // Assert
      $this->assertEquals($result[0],$test_cuisine);
    }

    function test_getAll()
    {
      // Arrange
      $cuisine_name = 'Thai';
      $cuisine_name2 = 'Mexican';
      $test_cuisine = new Cuisine ($cuisine_name);
      $test_cuisine->save();
      $test_cuisine2 = new Cuisine ($cuisine_name2);
      $test_cuisine2->save();

      // Act
      $result = Cuisine::getAll();

      // Assert
      $this->assertEquals($result,[$test_cuisine,$test_cuisine2]);
    }

    function test_deleteCuisine()
    {
        $cuisine_name = 'Thai';
        $test_cuisine = new Cuisine($cuisine_name);
        $test_cuisine->save();
        $cuisine_name2 = 'Mexican';
        $test_cuisine2 = new Cuisine($cuisine_name2);
        $test_cuisine2->save();

        $test_cuisine2->deleteCuisine();
        $result = Cuisine::getAll();

        $this->assertEquals($result[0], $test_cuisine);
    }

    function test_UpdateProperty()
    {
        $cuisine_name = 'Thai';
        $test_cuisine = new Cuisine($cuisine_name);
        $table_collumn_name = 'cuisine_name';
        $test_cuisine->save();
        $update_name = 'Mexican';
        $test_cuisine->updateProperty($table_collumn_name, $update_name);

        $result = Cuisine::getAll();

        $this->assertEquals($update_name, $result[0]->getCuisineName());
    }
    // function test_UpdateCuisine()
    // {
    //     $cuisine_name = 'Thai';
    //     $test_cuisine = new Cuisine($cuisine_name);
    //     $test_cuisine->save();
    //     $update_name = 'Mexican';
    //     $test_cuisine->updateCusineName($update_name);
    //
    //     $result = Cuisine::getAll();
    //
    //     $this->assertEquals($update_name, $result[0]->getCuisineName());
    // }

    function test_findCuisine()
    {
        $cuisine_name = 'Thai';
        $test_cuisine = new Cuisine($cuisine_name);
        $test_cuisine->save();
        $cuisine_name2 = 'Mexican';
        $test_cuisine2 = new Cuisine($cuisine_name2);
        $test_cuisine2->save();

        $result = Cuisine::findCuisine($test_cuisine->getId());

        $this->assertEquals($test_cuisine,$result);
    }

}

?>
