<?php
$I = new ApiGuy($scenario);
$I->wantTo('Post a rank');
//$I->amHttpAuthenticated('service_user', '123456');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
//$I->sendPOST('/users', ['name' => 'davert', 'email' => 'davert@codeception.com']);
$I->sendPOST('/ranks', ['name' => 'testRank', 'ord' => 1000]);
//$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(['code'=>200, 'status'=>'success', 'message'=>null]);
$I->seeResponseJsonMatchesJsonPath('data.links');
