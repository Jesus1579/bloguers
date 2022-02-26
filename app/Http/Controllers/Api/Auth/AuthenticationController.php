<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{DB, Validator, Auth, Gate, Log};
use App\Models\{User};
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticationController extends Controller
{
	public function authentication($role, Request $request)
	{
		$credentials = $request->only('email', 'password'); //Get credentials

		try {
			if (!isset($request->email)) {
				return response()->json(["message" => 'El email es requerido.'], 400);
			}
			
			// Verify if password is in request
			if (!is_null($request->password)) {
				// Try to login with credentials
				if (!$token = auth()->attempt($credentials)) {
					throw new JWTException('Credenciales inválidas', 400);
				}

				$user = auth()->user();

				$roleCompare = $role == 'admin' ? ['admin','finance', 'office', 'approves'] : array($role);
				
				$roleName = $user->getRoleNames()[0];
				
				if (in_array($roleName,$roleCompare)) {

					if ($role == "manager") {
						if (!$user->isManagerApproved()) {
							throw new JWTException('Tu usuario esta pendiente por verificación de Descomplicate', 400);
						}
						$user->append('manager_types');
					}elseif ($role == 'client'){
						if (!$user->isEmailVerify()) {
							throw new JWTException('Tu usuario aun no esta verificado, verificalo antes de poder ingresar.', 400);
						}
						$user->loadProfile();
					} // role:manager


					$response = [
						"data" => $token,
						"user" => new UserCollection($user),
						"message" => "Autenticación exitosa"
					];
				} else {
					return response()->json(["message" => 'No cuentas con los permisos necesarios para acceder.'], 404);
				}
			} else {
				if (!isset($request->facebook_id) && $role == 'client') {
					return response()->json(["message" => 'El ID de red social es requerido.'], 400);
				}elseif($role != 'client'){
					return response()->json(["message" => 'El password es requerido.'], 400);
				}

				$user = User::query();
				$user->role($role);
				$user->where('email', $request->email);
				$user->where('facebook_id', $request->facebook_id);
				$user = $user->first();
				$user->loadProfile();

				if ($user) {
					//Update token
					$token = JWTAuth::fromUser($user);
					$response = [
						"data" => $token,
						"user" => new UserCollection($user),
						"message" => "Autenticación exitosa"
					];
				} else {

					//User not exist
					$rules = [
						'name' => 'required|string|max:255',
						'email' => 'required|string|email|max:255|unique:users',
					];

					//Rules user
					$validator = Validator::make($request->all(), $rules);
					
					if ($validator->fails()) {
						$response = [
							"message" => "Validar datos de registro",
							"errors" => $validator->errors()
						];
						return response()->json($response, 400);
					} //Validator fails

					//Create user
					$data = [
						"name" => $request->name,
						"email" => $request->email,
						"facebook_id" => $request->facebook_id,
						"profile_image" => is_null($request->avatar) ? null : $request->avatar,
					];

					$user = User::updateOrCreate([
						"email" => $request->email
					], $data);

					$user->email_verified_at = now();
					$user->save();
					
					if (!$user->hasRole($role))
						$user->assignRole($role);
					$token = JWTAuth::fromUser($user);
					$response = [
						"data" => $token,
						"user" => new UserCollection($user),
						"message" => "Autenticación exitosa"
					];
				}
			}
		} catch (JWTException $e) {
			$code = $e->getCode() ? (is_numeric($e->getCode()) ? $e->getCode() : 500) : 500;
			$msg = $e->getMessage() ?? "No se ha podido crear el token de usuario";
			$response = [
				"message" => $msg
			];
			$detail = [
				"line" => $e->getLine(),
				"msg" => $e->getMessage(),
				"file" => $e->getFile()
			];
			Log::info($detail);
		} //catch
		return response()->json($response, $code ?? 200);
	}

	public function getAuthenticatedUser(Request $request)
	{
		$with = $request->input('with') ?? [];
		$managerType = $request->input('manager_type') ?? null;

		if (!$user = auth()->user())
			return response()->json(["message" => "Usuario no encontrado"], 404);
		
		$user->loadProfile($with, $managerType);

		if ($user->relationLoaded('manager') && $managerType && !empty($user->manager)) {
			Gate::authorize('approved-manager',$user->manager);
		}
		
		return $this->response([
			"data" => new UserCollection($user),
			"message" => "Datos de usuario autenticado"
		], $code ?? 200);
	}

	public function logout()
	{
		JWTAuth::invalidate(JWTAuth::getToken());
		return $this->response(["message" => "Sesión cerrada"], 200);
	}

	public function verifyEmailToken(Request $request){
		$token = $request->token ?? null;

		DB::beginTransaction();
		try {
			if (!$token) {
				throw new \Exception("Token not found", 404);
			}

			$user = User::where('verification_token', $token)->first();
			if (empty($user->id)) {
				throw new \Exception("Token invalido", 400);
			}

			if (!empty($user->email_verified_at)) {
				throw new \Exception("El usuario ya ha sido verificado", 400);
			}

			$user->email_verified_at = now();
			$user->save();
			$view = 'success';
			$data = [];
		} catch (\Exception $e) {
			DB::rollBack();
			$code = $e->getCode() ? (is_numeric($e->getCode()) ? $e->getCode() : 500) : 500;
			$msg = $e->getMessage() ?? "No se ha podido crear el token de usuario";
			$view = 'error';
			$data = [
				'code' => $code,
				'message' => $msg
			];
		}

		DB::commit();
		return response(view($view, $data), $code ?? 200);
	}

	public function resendVerifyEmail(Request $request){
		$user = User::where('email', $request->email)->first();
		try {
			if (empty($user->id)) {
				throw new \Exception("Datos invalidos", 400);
			}
			$user->sendVerification();
			$code = 200;
			$response = $this->getSuccessResponse(null, $client_message ?? 'Se ha reenviado el email de verificación.');
		} catch (\Exception $e) {
			DB::rollBack();
			$code = $this->getCleanCode($e);
			$response = $this->getErrorResponse($e, 'Ocurrio algo inesperado al intentar enviar el email de verificación del usuario');
			$detail = [
				"line" => $e->getLine(),
				"msg" => $e->getMessage(),
				"file" => $e->getFile()
			];
			Log::info($detail);
		}

		return $this->response($response, $code);
	}
}
