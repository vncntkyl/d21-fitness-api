<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Length, Authorization');
header('Content-Type: application/json');

require_once __DIR__ . "/../config/env.php";
// FOR AUTHENTICATION AND SECURITY

function base64UrlEncode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function create_JWT()
{
    $PAYLOAD = [
        'iat' => time(), // Issued at
        'exp' => time() + (60 * 60 * 24) // Expiration time 60mins
    ];
    // Encode Header
    $headerEncoded = base64UrlEncode(json_encode(HEADER));

    // Encode Payload
    $payloadEncoded = base64UrlEncode(json_encode($PAYLOAD));

    // Create Signature
    $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", SECRET, true);
    $signatureEncoded = base64UrlEncode($signature);

    // Create JWT
    return "$headerEncoded.$payloadEncoded.$signatureEncoded";
}

function validate_JWT($jwt)
{

    if (empty($jwt) || count(explode('.', $jwt)) < 3)
        return false;


    // Split the JWT into its parts
    [$headerEncoded, $payloadEncoded, $signatureEncoded] = explode('.', $jwt);

    // Decode the header and payload
    $payload = json_decode(base64_decode($payloadEncoded), true);

    // Verify the signature
    $expectedSignature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", SECRET, true);
    $expectedSignatureEncoded = base64UrlEncode($expectedSignature);

    if ($signatureEncoded !== $expectedSignatureEncoded) {
        return false; // Signature verification failed
    }

    // Check expiration
    if (isset($payload['exp']) && $payload['exp'] < time()) {
        return false; // Token has expired
    }

    return $payload['exp'] > time(); // Return the payload if valid
}


function get_bearer_token()
{
    $headers = getallheaders();

    if (isset($headers['Authorization'])) {
        if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            return $matches[1];
        }
    }

    return null;
}
function validate_bearer_token()
{
    $bearer_token = get_bearer_token();

    if ($bearer_token === null || $bearer_token === "") {
        throw new Exception('ACCESS FORBIDDEN!');
    }

    if (!validate_JWT($bearer_token)) {
        throw new Exception('Sessions Expired. Please login again.');
    }

    return true;
}