<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/24
 * Time: 9:29
 * Desc:
 */

namespace Kph\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Error;
use Exception;
use Throwable;
use Kph\Helpers\ConvertHelper;


class ConvertHelperTest extends TestCase {

    public function testObject2Array() {
        $childs = [];
        for ($i = 1; $i < 5; $i++) {
            $chi         = new \stdClass();
            $chi->id     = $i;
            $chi->type   = 'child';
            $chi->name   = 'boy-' . strval($i);
            $chi->childs = [];

            array_push($childs, $chi);
        }

        $par         = new \stdClass();
        $par->id     = 0;
        $par->type   = 'parent';
        $par->name   = 'hello';
        $par->childs = $childs;
        $par->one    = current($childs);

        $res1 = ConvertHelper::object2Array(new \stdClass());
        $this->assertEmpty($res1);

        $res2 = ConvertHelper::object2Array($chi);
        $this->assertEquals(4, count($res2));

        $res3 = ConvertHelper::object2Array($par);
        $this->assertEquals(4, count($res3['childs']));

        $res4 = ConvertHelper::object2Array(1);
        $this->assertEquals(1, count($res4));

        $obj         = new \stdClass();
        $obj->childs = array_fill(0, 5, $par);
        $res5        = ConvertHelper::object2Array($obj);
        $this->assertTrue(is_array($res5['childs'][0]));
    }


    public function testArrayToObject() {
        $arr = [
            'aa' => [
                'id'    => 9,
                'age'   => 19,
                'name'  => 'hello',
                'child' => [],
            ],
            'bb' => [
                'id'   => 2,
                'age'  => 31,
                'name' => 'lizz',
            ],
            'cc' => [
                'id'   => 9,
                'age'  => 19,
                'name' => 'hello',
            ],
            'dd' => [
                'id'   => 87,
                'age'  => 50,
                'name' => 'zhang3',
            ],
        ];

        $res1 = ConvertHelper::array2Object([]);
        $this->assertTrue(is_object($res1));

        $res2 = ConvertHelper::array2Object($arr);
        $this->assertTrue(is_object($res2->aa->child));
    }


    public function testHex2Byte() {
        $str = '68656c6c6f';
        $res = ConvertHelper::hex2Byte($str);
        $this->assertEquals('hello', $res);
    }


}