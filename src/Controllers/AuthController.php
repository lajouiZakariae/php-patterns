<?php

namespace PHPPatterns\Controllers;

use PHPPatterns\Auth\EmailVerificationRequest;
use PHPPatterns\Auth\User;
use PHPPatterns\Http\Request;
use PHPPatterns\Http\Response;
use PHPPatterns\Support\Session;
use PHPPatterns\Views\View;

class AuthController
{
    public function login_page(Request $request)
    {
        return View::make('admin/login');
    }

    public function login(Request $request)
    {
        $email    = $request->input('email');
        $password = $request->input('password');


        $isEmail         = filter_var($email, FILTER_VALIDATE_EMAIL);
        $isValidPassword = preg_match('/[a-zA-Z0-9@_-]+/', $password) !== false;

        if (
            !$isEmail
            // || $isValidPassword
        ) {
            return ['msg' => 'not valid data'];
        }

        return [$email, $password];
        // if (Auth::attempt(['email' => $email, 'password' => $password])) {
        //     return ['loggedIn' => true, 'redirect' => '/admin/products'];
        // } else {
        // }
    }

    public static function register_page(Request $request)
    {
        return View::make('admin/register');
    }

    public static function register(Request $request)
    {
        $email = $request->input('email');

        // if (User::exists($email)) {
        //     return ['exists' => true];
        // }

        $userID = User::save([
            'email' => $request->input('email'),
            'password' => password_hash($request->input('password'), PASSWORD_DEFAULT),
            'verified' => 0,
            'role_id' => 1
        ]);


        if ($userID) {
            $requestObj = EmailVerificationRequest::save($userID);

            $emailVerificationLink = 'http://event_sys.test/admin/verify_email?id='
                . $requestObj['id']
                . '&verif_code='
                . $requestObj['verif_code'];

            // Send Email
            // dd($requestObj);
        }

        Session::set("loggedIn", true);
        Session::set("userId", $userID);


        return ["loggedIn" => true, "redirect" => "/admin/products"];
    }

    // public static function logout(Response $response)
    // {
    //     Auth::logout();
    //     $response->redirect("/admin/login");
    // }

    // public static function delete_account(Response $response)
    // {
    //     $deleted = User::destroy((int) Session::get("userId"));

    //     if ($deleted) {
    //         Auth::logout();
    //         $response->json(["redirect" => "/auth/register.php"]);
    //     }
    // }

    // public static function request_mail_verification(Request $request, Response $response)
    // {
    //     $email = $request->input("email");
    //     $user = User::emailVerificationRequestCount($email);


    //     if (!$user) {
    //         $response->json(["error" => "user does not exist"]);
    //     }

    //     if ($user["verified"] === 1) {
    //         $response->json(["error" => "user has been verified already"]);
    //     }

    //     if ($user["request_count"] >= MAX_EMAIL_VERIFICATION_REQUEST_PER_DAY) {
    //         $response->json(["error" => "too many tries"]);
    //     };

    //     $requestObj = EmailVerificationRequest::save((int) Session::get("userId"));

    //     $response->json(
    //         'http://mvc.test/admin/mail-verification/verify?id='
    //             . $requestObj["id"]
    //             . '&verif_code='
    //             . $requestObj["verif_code"]
    //     );
    // }

    // public static function verify_mail(Request $request, Response $response)
    // {
    //     if ($request->param("id") &&  $request->param("verif_code")) {
    //         $requestID = $request->param("id");
    //         $verifCode = $request->param("verif_code");

    //         $requestObj = EmailVerificationRequest::find($requestID);

    //         if (!$requestObj) {
    //             $response->json(["msg" => "INVALID REQUEST"]);
    //         }

    //         if (!$requestObj["timestamp"] > time() - 60 * 60 * 24) {
    //             $response->json(["msg" => "EXPIRED"]);
    //         }

    //         if ($requestObj["verif_code"] !== $verifCode) {
    //             $response->json(["msg" => "INVALID REQUEST"]);
    //         }

    //         if (User::setVerifiedEmail($requestObj["user_id"])) {
    //             EmailVerificationRequest::clear($requestObj["user_id"]);
    //             $response->redirect("/auth/index.php");
    //         }
    //     }
    // }

    // public static function change_password_request(Request $request, Response $response)
    // {
    //     $email = $request->input("email");

    //     $user = User::PasswordResetRequestCount($email);

    //     if (!$user) {
    //         $response->json(["error" => "User does not exist"]);
    //     }

    //     if ($user["verified"] === 0) {
    //         $response->json(["error" => "User is not verified"]);
    //     }

    //     if ($user["request_count"] >= MAX_RESET_PASSWORD_REQUESTS_PER_HOUR) {
    //         $response->json(["error" => "Too many password reset requests"]);
    //     }

    //     $requestObj = PasswordResetRequest::save((int) Session::get("userId"));

    //     $response->json(
    //         'http://mvc.test/auth/change-password?id='
    //             . $requestObj["id"]
    //             . '&verif_code='
    //             . $requestObj["verif_code"]
    //     );
    // }

    // public static function change_password_form(Request $request, Response $response)
    // {
    //     $user = Auth::user();

    //     View::make("admin.change_password", "admin", [
    //         "user" => $user,
    //         "id"    => $request->param("id"),
    //         "verif_code"    => $request->param("verif_code"),
    //     ]);
    // }

    // public static function change_password(Request $request, Response $response)
    // {
    //     $id = $request->input("id");
    //     $verif_code = $request->input("verif_code");

    //     $password = $request->input("password");
    //     $c_password = $request->input("c_password");

    //     // Input Validation
    //     $requestObj = PasswordResetRequest::find($id);

    //     if (
    //         !$requestObj /* Reset Request Not Found */
    //         || ($requestObj["verif_code"] !== $verif_code) /* Reset Request doesn't match */
    //         || $requestObj["timestamp"] < time() - 60 * 60 /* One Hour Ago, Reset Request is old */
    //     ) {
    //         $response->json(["error" => "Invalid Reset Request"]);
    //     }

    //     $updated = User::setNewPassword($requestObj["user_id"], $password);

    //     if ($updated) {
    //         PasswordResetRequest::clear($requestObj["user_id"]);
    //         $response->json(["msg" => "password Updated"]);
    //     }
    // }
}
