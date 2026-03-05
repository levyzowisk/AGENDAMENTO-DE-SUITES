<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\UserServiceInterface;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
	public function __construct(
		private readonly UserServiceInterface $userService
	) {
	}

	/**
	 * GET /api/users
	 */
	public function index(): AnonymousResourceCollection
	{
		$users = $this->userService->listAll();

		return UserResource::collection($users);
	}

	/**
	 * POST /api/users
	 */
	public function store(StoreUserRequest $request): JsonResponse
	{
		$user = $this->userService->create($request->validated());

		return (new UserResource($user))
			->response()
			->setStatusCode(201);
	}

	/**
	 * PATCH /api/users/{user}
	 */
	public function update(UpdateUserRequest $request, int $user): JsonResponse
	{
		$updated = $this->userService->update($user, $request->validated());

		return (new UserResource($updated))->response();
	}

	/**
	 * DELETE /api/users/{user}
	 */
	public function destroy(int $user): JsonResponse
	{
		$this->userService->delete($user);

		return response()->json(['id' => $user]);
	}
}
