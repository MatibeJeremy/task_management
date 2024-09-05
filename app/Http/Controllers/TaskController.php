<?php

namespace App\Http\Controllers;

use App\Exceptions\FetchingFailureException;
use App\Exceptions\TaskNotFoundException;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    /**
     * Get all tasks.
     * @param Request $request
     * @return JsonResponse
     * @throws FetchingFailureException
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Task::query();

            if ($request->has('status')) {
                $query->where('status', $request->input('status'));
            }

            if ($request->has('due_date')) {
                $query->whereDate('due_date', $request->input('due_date'));
            }

            $tasks = $query->paginate(10);
            if ($tasks->isEmpty()){
                return response()->json([
                    'message' => 'No tasks found'
                ], 404);
            }
        } catch (QueryException $e) {
            throw new FetchingFailureException();
        }

        return response()->json([
            'message' => 'Successfully fetched tasks',
            'data' => $tasks->items(),
            'total' => $tasks->total(),
            'per_page' => $tasks->perPage(),
            'current_page' => $tasks->currentPage(),
            'last_page' => $tasks->lastPage(),
        ], 200);
    }


    /**
     * Search for a task.
     * @param Request $request
     * @return JsonResponse
     * @throws FetchingFailureException
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('search');

        // Validate input
        if (empty($query)) {
            return response()->json([
                'message' => 'Query parameter is required.',
            ], 400);
        }

        try {
            $tasks = Task::query()
                ->where(function ($subQuery) use ($query) {
                    $subQuery->where('title', 'like', '%' . $query . '%')
                        ->orWhere('description', 'like', '%' . $query . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            // Check if the tasks collection is empty
            if ($tasks->isEmpty()) {
                return response()->json([
                    'message' => 'No tasks found for the given query.'
                ], 404);
            }
        } catch (QueryException $e) {
            throw new FetchingFailureException('Failed to fetch tasks', 0, $e);
        }

        return response()->json([
            'message' => 'Successfully found tasks.',
            'data' => $tasks->items(),
            'total' => $tasks->total(),
            'per_page' => $tasks->perPage(),
            'current_page' => $tasks->currentPage(),
            'last_page' => $tasks->lastPage(),
        ], 200);
    }


    /**
     * Get a task by ID.
     * @param int $id
     * @return JsonResponse
     * @throws TaskNotFoundException
     */
    public function show(int $id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);
        } catch (\Exception $e) {
            throw new TaskNotFoundException();
        }

        return response()->json([
            'message' => 'Successfully fetched task',
            'data' => $task], 200);
    }


    /**
     * Create a new task.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $validatedData = $this->validate($request, [
            'title' => 'required|unique:tasks,title|string',
            'description' => 'required|string',
            'status' => 'string|in:PENDING,COMPLETED',
            'due_date' => 'required|date|after:today',
        ]);

        try {
            $task = Task::create($validatedData);
        } catch (QueryException $e) {
            throw new FetchingFailureException();
        }

        return response()->json([
            'message' => "Successfully created a task",
            'data' => $task
        ], 201);
    }

    /**
     * Update a task.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     * @throws TaskNotFoundException
     */
    public function update(Request $request, int $id): JsonResponse{

        try{
            $task = Task::findOrFail($id);
        }catch (\Exception $e){
            throw new TaskNotFoundException();
        }

        $validatedData = $this->validate($request, [
            'title' => 'string|unique:tasks,title,'.$task->id,
            'description' => 'string',
            'status' => 'string|in:PENDING,COMPLETED',
            'due_date' => 'date|after:today',
        ]);

        $task->update($validatedData);
        return response()->json([
            'message' => "Successfully updated a task",
            'data' => $task], 200);
    }

    /**
     * Delete a task.
     * @param int $id
     * @return JsonResponse
     * @throws TaskNotFoundException
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);
        } catch (\Exception $e) {
            throw new TaskNotFoundException();
        }

        $task->delete();
        return response()->json([
            'message' => "Successfully deleted a task",
            'data' => $task], 200);
    }
}
