<?php
$I = new ApiTester($scenario);
$I->wantTo('get all rank groups');
$I->amHttpAuthenticated('service_user', '123456');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET('rankGroups');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('"code":200');
$I->seeResponseContains('"status":"success"');
$I->seeResponseContains('"message":null');