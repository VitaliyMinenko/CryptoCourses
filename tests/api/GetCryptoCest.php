<?php

class GetCryptoCest
{
    public function _before(ApiTester $I)
    {
    }

    /**
     * Test initial method for applicatin.
     * @param ApiTester $I
     */
    public function testInitMethod(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/init/date/2021-12-20');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType([
            'status' => 'string',
            'data' => 'array'
        ]);
    }

    /**
     * Check can we get crypto Date with this method.
     * @param ApiTester $I
     */
    public function testReload(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/crypto/date/2021-12-15');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType([
            'status' => 'string',
            'data' => 'array'
        ]);
    }

    /**
     * Try to send request with not allowed route.
     * @param ApiTester $I
     */
    public function testRoute(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/crypto/wrong');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(404);
    }

    /**
     * Try to send request with not allowed HTTP Method.
     * @param ApiTester $I
     */
    public function testMethod(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/crypto/date/2021-12-15');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(404);
    }
}
