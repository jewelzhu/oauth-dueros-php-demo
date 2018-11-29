<?php
/**
 * Created by IntelliJ IDEA.
 * User: zhuzhu01
 * Date: 2018/10/25
 * Time: 下午12:02
 */

// include our OAuth2 Server object
require_once __DIR__.'/server.php';

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}
// display an authorization form
if (empty($_POST)) {
    exit('
<form method="post">
  <label>Input Your Name:</label>
  <input type="text" name="user">
  <br>
  <label>Do You Authorize TestClient?</label><br />
  <input type="submit" name="authorized" value="yes">
  <input type="submit" name="authorized" value="no">
</form>');
}

// print the authorization code if the user has authorized your client
$is_authorized = ($_POST['authorized'] === 'yes');
$server->handleAuthorizeRequest($request, $response, $is_authorized, $_POST["user"]);
error_log("user id" . $_POST["user"]);
/*if ($is_authorized) {
    // TODO this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
    $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);
    exit("SUCCESS! Authorization Code: $code");
}*/
$response->send();