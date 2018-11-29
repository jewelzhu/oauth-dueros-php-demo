<?php
/**
 * Created by IntelliJ IDEA.
 * User: zhuzhu01
 * Date: 2018/2/12
 * Time: 下午5:25
 */
// include our OAuth2 Server object
require_once __DIR__.'/server.php';

error_reporting(E_ALL ^ E_NOTICE);
header("Content-Type: application/json");

$rawInput = file_get_contents("php://input");
$rawInput = str_replace("", "", $rawInput);
$postData = json_decode($rawInput, true);
$accessToken = $postData['payload']['accessToken'];
error_log("access token=".$accessToken);
$_SERVER['HTTP_Authorization'] = "Bearer ".$accessToken;

$request = OAuth2\Request::createFromGlobals();
// validate access token
if (!$server->verifyResourceRequest($request)) {
    $server->getResponse()->send();
    error_log("access token invalid ".json_encode($server->getResponse()));
    die;
}
// get userId from accessToken
$token = $server->getAccessTokenData($request);
error_log("User ID associated with this token is {$token['user_id']}");

// 发现设备/开灯/关灯的mock实现
$messageId = $postData['header']['messageId'];
$nameSpace = $postData['header']['namespace'];

$name = $postData['header']['name'];

$devices = array(
    "123456" =>
        array(
            "name"=> "小夜灯"
        ),
    "234567" => array(
        "name" => "吸顶灯"
    )
);

if ($name == "DiscoverAppliancesRequest") {
    $reply = array(
        "header" => array(
            "namespace" => $nameSpace,
            "name" => "DiscoverAppliancesResponse",
            "messageId" => $messageId,
            "payloadVersion" => "1"
        ),
        "payload" => array(
            "discoveredAppliances" => array(
                array(
                    "actions" => array("turnOn", "turnOff"),
                    "applianceTypes" => array("LIGHT"),
                    "applianceId" => "123456",
                    "manufacturerName" => "zhuzhu",
                    "isReachable" => true,
                    "friendlyDescription" => "friendlyDescription",
                    "friendlyName" => $devices['123456']["name"],
                    "version" => "version",
                    "modelName" => "modelName",
                ),
                array(
                    "actions" => array("turnOn", "turnOff"),
                    "applianceTypes" => array("LIGHT"),
                    "applianceId" => "234567",
                    "manufacturerName" => "zhuzhu",
                    "isReachable" => true,
                    "friendlyDescription" => "friendlyDescription",
                    "friendlyName" => $devices['234567']["name"],
                    "version" => "version",
                    "modelName" => "modelName",
                )
            )
        ),
        "discoveredGroups" => array(
            array(
                "groupName" => "卧室",
                "applianceIds" => array("123456", "234567"),
                "groupNotes" => "groupNotes",
                "additionalGroupDetails" => array(),

            )
        )
    );
    $response = json_encode($reply);
}
else if ($name == "TurnOnRequest") {
    $reply = array(
        "header" => array(
            "namespace" => $nameSpace,
            "name" => "TurnOnConfirmation",
            "messageId" => $messageId,
            "payloadVersion" => "1",
        ),
        "payload" => array()
    );
    $response = json_encode($reply);
}

else if ($name == "TurnOffRequest") {
    $reply = array(
        "header" => array(
            "namespace" => $nameSpace,
            "name" => "TurnOffConfirmation",
            "messageId" => $messageId,
            "payloadVersion" => "1",
        ),
        "payload" => array()
    );
    $response = json_encode($reply);
}
else {
    $response = "unknown request";
}
error_log("response=" . $response);
print $response;