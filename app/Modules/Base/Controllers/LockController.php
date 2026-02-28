<?php

namespace App\Modules\Base\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\Lock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LockController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /**
     * Попытка заблокировать сущность.
     * Возвращает информацию о блокировке или ошибку, если сущность уже заблокирована.
     */
    public function lock(Request $request): JsonResponse
    {
        $request->validate([
            'entity_id' => 'required|numeric',
            'entity' => 'required|string',
        ]);
        $user = $request->user();
        $entity_id = $request->integer('entity_id');
        $entity = $request->string('entity')->value();

        $existingLock = Lock::where('entity_id', $entity_id)
            ->where('entity', $entity)
            ->where('expires_at', '>', now())
            ->first();

        if ($existingLock && $existingLock->user_id !== $user->id) {
            //Сущность заблокирована другим пользователем
            return response()->json([
                'message' => 'Сущность уже редактируется другим менеджером.',
                'lockedBy' => $existingLock->user->name, // Предполагаем, что у пользователя есть поле name
                'lockedAt' => $existingLock->locked_at->diffForHumans(),
            ], Response::HTTP_CONFLICT); // 409 Conflict
        }
        //Сущность заблокирована текущим пользователем, обновляем ее
        if ($existingLock && $existingLock->user_id === $user->id) {
            $existingLock->update([
                'expires_at' => now()->addSeconds(Lock::DURATION_SECONDS),
            ]);
            return response()->json([
                'message' => 'Блокировка обновлена.',
                'lockedBy' => $user->name,
                'lockedAt' => $existingLock->locked_at->diffForHumans(),
            ]);
        }
        //Сущность не заблокирована, создаем новую блокировку
        $lock = Lock::create([
            'entity_id' => $entity_id,
            'entity' => $entity,
            'user_id' => $user->id,
            'locked_at' => now(),
            'expires_at' => now()->addSeconds(Lock::DURATION_SECONDS),
        ]);
        return response()->json([
            'message' => 'Сущность успешно заблокирована для редактирования.',
            'lockedBy' => $user->name,
            'lockedAt' => $lock->locked_at->diffForHumans(),
        ], Response::HTTP_OK);
    }

    /**
     * Снять блокировку с сущности.
     */
    public function unlock(Request $request): JsonResponse
    {
        $user = $request->user();
        $entity_id = $request->integer('entity_id');
        $entity = $request->string('entity')->value();
        // Удаляем блокировку, если она принадлежит текущему пользователю
        $deletedCount = Lock::where('entity_id', $entity_id)
            ->where('entity', $entity)
            ->where('user_id', $user->id)
            ->delete();
        if ($deletedCount) {
            return response()->json(['message' => 'Блокировка снята.'], Response::HTTP_OK);
        }
        return response()->json(['message' => 'Блокировка не найдена или принадлежит другому пользователю.'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Получить информацию о блокировке сущности.
     */
    public function status(Request $request): JsonResponse
    {
        $entity_id = $request->integer('entity_id');
        $entity = $request->string('entity')->value();

        $existingLock = Lock::where('entity_id', $entity_id)
            ->where('entity', $entity)
            ->where('expires_at', '>', now())
            ->first();
        if ($existingLock) {
            return response()->json([
                'locked' => true,
                'lockedBy' => $existingLock->user->name,
                'lockedAt' => $existingLock->locked_at->diffForHumans(),
            ]);
        }
        return response()->json(['locked' => false]);
    }

}
