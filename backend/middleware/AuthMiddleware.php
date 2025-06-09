<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
   public function verifyToken($token){
       if(!$token)
           Flight::halt(401, "Missing authentication header");
       $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
       Flight::set('user', $decoded_token->user);
       Flight::set('jwt_token', $token);
       return TRUE;
   }
   public function authorizeRole($requiredRole) {
       $user = Flight::get('user');
    if (!$user) {
        Flight::halt(401, 'Unauthorized: user not found in token');
    }
    if (is_array($requiredRole)) {
        if (!in_array($user->role, $requiredRole)) {
            Flight::halt(403, 'Access denied: insufficient privileges');
        }
    } else {
        if ($user->role !== $requiredRole) {
            Flight::halt(403, 'Access denied: insufficient privileges');
        }
    }
   }
   public function authorizeRoles($roles) {
       $user = Flight::get('user');
       if (!in_array($user->role, $roles)) {
           Flight::halt(403, 'Forbidden: role not allowed');
       }
   }
   function authorizePermission($permission) {
       $user = Flight::get('user');
       if (!in_array($permission, $user->permissions)) {
           Flight::halt(403, 'Access denied: permission missing');
       }
   }   
}
// Usage example:
// $authMiddleware = new AuthMiddleware();