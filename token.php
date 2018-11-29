<?php
/**
 * Created by IntelliJ IDEA.
 * User: zhuzhu01
 * Date: 2018/10/25
 * Time: 上午11:36
 */

// include our OAuth2 Server object
require_once __DIR__.'/server.php';

// Handle a request for an OAuth2.0 Access Token and send the response to the client
$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();
